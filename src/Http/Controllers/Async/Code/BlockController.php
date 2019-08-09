<?php

namespace MBLSolutions\InspiredDeckSupport\Http\Controllers\Async\Code;

use MBLSolutions\InspiredDeckSupport\Http\Controllers\Async\AsyncController;
use MBLSolutions\InspiredDeckSupport\Repositories\CodeRepository;
use Illuminate\Http\Request;

class BlockController extends AsyncController
{

    /**
     * Block a Code
     *
     * @param Request $request
     * @return array
     */
    public function code(Request $request): array
    {
        return (new CodeRepository)->block($request)->toArray();
    }

}