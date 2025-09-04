<?php

namespace App\Http\Controllers;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LocationController extends Controller
{

    private $rules = [
        'name' => 'required|string|min:3|max:100',
        'address' => 'required|string|min:3|max:255',
    ];

    private $traductionAttributes = [
        'name' => 'nombre',
        'address' => 'dirección',
    ];


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $locations = Location::all();
        return response()->json($locations, Response::HTTP_OK);
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

        $location = Location::create($request->all());
        $response = [
            'message' => 'Registro creado exitosamente',
            'causal' => $location
        ];

        return response()->json($response, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Location $location)
    {
        return response()->json($location, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Location $location)
    {
        $data = $this->applyValidator($request, $this->rules, $this->traductionAttributes);
        if (!empty($data)) {
            return $data;
        }

        $location->update($request->all());
        $response = [
            'message' => 'Registro actualizado exitosamente',
            'causal' => $location
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Location $location)
    {
        $location -> delete();

        $response = [
            'message' => 'Registro eliminado exitosamente',
            'causal' => $location
        ];

        return response()->json($response, Response::HTTP_OK);
    }
}