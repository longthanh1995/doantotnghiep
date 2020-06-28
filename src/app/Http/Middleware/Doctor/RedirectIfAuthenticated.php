<?php

namespace App\Http\Middleware\Doctor;

use Closure;
use App\Services\DoctorServiceInterface;
use Illuminate\Http\Request;

/**
 * Class RedirectIfAuthenticated.
 */
class RedirectIfAuthenticated
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
        if ($this->doctorService->isSignedIn()) {
            $bypassKey = env('BY_PASS_CSRF_TOKEN', null);
            if($bypassKey){
                $requestBypassKey = $request->get('bypassKey');
                if($bypassKey === $requestBypassKey){
                    return $next($request);
                }
            }
            $url = route('doctor.dashboard');

            return redirect()->to($url);
        }

        return $next($request);
    }
}
