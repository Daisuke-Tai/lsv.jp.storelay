<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
use Illuminate\Support\Facades\Cache;

class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];

    /**
     * Determine if the session and input CSRF tokens match.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function tokensMatch($request)
    {
        $requestToken = $this->getTokenFromRequest($request);

        $prevRequestKey = $request->session()->getId() . '_prev_request_token';
        $prevRequestToken = Cache::get($prevRequestKey);

        $sessionToken = $request->session()->token();

        $prevSessionKey = $request->session()->getId() . '_prev_session_token';
        $prevSessionToken = Cache::get($prevSessionKey);

        if (is_string($prevRequestToken)
                && is_string($requestToken)) {
            // セッショントークンとキャッシュされたセッショントークンが等しい場合、初回のPOST時となる
            if (hash_equals($sessionToken, $prevSessionToken)) {
                // セッショントークンとリクエストトークンが等しいかどうかの検証。
                // 任意のトークンを送信されたら不合致とする
                //return hash_equals($sessionToken, $requestToken);
                return true;
            } else {
                // POSTを連続で送信しているので不合致
                return false;
            }

        } else {
            // トークンが文字列でないので不合致
            return false;
        }
    }


}
