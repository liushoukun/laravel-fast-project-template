<?php
/**
 * Created by PhpStorm.
 * User: 24147
 * Date: 2019/7/26
 * Time: 14:07
 */

namespace App\Http\Middleware;


use App\Entities\OauthClient;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

class AuthClient
{
    public function handle(Request $request, Closure $next)
    {
        try {
            $jwt   = $request->bearerToken();
            $token = (new \Lcobucci\JWT\Parser())->parse($jwt);
            $request->offsetSet('client', OauthClient::find($token->getClaim('aud')));
        } catch (\Exception $exception) {
            throw new AuthenticationException('error client');
        }
        return $next($request);
    }

}
