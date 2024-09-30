<?php

namespace App\Enums;

enum CamStatus: string {
    case C = "Cadastramento";
    case A = "Alteração";
    case D = "Desativação";
    case R = "Reativação";

    public static function fromValue(string $name): string {
        foreach (self::cases() as $status) {
            if ($name === $status->name) {
                return $status->value;
            }
        }

        throw new \ValueError("$status is not a valid");
    }

    public static function sendFromValue($name): string {
        $values = [
            'C' => 1,
            'A' => 2,
            'D' => 3,
            'R' => 4
        ];
        foreach (self::cases() as $status) {
            if ($name === $status->name) {
                return $values[$status->name];
            }
        }

        throw new \ValueError("$status is not a valid from send");
    }

    public static function getKey($value): CamStatus {
        $values = [
            'C' => 1,
            'A' => 2,
            'D' => 3,
            'R' => 4
        ];
        foreach ($values as $chave => $valor) {
            if ($valor === $value) {
                switch ($chave) {
                    case 'C':
                        return self::C;
                    case 'A':
                        return self::A;
                    case 'D':
                        return self::D;
                    case 'R':
                        return self::R;
                }
            }
        }

        throw new \ValueError("$value is not a value valid");
    }
}
