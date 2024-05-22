<?php

namespace App\Helpers;

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
        $cams = [
            '01' => 'Entrada da cidade pela ponte Tramandai - Imbe utilizando a faixa da direita',
            '13' => 'Entrada da cidade pela ponte Tramandai - Imbe utilizando a faixa da esquerda',
            '14' => 'Saida do municipio de Imbe utilizando a via beira mar no bairro imara',
            '15' => 'Entrada do municipio de Imbe utilizando a via beira mar no bairro imara',
            '16' => 'Saida do municipio de Imbe utilizando a RS-786 no bairro imara',
            '17' => 'Entrada do municipio de Imbe utilizando a RS-786 no bairro imara',
            '26011' => 'teste-Guaiba-11',
            '26111' => 'teste-Guaiba-111',
            '012' => 'PM-4309308-Av. Nei Brito x Br116-Entrada 2',
            '112' => 'PM-4309308-Av. Nei Brito x Br116-Entrada 1'
        ];

        return $cams[$idCam];
    }
}
