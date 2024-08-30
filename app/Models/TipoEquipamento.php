<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoEquipamento extends Model
{
    use HasFactory;

    const SLD = '1';
    const OCR = '2';

    protected $table = 'tipo_equipamento';

}
