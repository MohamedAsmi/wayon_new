<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\AdminownerDataTable;
use App\Http\Controllers\Controller;
use App\Http\Controllers\EmailController;
use App\Http\Helpers\Common;
use App\Models\Owner;
use App\Models\OwnerVerification;
use App\Models\RoleOwner;
use App\Models\Roles;
use App\Models\Settings;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Auth;
use Validator;
use Illuminate\Support\Facades\Cache;



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

    public function index(AdminownerDataTable $dataTable)
    {
      
        return $dataTable->render('admin.owner.view');
    }

    public function wallet($userId)
    {
       $defaultCurrencyId    = Settings::getAll()->where('name', 'default_currency')->first();
       $wallet               = new Wallet();
       $wallet->user_id      = $userId;
       $wallet->currency_id  = (int)$defaultCurrencyId->value;
       $wallet->save();

    }
    
   
    public function add(Request $request, EmailController $email_controller)
    {
        
        if (! $request->isMethod('post')) {
            $data['roles'] = Roles::all()->pluck('display_name','id');
            return view('admin.owner.add', $data);
        } elseif ($request->isMethod('post')) {
            $rules = array(
                'username'   => 'required|unique:owners|max:255',
                'email'      => 'required|email|unique:owners|max:255',
                'password'   => 'required|max:50',
                'status'     => 'required'
            );
            $fieldNames = array(
                'username'   => 'Username',
                'email'      => 'Email',
                'password'   => 'Password',
                'status'     => 'Status'
            );

            $validator = Validator::make($request->all(), $rules);
            $validator->setAttributeNames($fieldNames);
            // dd($validator->fails());

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {
                $owner = new Owner;
                $owner->username = $request->username;
                $owner->email    = $request->email;
                $owner->password = bcrypt($request->password);
                $owner->status   = !empty($request->status) ? $request->status : 'Active';
                $owner->save();

                $owner_verification  = new OwnerVerification;
                $owner_verification->owner_id  =   $owner->id;
                $owner_verification->save();
    
                $this->wallet($owner->id);
                $email_controller->welcome_email($owner);

                RoleOwner::insert(['owner_id' => $owner->id, 'role_id' => Owner::IS_OWNER]);

                $this->helper->one_time_message('success', 'Added Successfully');

                return redirect('admin/admin-owners');
            }
        } else {
            return redirect('admin/admin-owners');
        }
    }

   

    public function update(Request $request)
    {
        if (!$request->isMethod('post')) {
            $data['result']  = Owner::find($request->id);

            $data['roles']   = Roles::all()->pluck('display_name', 'id');

            $data['role_id'] = Roles::role_admin($request->id)->role_id;

            return view('admin.owner.edit', $data);
        } elseif ($request->isMethod('post')) {
            $rules = array(
                'username'   => 'required|max:255|unique:owners,username,'.$request->id,
                'email'      => 'required|max:255|email|unique:owners,email,'.$request->id,
                'role'       => 'required',
                'status'     => 'required'
            );

            $fieldNames = array(
                'username'   => 'Username',
                'email'      => 'Email',
                'role'       => 'Role',
                'status'     => 'Status'
            );

            $validator = Validator::make($request->all(), $rules);
            $validator->setAttributeNames($fieldNames);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {
                $owner = Owner::findOrFail($request->id);

                $owner->username = $request->username;
                $owner->email    = $request->email;
                $owner->status   = $request->status;

                if($request->password != '')
                    $owner->password = bcrypt($request->password);

                $owner->save();

                RoleOwner::where(['owner' => $request->id])->update(['role_id' => Owner::IS_OWNER]);

                Cache::forget(config('cache.prefix') . '.role_owner');

                $this->helper->one_time_message('success', 'Updated Successfully');

                return redirect('admin/admin-owners');
            }
        } else {
            return redirect('admin/admin-owners');
        }
    }



    
    public function delete(Request $request)
    {
        if ( $request->id == 1 ) {

           $this->helper->one_time_message('error', 'This User can\'t be deleted');
           return redirect('admin/admin-users');
        }elseif ($request->id == Auth::guard('admin')->id()) {
            $this->helper->one_time_message('error', 'You can\'t delete yourself!');
           return redirect('admin/admin-users');
        }else{

            Owner::find($request->id)->delete();
            RoleOwner::where('owner_id', $request->id)->delete();
            Cache::forget(config('cache.prefix') . '.role_owner');
            $this->helper->one_time_message('success', 'Deleted Successfully');
            return redirect('admin/admin-owners');
        }

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
}
