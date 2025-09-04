<?php

namespace App\Http\Controllers;
use App\Models\Career;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class CareerController extends Controller
{
    private $rules = [
        'name' => 'required|string|min:3|max:50',
        'type' => 'required|string|min:3|max:50',
    ];

    private $traductionAttributes = [
        'name' => 'nombre',
        'type' => 'tipo',
    ];


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $careers = Career::all();
        return response()->json($careers, Response::HTTP_OK);
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

        $career = Career::create($request->all());
        $response = [
            'message' => 'Registro creado exitosamente',
            'career' => $career
        ];

        return response()->json($response, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Career $career)
    {
        return response()->json($career, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Career $career)
    {
        $data = $this->applyValidator($request, $this->rules, $this->traductionAttributes);
        if (!empty($data)) {
            return $data;
        }

        $career->update($request->all());
        $response = [
            'message' => 'Registro actualizado exitosamente',
            'career' => $career
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Career $career)
    {
        $career -> delete();

        $response = [
            'message' => 'Registro eliminado exitosamente',
            'career' => $career
        ];

        return response()->json($response, Response::HTTP_OK);
    }
}