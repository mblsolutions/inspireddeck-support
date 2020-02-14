<?php

use Illuminate\Support\Str;
use MBLSolutions\InspiredDeckSupport\Product\Code;
use MBLSolutions\InspiredDeckSupport\Repositories\CodeRepository;
use MBLSolutions\InspiredDeckSupport\Services\UIAvatarsService;

if (! function_exists('c')) {
    /**
     * Check if Route is current
     *
     * @param string $name
     * @return bool
     */
    function route_contains(string $name)
    {
        if (request()->route()) {
            return Str::contains(request()->route()->getName(), $name);
        }

        return false;
    }
}

if (! function_exists('deck_auth')) {
    function deck_auth()
    {
        return new InspiredDeckAuth();
    }
}

if (! function_exists('selected_code')) {
    /**
     * Selected Code
     *
     * @param null $default
     * @return Code|null
     */
    function selected_code($default = null)
    {
        $code = (new CodeRepository())->getSelectedCode($default);

        if ($code) {
            return new Code(json_decode($code, true));
        }

        return null;
    }
}

if (! function_exists('deck_js_object')) {
    /**
     * Get the Inspired Deck JS Object
     *
     * @return string
     */
    function deck_js_object()
    {
        return json_encode([
            'serial' => optional(selected_code())->serial
        ], JSON_FORCE_OBJECT);
    }
}

if (! function_exists('ui_avatar')) {

    /**
     * Get the UI Avatar Service
     *
     * @return UIAvatarsService
     */
    function ui_avatar()
    {
        return new UIAvatarsService();
    }

}