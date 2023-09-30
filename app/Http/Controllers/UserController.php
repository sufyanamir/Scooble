<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Client\ConnectionException;
use App\Models\User;
use App\Mail\otpVerifcation;
use App\Mail\SubscriptionPurchased;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use App\Http\Controllers\API\APIController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Announcement;
use App\Models\Package;
use App\Models\Notification;
use Illuminate\Foundation\Auth\Authenticatable;
use Carbon\Carbon;
use App\Models\Trip;
use App\Models\Address;
use Omnipay\Omnipay;
use App\Models\Payment;
use App\Jobs\SendSubscriptionPurchasedEmail;
use App\Jobs\SendEmailVerificationJob;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB; 
use App;

class UserController extends Controller
{

    public $api;

    private $gateway;
    private $user;
    private $payment;
    protected $tripStatus;
    protected $userStatus;
    protected $curFormatDate;

    public function __construct(){
        $this->user = auth()->user();
        $this->api = new APIController();
        $this->gateway = Omnipay::create('PayPal_Rest');
        $this->gateway->setClientId(config('constants.PAYPAL.CLIENT_ID'));
        $this->gateway->setSecret(config('constants.PAYPAL.CLIENT_SECRET'));
        $this->gateway->setTestMode(true);
        $this->tripStatus = config('constants.TRIP_STATUS');
        $this->userStatus = config('constants.USER_STATUS');
        $this->curFormatDate = Carbon::now()->format('Y-m-d');
    }

    public function lang_change(Request $request)
    {
       
        App::setLocale($request->lang);
        session()->put('locale', $request->lang);

        return redirect()->back();
       
    }

    public function index(Request $request)
    {
        $user = auth()->user();

        if($user){
            session(['user_details' => $user]);
            $now = Carbon::now('Asia/Karachi');
            $current_date = $now->format('Y-m-d H:i:s');
            $currentDate = Carbon::now();
            // User roles: 1 for admin, 2 for client, 3 for driver
            if(isset($user->role) && $user->role == user_roles('2')){

                if( $user->sub_exp_date){
                    
                    $expirationDate = Carbon::createFromFormat('Y-m-d', $user->sub_exp_date);
                    if ($currentDate->gt($expirationDate)) { 

                        return view('subscription_expired', ['user' => $user]);
                    }
                    else {

                        // $data['announcements'] = Announcement::where('start_date', '<=', $current_date)->where('end_date', '>=', $current_date)->get()->toArray();

                        $data['user']           = $user;
                        $data['drivers'] = User::where(['role' => user_roles('3'), 'client_id' => $user->id, 'status' => $this->userStatus['Active']])
                        ->select('id', 'name', 'user_pic')
                        ->addSelect(DB::raw('ROUND(((
                            SELECT COUNT(*) 
                            FROM trips 
                            WHERE trips.driver_id = users.id 
                            AND DATE(trip_date) = CURDATE() 
                            AND status = 1
                        ) / (
                            SELECT COUNT(*) 
                            FROM trips 
                            WHERE trips.driver_id = users.id 
                            AND DATE(trip_date) = CURDATE() 
                            AND status IN (1, 2)
                        )) * 100, 2) as driv_active_percentage'))
                        ->get()
                        ->toArray();

                        $data['driversCount'] = count($data['drivers'] ?? []); 

                        $data['activeRoutes'] = Trip::with(['user:id,name', 'driver:id,name'])
                        ->whereHas('user', function ($query) use ($user) {
                            $query->where('id', $user->id);
                        })->whereDate('trip_date', $this->curFormatDate)->where('status', $this->tripStatus['In Progress'])
                        ->get(['id', 'title', 'desc', 'trip_date', 'driver_id', 'client_id', 'status'])
                        ->toArray();
                    

                        $data['totalRoutes']     = Trip::where('client_id', $user->id)->count();
                        $data['totalAct_Routes'] = Trip::whereIn('status', [$this->tripStatus['Pending'], $this->tripStatus['In Progress']])->where('client_id', $user->id)->count();
                        $data['totalTodayRout']  = Trip::whereDate('trip_date', $this->curFormatDate)->where('client_id', $user->id)->count();
                        $data['completedTrips']  = Trip::whereDate('trip_date', $this->curFormatDate)->where([['status', $this->tripStatus['Completed']], ['client_id', $user->id]])->count();
                        $data['activeTrips']     = Trip::whereDate('trip_date', $this->curFormatDate)->where([['status', $this->tripStatus['In Progress']], ['client_id', $user->id]])->count();
                        $data['PendingTrips']    = Trip::whereDate('trip_date', $this->curFormatDate)->where([['status', $this->tripStatus['Pending']], ['client_id', $user->id]])->count();

                        $data['compTrp_percentage'] = $data['totalTodayRout'] > 0 ? round(($data['completedTrips'] / $data['totalTodayRout']) * 100, 1) : 0;
                        $data['actvTrp_percentage'] = $data['totalTodayRout'] > 0 ? round(($data['activeTrips'] / $data['totalTodayRout']) * 100, 1) : 0;
                        $data['pendTrp_percentage'] = $data['totalTodayRout'] > 0 ? round(($data['PendingTrips'] / $data['totalTodayRout']) * 100, 1) : 0;

                        return view('client_dashboard', $data);
                    }
                }else{
                    return redirect('/home');
                }

            }

            else if(isset($user->role) && $user->role == user_roles('3')){
                
                $client = User::where(['role' => 'Client', 'id' => $user->client_id])->first();

                if ($client) {
                    if( $client->sub_exp_date){
                        $expirationDate = Carbon::createFromFormat('Y-m-d', $client->sub_exp_date);
                    
                        if ($currentDate->gt($expirationDate)) {
                            return redirect('/subscription-expired_driver');
                        }
                        else{

                            $data['activeRoutes'] = Trip::with('driver:id,name')
                            ->whereHas('driver', function ($query) use ($user) {
                                $query->where('id', $user->id);
                            })->whereDate('trip_date', $this->curFormatDate)->get(['id', 'title', 'desc', 'trip_date', 'driver_id', 'client_id', 'status'])->toArray();

                            $data['user']           = $user;
                            $data['totalRoutes']     = Trip::where('driver_id', $user->id)->count();
                            $data['totalAct_Routes'] = Trip::whereIn('status', [$this->tripStatus['Pending'], $this->tripStatus['In Progress']])->where('driver_id', $user->id)->count();
                            $data['activeTrips']     = Trip::where([['status', $this->tripStatus['In Progress']], ['driver_id', $user->id]])->count();
                            $data['PendingTrips']    = Trip::where([['status', $this->tripStatus['Pending']], ['driver_id', $user->id]])->count();
                            $data['completedTrips_detail']  = Trip::where([['status', $this->tripStatus['Completed']], ['driver_id', $user->id]])->get()->toArray();
                        
                            $data['completedTrips'] = count($data['completedTrips_detail'] ?? []);
                            return view('driver_dashboard', $data);
                        }
                    }else{
                        return redirect('/subscription-expired_driver');
                    }

                } else {
                    return redirect('/login');
                }

            }

            else{

                $data['user']           = $user;
                $data['adminsCount']    = User::where('role', user_roles('1'))->count();
                $data['clientsCount']   = User::where('role', user_roles('2'))->count();
                $data['driversCount']   = User::where('role', user_roles('3'))->count();
                $data['revenue']        = Payment::where('payment_status', 'approved')->where('transaction_status', 'approved')->sum('amount');
               
                $data['activeRoutes']   = Trip::with('user:id,name')->whereDate('trip_date', $this->curFormatDate)->where('status', $this->tripStatus['In Progress'])->get(['id', 'title', 'desc', 'trip_date', 'driver_id', 'client_id', 'status'])->toArray();

                $data['totalRoutes']    = Trip::count();
                $data['totalTodayRout'] = Trip::whereDate('trip_date', $this->curFormatDate)->count();
                $data['completedTrips'] = Trip::where('status', $this->tripStatus['Completed'])->whereDate('trip_date', $this->curFormatDate)->count();
                $data['activeTrips']    = Trip::where('status', $this->tripStatus['In Progress'])->whereDate('trip_date', $this->curFormatDate)->count();
                $data['PendingTrips']   = Trip::where('status', $this->tripStatus['Pending'])->whereDate('trip_date', $this->curFormatDate)->count();
                
                $data['compTrp_percentage'] = $data['totalTodayRout'] > 0 ? round(($data['completedTrips'] / $data['totalTodayRout']) * 100, 1) : 0;
                $data['actvTrp_percentage'] = $data['totalTodayRout'] > 0 ? round(($data['activeTrips'] / $data['totalTodayRout']) * 100, 1) : 0;
                $data['pendTrp_percentage'] = $data['totalTodayRout'] > 0 ? round(($data['PendingTrips'] / $data['totalTodayRout']) * 100, 1) : 0;

                return view('index', $data);
            }
        }
        else {
            $package = Package::orderBy('id', 'ASC')->get()->toArray();
            return view('home', ['data' => $package]);
        }
    }
    
    public function clients()
    {
        $user = auth()->user();
        $page_name = 'clients';

        if(!view_permission($page_name)){
            return redirect()->back();  
        }

        $clients = User::where(['role' => user_roles('2')])->orderBy('id', 'desc')->get()->toArray();
        return view('clients', ['data' => $clients,'user'=>$user ,'add_as_user'=> user_roles('2')]);

    }

    public function drivers()
    {
        $user = auth()->user();
        $page_name = 'drivers';

        if(!view_permission($page_name)){
            return redirect()->back();  
        }

        if(isset($user->role) && $user->role == user_roles('1')){

            $drivers = User::join('users as c', 'users.client_id', '=', 'c.id')
            ->where('users.role', 'Driver')
            ->select('users.*', 'c.name as client_name', 'c.user_pic as client_pic','c.email as client_email')
            ->orderBy('users.id', 'desc')
            ->get()
            ->toArray();
            $client_list = User::where(['role' => 'Client'])->orderBy('id', 'desc')->select('id','name')->get()->toArray();   
            
            return view('drivers', ['data' => $drivers,'user'=>$user,'add_as_user'=> user_roles('3'), 'client_list'=>$client_list]);
        } 
        else{

            $derivers = User::where(['role' => user_roles('3'),'client_id' => $user->id])->orderBy('id', 'desc')->get()->toArray();
            return view('drivers', ['data' => $derivers,'user'=>$user ,'add_as_user'=> user_roles('3')]); 
        }

    }

    public function routes()
    {
        $user = auth()->user();
        $page_name = 'routes';

        if(!view_permission($page_name)){
            return redirect()->back();  
        }

        if(isset($user->role) && $user->role == user_roles('1')){

            $trips = Trip::join('users as drivers', 'drivers.id', '=', 'trips.driver_id')
            ->join('users as clients', 'clients.id', '=', 'trips.client_id')
            ->select('trips.*', 'drivers.id as driver_id', 'drivers.name as driver_name', 'drivers.user_pic as driver_pic', 'clients.user_pic as client_pic', 'clients.name as client_name')
            ->orderBy('trips.id', 'desc')
            ->get()
            ->toArray();

            return view('routes', ['data' => $trips,'user'=>$user]);
        } 

        else if(isset($user->role) && $user->role == user_roles('2')){
            $trips = Trip::join('users', 'users.id', '=', 'trips.driver_id')
            ->where('trips.client_id', $user->id)
            ->select('trips.*', 'users.id as driver_id', 'users.name as driver_name', 'users.user_pic  as driver_pic')
            ->orderBy('trips.id', 'desc')
            ->get()
            ->toArray();
            return view('routes', ['data' => $trips,'user'=>$user]);
        }
        
        else {
            $trips = Trip::join('users', 'users.id', '=', 'trips.client_id')
            ->where('trips.driver_id', $user->id)
            ->select('trips.*', 'users.id as client_id', 'users.name as client_name', 'users.user_pic  as client_pic')
            ->orderBy('trips.id', 'desc')
            ->get()
            ->toArray();
            return view('routes', ['data' => $trips,'user'=>$user]);
        } 

    }

    public function create_trip(Request $request)
{
    $user = auth()->user();
    $data['user'] = $user;
    $page_name = 'create_trip';

    if (!view_permission($page_name)) {
        return redirect()->back();
    }
    $data['duplicate_trip'] = null;
    if ($request->has('id')) {

        $data['duplicate_trip'] = $request->duplicate_trip ?? null;

        if (isset($user->role) && ($user->role == user_roles('1'))) {
            //for admin
            $trip = Trip::with(['addresses' => function ($query) {
                $query->orderBy('order_no', 'ASC');
            }])->find($request->id);

            $data['data'] = $trip->toArray();
            $data['data']['addresses'] = $trip->addresses->toArray();
            
            if ($request->dashboard_data == 1) {
                $data['client_list'] = User::where('id', $trip->client_id)->first();
                $data['driver_list'] = User::where(['role' => user_roles('3'), 'client_id' => $data['data']['client_id']])
                    ->where('status', '<>', 5) // Exclude drivers with status 5
                    ->orderBy('id', 'desc')->get()->toArray();
                
                return view('pdf_templates', $data);
            } else {
                $data['client_list'] = User::where(['role' => user_roles('2'), 'status' => auth_users()])
                    ->orderBy('id', 'desc')->select('id', 'name')->get()->toArray();
                $data['driver_list'] = User::where(['role' => user_roles('3'), 'client_id' => $data['data']['client_id']])
                    ->where('status', '<>', 5) // Exclude drivers with status 5
                    ->orderBy('id', 'desc')->get()->toArray();
                return view('create_trip', $data);
            }
        } else {
            $trip = Trip::with(['addresses' => function ($query) {
                $query->orderBy('order_no', 'ASC');
            }])->find($request->id);

            $data['data'] = $trip->toArray();
            $data['data']['addresses'] = $trip->addresses->toArray();

            $data['driver_list'] = User::where(['client_id' => $trip->client_id])->orderBy('id', 'desc')
                ->where('status', '<>', 5) // Exclude drivers with status 5
                ->select('id', 'name')->get()->toArray();
            if ($request->dashboard_data == 1) {
                $data['client_list'] = User::where('id', $trip->client_id)->first();
                $data['driver_list'] = User::where('id', $trip->driver_id)->first();

                return view('pdf_templates', $data);
            } else {
                return view('create_trip', $data);
            }
        }
    } else {
        if (isset($user->role) && $user->role == user_roles('1')) {
            $data['driver_list'] = [];
            $data['client_list'] = User::where(['role' => user_roles('2'), 'status' => auth_users()])
                ->orderBy('id', 'desc')->select('id', 'name')->get()->toArray();
            return view('create_trip', $data);
        } else {
            $data['driver_list'] = User::where(['role' => user_roles('3'), 'client_id' => $user->id])
                ->orderBy('id', 'desc')
                ->where('status', '<>', 5) // Exclude drivers with status 5
                ->get()->toArray();
            return view('create_trip', $data);
        }
    }
}


    public function get_drivers(Request $request)
    {
        $driver_list = User::where(['role' => 'Driver', 'client_id' => $request->id])
            ->orderBy('id', 'desc')
            ->get()
            ->toArray();
    
        return response()->json($driver_list);
    }
    

    public function driver_map(Request $request)
    {
        $user = auth()->user();
        $page_name = 'driver_map';

        if(!view_permission($page_name)){
            return redirect('/');
        }

        if ($request->has('id')) {
            
            if(isset($user->role) && $user->role == user_roles('3')){   
                $trip = Trip::with(['addresses' => function ($query) {
                    $query->orderBy('order_no', 'ASC');
                }])->find($request->id);
                
                $tripData = $trip->toArray();
                $tripData['addresses'] = $trip->addresses->toArray();
                
                return view('driver_map',['data'=>$tripData, 'user'=>$user]);
            }
        }    
        else{
            return redirect('/routes');
         }
        
    }
    
    

    public function announcements_alerts()
    {
        return view('announcements_alerts');
    }

    public function pdf_templates()
    {
        return view('pdf_templates');
    }

    public function home(Request $request)
    {

        if (session()->has('user_details')) {

            $user = auth()->user();
        $page_name = 'home';

        if(!view_permission($page_name)){
            return redirect()->back();  
        }
    }
        

        if ($request->has('id')) {
            
            $package  = Package::where('id',$request->id)->first();
            return view('subscription', ['data' => $package]);
        } 
        else {

        $package = Package::orderBy('id', 'ASC')->get()->toArray();
        return view('home', ['data' => $package]);
        }
    }

    public function subscription()
    {
        return view('subscription');
    }


    public function calender()
    {
        $user = auth()->user();
        $page_name = 'calender';

        if(!view_permission($page_name)){
            return redirect()->back();  
        }

        if(isset($user->role) && $user->role == user_roles('1')){
            $data['trips'] = Trip::join('users as drivers', 'drivers.id', '=', 'trips.driver_id')
            ->join('users as clients', 'clients.id', '=', 'trips.client_id')
            ->select('trips.id', 'trips.trip_date','trips.title', 'trips.status', 'drivers.id as driver_id', 'drivers.name as driver_name')
            ->orderBy('trips.trip_date', 'ASC')
            ->get();   
            
            $data['dragable'] = 1;
        } 

        else if(isset($user->role) && $user->role == user_roles('2')){
            $data['trips'] = Trip::join('users', 'users.id', '=', 'trips.driver_id')
            ->where('trips.client_id', $user->id)
            ->select('trips.id', 'trips.trip_date','trips.title', 'trips.status', 'users.id as driver_id', 'users.name as driver_name')
            ->orderBy('trips.trip_date', 'ASC')
            ->get();

            $data['dragable'] = 1;

        }
        
        else {
            $data['trips'] = Trip::join('users', 'users.id', '=', 'trips.client_id')
            ->where('trips.driver_id', $user->id)
            ->select('trips.id', 'trips.trip_date','trips.title', 'trips.status', 'users.id as client_id', 'users.name as  driver_name', 'users.role as  dragable')
            ->orderBy('trips.trip_date', 'ASC')
            ->get();

            $data['dragable'] = 2;

        } 

        $data['user'] = $user;
    
        return view('calender',$data);
    }

    public function calendar_maintable()
    {
        $user = auth()->user();
        $page_name = 'calendar_maintable';

        if(!view_permission($page_name)){
            return redirect()->back();  
        }

        if(isset($user->role) && $user->role == user_roles('1')){

            $trips = Trip::join('users as drivers', 'drivers.id', '=', 'trips.driver_id')
            ->join('users as clients', 'clients.id', '=', 'trips.client_id')
            ->select('trips.*', 'drivers.id as driver_id', 'drivers.name as driver_name', 'drivers.user_pic as driver_pic', 'clients.user_pic as client_pic', 'clients.name as client_name')
            ->orderBy('trips.id', 'desc')
            ->get()
            ->toArray();

            return view('calendar_maintable', ['data' => $trips,'user'=>$user]);
        } 

        else if(isset($user->role) && $user->role == user_roles('2')){
            $trips = Trip::join('users', 'users.id', '=', 'trips.driver_id')
            ->where('trips.client_id', $user->id)
            ->select('trips.*', 'users.id as driver_id', 'users.name as driver_name', 'users.user_pic  as driver_pic')
            ->orderBy('trips.id', 'desc')
            ->get()
            ->toArray();
            return view('calendar_maintable', ['data' => $trips,'user'=>$user]);
        }
        
        else {
            $trips = Trip::join('users', 'users.id', '=', 'trips.client_id')
            ->where('trips.driver_id', $user->id)
            ->select('trips.*', 'users.id as client_id', 'users.name as client_name', 'users.user_pic  as client_pic')
            ->orderBy('trips.id', 'desc')
            ->get()
            ->toArray();
            return view('calendar_maintable', ['data' => $trips,'user'=>$user]);
        }
    }

    public function users()
    {
        $user = auth()->user();
        $page_name = 'users';

        if(!view_permission($page_name)){
            return redirect()->back();  
        }

        $users = User::where(['role' => 'Admin'])->orderBy('id', 'desc')->get()->toArray();
        return view('users', ['data' => $users ,'user'=>$user ,'add_as_user'=> user_roles('1')]);
    }

    public function notifications(Request $request)
    {
        $user = auth()->user();
        $page_name = 'notifications';
    
        if (!view_permission($page_name)) {
            return redirect()->back();
        }

    $notifications = NULL;
    if(isset($user->role) && $user->role == user_roles('1')){
        if ($request->has('all_read')) {
            Notification::where('status', '!=', 'seen') // Add any other condition if needed
                        ->update(['status' => 'seen']);
        
            return redirect()->back();
        }
         
            $notifications  = Notification::orderBy('id', 'desc')->get()->toArray();
        }
        return view('notifications', ['data'=>$notifications , 'user' => $user]);
    }

    public function announcements(Request $request)
    {
        $user = auth()->user();
        $page_name = 'announcements';
    
        if (!view_permission($page_name)) {
            return redirect()->back();
        }
    
        if ($request->has('id')) {
            
            $announcmnent  = Announcement::where('id',$request->id)->get()->toArray();
            $announcmnents = Announcement::where('status','on')->orderBy('id', 'desc')->get()->toArray();
            return view('announcements', ['data' => $announcmnents, 'user' => $user, 'announcmnent'=>$announcmnent[0]]);
        } 
        else {

            $announcmnents = Announcement::where('status','on')->orderBy('id', 'desc')->get()->toArray();
            return view('announcements', ['data' => $announcmnents, 'user' => $user]);
        }
    
    }

    public function packages(Request $request)
    {
        $user = auth()->user();
        $page_name = 'packages';
        
        if (!view_permission($page_name)) {
            return redirect()->back();
        }
    
        if ($request->has('id')) {
            
            $package  = Package::where('id',$request->id)->get()->toArray();
            $packages = Package::where('status','on')->orderBy('id', 'DESC')->get()->toArray();
            return view('packages', ['data' => $packages, 'user' => $user, 'package'=>$package[0]]);
        } 
        else {
            $packages = Package::where('status','on')->orderBy('id', 'DESC')->get()->toArray();
            return view('packages', ['data' => $packages, 'user' => $user]);
        }
    
    }
    

    public function settings()
    {
        $user = auth()->user();
        $page_name = 'settings';
    
        if (!view_permission($page_name)) {
            return redirect()->back();
        }

        $user = auth()->user();
        return view('settings',['user' => $user]);
    }

    public function user_store(REQUEST $request)
    {
        ($request->id) ? $user = User::find($request->id) : $user = new User();
        $user->name     = $request->client_name;
        $user->email    = $request->email;
        $user->phone    = $request->phone;
        $user->com_name = $request->company_name;
        $user->com_pic  = $request->company_logo;
        $user->address  = $request->address;
        $user->role     = $request->role;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $save = $user->save();

        return redirect()->back();
    }

    public function user_edit($id)
    {
        $user = User::where(['id' => $id])->get()->toArray();
        return json_encode($user);
    }

    public function user_register(REQUEST $request)
    {
        if ($request->all()) {

            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'password' => 'required',
                'confirm_password' => 'required|same:password',
                'email' => [
                    'required',
                    'email',
                    Rule::unique('users')->ignore($request->id),
                ],
            ]);            

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $verificationToken = Str::random(20);

            $user =  new User();
            $user->name     = $request->name;
            $user->email    = $request->email;
            $user->phone    = $request->phone;
            $user->com_name = $request->company_name;
            $user->com_pic  = $request->company_logo;
            $user->address  = $request->address;
            $user->role     = $request->role;
            $user->status   = 4;
            $user->remember_token   = $verificationToken;
            $user->password = Hash::make($request->password);
            $save = $user->save();
            if($save){
                $notification =  new Notification(); 
    
                $notification->title      = 'New User Regisration';
                $notification->user_id    = $user->id;
                $notification->desc       = 'New User Mr/Mis. '.$user->name.' Regisration is created Now. With Email: '.$user->email;
                $notification->status     = 'nseen' ;
                $notification->created_by = $user->id;
                $save = $notification->save();

                $emailData = [
                    'hash'  => $verificationToken,
                    'email' => $request->email,
                    'name'  => $request->name,
                    'body'  => 'Congratulations! You have successfully subscribed to our package.',
                ];

                SendEmailVerificationJob::dispatch($emailData)->onQueue('emails');
                
                return redirect('/register')->with('success', 'Please Check your Email for Verification');
            }
            
        } else {
            return view('register');
        }
    }
  
    public function user_login(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            if ($request->all()) {
                $login = $this->api->user_login($request);
                $responseData = json_decode($login->getContent(), true);
    
                if ($responseData['status'] == "success") {
                    session(['user' => $responseData['token']]);
                    session(['lang' => 'en']);
                }
    
                echo $login->getContent();
            } else {
                return view('login');
            }
        } else {
            return redirect('/');
        }
    }
    
    public function logout(REQUEST $request)
    {
        session()->forget('lang');
        session()->flush();
        return redirect('/home');
    }

    public function forgot_password(REQUEST $request)
    {

        $req = $request->all();
        if (isset($req['no1']) || isset($req['no2']) || isset($req['no3']) || isset($req['no4']) || isset($req['no5'])) 
        {
            $array = [$req["no1"], $req["no2"], $req["no3"], $req["no4"], $req["no5"]];
            $otp = implode('', $array);

            $user = User::where(['email' => $req['email'], 'otp' => $otp])->first();
            if ($user) {
                Session::flash('email_temp', $user->email);
                return redirect('/set_password');
            } else {             
        
                Session::flash('invalid', "OTP is not Correct");
                Session::flash('email', $req['email']);

                return view('forgotPassword', ['email' => $req['email'] , 'no'=>$array]);
            }
        } 

        else {

            if (isset($req['email']) && !empty($req['email'])) {

                $user = User::where('email', $req['email'])->first();
                if ($user) {
                    $otp = str_pad(random_int(0, 99999), 5, '0', STR_PAD_LEFT);
                    $emailData = [
                        'otp' => $otp,
                        'name' => $user->name,
                        'body' => 'Thank you for choosing our services. We are pleased to provide you with the OTP verification.',
                    ];
                    $mail = new otpVerifcation($emailData);

                                    
                
                    try {
                        $user->reset_pswd_attempt = $user->reset_pswd_attempt ? ++$user->reset_pswd_attempt : 1;

                        if ($user->reset_pswd_attempt > 3) {
                            $resetTime = $user->reset_pswd_time ? Carbon::parse($user->reset_pswd_time) : null;
                            $currentTime = Carbon::now();

                            if (!$resetTime || $resetTime->addMinutes(5)->isPast()) {
                                $user->reset_pswd_attempt = 1;
                                $user->reset_pswd_time = $currentTime;
                            } else {
                                Session::forget(['status', 'message','otp']);
                                $remainingTime = $resetTime->diffInSeconds($currentTime);
                                return view('forgotPassword', ['email' => $req['email'], 'forgot_pass' => 'You have exceeded the maximum password reset attempts. Please try again after ', 'remainingTime' => $remainingTime]);
                            }
                        }

                        Mail::to($user->email)->send($mail);

                        $user->otp = $otp;
                        $user->reset_pswd_time = Carbon::now();
                        $user->save();

                        Session::flash('otp', "Email sent successfully!");
                        Session::flash('email', $user->email);

                        return view('forgotPassword', ['email' => $req['email']]);
                    } catch (\Exception $e) {
                        echo "Failed to send email: " . $e->getMessage();
                    }

                } else {

                    Session::flash('status', 'invalid');
                    Session::flash('message', 'this email is invalid');
                    Session::flash('email', $req['email']);
                    

                    return view('forgotPassword', ['email' => $req['email']]);
                }
            } else {
                return view('forgotPassword');
            }
        }
    }

    public function set_password(Request $request)
    {
        $req['email'] = ($request->email) ? $request->email : session('email_temp');
        if ($req['email']) {
            if ($request->has('password')) {
                $validator = Validator::make($request->all(), [
                    'password' => 'required',
                    'confirm_password' => 'required|same:password',
                    'email' => 'required'
                ]);
    
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
    
                $user = User::where('email', $req['email'])->first();
                $user->password = Hash::make($request->password);
                $save = $user->save();
    
                if ($save) {
                    return redirect('/login')->with('password_changed', "Password is successfully changed");;
                }
            } else {
                return view('setPassword', ['email' => $req['email']]);
            }
        } else {
            return view('setPassword', ['email' => $req['email']]);
        }
    }

    public function change_status(REQUEST $request)
    {
        $user = User::where('id',$request->id)->first();
        if($request->status == 1){
        $user->status     = $request->status;
        $save = $user->save();
            if($save){
                $emailData = [
                    'otp' => 'Account Activation',
                    'name' => $user->name,
                    'body' => 'Dear You Account has been activated successfully :',
                ];
                $mail = new otpVerifcation($emailData);

                try {
                    Mail::to($user->email)->send($mail);
                     echo $save;
                } catch (\Exception $e) {
                    echo "Failed to send email: " . $e->getMessage();
                }

            }
        }
        else{
            $user->status     = $request->status;
            $save = $user->save(); 
            echo $save;
        }
        
    }

    public function pay(Request $request)
    {
        $user = auth()->user();
        if ($user) {
            try {
                $payment = new Payment();
                $payment->amount = $request->amount;
                $payment->currency = config('constants.PAYPAL.CURRENCY');
                $payment->package_id = $request->package_id;
                $payment->payment_method = 'PayPal';
                $payment->exp_date = Carbon::now()->addDays(30);
                $payment->created_by = Auth::id();
                $payment->save();
    
                $payment = Payment::where('created_by', Auth::id())->latest()->first();
    
                $response = $this->gateway->purchase(array(
                    'amount'    => $request->amount,
                    'currency'  => config('constants.PAYPAL.CURRENCY'),
                    'returnUrl' => url('/payment_success'),
                    'cancelUrl' => url('/payment_cancel')
                ))->send();
        
                if ($response->isRedirect()) {
                        $response->redirect();
                } 
    
                else {
    
                    if ($payment) {
                        $this->fail_trans($response->getMessage(), null, null, 'error');
                    }
    
                    return redirect()->back()->with('error', 'Payment could not proceed futher contact to Admin!!.');
                }
    
            } catch (\Throwable $th) {
    
                if ($payment) {
                    $this->fail_trans(null, $th->getMessage(), null, 'server_error');
                }
    
                return redirect()->back()->with('error', 'PayPal is declined to Connet. Check Your Network or Contact to Admin.');
            }
        }else{
            return redirect('/login');
        }
    }
    
    public function payment_success(Request $request)
    {
        $payment = Payment::where('created_by', Auth::id())->latest()->first();
        $user = auth()->user();

        if ($request->input('paymentId') && $request->input('PayerID')) {

            $transaction = $this->gateway->completePurchase(array(
                'payer_id' => $request->input('PayerID'),
                'transactionReference' => $request->input('paymentId')
            ));

            $response = $transaction->send();

            if ($response->isSuccessful()) {

                $arr = $response->getData();

                if ($payment) {
                    $payment->payment_id = $arr['id'];
                    $payment->payer_id = $arr['payer']['payer_info']['payer_id'];
                    $payment->payer_email = $arr['payer']['payer_info']['email'];
                    $payment->amount = $arr['transactions'][0]['amount']['total'];
                    $payment->currency = config('constants.PAYPAL.CURRENCY');
                    $payment->payment_status = $arr['state'];
                    $payment->transaction_status = $arr['state'];
                    $payment->payment_token = $request->input('token');;
                    $payment->save();

                    $user->sub_id  = $payment->id;
                    $user->sub_exp_date  = $payment->exp_date;
                    $user->sub_package_id = $payment->package_id;
                    $user->status = 1;
                    $saved = $user->save();

                    if($saved){
                        $emailData = [
                            'package_name' => $payment->package->title,
                            'name' => $user->name,
                            'body' => 'Congratulations! You have successfully subscribed to our package.',
                        ];

                        SendSubscriptionPurchasedEmail::dispatch($user, $payment)->onQueue('emails');
    
                    }


                }

                return redirect('/')->with('subscription_active', 'Your subscription is now active.');

            }
            else{
                if ($payment) {
                    $this->fail_trans($response->getMessage(), null, null, 'error');
                    $url = url('/home');
                    return redirect($url)->with('error', 'Payment Could Completed!!.');
                }
            }
        }
        else{
            if ($payment) {
                $this->fail_trans($response->getMessage(), null, null, 'error');
                $url = url('/home');
                return redirect($url)->with('error', 'Payment declined!!.');
            }
        }
    }

    public function payment_cancel(Request $request)
    {  
        $this->fail_trans(null, null, $request->input('token'), 'cancel');
        $url = url('/home');
        return redirect($url)->with('error', 'Your Decliened Payment and Cancel Subscription.');
    }
    
    public function fail_trans($transaction_error=null, $server_error=null, $token=null, $status=null){
        
        $payment = Payment::where('created_by', Auth::id())->latest()->first();
        if ($payment) {
            $payment->transaction_error = $transaction_error;
            $payment->server_error      = $server_error;    
            $payment->payment_token     = $token;
            $payment->payment_status    = $status;
            $payment->save();
        }
    }

    public function verify(Request $request, $hash)
    {
        $user = User::where('remember_token', $hash)->first();
    
        if ($user) {
            if (!$user->hasVerifiedEmail()) {
                $user->markEmailAsVerified();
                $user->status = 1;
                $user->save();
    
                return redirect('/login')->with('success', 'Email verified successfully. Please log in.');
            } else {
                return redirect('/login')->with('success', 'Email already verified.');
            }
        } else {
            return redirect('/login')->with('error', 'Invalid verification link.');
        }
    }
    
}
