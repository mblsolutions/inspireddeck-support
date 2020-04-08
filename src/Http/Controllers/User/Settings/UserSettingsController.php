<?php

namespace MBLSolutions\InspiredDeckSupport\Http\Controllers\User\Settings;

use Illuminate\View\View;
use MBLSolutions\InspiredDeckSupport\Http\Controllers\Controller;

class UserSettingsController extends Controller
{

    /**
     * Edit User Settings
     *
     * @return View
     */
    public function edit(): View
    {
        return view('inspireddeck.user.settings.edit');
    }

}
