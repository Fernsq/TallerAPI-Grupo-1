<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CourseController extends Controller
{

    private $rules = [
        'number_group' => 'required|numeric|min:1|max:99999999999999999999',
        'shift' => 'requiered|string|max:50',
        'trimester' => 'required|string|max:50',
        'year' => 'required|numeric|min:1900|max:2100',
        'status' => 'required|string|max:50',
        'career_id' => 'required|exists:careers,id'
    ];

    private $traductionAttributes = [
        'number_group' => 'numero de grupo',
        'shift' => 'jornada',
        'trimester' => 'trimestre',
        'year' => 'año',
        'status' => 'estado',
        'career_id' => 'carrera'
    ];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::all();
        $courses->load(['career']);
        return response()->json($courses, Response::HTTP_OK);
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

        $course = Course::create($request->all());
        $response = [
            'message' => 'Registro creado exitosamente',
            'course' => $course
        ];

        return response()->json($response, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        $course->load(['career']);
        return response()->json($course, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        $data = $this->applyValidator($request, $this->rules, $this->traductionAttributes);
        if (!empty($data)) {
            return $data;
        }

        $course->update($request->all());
        $response = [
            'message' => 'Registro actualizado exitosamente',
            'career' => $course
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $course -> delete();

        $response = [
            'message' => 'Registro eliminado exitosamente',
            'career' => $course
        ];

        return response()->json($response, Response::HTTP_OK);
    }
}