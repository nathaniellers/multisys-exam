<?php

namespace App\Enums;

class ResponseMessage
{
    const success = [
        'registration' => 'User successfully registered',
        'base' => 'Success',
        'login' => 'Login success',
        'logout' => 'Logout success',
        'order' => 'You have successfully ordered this product.'
    ];
    const error = [
        'base' => 'Error has been occured',
        'token' => 'Invalid Token',
        'login' => 'Invalid credentials',
        'email_required' => 'Email is required',
        'email_unique' => 'Email already taken',
        'email_invalid' => 'Not a valid email',
        'password_required' => 'Password is required',
        'order' => 'Failed to order this product due to unavailability of the stock'
    ];
}