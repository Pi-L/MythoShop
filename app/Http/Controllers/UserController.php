<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddresseRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\User;
use App\Addresse;


class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function welcome()
    {
        return view('user.welcome');
    }


    public function createAddresse()
    {
        return view('user.createAddresse');
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function storeAddresse(AddresseRequest $request)
    {
        $addresse = new Addresse;
        $name = Str::ucfirst($request->name);
        $addresse->number = $request->number;
        $addresse->street = $request->street;
        $addresse->postcode = $request->postcode;
        $addresse->town = Str::upper($request->town);

        $addresse->save();

        $addresse->users()->attach(Auth::id(), ['name' => $name]);

        return redirect()->route('order.shipping')->with('flashSuccess', ['p1' => 'Adresse ajoutée !']);
    }
}
