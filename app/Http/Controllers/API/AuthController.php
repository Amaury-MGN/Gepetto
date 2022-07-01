<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $request->validate([
            'firstname'             => 'required|string',
            'lastname'              => 'required|string',
            'company'               => 'nullable',
            'phoneNumber'           => 'nullable|numeric',
            'pseudonym'             => 'required|string',
            'email'                 => 'required|email|regex:/^.+@.+$/i',
            'password'              => 'required|min:3',
            'passwordConfirmation'  => 'required|same:password',

        ]);
        if ($request->company === null) {
            $compagny = 'Non renseigné';
        } else {
            $compagny = $request->company;
        }
        if ($request->phoneNumber === null) {
            $phoneNumber = 'Non renseigné';
        } else {
            $phoneNumber = $request->phoneNumber;
        }

        User::create([
            'firstname'          => $request->firstname,
            'lastname'           => $request->lastname,
            'company'            => $compagny,
            'phoneNumber'        => $phoneNumber,
            'pseudonym'          => $request->pseudonym,
            'email'              => $request->email,
            'password'           => Hash::make($request->password),
            // 'password'      => $request->name,


        ]);

        return response()->json(['msg', 'Enregistrement effectué avec succès']);
    }
    public function adminRegister(Request $request)
    {
        $request->validate([
            'role'                  => 'required|numeric',
            'firstname'             => 'required|string',
            'lastname'              => 'required|string',
            'company'               => 'nullable',
            'phoneNumber'           => 'nullable|numeric',
            'pseudonym'             => 'required|string',
            'email'                 => 'required|email|regex:/^.+@.+$/i',
            'password'              => 'required|min:3',
            'passwordConfirmation'  => 'required|same:password',

        ]);
        if ($request->company === null) {
            $compagny = 'Non renseigné';
        } else {
            $compagny = $request->company;
        }
        if ($request->phoneNumber === null) {
            $phoneNumber = 'Non renseigné';
        } else {
            $phoneNumber = $request->phoneNumber;
        }
        User::create([
            'role'               => $request->role,
            'firstname'          => $request->firstname,
            'lastname'           => $request->lastname,
            'company'            => $compagny,
            'phoneNumber'        => $phoneNumber,
            'pseudonym'          => $request->pseudonym,
            'email'              => $request->email,
            'password'           => Hash::make($request->password),
        ]);

        return response()->json(['msg', 'Enregistrement effectué avec succès']);
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        if (Auth::attempt([
            'email'         => $request->email,
            'password'      => $request->password
        ])) {

            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->plainTextToken;
            $success['name'] =  $user->pseudonym;
            $success['id'] = $user->id;
            $success['role'] = $user->role;
            return $this->sendResponse($success, 'Utilisateur identifié avec succès.');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }

    public function user(Request $request)
    {
        $user = User::find(Auth::user()->id);

        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
    }
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        // dd($user->firstname);
        $request->validate([
            'firstname'             => 'nullable|string',
            'lastname'              => 'nullable|string',
            'company'               => 'nullable',
            'phoneNumber'           => 'nullable|numeric',
            'pseudonym'             => 'nullable|string',
            'email'                 => 'nullable|email|regex:/^.+@.+$/i',
            'password'              => 'nullable|min:3',
            'passwordConfirmation'  => 'same:password',

        ]);
        if ($request->firstname === null) {
            $firstname = $user->firstname;
        } else {
            $firstname = $request->firstname;
        }
        if ($request->lastname === null) {
            $lastname = $user->lastname;
        } else {
            $lastname = $request->lastname;
        }
        if ($request->company === null) {
            $compagny = $user->company;
        } else {
            $compagny = $request->company;
        }
        if ($request->phoneNumber === null) {
            $phoneNumber = $user->phoneNumber;
        } else {
            $phoneNumber = $request->phoneNumber;
        }
        if ($request->pseudonym === null) {
            $pseudonym = $user->pseudonym;
        } else {
            $pseudonym = $request->pseudonym;
        }
        if ($request->email === null) {
            $email = $user->email;
        } else {
            $email = $request->email;
        }
        if ($request->password === null) {
            $password = $user->password;
        } else {
            $password = Hash::make($request->password);
        }

        $user->firstname    = $firstname;
        $user->lastname     = $lastname;
        $user->company      = $compagny;
        $user->phoneNumber  = $phoneNumber;
        $user->pseudonym    = $pseudonym;
        $user->email        = $email;
        $user->password     = $password;
        $user->save();
        return response()->json(['Message', 'Nouvelles informations bien enregistrées']);
    }

    /**
     * Logout api
     *
     * @return \Illuminate\Http\Response
     */

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['Message', 'Déconnexion réussie']);
    }
}
