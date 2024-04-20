<?php


namespace App\DTO;

use App\Helpers\RegisteredCamerasHelper;

class CreateCaptureDTO {
    const RECEBIDO = 1;
    const SENT = 2;
    const ERROR = 3;

    public function __construct(
        public $id,
        public $idRegister,
        public $captureDateTime, //yyyy-MM-dd HH:mm:ss
        public string $plate,
        public string $idEquipment,
        public $idCam,
        public $nameCam,
        public $latitude,
        public $longitude,
        public $image, //Base64
        public $fileName,
        public $statusSend
    ) {
    }

    public static function makeFromRequest($request): self {
        return new self(
            $request->id,
            $request->idRegister,
            str_replace(' ', 'T', $request->captureDateTime),
            $request->plate,
            $request->idEquipment,
            $request->idCam,
            self::getNameCam($request->idCam),
            $request->latitude,
            $request->longitude,
            $request->image,
            str_replace(array('.', '-', '/', ':', ' '), "", $request->captureDateTime) . '-' . $request->plate . '.jpg',
            self::RECEBIDO
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
