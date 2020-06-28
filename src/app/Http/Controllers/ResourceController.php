<?php namespace App\Http\Controllers;

use App\Repositories\CountryRepositoryInterface;

/**
 * Class ResourceController
 * Returns static resources
 * @package App\Http\Controllers
 */
class ResourceController extends Controller
{
    /**
     * @var CountryRepositoryInterface
     */
    private $countryRepository;

    /**
     * ResourceController constructor.
     * @param CountryRepositoryInterface $countryRepository
     */
    public function __construct(
        CountryRepositoryInterface $countryRepository
    )
    {
        $this->countryRepository = $countryRepository;
    }

    /**
     * Return all countries
     * @return \Illuminate\Http\JsonResponse
     */
    public function countries()
    {
        $countries = $this->countryRepository->all();

        return response()->json($countries);
    }
}