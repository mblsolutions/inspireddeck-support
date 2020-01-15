<?php

namespace MBLSolutions\InspiredDeckSupport\Http\Controllers\Search;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use MBLSolutions\InspiredDeckSupport\Http\Controllers\Controller;
use MBLSolutions\InspiredDeckSupport\Repositories\CodeRepository;

class SearchController extends Controller
{

    /**
     * Search Results Page
     *
     * @param Request $request
     * @return View
     */
    public function results(Request $request): View
    {
        $results = Cache::get($request->get('ck'));

        return view('inspireddeck.code.search.results', [
            'results' => $results ?? ['data' => []]
        ]);
    }

    /**
     * Select a Code
     *
     * @param int $serial
     * @return RedirectResponse
     */
    public function select(int $serial): RedirectResponse
    {
        (new CodeRepository)->search(new Request([
            'reference' => 'ID-' . date('U'),
            'serial' => $serial
        ]));

        return redirect()->route('transaction.index');
    }

}
