<?php

namespace App\Http\Controllers\client;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;

class ClientManagerController extends Controller
{
    /**
     * @param array $data
     * @return mixed
     */
    protected $redirectTo = 'client/account/manager';
    //private $last_id = '';  //put into variable last insert id
    private $hash = ''; //put into variable user hash to confirm user account
    private $login_generator = ''; //generate login
    private $pass_generator = '';  //generate pass
    private $login_err_m = ''; //login error message
    protected function validator(array $data)
    {
        $messages = [ //validation message
            'name.required' => 'Введите имя!',
        ];
        return Validator::make($data, [   //validation registration form
            'name' => 'required|min:6|max:50',
        ],$messages);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() //default
    {
        $user = User::where('id', Auth::user()->id)->first();
        $all_manager = User::where('parent_id',Auth::user()->id)->get(); //display all client manager
        return view('client.manager',['user' => $user,'manager' => $all_manager]);
    }

    /**
     * @param Request $request
     */
    public function create(Request $request) //create new manager (respons from ajax)
    {
        if ($request->isMethod('post')){
            // Display text here
            $validator = $this->validator($request->all());
            if ($validator->fails()) {
                $errors = $validator->errors(); //error send to ajax
                $errors =  json_decode($errors);
                return response()->json([
                    'success' => false,
                    'message' => $errors
                ], 200);
                die();
            }
            $this->add($request->all());
            //send mail
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=utf8' . "\r\n";
            $headers .= 'От '.env('admin_email'). "\r\n";
            $message = 'Логин менеджера '.$this->login_generator."\r\n";
            $message .= 'Пароль менеджера '.$this->pass_generator."\r\n";
            mail(Auth::user()->email, 'Данные нового менеджера', $message, $headers);
            return response()->json([
                'success' => true,
                'message' => Lang::get('message.client.positiv_add_new_manager')
            ], 200);
            die();
        } else {
            return redirect($this->redirectTo);
        }
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
        $manager = User::where('id',$id)->first();
        $delete_manager = User::where('id', $id)->delete();
        Session::flash('user-info', Lang::get('message.client.positiv_delete_m'));
        //send mail
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf8' . "\r\n";
        $headers .= 'От '.env('admin_email'). "\r\n";
        $message = 'Менеджер '.$manager->name.' удален успешно'."\r\n";
        mail(Auth::user()->email, 'Менеджер удален!', $message, $headers);
        return redirect($this->redirectTo);


    }
    protected function add(array $data){ //method to save registration user data to database
        $this->hash = bcrypt($data['name']); //put user account activate hash into variable
        $this->pass_generator = str_random(8); //generate password
        $this->generateLogin(); //generate login manager login name
        $save_data = User::create([
            'name' => $data['name'],
            'login' => $this->login_generator, //email column for manager login
            'password' => bcrypt($this->pass_generator),
            'active' => 1, //set user to active (need to be confirm on email address in future)
            'access' => 1,
            'hash' => $this->hash,
            'parent_id' => Auth::user()->id,
        ]);
        return $save_data;
    }
    protected function generateLogin(){ //generate manager login name
        $this->login_generator = str_pad(mt_rand(1,99999999),8,'0',STR_PAD_LEFT); //substr($this->login_generator, 2);
        $login_name =  User::where('login', $this->login_generator)->first();  //email column for manager login
        if(count($login_name) > 0){ //if login name isset -> generate new login name
            $this->generateLogin();
        }
    }
}
