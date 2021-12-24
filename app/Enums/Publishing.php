<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method PENDING : user not accepted
 * @method CONFIRMED : user accepted
 */
final class Publishing extends Enum
{
    const P_PRIVATE = "private";
    const P_PUBLIC =  "public";
    const P_FRIENDS = "friends-only";

}
