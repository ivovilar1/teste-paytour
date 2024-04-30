<?php

namespace App\Models;

use App\Enum\EscolaridadeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resume extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'email',
        'telefone',
        'cargo',
        'escolaridade',
        'observacoes',
        'arquivo',
        'data_envio',
        'ip_address'
    ];
    protected function casts(): array
    {
        return [
            'escolaridade' => EscolaridadeEnum::class,
        ];
    }
}
