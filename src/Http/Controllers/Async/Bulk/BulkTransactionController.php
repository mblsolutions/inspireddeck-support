<?php

namespace MBLSolutions\InspiredDeckSupport\Http\Controllers\Async\Bulk;

use MBLSolutions\InspiredDeck\BulkTransaction;
use MBLSolutions\InspiredDeckSupport\Http\Controllers\Async\AsyncController;

class BulkTransactionController extends AsyncController
{

    /**
     * Transfer a Code
     *
     * @param int $page
     * @return array
     */
    public function index(int $page = 0): array
    {
        return (new BulkTransaction)->all($page, 5);
    }

    /**
     * Generate Response Export URI
     *
     * @param $id
     * @return array
     */
    public function export($id): array
    {
        return (new BulkTransaction)->export($id);
    }

    /**
     * Get Bulk Transaction metrics
     *
     * @return array
     */
    public function metrics(): array
    {
        return (new BulkTransaction)->metrics();
    }

}