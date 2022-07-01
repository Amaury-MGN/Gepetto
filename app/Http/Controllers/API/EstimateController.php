<?php

namespace App\Http\Controllers\API;


use App\Models\Estimate;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Resources\Estimate as EstimateResource;
use Illuminate\Support\Str;

use Validator;


class EstimateController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id;

        if (Auth::user()->role === 1) {
            $estimates = Estimate::orderBy('created_at', 'DESC')->paginate(12);
        }
        if (Auth::user()->role === 2) {
            $estimates = Estimate::where('user_id', $user_id)->get();
        }
        return response()->json($estimates);
        // return $this->sendResponse(EstimateResource::collection($estimates), 'Estimates retrieved successfully.');
    }
    public function indexSearch()
    {
        $user_id = Auth::user()->id;

        if (Auth::user()->role === 1) {
            $estimates = Estimate::all();
        }
        if (Auth::user()->role === 2) {
            $estimates = Estimate::where('user_id', $user_id)->get();
        }
        return $this->sendResponse(EstimateResource::collection($estimates), 'Estimates retrieved successfully.');
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
    public function store(Request $request, Estimate $estimate)
    {

        $user_id = auth()->id();
        $user = auth()->user();

        $input = $request->all();
        $validator = Validator::make($input, [
            'estimateName'          => 'required',
            'estimateContents'      => 'required',
            'estimateItemNumber'    => 'required',
            'estimateUserFile'      => 'mimes:pdf|max:1024',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $estimateNumber = 'ESTIM_' . str::random(12);
        $estimateUserFileName = $user->name . '_devis_' . $estimateNumber . '.' . $input['estimateUserFile']->getClientOriginalExtension();

        //Save data in the DB AND file in public or S3
        $estimate->user_id            = $user_id;
        $estimate->estimateNumber     = $estimateNumber;
        $estimate->estimateName       = $estimate->estimateName = $input['estimateName'];
        $estimate->estimateContents   = $input['estimateContents'];
        $estimate->estimateItemNumber = $input['estimateItemNumber'];

        // File name and location
        $estimate->estimateUserFileName = $estimateUserFileName;
        $estimate->estimateUserFile = $input['estimateUserFile']->storeAs('estimates/' . $user_id, $estimateUserFileName);

        $estimate->save();

        return $this->sendResponse(new EstimateResource($estimate), 'Estimate created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Estimate  $estimate
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $estimate = Estimate::find($id);
        $user_id = $estimate->user_id;
        $user = User::where('id', $user_id)->first();
         $userFirstname = $user->firstname;
        $userLastname = $user->lastname;
        $userEmail = $user->email;
        $response =  response()->json(
            [
            'status'                    => 'Estimate retrieved successfully.',
            'id'                        => $estimate->id,
            'user_id'                   => $estimate->user_id,
            'estimateName'              => $estimate->estimateName,
            'estimateNumber'            => $estimate->estimateNumber,
            'estimateItems'             => $estimate->estimateItemNumber,
            'estimateContents'          => $estimate->estimateContents,
            'estimateAdminFileName'     => $estimate->estimateUserFileName,
            'estimateAdminFilePath'     => $estimate->estimateUserFile,
            'created_at'                => $estimate->created_at->format('d/m/Y'),
            'updated_at'                => $estimate->updated_at->format('d/m/Y'),
            'firstname'                 => $userFirstname,
            'lastname'                  => $userLastname,
            'email'                     => $userEmail,
            ],
            200
        );

        if (Auth::user()->role === 1) {
            $estimate = Estimate::where('user_id', $user_id)->get();
            if ($estimate->isEmpty()) {
                return $this->sendError('Error', 'No data inside the Database for this id');
            } else {
                $estimate = Estimate::where('user_id', $user_id)->first();
                return $response;
            }
        }
        if (Auth::user()->role === 2) {
            $estimate = Estimate::where('user_id', $user_id)->where('id', $id)->get();
            if ($estimate->isEmpty()) {
                return $this->sendError('Error', 'Unauthorized', 401);
            } else {
                $estimate = Estimate::where('user_id', $user_id)->where('id', $id)->first();
                return $this->sendResponse(new EstimateResource($estimate), 'Success');
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Estimate  $estimate
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Estimate $estimate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Estimate  $estimate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $estimate = Estimate::find($id);
        // $input = $request->all();
        $paymentValidation = $request->paymentValidation;


        // dd($estimate);
        $estimate->paymentValidation = $paymentValidation;

        $estimate->save();

        return $this->sendResponse(new EstimateResource($estimate), 'Estimate updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Estimate  $estimate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Estimate $estimate)
    {
        //
    }
}
