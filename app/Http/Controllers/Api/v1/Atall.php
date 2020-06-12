<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\v1\Meeting;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    // app/Http/Controllers/SampleController.php
    /**
     * @SWG\Get(
     *   path="/api/v1/meetings",
     *   summary="Get all meetings with pagination",
     *   tags={"Meeting"},
     *   @SWG\Response(response=201, description="Meeting successful fetched")
     *
     *   @SWG\Response(response=401,  description="Unauthenticated",  description="Unauthenticated",)
     *
     *   @SWG\Response(response=403,description="Forbidden")
     *
     *   @SWG\Response(response=403,description="Forbidden")
     * )
     **/
    public function index()
    {
        try{
            $meeting = Meeting::paginate(12);

            return response()->json([
                'data' => $meeting,
                'message' => 'Meeting successfully fetch'
            ], 201);
        }catch (\Exception $e) {
            return response()->json([
                'data' => null,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * @@SWG\Post(
     *     path="/api/v1/meetings",
     *     operationId="addMeeting",
     *     summary="Add a new meeting to the database",
     *     tags={"Meeting"},
     *     @SWG\RequestBody(
     *      description="Meeting object that needs to be added to the store",
     *      required=true,
     *      @SWG\Parameter(
     *       name="user_id",
     *       required=true,
     *       description="The user id",
     *       @SWG\Schema(
     *         type="integer"
     *       )
     *   ),
     *   @SWG\Parameter(
     *     name="employee_id",
     *     @SWG\Schema(
     *      type="integer",
     *     ),
     *     description="The employee id",
     *      ),
     *     ),
     *     @SWG\Parameter(
     *     name="event_id",
     *     @SWG\Schema(
     *      type="integer",
     *     ),
     *     description="The event id",
     *     ),
     * @SWG\Response(response=201, description="Meeting successful fetched")
     * )
     * @param Request $request
     * @return JsonResponse
     */
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

    /**
     * @SWG\Put(
     *     path="/api/v1/meetings/{eventId}",
     *     operationId="updateMeeting",
     *     summary="Update meeting to the database",
     *     tags={"Meeting"},
     *     @SWG\RequestBody(
     *      description="Meeting object that needs to be updated to the store",
     *      required=true,
     *     @SWG\Parameter(
     *     name="eventId",
     *     in="path",
     *     description="Event Id to find a paticular meeting",
     *     required=true,
     *     @SWG\Schema(
     *         type="string"
     *     )
     *   ),
     *      @SWG\Parameter(
     *       name="user_id",
     *       required=true,
     *       description="The user id",
     *       @SWG\Schema(
     *         type="integer"
     *       )
     *   ),
     *   @SWG\Parameter(
     *     name="employee_id",
     *     @SWG\Schema(
     *      type="integer",
     *     ),
     *     description="Employee id",
     *      ),
     *     ),
     *     *   @SWG\Parameter(
     *     name="event_id",
     *     @SWG\Schema(
     *      type="integer",
     *     ),
     *     description="The event id",
     *      ),
     *     ),
     * @SWG\Response(response=201, description="Meeting successful fetched")
     * )
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */

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

    /**
     * @SWG\Delete(path="/api/vi/meeting/{meeting_id}",
     *   tags={"Meeting"},
     *   summary="Delete Meeting",
     *   description="This endpoint deletes a meeting",
     *   operationId="meeting_id",
     *   @SWG\Parameter(
     *     name="meeting_id",
     *     in="path",
     *     description="The meeting id that needs to be deleted",
     *     required=true,
     *     @SWG\Schema(
     *         type="integer"
     *     )
     *   ),
     *   @SWG\Response(response=400, description="Invalid username supplied"),
     *   @SWG\Response(response=500, description="User not found")
     * )
     * @param $id
     * @return JsonResponse
     */

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

    /**
     * @SWG\Get(path="/api/v1/{meeting_id}",
     *   tags={"meeting"},
     *   summary="Get meeting by Id",
     *   description="This gets only one meeting by id",
     *   operationId="getMeetingById",
     *   @SWG\Parameter(
     *     name="meeting_id",
     *     in="path",
     *     description="The id that needs to be fetched. ",
     *     required=true,
     *     @SWG\Schema(
     *         type="integer"
     *     )
     *   ),
     *   @SWG\Response(response=200, description="successful operation",
     *   @SWG\Response(response=400, description="Invalid Id supplied"),
     *   @SWG\Response(response=500, description="An error has occurred"
     * )
     **/

    public function getMeetingById($id)
    {
        try{
            $meeting = Meeting::findOrFail($id);

            return $meeting;

        }catch (ModelNotFoundException $e) {
            return response()->json([
                'data' => null,
                'message' => 'Meeting not found'
            ], 400);
        }catch (\Exception $e) {
            return response()->json([
                'data' => null,
                'message' => 'An error occurred, please try again'
            ], 500);
        }
    }
}
