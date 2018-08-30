<?php

namespace App\UseCases\Auth;

use App\User;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Events\Dispatcher;

class RegisterService
{
  private $dispatcher;

  public function __construct(Dispatcher $dispatcher)
  {
    $this->dispatcher = $dispatcher;
  }

  public function register(RegisterRequest $request)
  {
    $user = User::register(
      $request['name'],
      $request['email'],
      $request['password']
    );

    $this->dispatcher->dispatch(new Registered($user));
    return $user;
  }


}
