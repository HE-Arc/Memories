<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method P_PRIVATE : private memory
 * @method P_PUBLIC : memory accessible to all
 * @method P_FRIENDS : memory accessible for friends
 */
final class Publishing extends Enum
{
    const P_PRIVATE = "private";
    const P_PUBLIC =  "public";
    const P_FRIENDS = "friends-only";

}
