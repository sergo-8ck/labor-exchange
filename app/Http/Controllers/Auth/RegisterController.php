<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\RegisterRequest;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\UseCases\Auth\RegisterService;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{

  private $service;

  use RegistersUsers;

  protected $redirectTo = '/home';

  public function __construct(RegisterService $service)
  {
    $this->middleware('guest');
    $this->service = $service;
  }

  /**
   * Get a validator for an incoming registration request.
   *
   * @param  array $data
   * @return \Illuminate\Contracts\Validation\Validator
   */
  protected function validator(array $data)
  {
    return Validator::make($data, [
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users',
      'password' => 'required|string|min:6|confirmed',
    ]);
  }
  public function showRegistrationForm()
  {
    return view('auth.register');
  }

//  public function register(RegisterRequest $request)
//  {
//    $this->service->register($request);
//
////    return redirect()->route('home')
////      ->with('success', 'Welcome.');
//    return redirect()->intended(route('home', 1));
//  }

  public function register(RegisterRequest $request)
  {
    $user = $this->service->register($request);

//    $this->validator($request->all())->validate();


//    event(new Registered($user = $this->create($request->all())));

    $this->guard()->login($user);

    return $this->registered($request, $user)
      ?: redirect($this->redirectPath());
  }

  /**
   * Create a new user instance after a valid registration.
   *
   * @param  array $data
   * @return \App\User
   */
  protected function create(array $data)
  {
    return User::create([
      'name' => $data['name'],
      'email' => $data['email'],
      'password' => Hash::make($data['password']),
    ]);
  }
}
