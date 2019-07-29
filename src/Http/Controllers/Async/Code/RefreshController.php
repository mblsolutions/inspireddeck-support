<?php

namespace  MBLSolutions\InspiredDeckSupport\Http\Controllers\Async\Code;

use  MBLSolutions\InspiredDeckSupport\Http\Controllers\Async\AsyncController;
use MBLSolutions\InspiredDeckSupport\Repositories\CodeRepository;

class RefreshController extends AsyncController
{

    /**
     * Search for a Code
     *
     * @param int $serial
     * @return array
     */
    public function code(int $serial): array
    {
        return (new CodeRepository)->refresh($serial)->toArray();
    }

}