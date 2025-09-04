<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Client\Response as ClientResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{

    private $rules = [
        'fullname' => 'required|string|min:3|max:255',
        'email' => 'required|email|max:255',
        'document' => 'required|numeric',
        'password' => 'nullable|string|min:6|max:255|confirmed',
        'status' => 'required|string|in:ACTIVO,INACTIVO',
        'role_id' => 'required|numeric|exists:roles,id'
    ];


    private $traductionAttributes = [
        'fullname' => 'nombre completo',
        'email' => 'correo electrónico',
        'document' => 'documento',
        'password' => 'contraseña',
        'status' => 'estado',
        'role_id' => 'rol'
    ];

    private $statuses = [
        ['name' => 'ACTIVO', 'value' => 'ACTIVO'],
        ['name' => 'INACTIVO', 'value' => 'INACTIVO']
    ];


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        $users->load(['roles']);
        return response()->json($users, Response::HTTP_OK);
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

        $user = User::crete($request->all());
        $response = [
            'message' => 'Usuario creado exitosamente',
            'activity' => $user
        ];

        return response()->json($response, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load(['role']);
        return response()->json($user, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $user->update($request->all());
        $response = [
            'message' => 'Usuario actualizado exitosamente',
            'activity' => $user
        ];
        return response()->json($response, Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user -> delete();
        $response = [
            'message' => 'Usuario eliminado exitosamente',
            'technician' => $user
        ];

        return response()->json($response, Response::HTTP_OK);
    }
}
