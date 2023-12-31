<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Common;
use App\Models\Bookings;
use App\Models\Owner;
use App\Models\Properties;
use App\Models\Settings;
use App\Models\User;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $helper;

    public function __construct()
    {
        $this->helper = new Common;
    }
 
    public function logout()
    {
        Auth::guard('owner')->logout();

        return redirect('owner/login');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function login()
    {

        return view('owner.login');
    }

    
    public function authenticate(Request $request){
        $remember = ($request->remember_me) ? true : false;
        $owner = Owner::where('email', $request['email'])->first();
        if (!empty($owner->status)) {
          if ($owner->status != 'Inactive') {
      
             if (Auth::guard('owner')->attempt(['email' => trim($request['email']), 'password' => trim($request['password'])])) {
              
                 $pref   = Settings::getAll()->where('type', 'preferences');
                 $prefer = [];
                 if($this->n_as_k_c()) {
                    Session::flush();
                    return view('vendor.installer.errors.admin');
                }
                 if (!empty($pref)) {
                    foreach ($pref as $value) {
                        $prefer[$value->name] = $value->value;
                     }
                    Session::put($prefer);
                 }
                return redirect()->intended('owner/dashboard');
             } else {
                $this->helper->one_time_message('danger', 'Please Check Your Email/Password');
                return redirect('owner/login');
             }
          } else {
            $this->helper->one_time_message('danger', 'You are Blocked.');
            return redirect('owner/login');
          }
        } else {

             $this->helper->one_time_message('danger', 'Please Check Your Email/Password');
             return redirect('owner/login');

        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function n_as_k_c() {
        if(!g_e_v()) {
            return true;
        }
        if(!g_c_v()) {
            try {
                $d_ = g_d();
                $e_ = g_e_v();
                $e_ = explode('.', $e_);
                $c_ = md5($d_ . $e_[1]);
                if($e_[0] == $c_) {
                    p_c_v();
                    return false;
                }
                return true;
            } catch(\Exception $e) {
                return true;
            }
        }
        return false;
    }
}
