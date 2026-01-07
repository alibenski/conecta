<?php

namespace App\Http\Controllers;

use App\Services\ZoomService;

class ZoomController extends Controller
{
    public function addWebinarDropdown(ZoomService $zoom)
    {
        $webinarId = 96082383948; // ← your webinar ID

        $question = [
            'field_name' => 'Department',
            'type' => 'single',
            'required' => true,
            'answers' => [
                'IT',
                'HR',
                'Finance',
                'Legal',
            ],
        ];

        $zoom->addDropdownToWebinar($webinarId, $question);

        return response()->json(['status' => 'Webinar dropdown added']);
    }
}
