<?php

namespace Modules\Admin\Http\Middleware;

use Closure;
use Input;

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
        if ($this->checkAuthentication()) {

            return $next($request);
        }

        if ($request->ajax()) {
            abort(403);
        } else {
            return view('admin::errors.403');
        }
    }

    
    protected function checkAuthentication()
    {
        //$value = Request::header('Content-Type');
//        $inputs = Input::all();
//        if(!empty($inputs['appid']) && !empty($inputs['apikey'])){
//            
//            return ($inputs['appid']=='KorJrMel164LqrI' && $inputs['apikey']=='81d6b356773e72c15438282df0382d24') ? 1 : 0;
//        }
//        return 0;
        
        return 1;
    }
}
