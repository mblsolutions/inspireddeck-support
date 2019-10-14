<?php

namespace MBLSolutions\InspiredDeckSupport\Http\Controllers\Legal;

use MBLSolutions\InspiredDeck\ApplicationSettings;
use MBLSolutions\InspiredDeckSupport\Http\Controllers\Controller;

class PrivacyController extends Controller
{

    /**
     * View the Privacy Policy
     *
     * @return array
     */
    public function index(): array
    {
        return view('inspireddeck-views::legal.privacy.index', [
            'settings' => (new ApplicationSettings)->get()
        ]);
    }

}