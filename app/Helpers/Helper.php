<?php
use Illuminate\Support\Facades\Auth;

if (!function_exists('roles')) {
    function roles()
    {
      $user = Auth::user()->type;
      return $user;
    }
}
