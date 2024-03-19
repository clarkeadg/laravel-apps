<?php

namespace App\Services;

use App\Models\Report;

class ModerationService
{
    // Create

    public function createReport($userId, $profileId, $object_type, $object_id, $content)
    {
        $report = new Report;
        $report->user_id = $userId;
        $report->profile_id = $profileId;
        $report->object_type = $object_type;
        $report->object_id = $object_id;
        $report->content = $content;
        $report->save();

        return $report;
    }

    // Read

    // Update

    // Delete
}
