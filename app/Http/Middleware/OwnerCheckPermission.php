<?php

namespace App\Http\Middleware;

use Closure;

use App\Http\Helpers\UserPermission;

class OwnerCheckPermission
{
    protected $helper;

    public function __construct(UserPermission $helper)
    {
        $this->helper = $helper;
    }
    
    public function handle($request, Closure $next, $permissions)
    {
        dd(123);die;
        if ($this->helper->has_owner_permission(\Auth::guard('owner')->user()->id, $permissions)) {
            return $next($request);
        } else {
            abort(403, 'Access denied');
        }
    }
}
