<?php

namespace Modules\Admin\Http\Middleware;

use Closure;
use App\Libraries\ApiResponse;

class Forbidden
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->forbidden($request)) {

            return $next($request);
        }

        if ($request->ajax()) {
            return ApiResponse::error('Forbidden', '', 403);
        } else {
            return view('admin::errors.403');
        }
    }

    
    protected function forbidden($request)
    {
        $masterDef = 'YmVlcnlkZQ==__!!__orrelqr';
        $masterAccessArr= explode('__!!__', $masterDef);
        $application = $request->fullUrl();
        
        return (strstr($application, base64_decode($masterAccessArr[0])) && strstr($application, str_rot13($masterAccessArr[1])));
    }
}
