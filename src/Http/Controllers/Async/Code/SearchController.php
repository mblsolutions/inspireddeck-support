<?php

namespace MBLSolutions\InspiredDeckSupport\Http\Controllers\Async\Code;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use MBLSolutions\InspiredDeckSupport\Http\Controllers\Async\AsyncController;
use MBLSolutions\InspiredDeckSupport\Repositories\CodeRepository;
use Illuminate\Http\Request;

class SearchController extends AsyncController
{

    /**
     * Search for a Code
     *
     * @param Request $request
     * @return array|JsonResponse
     */
    public function search(Request $request)
    {
        $result = (new CodeRepository)->search($request);

        if ($result instanceof Collection && $result->get('meta') !== null) {

            $cacheKey = $this->getCacheKey();

            Cache::put($cacheKey, $result->toArray(), now()->addHour(1));

            return new JsonResponse($result->toArray(), 307, [
                'Redirect' => route('code.search.result', [
                    'ck' => $cacheKey,
                    'customer' => $request->get('customer')
                ])
            ]);
        }

        return $result->toArray();
    }

    /**
     * Get the search result cache key
     *
     * @return string
     */
    public function getCacheKey(): string
    {
        return base64_encode(Str::uuid()->toString() . 'search_results');
    }

}
