<?php

namespace MBLSolutions\InspiredDeckSupport\Http\Controllers\Async\Code;

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
            'privacy' => null
        ]);
    }

}