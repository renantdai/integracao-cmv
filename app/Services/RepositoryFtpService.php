<?php

namespace App\Services;

use App\DTO\CreateCaptureDTO;
use App\Http\Controllers\Api\IntegrationController;
use App\Models\Capture;
use App\Repositories\Contracts\IntegrationRepositoryInterface;
use App\Repositories\IntegrationEloquentORM;
use FtpClient\FtpClient;
use phpseclib3\Net\SFTP;
use stdClass;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;

class RepositoryFtpService {

    public $registered_cameras = [];

    public function __construct(
        protected IntegrationRepositoryInterface $repository,
        protected FtpClient $ftp,
        public $sftp = null,
        public string $diretory = '',
    ) {
        $this->registered_cameras = CreateCaptureDTO::registered_cameras();
    }

    public function getInitConectionFtp() {
        $this->ftp->connect(env('HOST_FTP'), false, env('PORT_FTP'), 10);
        $this->ftp->login(env('LOGIN_FTP'), env('PASSWORD_FTP'));
        $this->ftp->chdir($this->diretory);
    }

    public function getInitConectionSftp() {
        $this->sftp = new SFTP(env('HOST_SFTP'), env('PORT_SFTP'));
        $this->sftp->login(env('LOGIN_SFTP'), env('PASSWORD_SFTP'));
        $this->sftp->chdir($this->diretory);
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

    public function verificaRepositorio() {
        $this->getInitConectionFtp();

        $lastItemSent = $this->repository->lastSendCam($this->registered_cameras[$this->diretory]['idCam']);
        $list = $this->ftp->nList('.', 'rsort');
        #$rawlist = $this->ftp->rawlist();
        $plate = $this->getPlateFromPath($list[0]);

        if (!$this->validatePlate($lastItemSent, $plate)) {
            return false;
        }

        $return = $this->sendCapture($list[0]);

        if (!$return) {
            return false;
        }

        $this->saveImage($list[0]);

        return $return;
    }

    public function verificaRepositorioSftp() {
        $this->getInitConectionSftp();

        if (!$this->validateCam()) {
            return false;
        }

        $lastItemSent = $this->repository->lastSendCam($this->registered_cameras[$this->diretory]['idCam']);

        $this->sftp->setListOrder('filename', SORT_ASC, true);

        $list = array_reverse($this->sftp->nlist());
        $plate = $this->getPlateFromPath($list[0]);

        if (!$this->validatePlate($lastItemSent, $plate)) {
            return false;
        }

        $return = $this->sendCapture($list[0]);

        if (!$return) {
            return false;
        }

        $this->saveImageSftp($list[0]);

        return $return;
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
            //$this->ftp->get('.', $path, FTP_IMAGE);
            // $image = $this->ftp->get('tmp-images/teste2.jpg', $path, FTP_IMAGE);
            $handle = fopen('php://temp', 'r+');
            $nameTmp = time();
            $this->ftp->get($handle . $nameTmp, $path, FTP_IMAGE);
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
            "idEquipment" => $this->registered_cameras[$this->diretory]['idEquipment'],
            "idCam" => $this->registered_cameras[$this->diretory]['idCam'],
            "image" => base64_encode($image)
        ];
    }

    public function saveImage(string $path) {
        $this->verifyDiretory();
        $pathName = explode('/', $path);

        $this->ftp->rename(end($pathName), "enviado\\" . end($pathName));
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
        return in_array($this->diretory, $this->registered_cameras);
    }
}
