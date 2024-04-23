<?php

namespace App\Helpers;

class RegisteredCamerasHelper {

    public static function registered_cameras(): array {
        return [
            '192_168_26_11' => [
                'idEquipment' => '211',
                'idCam' => '26011'
            ],
            '192_168_26_111' => [
                'idEquipment' => '211',
                'idCam' => '26111'
            ],
            '192_168_26_12' => [
                'idEquipment' => '212',
                'idCam' => '26012'
            ],
            '192_168_26_112' => [
                'idEquipment' => '212',
                'idCam' => '26112'
            ],
            'smsalbatroz' => [
                'idEquipment' => '211',
                'idCam' => '111'
            ]
        ];
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
        ];

        return $cams[$idCam];
    }
}
