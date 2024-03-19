<?php

namespace App\Actions\Reactions;

use App\Models\Reaction;

class CreateReaction
{
    public static function handle($userId, $name, $object_type, $object_id)
    {
        $reaction = new Reaction;
        $reaction->user_id = $userId;
        $reaction->name = $name;
        $reaction->object_type = $object_type;
        $reaction->object_id = $object_id;
        $reaction->save();

        return $reaction;
    }
}
