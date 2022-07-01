<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Order;
use App\Models\Estimate;
use App\Models\EstimateAdmin;
use App\Http\Resources\Order as OrderResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class OrderController extends BaseController
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
            $orders = Order::orderBy('created_at', 'DESC')->paginate(12);
        }
        if (Auth::user()->role === 2) {
            $orders = Order::where('user_id', $user_id)->get();
        }
        return response()->json($orders);

    }
    public function indexSearch()
    {
        $user_id = Auth::user()->id;

        if (Auth::user()->role === 1) {
            $orders = Order::all();
        }
        if (Auth::user()->role === 2) {
            $orders = Order::where('user_id', $user_id)->get();
        }
        return $this->sendResponse(OrderResource::collection($orders), 'Orders retrieved successfully.');

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
    public function store(Request $request, Order $order)
    {

        $user_id              = auth()->id();
        $estimateId           = $request->estimateId;
        $estimate             = Estimate::find($estimateId);
        $estimateAdmin        = EstimateAdmin::where('estimate_id', $estimateId)->first();
        $OrderNewNumber       = 'ORDER_' . str::random(12);
        $orderName            = $estimate->estimateName;
        $orderItems           = $estimate->estimateItemNumber;
        $orderAdminFileName   = $estimateAdmin->estimateAdminFileName;
        $orderAdminFilePath   = $estimateAdmin->estimateAdminFile;
        $orderProgress        = 'En Attente';
        $orderPrice           = $estimateAdmin->estimateAdminPrice;

        // $input = $request->all();

        $order->user_id             = $user_id;
        $order->orderName           = $orderName;
        $order->orderNumber         = $OrderNewNumber;
        $order->orderItems          = $orderItems;
        $order->orderAdminFileName  = $orderAdminFileName;
        $order->orderAdminFilePath  = $orderAdminFilePath;
        $order->orderProgress       = $orderProgress;
        $order->orderPrice          = $orderPrice;

        $order->save();

        return $this->sendResponse(new OrderResource($order), 'Order created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::find($id);
        $user_id = $order->user_id;

        $user = User::where('id', $user_id)->first();
        $userFirstname = $user->firstname;
        $userLastname = $user->lastname;
        $userEmail = $user->email;
        $response =  response()->json(
            [
                'status'                => 'Order retrieved successfully.',
                'id'                    => $order->id,
                'user_id'               => $order->user_id,
                'orderName'             => $order->orderName,
                'orderNumber'           => $order->orderNumber,
                'orderItems'            => $order->orderItems,
                'orderContents'         => $order->orderContents,
                'orderProgress'         => $order->orderProgress,
                'orderAdminFileName'    => $order->orderAdminFileName,
                'orderAdminFilePath'    => $order->orderAdminFilePath,
                'orderInvoice'          => $order->orderInvoice,
                'orderPrice'            => $order->orderPrice,
                'created_at'            => $order->created_at->format('d/m/Y'),
                'updated_at'            => $order->updated_at->format('d/m/Y'),
                'firstname'             => $userFirstname,
                'lastname'              => $userLastname,
                'email'                 => $userEmail,
            ],
            200
        );
        if (Auth::user()->role === 1) {
            $order = Order::where('user_id', $user_id)->where('id', $id)->get();
            if ($order->isEmpty()) {
                return $this->sendError('Error', 'No data inside the Database for this id');
            } else {
                return $response;
            }
        }
        if (Auth::user()->role === 2) {
            $order = Order::where('user_id', $user_id)->where('id', $id)->get();
            if ($order->isEmpty()) {
                return $this->sendError('Error', 'Unauthorized', 401);
            } else {
                return $response;
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $order = Order::find($id);
        $orderProgress = $request->orderProgress;
        // dd($orderProgress);
        $order->orderProgress = $orderProgress;

        $order->save();

        // return $this->sendResponse(new OrderResource($order), 'Order updated successfully.');
        return response()->json(['success' => 'Progress updated successsfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return $this->sendResponse([], 'Order deleted successfully.');
    }
}
