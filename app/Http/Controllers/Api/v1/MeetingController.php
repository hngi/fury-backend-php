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
     * @OA\Get(
     *   path="/api/v1/meetings",
     *   summary="Get all meetings with pagination",
     *   tags={"Meeting"},
     *   @OA\Response(response=201, description="Meeting successful fetched")
     *
     *   @OA\Response(response=401,  description="Unauthenticated",  description="Unauthenticated",)
     *
     *   @OA\Response(response=403,description="Forbidden")
     *
     *   @OA\Response(response=403,description="Forbidden")
     * )
     */
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
     * @@OA\Post(
     *     path="/api/v1/meetings",
     *     operationId="addMeeting",
     *     summary="Add a new meeting to the database",
     *     tags={"Meeting"},
     *     @OA\RequestBody(
     *      description="Meeting object that needs to be added to the store",
     *      required=true,
     *      @OA\Parameter(
     *       name="user_id",
     *       required=true,
     *       description="The user id",
     *       @OA\Schema(
     *         type="integer"
     *       )
     *   ),
     *   @OA\Parameter(
     *     name="employee_id",
     *     @OA\Schema(
     *      type="integer",
     *     ),
     *     description="The employee id",
     *      ),
     *     ),
     *     @OA\Parameter(
     *     name="event_id",
     *     @OA\Schema(
     *      type="integer",
     *     ),
     *     description="The event id",
     *     ),
     * @OA\Response(response=201, description="Meeting successful fetched")
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
     * @OA\Put(
     *     path="/api/v1/meetings/{eventId}",
     *     operationId="updateMeeting",
     *     summary="Update meeting to the database",
     *     tags={"Meeting"},
     *     @OA\RequestBody(
     *      description="Meeting object that needs to be updated to the store",
     *      required=true,
     *     @OA\Parameter(
     *     name="eventId",
     *     in="path",
     *     description="Event Id to find a paticular meeting",
     *     required=true,
     *     @OA\Schema(
     *         type="string"
     *     )
     *   ),
     *      @OA\Parameter(
     *       name="user_id",
     *       required=true,
     *       description="The user id",
     *       @OA\Schema(
     *         type="integer"
     *       )
     *   ),
     *   @OA\Parameter(
     *     name="employee_id",
     *     @OA\Schema(
     *      type="integer",
     *     ),
     *     description="Employee id",
     *      ),
     *     ),
     *     *   @OA\Parameter(
     *     name="event_id",
     *     @OA\Schema(
     *      type="integer",
     *     ),
     *     description="The event id",
     *      ),
     *     ),
     * @OA\Response(response=201, description="Meeting successful fetched")
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
     * @OA\Delete(path="/api/vi/meeting/{meeting_id}",
     *   tags={"Meeting"},
     *   summary="Delete Meeting",
     *   description="This endpoint deletes a meeting",
     *   operationId="meeting_id",
     *   @OA\Parameter(
     *     name="meeting_id",
     *     in="path",
     *     description="The meeting id that needs to be deleted",
     *     required=true,
     *     @OA\Schema(
     *         type="integer"
     *     )
     *   ),
     *   @OA\Response(response=400, description="Invalid username supplied"),
     *   @OA\Response(response=500, description="User not found")
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
     * @OA\Get(path="/api/v1/{meeting_id}",
     *   tags={"meeting"},
     *   summary="Get meeting by Id",
     *   description="This gets only one meeting by id",
     *   operationId="getMeetingById",
     *   @OA\Parameter(
     *     name="meeting_id",
     *     in="path",
     *     description="The id that needs to be fetched. ",
     *     required=true,
     *     @OA\Schema(
     *         type="integer"
     *     )
     *   ),
     *   @OA\Response(response=200, description="successful operation",
     *   @OA\Response(response=400, description="Invalid Id supplied"),
     *   @OA\Response(response=500, description="An error has occurred"
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
