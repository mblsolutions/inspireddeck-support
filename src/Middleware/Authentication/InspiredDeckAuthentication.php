<?php

namespace MBLSolutions\InspiredDeckSupport\Middleware\Authentication;

use Closure;
use Illuminate\Http\Request;
use MBLSolutions\InspiredDeck\InspiredDeck;
use MBLSolutions\InspiredDeckLaravel\Authentication;
use MBLSolutions\InspiredDeckLaravel\Exceptions\AuthenticationException;

class InspiredDeckAuthentication
{
    /** @var Authentication $authentication */
    private $authentication;

    public function __construct()
    {
        $this->authentication = new Authentication;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->session()->has($this->authentication->sessionKey)) {
            throw new AuthenticationException(401);
        }

        $auth = $this->authentication->get();

        InspiredDeck::setToken($auth['access_token']);

        return $next($request);
    }

}}