<?php
namespace Tectonic\Shift\Library\Middleware;

use Auth;
use Closure;
use Consumer;
use Redirect;
use Illuminate\Contracts\Auth\Guard;
use Tectonic\Shift\Library\Authorization\UserConsumer;


/**
 * Class AuthFilter
 *
 * The auth filter manages the logic surrounding setting up consumer data that is dependent on sessions.
 *
 * @package Tectonic\Shift\Library\Filters
 */
class AuthFilter
{

    /**
     * @var \Illuminate\Contracts\Auth\Guard
     */
    protected $auth;

    /**
     * @param \Illuminate\Contracts\Auth\Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param          $request
     * @param callable $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($this->auth->guest())
        {
            return redirect()->to('/');
        }

        Consumer::set(new UserConsumer($this->auth->user()));

        return $next($request);
    }
}
