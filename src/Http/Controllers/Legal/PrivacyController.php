<?php

namespace MBLSolutions\InspiredDeckSupport\Http\Controllers\Legal;

use Illuminate\View\View;
use MBLSolutions\InspiredDeck\ApplicationSettings;
use MBLSolutions\InspiredDeckSupport\Http\Controllers\Controller;
use MBLSolutions\InspiredDeckSupport\Services\MarkDownRenderService;

class PrivacyController extends Controller
{
    /** @var ApplicationSettings $settings */
    protected $settings;

    /** @var MarkDownRenderService */
    protected $renderService;

    /**
     * Privacy Policy Controller
     *
     * @param ApplicationSettings $settings
     * @param MarkDownRenderService $renderService
     */
    public function __construct(ApplicationSettings $settings, MarkDownRenderService $renderService)
    {
        $this->settings = $settings;
        $this->renderService = $renderService;
    }

    /**
     * View the Privacy Policy
     *
     * @return View
     */
    public function index(): View
    {
        $applicationSettings = $this->settings->get();

        return view('inspireddeck.legal.privacy', [
            'contents' => $this->renderService->render($applicationSettings['data']['privacy_policy'])
        ]);
    }

}
