<?php

namespace App\Enum;

enum EscolaridadeEnum: int
{
    case MEDIO = 0;
    case MEDIO_INCOMPLETO = 1;
    case SUPERIOR_COMPLETO = 2;
    case SUPERIOR_INCOMPLETO = 3;

    public function getName(): string
    {
        return match ($this) {
            self::MEDIO => 'Ensino Médio Completo',
            self::MEDIO_INCOMPLETO => 'Ensino Médio Incompleto',
            self::SUPERIOR_COMPLETO => 'Ensino Superior Completo',
            self::SUPERIOR_INCOMPLETO => 'Ensino Superior Incompleto',
            default => 'Não Informado'
        };
    }
}
