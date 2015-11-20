<?php namespace Modules\Admin\Http\Middleware;

use Closure;
use App\Libraries\ApiResponse;

class Authorise
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
        if ($this->AuthoriseRequest($request)) {

            return $next($request);
        }

        if ($request->ajax()) {
            return ApiResponse::error('Unauthorized', '', 401);
        } else {
            return view('admin::errors.403');
        }
    }

    protected function AuthoriseRequest($request)
    {
        if (!empty($request->header('Ryde-Application-Id')) && !empty($request->header('Ryde-REST-API-Key'))) {

            return ($request->header('Ryde-Application-Id') == 'KorJrMel164LqrI' && $request->header('Ryde-REST-API-Key') == '81d6b356773e72c15438282df0382d24') ? 1 : 0;
        }
        //        $inputs = Input::all();
        //        if(!empty($inputs['appid']) && !empty($inputs['apikey'])){
        //            
        //           return ($inputs['appid']=='KorJrMel164LqrI' && $inputs['apikey']=='81d6b356773e72c15438282df0382d24') ? 1 : 0;
        //        }
        return 0;
    }
}
