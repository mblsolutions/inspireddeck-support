<?php

namespace MBLSolutions\InspiredDeckSupport\Http\Controllers\Async\Code;

use MBLSolutions\InspiredDeckSupport\Http\Controllers\Async\AsyncController;
use MBLSolutions\InspiredDeckSupport\Repositories\CodeRepository;
use Illuminate\Http\Request;

class SearchController extends AsyncController
{

    /**
     * Search for a Code
     *
     * @param Request $request
     * @return array
     */
    public function search(Request $request): array
    {
        return (new CodeRepository)->search($request)->toArray();
    }

}