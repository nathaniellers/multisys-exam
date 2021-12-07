<?php

namespace App\Interfaces;

interface ApiInterface
{

    public function registration(array $data);

    public function login(array $data);

    public function logout();
}