<?php

namespace App\Http\Controllers;

use App\Services\ZoomService;

class ZoomController extends Controller
{
    public function addQuestion(ZoomService $zoom)
    {
        $zoom->addCustomQuestion(96333247892);

        return redirect()->back()->with('success', 'Question added');
    }

    public function addWebinarDropdown(ZoomService $zoom)
    {
        $zoom->appendDropdownToWebinar(
            96333247892,
            [
                'title' => 'Test Question',
                'type' => 'short',
                'required' => false,
               
            ]
        );

        return response()->json([
            'status' => 'Dropdown added (append-safe)'
        ]);
    }
}
