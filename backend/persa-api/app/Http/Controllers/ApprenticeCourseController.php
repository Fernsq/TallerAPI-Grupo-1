<?php

namespace App\Http\Controllers;
use App\Models\ApprenticeCourse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApprenticeCourseController extends Controller
{

    private $rules = [
        'user_id' => 'required|numeric|min:1|max:99999999999999999999',
        'course_id' => 'required|numeric|min:1|max:99999999999999999999'
    ];

    private $traductionAttributes = [
        'user_id' => 'usuario',
        'course_id' => 'curso'
    ];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $apprenticeCourses = ApprenticeCourse::all();
        $apprenticeCourses->load(['users', 'course']);
        return response()->json($apprenticeCourses, Response::HTTP_OK);
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

        $apprenticeCourse = ApprenticeCourse::create($request->all());
        $response = [
            'message' => 'Registro creado exitosamente',
            'users' => $apprenticeCourse,
            'course' => $apprenticeCourse
        ];
        return response()->json($response, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(ApprenticeCourse $apprenticeCourse)
    {
        $apprenticeCourse->load(['users', 'course']);
        return response()->json($apprenticeCourse, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ApprenticeCourse $apprenticeCourse)
    {
        $data = $this->applyValidator($request, $this->rules, $this->traductionAttributes);
        if (!empty($data)) {
            return $data;
        }

        $apprenticeCourse->update($request->all());
        $response = [
            'message' => 'Registro actualizado exitosamente',
            'users' => $apprenticeCourse,
            'course' => $apprenticeCourse
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ApprenticeCourse $apprenticeCourse)
    {
        $apprenticeCourse -> delete();

        $response = [
            'message' => 'Registro eliminado exitosamente',
            'users' => $apprenticeCourse,
            'course' => $apprenticeCourse
        ];

        return response()->json($response, Response::HTTP_OK);
    }
}