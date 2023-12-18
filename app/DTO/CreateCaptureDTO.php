<?php


namespace App\DTO;

class CreateCaptureDTO {
    const RECEBIDO = 1;
    const SENT = 2;
    const ERROR = 3;

    public function __construct(
        public $id,
        public $idRegister,
        public $captureDateTime, //yyyy-MM-ddTHH:mm:ss
        public string $plate,
        public string $idEquipment,
        public $idCam,
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
            $request->captureDateTime,
            $request->plate,
            $request->idEquipment,
            $request->idCam,
            $request->latitude,
            $request->longitude,
            $request->image,
            str_replace(array('.', '-', '/', ':'), "", $request->captureDateTime) . '-' . $request->plate . '.jpg',
            self::RECEBIDO
        );
    }
}
