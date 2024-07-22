<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexRequest;
use App\Http\Requests\StoreAndUpdateLoanRequest;
use App\Http\Resources\LoanResource;
use App\Models\Loan;
use Carbon\Carbon;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexRequest $request)
    {
        $query = Loan::query();

        $request->whenFilled('filter.created_at.from', function($from) use ($query) {
            $from = Carbon::createFromTimestamp($from, config('app.timezone'))->toDateTimeString();
            $query->where('created_at', '>=', $from);
        });
        $request->whenFilled('filter.created_at.to', function($to) use ($query) {
            $to = Carbon::createFromTimestamp($to, config('app.timezone'))->toDateTimeString();
            $query->where('created_at', '<=', $to);
        });
        $request->whenFilled('filter.amount.from', function($from) use ($query) {
            $query->where('amount', '>=', $from);
        });
        $request->whenFilled('filter.amount.to', function($to) use ($query) {
            $query->where('amount', '<=', $to);
        });

        return LoanResource::collection($query->get());
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
        $loan->update($request->validated());
        return new LoanResource($loan);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Loan $loan)
    {
        $loan->delete();
        return LoanResource::collection(Loan::all());
    }
}
