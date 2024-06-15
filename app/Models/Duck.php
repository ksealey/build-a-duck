<?php

namespace App\Models;

use App\Strategies\GeneratesImageData;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use MongoDB\Laravel\Eloquent\Model;

class Duck extends Model
{
    use HasFactory,
        HasUuids;

    /**
     * The attributes that are guarded.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

     /**
     * The attributes that are appended.
     *
     * @var array<int, string>
     */
    protected $appends = ['image_uri'];
    
    /**
     * Get the user associated with a duck
     * 
     * @return \MongoDB\Laravel\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get a public-facing uri for an image
     * 
     * @return string
     */
    public function getImageUriAttribute()
    {
        return Storage::disk('public')->url($this->image_path);
    }

    /**
     * Use the provided strategy to generate an image resource
     * 
     * @param \App\Strategies\GeneratesImageData $generator
     * @param int $width
     * @param int $height
     * 
     * @return resource
     */
    public function generateImage(GeneratesImageData $generator, int $width = 200, int $height = 200)
    {
        return $generator->createImage($this, $width, $height);
    }
}
