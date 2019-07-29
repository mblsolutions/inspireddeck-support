<?php

namespace  MBLSolutions\InspiredDeckSupport\Http\Controllers\Async\Code;

use  MBLSolutions\InspiredDeckSupport\Http\Controllers\Async\AsyncController;
use MBLSolutions\InspiredDeckSupport\Repositories\CodeRepository;
use Illuminate\Http\Request;

class TransferController extends AsyncController
{

    /**
     * Transfer a Code
     *
     * @param Request $request
     * @return array
     */
    public function code(Request $request): array
    {
        return (new CodeRepository)->transfer($request)->toArray();
    }

}