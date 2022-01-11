<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * Enum to indicate the current state of a friendship
 * @method PENDING : user not accepted
 * @method CONFIRMED : user accepted
 */
final class Status extends Enum
{
    const PENDING = "pending";
    const CONFIRMED =  "confirmed";
}
