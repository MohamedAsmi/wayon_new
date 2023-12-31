<?php

namespace App\Http\Controllers\Owner;

use App\DataTables\OwnerTransactionDataTable;
use DB,Auth,Validator,Hash;
use App\Http\Controllers\Controller;
use App\Http\Controllers\EmailController;
use App\Http\Helpers\Common;
use Illuminate\Http\Request;

use App\Models\{
    User,
    Properties,
    Bookings,
    Country,
    Owner,
    Timezone,
    UserDetails
};
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
  
    protected $helper;

    public function __construct()
    {
        $this->helper = new Common;
    }

    public function index()
    {

    
        // $data['total_users_count']        = User::count();
        // $data['total_property_count']     = Properties::count();
        $data['total_reservations_count'] = Bookings::where('user_id', Auth::guard('owner')->user()->id)->count();

        // $data['today_users_count']        = User::whereDate('created_at', DB::raw('CURDATE()'))->count();
        // $data['today_property_count']     = Properties::whereDate('created_at', DB::raw('CURDATE()'))->count();
        $data['today_reservations_count'] = Bookings::where('host_id', Auth::guard('owner')->user()->id)->whereDate('created_at', DB::raw('CURDATE()'))->count();
// dd($data);
        // $properties = new Properties;
        // $data['propertiesList'] = $properties->getLatestProperties();

        $bookings = new Bookings;
        $data['bookingList'] = $bookings->getBookingOwnerLists();
        return view('owner.dashboard', $data);
    }

    public function transactionHistory(OwnerTransactionDataTable $dataTable)
    {

        $data['from'] = isset(request()->from) ? request()->from : null;
        $data['to']   = isset(request()->to) ? request()->to : null;

        $data['title']  = 'Transaction History';
        return $dataTable->render('owner.account.transaction_history',$data);
    }

    public function profile(Request $request, EmailController $email_controller)
    {

        $owner = Owner::find(Auth::guard('owner')->user()->id);

        if ($request->isMethod('post')) {
            $rules = array(
                'username'      => 'required|max:255',
                'email'           => 'required|max:255|email|unique:owners,email,'.Auth::guard('owner')->user()->id,
            );

            $messages = array(
                'required'                => ':attribute is required.',
            );

            $fieldNames = array(
                'username'      => 'User Name',
            );

            $validator = Validator::make($request->all(), $rules, $messages);
            $validator->setAttributeNames($fieldNames);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {
                $new_email = ($owner->email != $request->email) ? 'yes' : 'no';

                $owner->username      = $request->username;
                $owner->email           = $request->email;
                $owner->save();

                if ($new_email == 'yes') {
                    $email_controller->change_email_confirmation($owner);

                    $this->helper->one_time_message('success', trans('messages.success.email_cofirmation_success'));
                } else {
                    $this->helper->one_time_message('success', trans('messages.profile.profile_updated'));
                }
            }
        }

        $data['profile']   = Owner::find(Auth::guard('owner')->user()->id);

        $data['timezone'] = Cache::remember('timezone', 86400, function () {
            return Timezone::get()->pluck('zone', 'value');
            });

        $data['country'] = Cache::remember('country', 86400, function () {
            return Country::get()->pluck('name', 'short_name');
            });



        if (isset($details['date_of_birth'])) {
            $data['date_of_birth'] = explode('-', $details['date_of_birth']);
        } else {
            $data['date_of_birth'] = [];
        }

        return view('owner.profile', $data);
    }

    public function media()
    {
        $data['result'] = $owner = Owner::find(Auth::guard('owner')->user()->id);

        if (isset($_FILES["photos"]["name"])) {
            foreach ($_FILES["photos"]["error"] as $key => $error) {
                $tmp_name     = $_FILES["photos"]["tmp_name"][$key];
                $name         = str_replace(' ', '_', $_FILES["photos"]["name"][$key]);
                $ext          = pathinfo($name, PATHINFO_EXTENSION);
                $name         = 'profile_'.time().'.'.$ext;
                $path         = 'public/images/profile/'.Auth::guard('owner')->user()->id;
                $oldImagePath =  public_path('images/profile').'/'.Auth::guard('owner')->user()->id.'/'.$data['result']->profile_image;
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                if ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg' || $ext == 'gif') {
                    if(!empty($owner->profile_image) && file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                    if (move_uploaded_file($tmp_name, $path."/".$name)) {
                        $owner->profile_image  = '/'.$path.'/'.$name;
                        $owner->save();
                        $this->helper->one_time_message('success', trans('messages.users_media.uploaded'));
                    }
                }

            }
        }
        return view('owner.media', $data);
    }

    public function verification(Request $request)
    {
        $data          = [];
        $data['title'] = 'Verify your account';
        return view('owner.verification', $data);
    }

    public function security(Request $request)
    {
        if ($request->isMethod('post')) {
            $rules = array(
                'old_password'          => 'required',
                'new_password'          => 'required|min:6|max:30|different:old_password',
                'password_confirmation' => 'required|same:new_password|different:old_password'
            );

            $fieldNames = array(
                'old_password'          => 'Old Password',
                'new_password'          => 'New Password',
                'password_confirmation' => 'Confirm Password'
            );

            $validator = Validator::make($request->all(), $rules);
            $validator->setAttributeNames($fieldNames);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {
                $owner = Owner::find(Auth::guard('owner')->user()->id);

                if (!Hash::check($request->old_password, $owner->password)) {
                    return back()->withInput()->withErrors(['old_password' => trans('messages.profile.pwd_not_correct')]);
                }

                $owner->password = bcrypt($request->new_password);

                $owner->save();

                $this->helper->one_time_message('success', trans('messages.profile.pwd_updated'));
                return redirect('owner/security');
            }
        }
        return view('owner.account.security');
    }
}
