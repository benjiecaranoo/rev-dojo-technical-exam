<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class ErrorCodes extends Enum implements LocalizedEnum
{
    /**
     * Error code for invalid account Credentials
     */
    const INVALID_CREDENTIALS = 'INVALID_CREDENTIALS';
}
