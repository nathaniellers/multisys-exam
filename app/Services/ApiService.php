<?php

namespace App\Services;

use App\Mail\SendMail;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use App\Enums\ResponseMessage;
use App\Traits\ResponseTraits;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Facades\JWTFactory;
use Illuminate\Support\Facades\RateLimiter;
use App\Interfaces\Service\ApiServiceInterface;
use App\Interfaces\Service\EmailServiceInterface;
use App\Interfaces\Repository\ApiRepositoryInterface;

class ApiService implements ApiServiceInterface
{
    use ResponseTraits;
    
    private $repository;
    private $email;

    public function __construct(ApiRepositoryInterface $repository, EmailServiceInterface $email)
    {
        $this->repository = $repository;
        $this->email = $email;
    }

    public function registration(array $data)
    {
        DB::beginTransaction();
        try {
            $info = [
                'email' => $data['email'],
                'password' => Hash::make($data['password'])
            ];
            $exist =  $this->checkEmail($data['email']);
            $this->email->send($data);
            if ($exist) {
                return response()->json(['message' => ResponseMessage::error['email_unique']])->setStatusCode(Response::HTTP_BAD_REQUEST);
            }
            $user = $this->repository->create($info);
            DB::commit();
            return response()->json(['message' => ResponseMessage::success['registration']])->setStatusCode(Response::HTTP_CREATED);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return $this->error($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    private function checkEmail($data)
    {
        return $this->repository->getModel()->whereEmail($data)->first();
    }

    public function login(array $data)
    {
        try {
            $this->checkTooManyFailedAttempts();
            if (!$token = JWTAuth::attempt($data)) {
                RateLimiter::hit($this->throttleKey(), $seconds = 300);
                return response()->json(['message' => ResponseMessage::error['login']])->setStatusCode(Response::HTTP_UNAUTHORIZED);
            }
            $user = $this->repository->show(JWTAuth::user()->id);
            $payload = JWTFactory::sub($user->id)->userInfo($user)->make();
            $token = JWTAuth::encode($payload);
            RateLimiter::clear($this->throttleKey());
            return response()->json(['access_token' => (string) $token])->setStatusCode(Response::HTTP_CREATED);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $this->error($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function throttleKey()
    {
        return Str::lower(request('email')) . '|' . request()->ip();
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @return void
     */
    public function checkTooManyFailedAttempts()
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        throw new \Exception('IP address banned. Too many login attempts.');
    }

    public function logout()
    {
        try {
            if (!JWTAuth::parseToken()->authenticate()) {
                return $this->error(ResponseMessage::error['token'], Response::HTTP_NOT_FOUND);
            }
            JWTAuth::refresh();
            JWTAuth::invalidate(JWTAuth::getToken());
            Auth::logout();
            return $this->success(ResponseMessage::success['logout'], [], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $this->error($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}