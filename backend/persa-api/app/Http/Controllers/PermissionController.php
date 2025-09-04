<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PermissionController extends Controller
{
private $rules = [
        'permission_date' => 'required|date|date_format:Y-m-d',
        'start_time' => 'required|date_format:H:i',
        'end_time' => 'required|date_format:H:i',
        'reasons' => 'required|string|min:3|max:60',
        'location_id' => 'required|numeric|min:1|max:99999999999999999999',
        'permission_type_id' => 'required|numeric|min:1|max:99999999999999999999',
    ];

    private $traductionAttributes = [
        'permission_date' => 'fecha de permiso',
        'start_time' => 'hora de inicio',
        'end_time' => 'hora de fin',
        'reasons' => 'motivo',
        'location_id' => 'sede',
        'permission_type_id' => 'tipo de permiso',
    ];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::all();
        $permissions->load(['users','location','permission_type']);
        return response()->json($permissions, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $this->applyValidator($request, $this->rules, $this->traductionAttributes);
        if(!empty($data)){
            return $data;
        }

        $permission = Permission::create($request->all());
        $response = [
            'message' => 'Permiso creado exitosamente',
            'permission' => $permission
        ];

        return response()->json($response, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        $permission->load(['users','location','permission_type']);
        return response()->json($permission, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        $data = $this->applyValidator($request, $this->rules, $this->traductionAttributes);
        if(!empty($data)){
            return $data;
        }

        $permission->update($request->all());
        $response = [
            'message' => 'Permiso actualizado exitosamente',
            'permission' => $permission
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
        $response = [
            'message' => 'Permiso eliminada exitosamente',
            'permission' => $permission
        ];
    }
}