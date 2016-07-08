<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Session;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;
    protected $redirectTo = '/'; //redirect path after sign in
    private $last_id = '';  //put into variable last insert id
    private $hash = ''; //put into variable user hash to confirm user account
    private $login_err_m = ''; //login error message
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest', ['except' => 'getLogout']); //было вначале // redirect from Middleware/RedirectifAuth
    }
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $messages = [ //validation message
            'name.required' => 'Введите имя!',
            'email.required' => 'Введите email или логин!',
            'email.unique' => 'Email уже занят!',
            'pass.required' => 'Введите пароль!',
            're_pass.required' => 'Введите пароль повторно!',
            're_pass.same' => 'Подтверждение пароля не верно!'
        ];
        return Validator::make($data, [   //validation registration form
            'name' => 'required|max:50',
            'email' => 'required|email|max:50|unique:users',
            'pass' => 'required|min:3|max:50',
            're_pass' => 'required|same:pass',
        ],$messages);
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function postLogin(Request $request) //login via email + pass for client (administrator)
    {
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();
        if ($throttles && $this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }
        //$credentials = $this->getCredentials($request);
        $messages = [ //validation message
            'l_email.required' => 'Введите имя!',
            'l_pass.required' => 'Введите пароль!'
        ];
        //$validator = Validator::make(Input::all(), $rules,$messages);
        $validator = Validator::make($request->all(), [
            'l_email' => 'required',
            'l_pass' => 'required'
        ], $messages);
        if ($validator->fails()) { //if true display error
            return redirect('auth/login')
                ->withInput()
                ->withErrors($validator); //set validation error name to display in error layout  views/common/errors.blade.php
        } else {
            $userdata_email = array( //login via email by client
                'email'     => Input::get('l_email'),  //email -> database row name
                'password'  => Input::get('l_pass')//password -> database row name
            );
            
            $userdata_name = array( //login via name by manager
                'login'    => Input::get('l_email'),
                'password'  => Input::get('l_pass')
            );

            if (Auth::attempt(/*$credentials*/$userdata_email/* + ['active' => 1]*/, $request->has('remember'))) { //avtive need to be 1 to check if user active account
                if(Auth::attempt($userdata_email + ['active' => 1])) { //check if user active account
                    if(Auth::user()->access == 2) {
                        Session::flash('user-info', Lang::get('message.auth.access_login')); //send message to user via flash data
                        return redirect('client/account');
                        // if (Session::has('user_auth_mess')) { //if session isset redirect if no push data to session
                        //return $this->handleUserWasAuthenticated($request, $throttles);
                        //} else {
                        //Session::push('user_auth_mess', $data);  //$data is an array and user is a session key.
                        //   return $this->handleUserWasAuthenticated($request, $throttles);
                        //}
                    } else {
                        $this->login_err_m = Lang::get('error.auth.no_access');
                    }
                } else {
                    $this->login_err_m = Lang::get('error.auth.no_active');
                }
            } elseif (Auth::attempt(/*$credentials*/$userdata_name /*+ ['active' => 1]*/, $request->has('remember'))) {

                if(Auth::attempt($userdata_name + ['active' => 1])) { //check if user active account
                    if(Auth::user()->access == 1) {
                        Session::flash('user-info', Lang::get('message.auth.access_login')); //send message to user via flash data
                        return redirect('manager/account');
                    } else {
                        $this->login_err_m = Lang::get('error.auth.no_access');
                    }
                    /*
                    if (Session::has('user_auth_mess')) { //if session isset redirect if no push data to session
                        return $this->handleUserWasAuthenticated($request, $throttles);
                    } else {
                        //Session::push('user_auth_mess', $data);  //$data is an array and user is a session key.
                        return $this->handleUserWasAuthenticated($request, $throttles);
                    }
                    */
                } else {
                    $this->login_err_m = Lang::get('error.auth.no_active');
                }
            
            } else {
                $this->login_err_m = Lang::get('error.login_pass_error');
            }
        }
        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ($throttles) {
            $this->incrementLoginAttempts($request);
        }
        //return redirect($this->loginPath())
        return redirect('auth/login') //redirect to with message
        ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                $this->loginUsername() => $this->login_err_m,//$this->getFailedLoginMessage(), //message active account error
            ]);
    }


    //now method disable ! Method need if we need second form to authorization by manager!
    public function postLoginManager(Request $request){ //login by manager (if need to do another login page for manager)
        if ($request->isMethod('post')) {
            // If the class is using the ThrottlesLogins trait, we can automatically throttle
            // the login attempts for this application. We'll key this by the username and
            // the IP address of the client making these requests into this application.
            $throttles = $this->isUsingThrottlesLoginsTrait();
            if ($throttles && $this->hasTooManyLoginAttempts($request)) {
                return $this->sendLockoutResponse($request);
            }
            //$credentials = $this->getCredentials($request);
            $messages = [ //validation message
                'm_login.required' => 'Введите логин!',
                'm_pass.required' => 'Введите пароль!'
            ];
            //$validator = Validator::make(Input::all(), $rules,$messages);
            $validator = Validator::make($request->all(), [
                'm_login' => 'required',
                'm_pass' => 'required'
            ], $messages);
            if ($validator->fails()) { //if true display error
                return redirect('auth/login')
                    ->withInput()
                    ->withErrors($validator); //set validation error name to display in error layout  views/common/errors.blade.php
            } else {
                $userdata_email = array( //login via email
                    'email'     => Input::get('m_login'),  //email -> database row name
                    'password'  => Input::get('m_pass')//password -> database row name
                );

                $userdata_name = array( //login via name
                    'name'    => Input::get('l_email'),
                    'password'  => Input::get('l_pass')
                );

                //print_r($userdata_email);
                //die();
                if (Auth::attempt(/*$credentials*/$userdata_email/* + ['active' => 1]*//*, $request->has('remember')*/)) { //avtive need to be 1 to check if user active account
                    if(Auth::attempt($userdata_email + ['active' => 1])) { //check if user active account
                       // echo Auth::user()-> access;
                       // die();
                        if(Auth::user()->access == 1) {
                            Session::flash('user-info', Lang::get('message.auth.access_login')); //send message to user via flash data
                            return redirect('client/account');
                        // if (Session::has('user_auth_mess')) { //if session isset redirect if no push data to session
                        //return $this->handleUserWasAuthenticated($request, $throttles);
                        //} else {
                        //Session::push('user_auth_mess', $data);  //$data is an array and user is a session key.
                        //   return $this->handleUserWasAuthenticated($request, $throttles);
                        //}
                         } else {
                              $this->login_err_m = 'У вас нет прав!';
                         }
                    } else {
                        $this->login_err_m = Lang::get('error.auth.no_active');
                    }
                } else {
                    $this->login_err_m = Lang::get('error.login_pass_error');
                }
            }
            // If the login attempt was unsuccessful we will increment the number of attempts
            // to login and redirect the user back to the login form. Of course, when this
            // user surpasses their maximum number of attempts they will get locked out.
            if ($throttles) {
                $this->incrementLoginAttempts($request);
            }
            //return redirect($this->loginPath())
            return redirect('auth/login') //redirect to with message
            ->withInput($request->only($this->loginUsername(), 'remember'))
                ->withErrors([
                    $this->loginUsername() => $this->login_err_m,//$this->getFailedLoginMessage(), //message active account error
                ]);
        } else {
            return redirect('/');
        }

    }
    /**
     * @param Request $request
     * @return mixed
     */
    public function postRegister(Request $request) //save registration user data
    {

        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
       // Auth::login($this->create($request->all())); //registration and authorization in web application
        $this->create($request->all());
        //$this->last_id -> return last database insert id
        $user = User::findOrFail($this->last_id); //user object
        $link_to_active = Config::get('app.url').'auth/active'.'?hash='.$this->hash.'&id='.$this->last_id; //send variable to mail view
        // To send HTML mail, the Content-type header must be set
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf8' . "\r\n";
        $headers .= 'От '.env('admin_email'). "\r\n";
        mail($user->email, 'Ссылка для активации аккаунта', 'Спасибо за регистрацию в нашем сервисе, пройдите по ссылке чтобы подтвердить свой email '."\r\n".$link_to_active, $headers);

        Session::flash('user-info',Lang::get('message.reg_confirm') ); //send message to user via flash data
        return redirect('/');
    }
    public function postActivate(Request $request) //activate user account
    {
        if(! count(Input::all())){ //if empty request input redirect
            return redirect('/'); //redirect to main page
        }
        Validator::make($request->all(), [
            'id' => 'integer'
        ]);
        $hash = Input::get('hash'); //user data id
        $id = Input::get('id');
        $find_user = User::where('id', $id)->where('hash',$hash)->get();  //find user with correct id and hash
        if(!$find_user->isEmpty()){ //if result true
            $values=array('active'=>1,'access'=>2,'hash'=>bcrypt(str_random(40))); //update data -> new hash to confirm that we active user acount and link work only once
            User::where('id',$id)->where('hash',$hash)->update($values);
            //$user = User::findOrFail($id);
            //Session::flash('user-info', Lang::get('message.active_account')); //send message to user via flash data
            //return redirect('/'); //redirect to main page
            return view('auth.reg_confirm',['user_info' => Lang::get('message.active_account')]);
        } else {
            Session::flash('user-info', Lang::get('error.invalid_link'));
            return redirect('/'); //redirect to main page
        }
    }
    /**
     * @return mixed
     */
    /*
    public function getLogout() //logout user
    {
        Auth::logout(); //destroy Auth class data
        Session::flush(); //destroy session
        return redirect('/');
    }
    */
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data){ //method to save registration user data to database
        $this->hash = bcrypt($data['name']); //put user account activate hash into variable
        $save_data = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['pass']),
            'hash' => $this->hash
            //'active' => 1 //set user to active (need to be confirm on email address in future)
        ]);
        $this->last_id = $save_data->id;    //put user id into variable -> use in account activatio
        return $save_data;
    }
}
