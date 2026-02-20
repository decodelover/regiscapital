<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class RegisterResponse implements RegisterResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        // After registration, log the user in and show email verification notice
        // User is already authenticated at this point
        if ($request->wantsJson()) {
            return new JsonResponse(['message' => 'Registration successful. Please check your email to verify your account.'], 201);
        }
        
        // Show the email verification notice immediately after registration
        // This displays the "verify your email" message with instructions
        return redirect('/verify-email');
    }
}
