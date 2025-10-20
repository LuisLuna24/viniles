<?php

namespace App\Enums;

enum EstatusEnum: string
{
    case Activa = 'Activa';
    case Cancelada = 'Cancelada';
    case Finalizada = 'Finalizada';
    case Otro = 'Otro';
}
