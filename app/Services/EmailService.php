<?php

namespace App\Services;

use App\Interfaces\Service\EmailServiceInterface;
use App\Jobs\SendEmail;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;

class Emailservice implements EmailServiceInterface
{

    public function send(array $data)
    {
        try {
            SendEmail::dispatch($data)->onQueue('emails');
            Mail::to($data['email'])->send(new SendMail($data));
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}