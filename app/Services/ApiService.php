<?php

namespace App\Services;

use App\Enums\ResponseMessage;
use Illuminate\Http\Response;
use App\Traits\ResponseTraits;
use App\Interfaces\ApiInterface;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTFactory;
use App\Interfaces\ApiRepositoryInterface;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;

class ApiService implements ApiInterface
{
    use ResponseTraits;
    
    private $repository;

    public function __construct(Product $model, ApiRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function registration(array $data)
    {
        DB::beginTransaction();
        try {
            $info = [
                'email' => $data['email'],
                'password' => Hash::make($data['password'])
            ];
            $user = $this->repository->create($info);
            DB::commit();
            $payload = JWTFactory::sub($user['id'])->userInfo($user)->make();
            $token = JWTAuth::encode($payload);
            return $this->success(ResponseMessage::success['base'], ['access_token' => (string) $token], Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return $this->error($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function login(array $data)
    {
        try {
            if (!$token = JWTAuth::attempt($data)) {
                return $this->error(ResponseMessage::error['login'], Response::HTTP_UNAUTHORIZED);
            }
            $user = $this->repository->show(JWTAuth::user()->id);
            $payload = JWTFactory::sub($user->id)->userInfo($user)->make();
            $token = JWTAuth::encode($payload);
            return $this->success(ResponseMessage::success['login'], ['access_token' => (string) $token], Response::HTTP_OK);

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $this->error($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
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