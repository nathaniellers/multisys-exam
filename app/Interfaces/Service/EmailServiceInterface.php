<?php

namespace App\Interfaces\Service;

interface EmailServiceInterface
{
    public function send(array $data);
}