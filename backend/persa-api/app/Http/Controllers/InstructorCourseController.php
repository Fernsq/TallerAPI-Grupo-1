<?php

namespace App\Http\Controllers;

use App\Models\InstructorCourse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InstructorCourseController extends Controller
{

    private $rules = [
        'instructor_id' => 'required|numeric|min:1|max:99999999999999999999',
        'course_id' => 'required|numeric|min:1|max:99999999999999999999'
    ];

    private $traductionAttributes = [
        'instructor_id' => 'instructor',
        'course_id' => 'curso'
    ];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $instructorCourses = InstructorCourse::all();
        $instructorCourses->load(['users', 'course']);
        return response()->json($instructorCourses, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $this->applyValidator($request, $this->rules, $this->traductionAttributes);
        if (!empty($data)) {
            return $data;
        }

        $instructorCourse = InstructorCourse::create($request->all());
        $response = [
            'message' => 'Registro creado exitosamente',
            'activity' => $instructorCourse
        ];

        return response()->json($response, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(InstructorCourse $instructorCourse)
    {
        $instructorCourse->load(['users', 'course']);
        return response()->json($instructorCourse, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InstructorCourse $instructorCourse)
    {
        $data = $this->applyValidator($request, $this->rules, $this->traductionAttributes);
        if (!empty($data)) {
            return $data;
        }

        $instructorCourse->update($request->all());
        $response = [
            'message' => 'Registro actualizado exitosamente',
            'activity' => $instructorCourse
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InstructorCourse $instructorCourse)
    {
        $instructorCourse -> delete();

        $response = [
            'message' => 'Registro eliminado exitosamente',
            'users' => $instructorCourse,
            'course' => $instructorCourse
        ];

        return response()->json($response, Response::HTTP_OK);
    }
}