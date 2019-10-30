<?php

namespace MBLSolutions\InspiredDeckSupport\Http\Controllers\Async\Product;

use MBLSolutions\InspiredDeck\AssetBatch;
use MBLSolutions\InspiredDeckSupport\Http\Controllers\Async\AsyncController;

class BatchController extends AsyncController
{

    /**
     * Generate an Asset Batch Export URI
     *
     * @param $id
     * @return array
     */
    public function export($id): array
    {
        return (new AssetBatch)->export($id);
    }

}