<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class VerficationStatus extends Enum
{
    const UNVERIFIED =   0;
    const VERIFIED=   1;
}
