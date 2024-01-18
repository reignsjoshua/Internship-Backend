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
                'message' => 'Intern Added',
                'data' => $intern,
            ], 201);
        } catch (QueryException $e) {
            Log::error('Database Query Exception: ' . $e->getMessage());
            return response()->json([
                'error' => 'Something went Wrong',
                'status' => 500
            ]);
        } catch (\Exception $e) {
            Log::error('Exception: ' . $e->getMessage());

            return response()->json([
                'error' => 'Something went wrong',
                'status' => 500,
            ]);
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
}
