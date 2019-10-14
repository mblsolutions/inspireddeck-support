<?php

namespace MBLSolutions\InspiredDeckSupport\Http\Controllers\Legal;

use MBLSolutions\InspiredDeck\ApplicationSettings;
use MBLSolutions\InspiredDeckSupport\Http\Controllers\Controller;

class PrivacyController extends Controller
{
    /** @var ApplicationSettings $settings */
    protected $settings;

    /**
     * Privacy Policy Controller
     *
     * @param ApplicationSettings $settings
     */
    public function __construct(ApplicationSettings $settings)
    {
        $this->settings = $settings;
    }

    /**
     * View the Privacy Policy
     *
     * @return array
     */
    public function index(): array
    {
        return view('inspireddeck-views::legal.privacy.index', [
            'settings' => $this->settings->get()
        ]);
    }

}