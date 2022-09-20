<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CampaignRequest;
use App\Http\Resources\CampaignResource;
use App\Models\Campaign;
use App\Models\CampaignImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CampaignController extends Controller
{
    public function index()
    {
        return response()->json( [
            'data' => CampaignResource::collection(Campaign::with('images')->latest()->get())
        ], 200);

    }

    public function store(CampaignRequest $request)
    {
        $campaign = Campaign::create($request->validated());
        $images = [];
        foreach ($request->images as $image){
            $images [] =[
                'slug' => Str::uuid()->getHex(),
                'campaign_id' => $campaign->id ,
                'driver' => 'campaign',
                'file' =>Storage::disk('campaign')->put($campaign->id,$image)
            ];
        }
        CampaignImage::insert($images);
        return response()->json([
            "message" => __('messaeges.created'),
            "data" => $campaign
        ], 201);
    }

    
    public function show(Campaign $campaign)
    {
        return response()->json([
            "message" => __('messages.view'),
            "data" => new CampaignResource($campaign)
        ], 200);


    }

    public function update(CampaignRequest $request, Campaign $campaign)
    {
        $campaign->update( $request->validated());
        $images = [];
        foreach ($request->images as $image){
            $images [] =[
                'slug' => Str::uuid()->getHex(),
                'campaign_id' => $campaign->id ,
                'driver' => 'campaign',
                'file' =>Storage::disk('campaign')->put($campaign->id,$image)
            ];
        }
        CampaignImage::insert($images);
        return response()->json([
            "message" => __('messages.updated'),
            "data" => new CampaignResource($campaign)
        ], 200);

    }

    public function destroy(Campaign $campaign)
    {
        $campaign->delete();
        return response()->json([
            "message" => __('messages.deleted'),
        ], 202);
    }
    public function destroyImage(CampaignImage $image)
    {
        $image->delete();
        return response()->json([
            "message" => __('messages.deleted'),
        ], 202);
    }
}