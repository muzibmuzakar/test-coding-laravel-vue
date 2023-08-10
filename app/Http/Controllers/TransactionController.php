<?php

namespace App\Http\Controllers;

use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Transaction::leftJoin('coas', 'transactions.coa_id', '=', 'coas.id')
        ->leftJoin('categories', 'coas.category_id', '=', 'categories.id')
        ->select(
            'transactions.id',
            'transactions.date',
            'transactions.desc',
            'transactions.debit',
            'transactions.credit',
            'coas.id as coa_id',
            'coas.code as coa_code',
            'coas.name as coa_name',
            'categories.id as category_id',
            'categories.name as category_name',
            'categories.type as category_type',
        )
        ->get();

    return TransactionResource::collection($data);
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
            'date' => 'required',
            'coa_id' => 'required',
            'desc' => 'required',
            'credit' => 'max:255',
            'debit' => 'max:255',
        ]);

        Transaction::create($data);

        return response('created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Transaction::where('id', $id)->first();

        return new TransactionResource($data);
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
            'date' => 'required',
            'coa_id' => 'required',
            'desc' => 'required',
            'debit' => 'max:255',
            'credit' => 'max:255',
        ]);

        Transaction::where('id', $id)->update($data);

        return response('updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Transaction::where('id', $id)->delete();

        return response('deleted');
    }
}
