<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Auth;
use App\Models\Estimate;
use App\Models\EstimateAdmin;

use Illuminate\Http\Request;
use App\Http\Resources\EstimateAdmin as EstimateAdminResource;
use Validator;

class EstimateAdminController extends BaseController
{
    public function store(Request $request, EstimateAdmin $estimateAdmin, $id)
    {
        // $is MUST be the same as the id from the estimate row

        $input = $request->all();
        // dd($input);
        $validator = Validator::make($input, [
            'estimateAdminContents'  => 'required',
            'estimateAdminFile'      => 'required|mimes:pdf|max:1024',
            'estimateAdminPrice'     => 'required|numeric|gt:0',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        // //store file to estimate_admins with the estimate id
        if (Auth::user()->role === 1) {
            $estimateId = EstimateAdmin::where('estimate_id', $id)->get();
            if ($estimateId->isEmpty()) {
                $estimate = Estimate::find($id);
                $estimate_id = $estimate->id;

                $estimateAdminFileName = 'Devis_' . $estimate->estimateNumber . '.' . $input['estimateAdminFile']->getClientOriginalExtension();

                // // Saving data and files

                $estimateAdmin->estimate_id             = $estimate_id;
                $estimateAdmin->estimateAdminContents   = $input['estimateAdminContents'];
                $estimateAdmin->estimateAdminFileName   = $estimateAdminFileName;
                $estimateAdmin->estimateAdminFile       = $input['estimateAdminFile']->storeAs('estimates/' . $estimate_id, $estimateAdminFileName);
                $estimateAdmin->estimateAdminPrice      = $input['estimateAdminPrice'];
                // $estimateAdmin->paymentValidation       = 'Non';
                $estimateAdmin->save();

                return $this->sendResponse(new EstimateAdminResource($estimateAdmin), 'estimateAdmin created successfully.');
            } else {
                // $estimateId = EstimateAdmin::where('estimate_id', $id)->first();
                // return $this->sendResponse(new EstimateAdminResource($estimateId), 'estimateAdmin retrieved successfully.');
                return $this->sendError('Error', 'An Estimate has already been sent to the user');
            }
        }
    }


    public function show(Request $request, $id)
    {

        // $is MUST be the same as the id from the estimate row

        $estimate = Estimate::find($id);
        $estimateUserId = $estimate->user->id;
        // dd($estimateAdmin);
        $userId = Auth::user()->id;
        // dd($userId);

        // dd(Auth::user()->role);
        if (Auth::user()->role === 1) {
            $estimateId = EstimateAdmin::where('estimate_id', $id)->get();
            if ($estimateId->isEmpty()) {
                return $this->sendError('Error', 'No data inside the Database for this id');
            } else {
                $estimateId = EstimateAdmin::where('estimate_id', $id)->first();
                return $this->sendResponse(new EstimateAdminResource($estimateId), 'estimateAdmin retrieved successfully.');
            }
        }
        if (Auth::user()->role === 2) {
            $estimateId = EstimateAdmin::where('estimate_id', $id)->get();
            // dd($estimateId);
            if ($estimateId->isEmpty() || $estimateUserId !== $userId) {
                return $this->sendError('Error', 'Unauthorized', 401);
            } else {
                $estimateId = EstimateAdmin::where('estimate_id', $id)->first();
                return $this->sendResponse(new EstimateAdminResource($estimateId), 'estimateAdmin retrieved successfully.');

                // return response()->json(['status' => 'success', 'users'  => $estimateId->toArray()], 200);
            }
        }
    }
}
