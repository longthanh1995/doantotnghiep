<?php
/**
 * Created by PhpStorm.
 * User: Knightus
 * Date: 6/20/2017
 * Time: 1:40 AM
 */

namespace App\Jobs\File;


use App\Jobs\Job;
use App\Models\ManaImage;
use App\Repositories\ManaImageRepositoryInterface;
use Illuminate\Http\UploadedFile;
use MicrosoftAzure\Storage\Blob\Models\CreateBlobOptions;
use WindowsAzure\Common\ServiceException;
use WindowsAzure\Common\ServicesBuilder;

class UploadFile extends Job
{
    /**
     * @var UploadedFile
     */
    protected $file;

    private $container;

    public function __construct(UploadedFile $file, $container = null)
    {
        $this->file = $file;
        $this->container = $container;
    }

    public function handle(
        ManaImageRepositoryInterface $manaImageRepository
    ){
        $container = $this->container ? $this->container : config('manadr.aws_storage.bucket');
        $content = fopen($this->file->getRealPath(), 'r');
        $blobName = 'file/'.$this->file->hashName();

        switch($container){
            case config('manadr.aws_storage.private_bucket'):
                $diskName = 's3_private';
                break;
            default:
                $diskName = 's3';
                break;
        }

        try {
            \Storage::disk($diskName)->put(
                $blobName,
                $content
            );
        } catch (\Exception $exception) {
            $code = $exception->getCode();
            $error_message = $exception->getMessage();

            throw new \Exception($code.': '.$error_message.PHP_EOL);
        }

        $manaImage = $manaImageRepository->create([
            'id' => str_random(26),
            'uri' => $blobName,
            'thumbnail_uri' => $blobName,
            'original_uri' => $blobName,
            'media_type' => $this->file->getMimeType(),
            'width' => null,
            'height' => null,
            'size' => $this->file->getSize(),
            'extension' => $this->file->extension(),
            'name' => $this->file->hashName(),
            'container' => $container,
        ]);

        return $manaImage;
    }
}