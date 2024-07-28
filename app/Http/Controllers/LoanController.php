<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexLoanRequest;
use App\Http\Requests\StoreAndUpdateLoanRequest;
use App\Http\Resources\LoanResource;
use App\Models\Loan;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class LoanController extends Controller
{
    /**
     * Получение списка всех займов с базовыми фильтрами по дате создания и сумме
     * @queryParam filter[created_at][from] integer Example: 1715927864
     * @queryParam filter[created_at][to] integer Example: 1715940063
     * @queryParam filter[amount][from] integer Example: 3000
     * @queryParam filter[amount][to] integer Example: 4800
     */
    public function index(IndexLoanRequest $request): AnonymousResourceCollection
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
     * Создание нового займа
     * @bodyParam amount integer required The amount of the loan. Example: 3000
     */
    public function store(StoreAndUpdateLoanRequest $request): LoanResource
    {
        return new LoanResource(Loan::create(['amount' => $request->amount]));
    }

    /**
     * Получение информации о займе
     */
    public function show(Loan $loan): LoanResource
    {
        return new LoanResource($loan);
    }

    /**
     * Обновление информации о займе
     * @bodyParam amount integer required The amount of the loan. Example: 3000
     */
    public function update(StoreAndUpdateLoanRequest $request, Loan $loan): LoanResource
    {
        $loan->update($request->validated());
        return new LoanResource($loan);
    }

    /**
     * Удаление займа
     */
    public function destroy(Loan $loan): AnonymousResourceCollection
    {
        $loan->delete();
        return LoanResource::collection(Loan::all());
    }
}
