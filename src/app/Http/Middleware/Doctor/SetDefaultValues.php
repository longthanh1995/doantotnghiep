<?php

namespace App\Http\Middleware\Doctor;

use Closure;
use App\Services\DoctorServiceInterface;
use Illuminate\Http\Request;

/**
 * Class SetDefaultValues.
 */
class SetDefaultValues
{
    /** @var DoctorServiceInterface */
    protected $doctorService;

    /**
     * Create a new filter instance.
     *
     * @param DoctorServiceInterface $userService
     */
    public function __construct(DoctorServiceInterface $userService)
    {
        $this->doctorService = $userService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle(Request $request, \Closure $next)
    {
        $user = $this->doctorService->getUser()?$this->doctorService->getUser()->account:null;

        if ($user) {
            $user->load('profileImage');
        }

        \View::share('authDoctor', $user);

        return $next($request);
    }
}
