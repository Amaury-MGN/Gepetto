<?php

namespace App\Http\Controllers\API;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Resources\Ticket as TicketResource;
use Validator;
use Illuminate\Support\Str;
class TicketController extends BaseController
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
            $ticket = Ticket::orderBy('created_at', 'DESC')->paginate(12);
        }
        if (Auth::user()->role === 2) {
            $ticket = Ticket::where('user_id', $user_id)->get();
        }
        return response()->json($ticket);
    }
    public function indexSearch()
    {
        $user_id = Auth::user()->id;

        if (Auth::user()->role === 1) {
            $ticket = Ticket::all();
        }
        if (Auth::user()->role === 2) {
            $ticket = Ticket::where('user_id', $user_id)->get();
        }
        return $this->sendResponse(TicketResource::collection($ticket), 'ticket retrieved successfully.');
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
    public function store(Request $request, Ticket $ticket)
    {
        $user_id = auth()->id();
        // $user = auth()->user();

        $input = $request->all();
        $validator = Validator::make($input, [
            'category'    => 'required',
            'userTicket'  => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        // dd ($input['category']=='Devis'||'commande'||'Autre');
        if($input['category'] == 'Devis' || 'commande' || 'Autre'){
            $ticketNumber = 'Ticket_' . str::random(12);

            $ticket->user_id        = $user_id;
            $ticket->ticketNumber   = $ticketNumber;
            $ticket->userTicket     = $input['userTicket'];
            $ticket->category       = $input['category'];
            $ticket->closed         = 'Non';

            $ticket->save();

            return $this->sendResponse(new TicketResource($ticket), 'Ticket created successfully.');
        }else{
            return $this->sendError('Error', 'Unauthorized', 401);
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ticket = Ticket::find($id);
        $user_id = $ticket->user_id;
        $user = User::where('id', $user_id)->first();
        $userFirstname = $user->firstname;
        $userLastname = $user->lastname;
        $userEmail = $user->email;
        $response =  response()->json(
            [
                'status'                    => 'Ticket retrieved successfully.',
                'id'                        => $ticket->id,
                'user_id'                   => $ticket->user_id,

                'ticketNumber'              => $ticket->ticketNumber,
                'category'                  => $ticket->category,
                'userTicket'                => $ticket->userTicket,
                'gepettoResponse'           => $ticket->gepettoResponse,
                'closed'                    => $ticket->closed,
                'created_at'                => $ticket->created_at->format('d/m/Y'),
                'updated_at'                => $ticket->updated_at->format('d/m/Y'),
                'firstname'                 => $userFirstname,
                'lastname'                  => $userLastname,
                'email'                     => $userEmail,
            ],
            200
        );
        // dd($response);
        if (Auth::user()->role === 1) {
            $ticket = Ticket::where('user_id', $user_id)->get();
            if ($ticket->isEmpty()) {
                return $this->sendError('Error', 'No data inside the Database for this id');
            } else {
                $ticket = Ticket::where('user_id', $user_id)->first();
                return $response;
            }
        }
        if (Auth::user()->role === 2) {
            $ticket = Ticket::where('user_id', $user_id)->where('id', $id)->get();
            if ($ticket->isEmpty()) {
                return $this->sendError('Error', 'Unauthorized', 401);
            } else {
                $ticket = Ticket::where('user_id', $user_id)->where('id', $id)->first();
                return $this->sendResponse(new TicketResource($ticket), 'Success');
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket, $id)
    {
        $ticket = Ticket::find($id);
        // $input = $request->all();
        $request->validate([
            'gepettoResponse'    => 'required',
        ]);
        $gepettoResponse = $request->gepettoResponse;
        $ticket->checkGepettoResponse = 'Oui';
        $ticket->closed = 'Oui';

        // dd($gepettoResponse);

        // dd($ticket);
        $ticket->gepettoResponse = $gepettoResponse;

        $ticket->save();

        return $this->sendResponse(new TicketResource($ticket), 'Ticket updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
