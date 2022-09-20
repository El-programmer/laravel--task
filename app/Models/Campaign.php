<?php

namespace App\Models;

use App\Models\Traits\Sluggable;
use App\Scopes\UserScope;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use Sluggable;
    protected $fillable = [
        'slug','name' ,'from','to','total','daily_budget','user_id',
    ];
    protected $casts =[
        'from' =>'date',
        'to' =>'date',
    ];
    public function images(){
        return $this->hasMany(CampaignImage::class);
    }

    public function toArray()
    {
        return [
            'slug' => $this->slug,
            'name' => $this->name ,
            'from' => $this->from,
            'to' => $this->to,
            'total' => $this->total,
            'daily_budget' => $this->daily_budget,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at
        ];
    }

    protected static function booted()
    {
        parent::booted();
        static::addGlobalScope(new UserScope());

    }
}
