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
     * @OA\Get(path="/api/v1/meetings",
     *   tags={"Meeting"},
     *   summary="Get 25 meetings with pagination",
     *   description="",
     *   @OA\Response(response=201,  description="Get all meeting")
     * )
     */
    public function index()
    {
        try{
            $meeting = Meeting::paginate(25);

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
     * @OA\POST(path="/api/v1/meetings",
     *   tags={"Meeting"},
     *   summary="Add a new meeting to the database",
     *   description="Add a new meeting to the database",
     *   @OA\Parameter(
     *      name="event_id",
     *      description="Event id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *      type="integer"
     *      )
     *     ),
     *    @OA\Parameter(
     *      name="employee_id",
     *      description="Employee id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *      type="integer"
     *      )
     *     ),
     *     @OA\Parameter(
     *      name="user_id",
     *      description="User id",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *      type="integer"
     *      )
     *     ),
     *   @OA\Response(response=201,  description="Create Meeting"),
     *   @OA\Response(response=500,  description="There is an error with your request")
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
     * @OA\PUT(path="/api/v1/meetings/{meeting_id}",
     *   tags={"Meeting"},
     *   summary="Update an exisitng meeting to the database",
     *   description="Update meeting to the database",
     *   @OA\Parameter(
     *      name="event_id",
     *      description="Meeting id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *      type="integer"
     *      )
     *     ),
     *    @OA\Parameter(
     *      name="employee_id",
     *      description="Employee id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *      type="integer"
     *      )
     *     ),
     *     @OA\Parameter(
     *      name="user_id",
     *      description="User id",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *      type="integer"
     *      )
     *     ),
     *   @OA\Response(response=201,  description="Create Meeting"),
     *   @OA\Response(response=500,  description="There is an error with your request")
     * )
     * @param Request $request
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
     * @OA\Delete(
     *     path="/api/v1/meeting/{meeting_id}",
     *     summary="Deletes meeting",
     *     description="",
     *     operationId="deleteMeeting",
     *     tags={"Meeting"},
     *     @OA\Parameter(
     *         description="Meeting id to delete",
     *         in="path",
     *         name="meetingId",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Header(
     *         header="api_key",
     *         description="Api key header",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid ID supplied"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Meeting not found"
     *     ),
     * )
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
     * @OA\Get(
     *     path="/api/v1/meeting/{meeting_id}",
     *     tags={"Meeting"},
     *     operationId="getAMeeting",
     *     summary="Get meeting by Id",
     *     description="",
     *     @OA\Parameter(
     *      name="meeting",
     *      description="Meeting id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *      type="integer"
     *      )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid ID supplied"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Meeting not found"
     *     ),
     * )
     */
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
