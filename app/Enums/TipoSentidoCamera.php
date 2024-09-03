<?php

namespace App\Enums;

enum TipoSentidoCamera: string {
    case E = "Entrada";
    case S = "Saida";
    case I = "Indeterminado";

    public static function sendFromString($id): string {
        $cases = [
            1 => 'E',
            2 => 'S',
            3 => 'I'
        ];

        return $cases[$id];
    }

    public static function sendFromSave($id) {
        $cases = [
            'E' => 1,
            'S' => 2,
            'I' => 3
        ];

        return $cases[$id];
    }
}
