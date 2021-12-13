<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function response;

class StudentController extends Controller
{
    /**
     * Get a listing of all the students
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $count = Student::all()
            ->offsetGet($request->query('offset'))
            ->limit($request->query('limit'))
            ->orWhere('firstName', 'like', '%'.$request->query('firstName').'%')
            ->withoutTrashed()
            ->get()
            ->count();
        $students = Student::all()
            ->offsetGet($request->query('offset'))
            ->limit($request->query('limit'))
            ->orWhere('firstName', 'like', '%'.$request->query('firstName').'%')
            ->withoutTrashed()
            ->get();
        return response()->json(['count'=>$count,'rows'=>$students]);
    }

    /**
     * Add a student
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $student = Student::create($request->all());
        } catch (Exception $error) {
            DB::rollBack();
            return response()->json(['status'=>'failed','error'=>$error->errorInfo[2]], 500);
        }
        DB::commit();
        return response()->json(['status'=>'success','obj'=>$student], 201);
    }

    /**
     * Update a student
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        $student = Student::find($request->get('id'));
        DB::beginTransaction();

        if ($student===null) {
            DB::rollBack();
            return response()->json(['status'=>'failed','error'=>'Student does not exist']);
        }

        try {
            $student->update([
                'firstName' => $request->get('firstName'),
                'lastName' => $request->get('lastName'),
                'email' => $request->get('email'),
                'age' => $request->get('age')
            ]);
        } catch (Exception $error) {
            DB::rollBack();
            return response()->json(['status'=>'failed','error'=>$error->errorInfo[2]], 500);
        }

        DB::commit();
        return response()->json(['status'=>'success','obj'=>$student]);
    }

    /**
     * Delete a student
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $student = Student::find($id);
        DB::beginTransaction();

        if ($student===null) {
            DB::rollBack();
            return response()->json(['status'=>'failed','error'=>'Student does not exist']);
        }

        try {
            $student->delete();
        } catch (Exception $error) {
            DB::rollBack();
            return response()->json(['status'=>'failed','error'=>$error->errorInfo[2]], 500);
        }

        DB::commit();
        return response()->json(['status'=>'success','obj'=>$student]);
    }

    /**
     * Get student by id
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $student = Student::find($id);
        return response()->json($student);
    }
}
