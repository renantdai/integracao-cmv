<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cam extends Model {
    use HasFactory;

    protected $table = 'cameras';

    protected $fillable = [
        'id_registro_camera',
        'tipo_ambiente_id',
        'tipo_manutencao_id',
        'equipamentos_id',
        'versao_aplicacao',
        'data_registro',
        'identificador_equipamento',
        'nome_amigavel',
        'uf_estado',
        'sentido_id',
        'latitude',
        'longitude',
        'tipo_equipamento_id',
        'referencia_complementar',
        'situacao_envio_id',
        'situacao_registro_id',
        'usuario_criacao_id',
        'usuario_alteracao_id',
        'cnpj'
    ];

    static function findConvert($id) {
        $data = Cam::find($id);
        if(!$data){
            return null;
        }

        return [
            'idRegister' => $data->id_registro_camera,
            'tpAmb' => $data->tipo_ambiente_id,
            'tpMan' => $data->tipo_manutencao_id,
            'equipament' => $data->equipamentos_id,
            'verAplic' => $data->versao_aplicacao,
            'dhReg' => $data->data_registro,
            'cEQP' => $data->identificador_equipamento,
            'xEQP' => $data->nome_amigavel,
            'cUF' => $data->uf_estado,
            'tpSentido' => $data->sentido_id,
            'latitude' => $data->latitude,
            'longitude' => $data->longitude,
            'tpEQP' => $data->tipo_equipamento_id,
            'xRefCompl' => $data->referencia_complementar,
            'statusSend' => $data->situacao_envio_id,
            'equipament' => $data->equipamentos_id,
            'CNPJOper' => $data->cnpj,
            'situacao_registro_id' => $data->situacao_registro_id,
            'usuario_criacao_id' => $data->usuario_criacao_id,
            'usuario_alteracao_id' => $data->usuario_alteracao_id
        ];
    }
}
