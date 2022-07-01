<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\ImagesWebsite as ImagesWebsiteResource;
use App\Models\ImagesWebsite;
use Illuminate\Http\Request;

class ImagesWebsiteController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $image = ImagesWebsite::all();
        // dd($image);

        return $this->sendResponse(ImagesWebsiteResource::collection($image), 'Images retrieved successfully.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ImagesWebsite  $img
     * @return \Illuminate\Http\Response
     */
    public function show(ImagesWebsite $img, $id)
    {
        $img = ImagesWebsite::find($id);
        // dd($post);
        return response()->json(['data' => $img]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ImagesWebsite  $img
     * @return \Illuminate\Http\Response
     */
    public function edit(ImagesWebsite $img)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ImagesWebsite  $img
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $img = ImagesWebsite::find($id);

        if ($request->firstImage === null) {
            $firstImage = $img->firstImage;
        } else ($firstImage = $request->firstImage);

        if ($request->secondImage === null) {
            $secondImage = $img->secondImage;
        } else ($secondImage = $request->secondImage);

        if ($request->thirdImage === null) {
            $thirdImage = $img->thirdImage;
        } else ($thirdImage = $request->thirdImage);

        if ($request->fourthImage === null) {
            $fourthImage = $img->fourthImage;
        } else ($fourthImage = $request->fourthImage);

        // dd($firstImage, $secondImage, $thirdImage, $fourthImage);
        $img->firstImage = $firstImage;
        $img->secondImage = $secondImage;
        $img->thirdImage = $thirdImage;
        $img->fourthImage = $fourthImage;


        $img->save();

        return $this->sendResponse(new ImagesWebsiteResource($img), 'Image updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ImagesWebsite  $img
     * @return \Illuminate\Http\Response
     */
    public function destroy(ImagesWebsite $img)
    {
        //
    }
}
