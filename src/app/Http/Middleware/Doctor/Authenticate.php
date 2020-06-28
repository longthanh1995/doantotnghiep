<?php

namespace App\Http\Middleware\Doctor;

use App\Services\DoctorServiceInterface;
use Closure;
use Illuminate\Http\Request;

class Authenticate
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
     * @param $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$this->doctorService->isSignedIn()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                $url = route('doctor.signIn');

                return redirect()->guest($url);
            }
        }

        view()->share('authDoctor', $this->doctorService->getUser()->account);

        return $next($request);
    }
}
