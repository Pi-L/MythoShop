<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Session;
use \Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
          $rules = [
            'lastname' => "nullable|regex:/(^[À-úa-zA-Z' -]+$)/",
            'name' => "required|regex:/(^[À-úa-zA-Z -]+$)/",
            'email' => [
                'required',
                'email:rfc,filter,dns',
                Rule::unique('users')
                ],
            'phone' => ['nullable', 'regex:/^(((\+33\d)|(0\d))\D*\d{2}\D*\d{2}\D*\d{2}\D*\d{2})$/'],
            'birth' => 'nullable|date',
            // 'password' => 'required|confirmed|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*_+-]).*$/'
            'password' => 'required|confirmed|min:4'
        ];

        return Validator::make($data, $rules);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        return User::create([
            'name' => $data['name'],
            'lastname' => $data['lastname'],
            'phone' => telToDB($data['phone']),
            'email' => $data['email'],
            'birth' => $data['birth'],
            'password' => Hash::make($data['password']),
        ]);
    }

    protected function registered(Request $request, $user)
    {
        $request->session()->flash('flashSuccess', ['p1' => 'Bienvenue '.$user->name.' !']);
    }

    public function redirectTo()
    {

        return session()->get('url.intended', route('main.index'));

    }
}
