<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\v1\Meeting;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    public function index()
    {
        try{
            $meeting = Meeting::paginate(12);

            return response()->json([
                'data' => $meeting,
                'message' => 'Meeting successfully fetch'
            ]);
        }catch (\Exception $e) {
            return response()->json([
                'data' => null,
                'message' => $e->getMessage()
            ]);
        }
    }
    public function create(Request $request)
    {

        try {
            $validatedData = $request->validate([
                'event_id' => 'required|integer|max:255',
                'employee_id' => 'required|integer|max:255',
                'user_id' => 'required|integer|max:255'
            ]);

            $meeting = Meeting::create($validatedData);

            return response()->json([
                'data' => $meeting,
                'message' => 'Meeting has successfully been created'
            ]);
        }catch (\Exception $e) {
            return response()->json([
                'data' => null,
                'message' => $e->getMessage()
            ]);
        }
    }
}
