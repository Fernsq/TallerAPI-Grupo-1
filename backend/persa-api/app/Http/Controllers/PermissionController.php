<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PermissionController extends Controller
{

    private $rules = [
        'permission_date' => 'required|date',
        'start_time' => 'required',
        'end_time' => 'required',
        'departure_time' => 'required',
        'reason' => 'required|string|max:255',
        'instructor_id' => 'required|exists:users,id',
        'career_id' => 'required|exists:careers,id',
        'apprentice_id' => 'required|exists:users,id',
        'instructor_id' => 'required|exists:users,id',
        'status' => 'required|string|max:50',
    ];

    private $traductionAttributes = [
        'permission_date' => 'fecha de permiso',
        'start_time' => 'hora de inicio',
        'end_time' => 'hora de fin',
        'departure_time' => 'hora de salida',
        'reason' => 'motivo',
        'instructor_id' => 'instructor',
        'career_id' => 'carrera',
        'apprentice_id' => 'aprendiz',
        'instructor_id' => 'instructor',
        'status' => 'estado',
    ];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::all();
        $permissions->load(['user,career,location,permissionType']);
        return response()->json($permissions, Response::HTTP_OK);
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

        $permission = Permission::create($request->all());
        $response = [
            'message' => 'Registro creado exitosamente',
            'user' => $permission,
            'career' => $permission,
            'location' => $permission,
            'permissionType' => $permission
        ];

        return response()->json($response, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        $permission->load(['user,career,location,permissionType']);
        return response()->json($permission, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        $data = $this->applyValidator($request, $this->rules, $this->traductionAttributes);
        if (!empty($data)) {
            return $data;
        }

        $permission->update($request->all());
       $response = [
            'message' => 'Registro actualizado exitosamente',
            'user' => $permission,
            'career' => $permission,
            'location' => $permission,
            'permissionType' => $permission
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $permission -> delete();

        $response = [
            'message' => 'Registro eliminado exitosamente',
            'user' => $permission,
            'career' => $permission,
            'location' => $permission,
            'permissionType' => $permission
        ];

        return response()->json($response, Response::HTTP_OK);
    }
}