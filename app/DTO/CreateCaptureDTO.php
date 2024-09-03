<?php


namespace App\DTO;

use App\Helpers\RegisteredCamerasHelper;
use App\Models\SituacaoEnvio;

class CreateCaptureDTO {
    public function __construct(
        public $id,
        public $id_registro,
        public $data_captura, //yyyy-MM-dd HH:mm:ss
        public string $placa,
        public $cameras_id,
        public $nameCam,
        public $latitude,
        public $longitude,
        public $image, //Base64
        public $fileName,
        public $situacao_envio_id
    ) {
    }

    public static function makeFromRequest($request): self {
        return new self(
            $request->id,
            $request->idRegister,
            str_replace(' ', 'T', $request->captureDateTime),
            $request->plate,
            $request->idCam,
            self::getNameCam($request->idCam),
            $request->latitude,
            $request->longitude,
            $request->image,
            str_replace(array('.', '-', '/', ':', ' '), "", $request->captureDateTime) . '-' . $request->plate . '.jpg',
            SituacaoEnvio::RECEBIDO
        );
    }

    /**
     * Função responsavel por retornar o nome do equipamento através do idedentificado da camera cadastrada junto ao CMV
     *
     * @param string $idCam
     * @return string
     */
    public static function getNameCam($idCam): string {
        return RegisteredCamerasHelper::getNameCam($idCam);
    }

    public static function registered_cameras(): array {
        return RegisteredCamerasHelper::registered_cameras();
    }
}
