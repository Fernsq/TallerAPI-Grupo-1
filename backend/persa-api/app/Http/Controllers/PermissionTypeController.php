<?php

namespace App\Http\Controllers;
use App\Models\PermissionType;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PermissionTypeController extends Controller
{

    private $rules = [
        'name' => 'required|string|min:3|max:100'
    ];

    private $traductionAttributes = [
        'name' => 'descripción'
    ];


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permisionTypes = PermissionType::all();
        return response()->json($permisionTypes, Response::HTTP_OK);
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

        $permisionType = PermissionType::create($request->all());
        $response = [
            'message' => 'Registro creado exitosamente',
            'causal' => $permisionType
        ];

        return response()->json($response, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(PermissionType $permisionType)
    {
        return response()->json($permisionType, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PermissionType $permisionType)
    {
        $data = $this->applyValidator($request, $this->rules, $this->traductionAttributes);
        if (!empty($data)) {
            return $data;
        }

        $permisionType->update($request->all());
        $response = [
            'message' => 'Registro actualizado exitosamente',
            'causal' => $permisionType
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PermissionType $permisionType)
    {
        $permisionType -> delete();

        $response = [
            'message' => 'Registro eliminado exitosamente',
            'causal' => $permisionType
        ];

        return response()->json($response, Response::HTTP_OK);
    }
}