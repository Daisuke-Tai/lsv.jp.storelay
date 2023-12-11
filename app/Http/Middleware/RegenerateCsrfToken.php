<?PHP
namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Contracts\Encryption\Encrypter;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Cookie\CookieValuePrefix;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\InteractsWithTime;
use Symfony\Component\HttpFoundation\Cookie;
use Illuminate\Support\Facades\Cache;

class RegenerateCsrfToken
{
   
    /**
     * The application instance.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;
    
    /**
     * The encrypter implementation.
     *
     * @var \Illuminate\Contracts\Encryption\Encrypter
     */
    protected $encrypter;
    
        /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @param  \Illuminate\Contracts\Encryption\Encrypter  $encrypter
     * @return void
     */
    public function __construct(Application $app, Encrypter $encrypter)
    {
        $this->app = $app;
        $this->encrypter = $encrypter;
    }

    
    public function handle($request, Closure $next)
    {
        $prevRequestKey = $request->session()->getId() . '_prev_request_token';
        $prevSessionKey = $request->session()->getId() . '_prev_session_token';

        if (in_array($request->method(), ['HEAD', 'GET', 'OPTIONS'])) {
            // キャッシュリクエストトークンを削除する
            Cache::forget($prevRequestKey);

        } else {
            // リフレッシュする前のセッショントークンをキャッシュに保持
            Cache::put(
                $prevSessionKey,
                $request->session()->token(),
                config('session.token_lifetime')
            );

            // 初回POST(PUT, DELETE)時はキャッシュトークンがnullになっている
            if (is_null(Cache::get($prevRequestKey))) {
                // 初回POST時だけキャッシュにリクエストトークンを保存する
                Cache::put(
                    $prevRequestKey,
                    $this->getTokenFromRequest($request),
                    config('session.token_lifetime')
                );

            } else {
                // POSTを続けて2回リクエストした場合にのみ、
                // セッショントークンをリフレッシュ
//                $request->session()->regenerateToken();
            }
        }

        return $next($request);
    }

    protected function getTokenFromRequest($request)
    {
        $token = $request->input('_token') ?: $request->header('X-CSRF-TOKEN');

        if (! $token && $header = $request->header('X-XSRF-TOKEN')) {
            $token = $this->encrypter->decrypt($header, static::serialized());
        }

        return $token;
    }

        /**
     * Determine if the cookie contents should be serialized.
     *
     * @return bool
     */
    public static function serialized()
    {
        return EncryptCookies::serialized('XSRF-TOKEN');
    }
}