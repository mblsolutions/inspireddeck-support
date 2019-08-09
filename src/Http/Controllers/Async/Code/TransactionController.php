<?php

namespace MBLSolutions\InspiredDeckSupport\Http\Controllers\Async\Code;

use MBLSolutions\InspiredDeckSupport\Http\Controllers\Async\AsyncController;
use MBLSolutions\InspiredDeck\TransactionHistory;

class TransactionController extends AsyncController
{

    /**
     * Transfer a Code
     *
     * @param int $serial
     * @param int $page
     * @return array
     */
    public function history(int $serial, int $page = 0): array
    {
        return (new TransactionHistory)->all($serial, $page, 5);
    }

}