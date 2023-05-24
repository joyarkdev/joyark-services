<?php

namespace Joyarkdev\JoyarkServices\Enums;

enum RiskLevel: string
{
    case PASS = 'pass';

    case REVIEW = 'review';

    case REJECT = 'reject';
}
