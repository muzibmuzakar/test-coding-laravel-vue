<?php

namespace App\Http\Controllers;

use App\Http\Resources\CoaResource;
use App\Models\Coa;
use Illuminate\Http\Request;

class CoaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Coa::get();

        return CoaResource::collection($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required',
            'name' => 'required',
            'category_id' => 'required',
        ]);

        Coa::create($data);

        return response('created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Coa::where('id', $id)->first();

        return new CoaResource($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'code' => 'required',
            'name' => 'required',
            'category_id' => 'required',
        ]);

        Coa::where('id', $id)->update($data);

        return response('updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Coa::where('id', $id)->delete();

        return response('deleted');
    }
}
