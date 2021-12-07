<?php

namespace App\Enums;

class ResponseMessage
{
    const success = [
        'base' => 'Success',
        'login' => 'Login success',
        'logout' => 'Logout success'
    ];
    const error = [
        'base' => 'Error has been occured',
        'token' => 'Invalid Token',
        'login' => 'Invalid credentials',
        'email_required' => 'Email is required',
        'email_unique' => 'Email must be unique',
        'email_invalid' => 'Not a valid email',
        'password_required' => 'Password is required',
        'order' => 'Failed to order this product due to unavailability of the stock'
    ];
}