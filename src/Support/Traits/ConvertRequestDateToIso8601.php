<?php

namespace MBLSolutions\InspiredDeckSupport\Support\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

trait ConvertRequestDateToIso8601
{

    /**
     * Convert Request Date to ISO8601
     * @param Request $request
     * @param string $key
     */
    public function convert(Request &$request, string $key)
    {
        if ($request->get($key) !== null) {
            $request->request->set($key, Carbon::parse($request->get($key))->toIso8601String());
        }
    }

}