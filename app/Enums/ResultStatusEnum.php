<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class ResultStatusEnum extends Enum
{
    const NOT_DETECT =   0;
    const DETECTED =   1;

}
