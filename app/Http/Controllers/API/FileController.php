<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use App\Models\Order;
use App\Models\Estimate;
use App\Models\EstimateAdmin;
use Illuminate\Support\Facades\Auth;


class FileController extends BaseController

{
    public function estimateUserDownload($id)
    {
        // $id = Estimate id from estimate DB
        $user_id = auth()->id();

        if (Estimate::where('user_id', $user_id)->where('id', $id)->get() || Auth::user()->role === 1) {
            $estimateDownload = Estimate::where('id', $id)->get();

            foreach ($estimateDownload as $key => $value)
                $relativePath = $value->estimateUserFile;
            return Storage::disk('local')->get($relativePath);
        }
    }
    public function estimateAdminDownload($id)
    {


        $user_id = Auth::user()->id;


        if (Auth::user()->role === 1) {
            $estimateAdmin = Order::where('id', $id)->get();
            if ($estimateAdmin->isEmpty()) {
                return $this->sendError('Error', 'No data inside the Database for this id');
            } else {
                $estimateAdmin = Order::where('id', $id)->get();
                foreach ($estimateAdmin as $key => $value)
                    $relativePath = $value->orderAdminFilePath;
                return Storage::disk('local')->get($relativePath);
            }
        }
        if (Auth::user()->role === 2) {
            $estimate = Estimate::where('user_id', $user_id)->where('id', $id)->get();
            if ($estimate->isEmpty()) {
                return $this->sendError('Error', 'File Not Found', 404);
            } else {
                $estimateAdmin = EstimateAdmin::where('estimate_id', $id)->get();
                foreach ($estimateAdmin as $key => $value)
                    $relativePath = $value->estimateAdminFile;
                return Storage::disk('local')->get($relativePath);
            }
        }
    }
}
