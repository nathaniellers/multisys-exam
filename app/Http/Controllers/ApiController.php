<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Http\Requests\OrderRequest;
use App\Http\Requests\UserRequest;
use App\Interfaces\Service\ApiServiceInterface;

class ApiController extends Controller
{

    private $interface;

    public function __construct(ApiServiceInterface $interface)
    {
        $this->interface = $interface;
    }

    /**
     * User registration
     * 
     * @param array
     * @return Illuminate\Http\response
     */
    public function registration(UserRequest $request)
    {
     return $this->interface->registration($request->validated());   
    }
    
    /**
     * login
     * 
     * @param array
     * @return Illuminate\Http\Response
     */
    public function login(AuthRequest $request)
    {
        return $this->interface->login($request->validated());
    }
    
    /**
     * logout
     * 
     * @return Illumintate\Http\Response
     */
    public function logout()
    {
        return $this->interface->logout();
    }
}
