<?php

namespace MBLSolutions\InspiredDeckSupport\Http\Controllers\Auth;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use MBLSolutions\InspiredDeckLaravel\Authentication;
use MBLSolutions\InspiredDeckSupport\Http\Controllers\Controller;
use MBLSolutions\InspiredDeckSupport\Http\Requests\AuthenticationRequest;

class LoginController extends Controller
{
    /** @var Authentication $authentication */
    public $authentication;

    /**
     * Login Controller
     *
     * @param Authentication $authentication
     */
    public function __construct(Authentication $authentication)
    {
        $this->authentication = $authentication;
    }

    /**
     * Show the Login Form
     *
     * @return View
     */
    public function show(): View
    {
        return view('auth.login');
    }

    /**
     * Authenticate the user with the application
     *
     * @param AuthenticationRequest $request
     * @return RedirectResponse
     * @throws GuzzleException
     */
    public function authenticate(AuthenticationRequest $request): RedirectResponse
    {
        try {
            $this->authentication->login($request->get('email'), $request->get('password'));

            return redirect('dashboard');

        } catch (Exception $exception) {
            $errors = json_decode($exception->getMessage(), true);

            if ($errors) {
                $message = $errors['message'];
            } else {
                $message = $exception->getMessage();
            }

            return redirect()->back()->withErrors(['auth' => $message]);
        }
    }

    /**
     * Log the user out of the application
     *
     * @return RedirectResponse
     */
    public function logout(): RedirectResponse
    {
        $this->authentication->logout();

        return redirect()->route('login');
    }

}
