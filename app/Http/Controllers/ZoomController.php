<?php

namespace App\Http\Controllers;

use App\Services\ZoomService;

class ZoomController extends Controller
{
    public function addWebinarDropdown(ZoomService $zoom)
    {
        $zoom->appendDropdownToWebinar(
            96333247892,
            [
                'field_name' => 'Department',
                'type' => 'single',
                'required' => true,
                'answers' => [
                    'IT',
                    'HR',
                    'Finance',
                    'Legal',
                ],
            ]
        );

        return response()->json([
            'status' => 'Dropdown added (append-safe)'
        ]);
    }
}
