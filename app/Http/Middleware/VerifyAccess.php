<?php

namespace App\Http\Middleware;

use App\Enums\ResponseMessage;
use App\Traits\ResponseTraits;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class VerifyAccess
{
    use ResponseTraits;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            if (!JWTAuth::parseToken()->authenticate()) {
                return $this->error(ResponseMessage::error['token'], Response::HTTP_UNAUTHORIZED);
            }
            return $next($request);
        }
        catch (TokenExpiredException $e) {
            return $this->error('token_expired', Response::HTTP_GONE);
        }
        catch (TokenInvalidException $e) {
            return $this->error('token_invalid', Response::HTTP_UNAUTHORIZED);
        }
        catch (JWTException $e) {
            return $this->error('token_absent', Response::HTTP_BAD_REQUEST);
        }
        catch (Exception $e){
            return $this->error($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
