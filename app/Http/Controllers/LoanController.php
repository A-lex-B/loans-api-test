<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAndUpdateLoanRequest;
use App\Http\Resources\LoanResource;
use App\Models\Loan;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAndUpdateLoanRequest $request)
    {
        return new LoanResource(Loan::create(['amount' => $request->amount]));
    }

    /**
     * Display the specified resource.
     */
    public function show(Loan $loan)
    {
        return new LoanResource($loan);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreAndUpdateLoanRequest $request, Loan $loan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Loan $loan)
    {
        //
    }
}
