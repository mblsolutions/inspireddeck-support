<?php

namespace MBLSolutions\InspiredDeckSupport\Http\Controllers\Async\User;

use Illuminate\Http\Request;
use MBLSolutions\InspiredDeck\UserSettings;
use MBLSolutions\InspiredDeckSupport\Http\Controllers\Async\AsyncController;

class UserSettingsController extends AsyncController
{
    /** @var UserSettings */
    protected $settings;

    /**
     * User Settings
     */
    public function __construct()
    {
        $this->settings = new UserSettings;
    }

    /**
     * Get the User Settings
     *
     * @return array
     */
    public function show(): array
    {
        return $this->settings->get();
    }

    /**
     * Update the User Settings
     *
     * @param Request $request
     * @return mixed
     */
    public function update(Request $request)
    {
        return $this->settings->update($request->toArray());
    }

}