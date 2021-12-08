<?php

namespace App\Interfaces\Service;

interface ApiServiceInterface
{

    public function registration(array $data);

    public function login(array $data);

    public function logout();
}