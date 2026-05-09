<?php

namespace App\Enums;

enum OrderStatus: string
{
    case SUCCESS = 'SUCCESS';
    case FAILED = 'FAILED';
    case PENDING = 'PENDING';
}
