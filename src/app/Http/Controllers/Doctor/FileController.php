<?php
/**
 * Created by PhpStorm.
 * User: Knightus
 * Date: 6/20/2017
 * Time: 1:32 AM
 */

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Jobs\File\UploadFile;
use Illuminate\Http\Request;
use App\Repositories\ManaImageRepositoryInterface;

class FileController extends Controller
{
    /**
     * @var ManaImageRepositoryInterface
     */
    protected $manaImageRepository;

    public function __construct(
        ManaImageRepositoryInterface $manaImageRepository
    )
    {
        $this->manaImageRepository = $manaImageRepository;
    }

    public function store(Request $request){
        $file = $request->file('file');

        $uploaded_file = $this->dispatchNow(new UploadFile($file));

        return response()->json([
            'success' => true,
            'file' => $uploaded_file
        ]);
    }
}