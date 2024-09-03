<?php

namespace App\Helpers;

use App\Models\Cam;
use App\Models\Directory as ModelsDirectory;

class RegisteredCamerasHelper {

    public static function registered_cameras(): array {
        return ModelsDirectory::where('status', '=', 'ativo')->get()->toArray();
    }

    /**
     * Função responsavel por retornar o nome do equipamento através do idedentificado da camera cadastrada junto ao CMV
     *
     * @param string $idCam
     * @return string
     */
    public static function getNameCam($idCam): string {
        $camera = Cam::select('nome_amigavel')->where('id', '=', $idCam)->first();

        return $camera->nome_amigavel;
    }
}
