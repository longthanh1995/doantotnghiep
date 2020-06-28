<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\ManaImage
 *
 * @property string $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property string $uri
 * @property string $media_type
 * @property integer $width
 * @property integer $height
 * @property integer $size
 * @property string $extension
 * @property string $name
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ManaImage whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ManaImage whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ManaImage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ManaImage whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ManaImage whereUri($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ManaImage whereMediaType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ManaImage whereWidth($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ManaImage whereHeight($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ManaImage whereSize($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ManaImage whereExtension($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ManaImage whereName($value)
 * @mixin \Eloquent
 */
class ManaImage extends Base
{
    use SoftDeletes;

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var string
     */
    protected $connection = 'mysql-backend';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'images';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'uri',
        'media_type',
        'width',
        'height',
        'size',
        'extension',
        'name',
        'description',
        'container',
        'thumbnail_uri',
        'original_uri',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * @var array
     */
    protected $dates = [
        'deleted_at',
    ];

    protected $appends = [
        'thumbnail_url',
        'full_url',
        'preview_url',
    ];

    // Relations

    // Utility Functions
    /**
     * @return string
     */
    public function getFullUrl()
    {
        $uri = $this->original_uri ? $this->original_uri : $this->uri;
        switch($this->container){
            case config('manadr.aws_storage.private_bucket'):
                return $this->getSignedUrl($uri);
            default:
                return $this->getPublicUrl($uri);
        }
    }

    /**
     * @return string
     */
    public function getFullUrlAttribute()
    {
        return $this->getFullUrl();
    }

    /**
     * @return string
     */
    public function getPreviewUrl()
    {
        $uri = $this->uri;
        switch($this->container){
            case config('manadr.aws_storage.private_bucket'):
                return $this->getSignedUrl($uri);
            default:
                return $this->getPublicUrl($uri);
        }
    }

    /**
     * @return string
     */
    public function getPreviewUrlAttribute()
    {
        return $this->getPreviewUrl();
    }

    /**
     * @return string
     */
    public function getThumbnailUrl()
    {
        $uri = $this->thumbnail_uri ? $this->thumbnail_uri : $this->uri;
        switch($this->container){
            case config('manadr.aws_storage.private_bucket'):
                return $this->getSignedUrl($uri);
            default:
                return $this->getPublicUrl($uri);
        }
    }

    /**
     * @return string
     */
    public function getThumbnailUrlAttribute()
    {
        return $this->getThumbnailUrl();
    }

    /**
     * @param $uri
     * @return string
     */
    public function getPublicUrl($uri)
    {
        $s3 = \Storage::disk('s3');
        $client = $s3->getDriver()->getAdapter()->getClient();

        return $client->getObjectUrl($this->container, $uri);
    }

    /**
     * @param $uri
     * @return string
     */
    public function getSignedUrl($uri)
    {
        $s3 = \Storage::disk('s3_private');
        $client = $s3->getDriver()->getAdapter()->getClient();
        $expiry = "+10 minutes";

        $command = $client->getCommand('GetObject', [
            'Bucket' => $this->container,
            'Key'    => $uri,
        ]);

        $request = $client->createPresignedRequest($command, $expiry);

        return (string) $request->getUri();
    }
}
