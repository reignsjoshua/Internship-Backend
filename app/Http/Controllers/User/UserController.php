<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use App\Models\Intern;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserController extends Controller
{
    public function registerIntern(Request $request)
    {

        try {
            $validatedData = $request->validate([
                'first_name' => 'required|string',
                'middle_name' => 'string|nullable',
                'last_name' => 'required|string',
                'school' => 'required|string',
                'age' => 'required|integer',
                'year_level' => 'required|string',
                'gender' => 'required|string',
            ]);

            $data = [
                'first_name' => $validatedData['first_name'],
                'middle_name' => $validatedData['middle_name'],
                'last_name' => $validatedData['last_name'],
                'school' => $validatedData['school'],
                'age' => $validatedData['age'],
                'year_level' => $validatedData['year_level'],
                'gender' => $validatedData['gender'],
            ];
            $intern = Intern::create($data);
            return response()->json([
                'message' => 'Added Successfuly',
                'data' => $intern,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Exception: ' . $e->getMessage());

            return response()->json([
                'message' => 'Something went wrong',
                'status' => 500,
            ], 500);
        }
    }

    public function getInterns()
    {
        try {
            $data = Intern::get();

            return response()->json([
                'status' => 200,
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            Log::error('Error retrieving interns: ' . $e->getMessage());

            return response()->json([
                'error' => 'Unable to retrieve interns',
                'status' => 500,
            ]);
        }
    }

    public function deleteIntern($id)
    {
        try {
            $intern = Intern::find($id);

            if (!$intern) {
                return response()->json([
                    'message' => 'Intern not found',
                    'status' => 404,
                ], 404);
            } else {


                $intern->delete();

                return response()->json([
                    'status' => 204,
                    'message' => 'Deleted successfuly',
                ], 204);
            }
        } catch (\Exception $e) {
            Log::error('Error retrieving interns: ' . $e->getMessage());

            return response()->json([
                'error' => 'Something went wrong',
                'status' => 500,
            ]);
        }
    }

    public function updateIntern(Request $request, $id)
    {
        try {
            Intern::find($id)->update($request->all());

            return response()->json([
                'message' => 'Updated Successfuly',
                'status' => 200,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error updating interns: ' . $e->getMessage());

            return response()->json([
                'error' => 'Something went wrong',
                'status' => 500,
            ]);
        }
    }
}
