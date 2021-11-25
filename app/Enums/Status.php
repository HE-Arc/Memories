<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method PENDING : user not accepted
 * @method CONFIRMED : user accepted
 */
final class Status extends Enum
{
    const PENDING = "pending";
    const CONFIRMED =  "confirmed";
}
