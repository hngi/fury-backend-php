<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\v1\Meeting;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
            ], 201);
        }catch (\Exception $e) {
            return response()->json([
                'data' => null,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try{
            $meeting = Meeting::findOrFail($id);

            $meeting->update($request->all());

            return response()->json([
                'data' => $meeting->get(),
                'message' => 'Meeting has been successfully updated'
            ], 201);

        }catch (ModelNotFoundException $e) {
            return response()->json([
                'data' => null,
                'message' => 'Meeting does not exist 🤧'
            ], 500);

        }catch (\Exception $e) {

            return response()->json([
                'data' => null,
                'message' => 'There was problem updating meeting 🥴'
            ], 500);
        }
    }

    public function delete($id)
    {
        try {
            /*
             * Authorization will done here
             * to decide who can delete what
             */

            $meeting = Meeting::findOrFail($id)->delete();

            return response()->json([
                'data' => null,
                'message' => 'Meeting has been successfully deleted '
            ], 201);

        }catch (ModelNotFoundException $e) {
            return response()->json([
                'data' => null,
                'message' => 'Meeting does not exist 🤧'
            ], 500);

        }catch (\Exception $e) {

            return response()->json([
                'data' => null,
                'message' => 'There was problem updating meeting 🥴'
            ], 500);
        }

    }

    public function getMeetingById($id)
    {
        try{
            $meeting = Meeting::findOrFail($id);

            return $meeting;

        }catch (ModelNotFoundException $e) {
            return response()->json([
                'data' => null,
                'message' => 'Meeting not found'
            ]);
        }catch (\Exception $e) {
            return response()->json([
                'data' => null,
                'message' => 'An error occurred, please try again'
            ]);
        }
    }
}
