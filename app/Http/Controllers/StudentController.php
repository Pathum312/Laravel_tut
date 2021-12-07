<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use function request;

class StudentController extends Controller
{
    public function get(): JsonResponse
    {
        $count = DB::table('students')
            ->offset(request()->query('offset'))
            ->limit(request()->query('limit'))
            ->whereNull('deleted_at')
            ->get()
            ->count();
        $students = DB::table('students')
            ->offset(request()->query('offset'))
            ->limit(request()->query('limit'))
            ->whereNull('deleted_at')
            ->get();
        return response()->json(['count'=>$count,'rows'=>$students]);
    }

    public function store(): JsonResponse
    {
        try {
            DB::table('students')->insert([
                'firstName' => request('firstName'),
                'lastName' => request('lastName'),
                'email' => request('email'),
                'age' => request('age'),
                'created_at' => Carbon::now()
            ]);
        } catch (Exception $ex) {
            return response()->json(['error'=>$ex], 500);
        }
        return response()->json(['message'=>'Student added'], 201);
    }

    public function update(): JsonResponse
    {
        try {
            DB::table('students')
                ->where('id', request('id'))
                ->whereNull('deleted_at')
                ->update([
                    'firstName' => request('firstName'),
                    'lastName' => request('lastName'),
                    'email' => request('email'),
                    'age' => request('age'),
                    'updated_at' => Carbon::now()
                ]);
        } catch (Exception $ex) {
            return response()->json(['error'=>$ex], 500);
        }
        return response()->json(['message'=>'Student updated']);
    }

    public function destroy($id): JsonResponse
    {
        try {
            DB::table('students')
                ->where('id', $id)
                ->whereNull('deleted_at')
                ->update(['deleted_at' => Carbon::now()]);
        } catch (Exception $ex) {
            return response()->json(['error'=>$ex], 500);
        }
        return response()->json(['message'=>'Student deleted']);
    }

    public function getById($id): JsonResponse
    {
        $student = DB::table('students')
            ->distinct()
            ->where('id', $id)
            ->get();
        return response()->json($student);
    }
}
