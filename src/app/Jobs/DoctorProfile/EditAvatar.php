<?php

namespace App\Jobs\DoctorProfile;

use App\Jobs\Job;
use App\Models\Doctor;
use App\Repositories\DoctorRepositoryInterface;
use App\Repositories\ManaImageRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Intervention\Image\ImageManager;

class EditAvatar extends Job
{
    /**
     * @var Doctor
     */
    protected $doctor;

    /**
     * @var UploadedFile
     */
    protected $avatar;

    /**
     * @var ImageManager
     */
    private $imageManager;

    /**
     * EditAvatar constructor.
     * @param Doctor $doctor
     * @param UploadedFile $avatar
     */
    public function __construct(Doctor $doctor, UploadedFile $avatar)
    {
        $this->doctor = $doctor;
        $this->avatar = $avatar;
        $this->imageManager = new ImageManager();
    }

    /**
     * @param ManaImageRepositoryInterface $manaImageRepository
     * @param DoctorRepositoryInterface $doctorRepository
     * @return mixed
     * @throws \Exception
     */
    public function handle(
        ManaImageRepositoryInterface $manaImageRepository,
        DoctorRepositoryInterface $doctorRepository
    ) {
        //produce images
        //1. thumbnail
        //2. preview
        //3. full image
        $image = $this->imageManager->make($this->avatar);
        $image->backup();
        $imageStream = $image->stream();
        $previewImageStream = $image->stream('jpg', 100);
        $thumbnailImageStream = $image->resize(160, 160, function($constraint){
            $constraint->aspectRatio();
            $constraint->upsize();
        })->stream();
        $image->reset();

        //create azure client & upload
        $container = config('manadr.aws_storage.bucket');

        $blobNamePrefix = "doctors/{$this->doctor->id}-avatar-".md5($image->__toString());
        $imageUploadPath = "{$blobNamePrefix}-full.".$this->avatar->extension();
        $previewImageUploadPath = "{$blobNamePrefix}-preview.jpg";
        $thumbnailImageUploadPath = "{$blobNamePrefix}-thumbnail.jpg";

        try{
            \Storage::put($imageUploadPath, $imageStream->__toString());
            \Storage::put($previewImageUploadPath, $previewImageStream->__toString());
            \Storage::put($thumbnailImageUploadPath, $thumbnailImageStream->__toString());
        } catch(\Exception $exception) {
            $code = $exception->getCode();
            $errorMessage = $exception->getMessage();

            throw new \Exception("{$code}: {$errorMessage}");
        }

        //delete existing profile image
        $existingProfileImage = $this->doctor->profileImage;
        if($existingProfileImage){
            $existingProfileImage->delete();
        }

        //store record
        $manaImage = $manaImageRepository->create([
            'id' => str_random(26),
            'original_uri' => $imageUploadPath,
            'uri' => $previewImageUploadPath,
            'thumbnail_uri' => $thumbnailImageUploadPath,
            'media_type' => $this->avatar->getMimeType(),
            'width' => $image->width(),
            'height' => $image->height(),
            'size' => $image->filesize(),
            'extension' => $this->avatar->extension(),
            'name' => $this->avatar->hashName(),
            'container' => $container,
        ]);

        $this->doctor->profileImage()->associate($manaImage);

        $this->doctor->save();

        return $manaImage->getThumbnailUrl();
    }
}
