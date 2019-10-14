<?php

namespace MBLSolutions\InspiredDeckSupport\Http\Controllers\Legal;

use MBLSolutions\InspiredDeck\ApplicationSettings;
use MBLSolutions\InspiredDeckSupport\Http\Controllers\Controller;

class TermsController extends Controller
{

    /**
     * View the Terms of Service
     *
     * @return array
     */
    public function index(): array
    {
        return view('inspireddeck-views::legal.terms.index', [
            'settings' => (new ApplicationSettings)->get()
        ]);
    }

}