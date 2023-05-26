<?php

namespace Joyarkdev\JoyarkServices\Enums;

enum AppReviewVisitRecordStatus: int
{
    case DEFAULT = 0;

    case WHITELIST = 1;

    case BLACKLIST = 2;

}
