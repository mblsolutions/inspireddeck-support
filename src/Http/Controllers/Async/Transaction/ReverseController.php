<?php

namespace MBLSolutions\InspiredDeckSupport\Http\Controllers\Async\Transaction;

use MBLSolutions\InspiredDeckSupport\Http\Controllers\Async\AsyncController;
use Illuminate\Http\Request;
use MBLSolutions\InspiredDeck\ReverseTransaction;

class ReverseController extends AsyncController
{

    /**
     * Check Balance of Code
     *
     * @param Request $request
     * @return array
     */
    public function transaction(Request $request): array
    {
        return (new ReverseTransaction)->reverse($request->toArray());
    }

}
