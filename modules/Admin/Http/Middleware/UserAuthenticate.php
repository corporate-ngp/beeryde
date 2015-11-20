<?php namespace Modules\Admin\Http\Middleware;

use Closure;
use Modules\Admin\Repositories\UserTokenRepository;
use App\Libraries\ApiResponse;

class UserAuthenticate
{

    protected $tokenRepo;

    public function __construct(UserTokenRepository $userTokenRepository)
    {
        $this->tokenRepo = $userTokenRepository;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->validToken($request)) {

            return $next($request);
        }

        if ($request->ajax()) {
            return ApiResponse::error('Invalid access token or session expires.', '', 403);
        } else {
            return view('admin::errors.403');
        }
    }

    protected function validToken($request)
    {
       
        if (!empty($request->header('Ryde-Token'))) {

            return $this->tokenRepo->token($request->header('Ryde-Token'));
        }

        return 0;
    }
}
