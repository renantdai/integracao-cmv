<?php

namespace App\Services;

use App\DTO\CreateCaptureDTO;
use App\Http\Controllers\Api\IntegrationController;
use App\Models\Capture;
use App\Models\Directory;
use App\Repositories\Contracts\IntegrationRepositoryInterface;
use App\Repositories\IntegrationEloquentORM;
use FtpClient\FtpClient;
use phpseclib3\Net\SFTP;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;

class RepositoryFtpService {
    const TIPO_CONEXAO_FTP = 1;
    const TIPO_CONEXAO_SFTP = 2;
    public $registered_cameras = [];

    public function __construct(
        protected IntegrationRepositoryInterface $repository,
        protected FtpClient $ftp,
        public $sftp = null,
        public string $diretory = '',
        protected $config = []
    ) {
        $this->registered_cameras = CreateCaptureDTO::registered_cameras();
    }


    public function getConfig() {
        return $this->config;
    }

    public function setConfig($config) {
        $this->config = $config;
    }

    public function getInitConnection() {
        if ($this->config['tipo_conexao_id'] == self::TIPO_CONEXAO_SFTP) {
            $testConnection = $this->getInitConectionSftp();
        } else {
            $testConnection = $this->getInitConectionFtp();
        }

        return $testConnection;
    }

    public function getInitConectionFtp() {
        /*         $conn_id = ftp_connect($this->config['host']);
        $login_result = ftp_login($conn_id, $this->config['login'], $this->config['password']); */
        try {
            $this->ftp->connect($this->config['host'], false, $this->config['porta'], 10);
            $this->ftp->login($this->config['login'], $this->config['password']);
            $this->ftp->chdir($this->diretory);
            $this->ftp->pasv(true);

            return ['error' => false];
        } catch (Exception $e) {
            return ['error' => true, 'msg' => 'Erro ao iniciar a conexao. ' . $e->getMessage()];
        }
    }

    public function getInitConectionSftp() {
        try {
            $this->sftp = new SFTP($this->diretory, $this->config['port'], 60);
            $this->sftp->login($this->config['login'], $this->config['password']);
            $this->sftp->chdir($this->config['host']);

            return ['error' => false];
        } catch (Exception $e) {
            return ['error' => true, 'msg' => 'Erro ao iniciar a conexao. ' . $e->getMessage()];
        }
    }

    public function registerDirectory(string $directory): void {
        $directorys = array_column($this->registered_cameras, 'diretorio');
        if (!in_array($directory, $directorys)) {
            throw new Exception('Diretorio não registrado no sistema');
        }
        $this->diretory = $directory;
    }

    public function show() {
        //$total = $this->ftp->countItems($diretorio);
        //$size = $this->ftp->dirSize($diretorio, true); #nao esta funcionando
        //$total_file_search = $this->ftp->countItems($diretorio, 'file'); #nao esta funcionando
        //$items = $this->ftp->scanDir($diretorio); #nao esta funcionando
        $list = $this->ftp->nList();
        // remove the old files
        #$ftp->removeByTime('/www/mysite.com/demo', time() - 86400);

        return $list;
    }

    public function prepareSendCapture($directoryCapture, $plate, $lastItemSent) {
        if (!$this->validatePlate($lastItemSent, $plate)) {
            return ['error' => true, 'msg' => 'Não foi possivel validar a placa'];
        }

        $return = $this->sendCapture($directoryCapture);
        if (!$return) {
            return ['error' => true];
        }
        $data = $return->getData();

        if (isset($data->error)) {
            if ($data->error) {
                return (array) $data;
            }
        }

        if ($this->config['tipo_conexao_id'] == self::TIPO_CONEXAO_SFTP) {
            $this->saveImageSftp($directoryCapture);
        } else {
            $this->saveImage($directoryCapture);
        }

        return [(array) $data->data, 'error' => false];
    }

    public function getList() {
        if ($this->config['tipo_conexao_id'] == self::TIPO_CONEXAO_SFTP) {
            $this->sftp->setListOrder('filename', SORT_ASC, true);

            return array_reverse($this->sftp->nlist());
        } else {
            return $this->ftp->nList('.', 'rsort');
        }
    }

    public function repositoryInit() {
        $testConnection = $this->getInitConnection();
        if ($testConnection['error']) {
            return $testConnection;
        }

        if (!$this->validateCam()) {
            return false;
        }

        $lastItemSent = $this->repository->lastSendCam($this->config['cameras_id']);

        $list = $this->getList();

        if (empty($list)) {
            return false;
        }
        $arrayItens = array_chunk($list, 10);
        $plate = '';
        $sucesso = [];
        foreach ($arrayItens[0] as $l) {
            if ($l == 'enviado' || $l == '.' || $l == '..' || $l == './enviado' || strpos($l, 'enviado')) {
                continue;
            }
            try {
                $plate = $this->getPlateFromPath($l);
                if ($plate == '0000000') {
                    $this->ftp->delete($l);
                    continue;
                }
                $sendStatus = $this->prepareSendCapture($l, $plate, $lastItemSent);
                if ($sendStatus['error']) {
                    continue; //criar log e tratar
                }
                $sucesso[$plate] = $sendStatus;
                $lastItemSent = $plate;
            } catch (Exception $e) {
                Log::info('Erro no fluxo de envio', [$e->getMessage()]);
            }
        }

        return $sucesso;
    }

    private function validatePlate($lastPlateSend, $plate) {
        if ($plate == $lastPlateSend || $plate == '0000000') {
            return false;
        }

        return true;
    }

    private function sendCapture($path) {
        $bodyRequest = $this->prepareDataBeforeSend($path);

        if (isset($bodyRequest['error'])) {
            return false;
        }

        $request = new Request();
        $request->merge($bodyRequest);

        $model = new Capture();
        $orm = new IntegrationEloquentORM($model);
        $service = new IntegrationService($orm);
        $integrationController = new IntegrationController($service);

        return $integrationController->capture($request);
    }

    public function prepareDataBeforeSend(string $path, $idRegister = '0') {
        $image = '';
        $pathArray = explode('_', $path);

        if (!is_null($this->sftp)) {
            $image = $this->sftp->get($path);
        } else {
            //$handle = fopen('php://temp/', 'w');
            $handle = public_path('images/');
            $nameTmp = $pathArray[1] . '_' . $pathArray[2] . '.jpg';
            if (!$this->ftp->get($handle . $nameTmp, $path, FTP_IMAGE)) {
                Log::error('Erro ao salvar arquivo ftp');
                return ['error' => true, 'msg' => 'erro ao salvar a imagem no repositorio'];
            }
            $image = file_get_contents($handle . $nameTmp);
            $pathArray[0] = substr($pathArray[0], 2);
        }

        if (empty($image)) {
            return ['error' => true];
        }

        return [
            "idRegister" => $idRegister,
            "captureDateTime" => Carbon::make($pathArray[0] . ' ' . $pathArray[1])->format('Y-m-d h:m:i'),
            "plate" => substr($pathArray[2], 0, 7),
            "idEquipment" => $this->config['cameras_id'],
            "idCam" => $this->config['cameras_id'],
            "image" => base64_encode($image)
        ];
    }

    public function saveImage(string $path) {
        $this->verifyDiretory();
        $pathName = explode('/', $path);

        $this->ftp->rename(end($pathName), "enviado/" . end($pathName)); // Linux usar Contra Barra - Windows usar duas barras invertida
    }

    public function verifyDiretory(string $path = 'enviado'): void {
        $this->ftp->mkdir($path, true);
    }

    public function saveImageSftp(string $path) {
        $this->verifyDiretorySftp();
        $pathName = explode('/', $path);

        $this->sftp->rename(end($pathName), "enviado\\" . end($pathName));
    }

    public function verifyDiretorySftp(string $path = 'enviado'): void {
        $this->sftp->mkdir($path);
    }

    private function getPlateFromPath(string $path): string {
        $path = explode('_', $path);
        $plate = explode('.', $path[2]);

        return $plate[0];
    }

    private function validateCam() {
        $cams = array_column($this->registered_cameras, 'host');

        return in_array($this->config['host'], $cams);
    }

    static public function testConnectionFtp($host, $user, $password, $port = 21) {
        $ftp = new FtpClient();

        for ($x = 0; $x < 3; $x++) {
            try {
                $ftp->connect($host, false, $port, 10);
            } catch (Exception $e) {
                continue;
            }
        }
        if (empty($ftp)) {
            return ['error' => true];
        }
        $ftp->login($user, $password);
        if (!$ftp->isEmpty('.')) {
            return ['msg' => 'sucesso'];
        }

        return ['error' => true, 'msg' => 'validar erro'];
    }

    static public function testConnectionFtpPHP($host, $user, $password) {
        // Estabelecer conexão com o servidor FTP
        $conn_id = ftp_connect($host);

        // Verificar se a conexão foi bem sucedida
        if (!$conn_id) {
            die("Falha na conexão com o servidor FTP: " . ftp_errormsg($conn_id));
        }

        // Efetuar login no servidor FTP
        $login_result = ftp_login($conn_id, $user, $password);

        // Verificar se o login foi bem sucedido
        if (!$login_result) {
            die("Falha no login do FTP: " . ftp_errormsg($conn_id));
        }

        // Exemplo de listagem de arquivos no diretório raiz
        $files = ftp_nlist($conn_id, ".");
        print_r($files);

        // Fechar a conexão com o servidor FTP
        ftp_close($conn_id);
    }

    public function getDirectory() {
        return Directory::where('situacao_registro_id', '=', 1)->where('tipo_conexao_id', '<>', '3')->get();
    }
}
