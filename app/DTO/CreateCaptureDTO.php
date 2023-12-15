<?php


namespace App\DTO;

class CreateCaptureDTO
{
    public function __construct(
        public $idRegister,
        public $dateTime, //ddMMyyyyHHmmss
        public string $place,
        public string $idEquipment,
        public $idCam,
        public $latitude,
        public $longitude,
        public $image, //Base64
    ) {}

    public static function makeFromRequest($request): self
    {
        return new self(
            $request->idRegister,
            $request->dateTime,
            $request->place,
            $request->idEquipment,
            $request->idCam,
            $request->latitude,
            $request->longitude,
            $request->image
        );
    }
}
