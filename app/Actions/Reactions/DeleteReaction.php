<?php

namespace App\Actions\Reactions;

use App\Models\Reaction;

class DeleteReaction
{
    public static function handle($reaction)
    {
        if(isset($reaction)) {
            $reaction->delete();
        }

        return null;
    }
}
