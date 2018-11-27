<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    // public function render($request, Exception $exception)
    // {
    //     return parent::render($request, $exception);
    // }

    // public function render($request, Exception $exception) {
    //   // Check out Error Handling #render for more information
    //   // render method is responsible for converting a given exception into an HTTP response
    //   // Catch AthenticationException and redirect back to somewhere else...
    //   if($exception instanceof AuthenticationException){
    //     $guard = array_get($exception->guards(), 0);
    //     switch($guard){
    //       case 'admin':
    //         return redirect(route('admin.login'));
    //         break;
    //       default:
    //         return redirect(route('login'));
    //         break;
    //     }
    //   }
    //   return parent::render($request, $exception);
    // }﻿

    protected function unauthenticated($request, AuthenticationException $exception) {
      if($request->expectsJson()){
        return response()->json(['message' => $exception->getMessage()], 401);
      }
      $guard = array_get($exception->guards(), 0);
      switch ($guard){
        case 'admin':
          $login = 'admin.login';
          break;
        default:
          $login = 'login';
          break;
      }
      return redirect()->guest(route($login));
    }
}
