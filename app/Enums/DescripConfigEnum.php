<?php

namespace App\Enums;

enum DescripConfigEnum: string
{
    case Temperatura = 'Temperatura';
    case Precion = 'Precion';
    case Velocidad = 'Velocidad';
    case Solvente = 'Solvente';
    case Otro = 'Otro';
}
