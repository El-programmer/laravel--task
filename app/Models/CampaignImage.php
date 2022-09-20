<?php

namespace App\Models;

use App\Models\Traits\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CampaignImage extends Model
{
    use Sluggable;
    protected $primaryKey = 'slug';
    protected $table ="campaign_images";
    protected $fillable = [
        'slug','campaign_id' ,'driver','file',
    ];
    public function campaign(){
        return $this->belongsTo(Campaign::class);
    }
    public  function getfilePathAttribute()
    {
        return Storage::disk($this->driver)->url($this->file);
    }

    public function toArray()
    {
        return [
            'slug' => $this->slug,
            'file' => $this->filePath,
        ];
    }
}
