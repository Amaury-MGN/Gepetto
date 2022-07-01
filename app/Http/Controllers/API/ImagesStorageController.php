<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\ImagesStorage as ImagesStorageResource;
use App\Models\ImagesStorage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;

class ImagesStorageController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $image = ImagesStorage::all();
        // dd($image);

        return $this->sendResponse(ImagesStorageResource::collection($image), 'Images retrieved successfully.');
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
    public function store(Request $request, ImagesStorage $image)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'imageName'   => 'required',
            'file'        => 'mimes:jpg,jpeg,png,svg|max:4096',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $file = $request->file('file');
        // $filename = $file->getClientOriginalName();
        // $filePath = $file->storeAs('images/' . $filename, 's3');
        // $filePath = Storage::disk('s3')->put('images/1', $filename);
        $fileUpload = Storage::disk('local')->put('/public/images', $file);
        $filePath = Storage::url($fileUpload);
        //Save data in the DB AND file in public or S3
        $image->imageName = $input['imageName'];
        $image->url       = $filePath;
        // dd($file->storeAs('images/' . $filename, 's3'), $image->url);
        $image->save();

        return $this->sendResponse(new ImagesStorageResource($image), 'New image uploaded successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ImagesStorage  $imagesStorage
     * @return \Illuminate\Http\Response
     */
    public function show(ImagesStorage $imagesStorage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ImagesStorage  $imagesStorage
     * @return \Illuminate\Http\Response
     */
    public function edit(ImagesStorage $imagesStorage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ImagesStorage  $imagesStorage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ImagesStorage $imagesStorage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ImagesStorage  $imagesStorage
     * @return \Illuminate\Http\Response
     */
    public function destroy(ImagesStorage $imagesStorage)
    {
        //
    }
}
