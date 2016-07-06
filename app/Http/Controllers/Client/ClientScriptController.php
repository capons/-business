<?php

namespace App\Http\Controllers\client;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\model\DB\Script;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;

class ClientScriptController extends Controller
{
    /**
     * @param array $data
     * @return mixed
     */
    protected function validator(array $data)
    {
        $messages = [ //validation message
            'name.required' => 'Введите имя!',
            'desc.required' => 'Введите описание',
        ];
        return Validator::make($data, [   //validation registration form
            'name' => 'required|min:3|max:50',
            'desc' => 'required|min:3|max:255',
        ],$messages);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::where('id', Auth::user()->id)->first();
        //$block_category = Script::all()->toArray();
        $block_category = Script::where('users_id', Auth::user()->id)->get()->toArray();;
        //builde category tree

        $cat = array();
        //В цикле формируем массив разделов, ключом будет id родительской категории, а также массив разделов, ключом будет id категории
        //$data['parent_categories'] all goods category
        foreach ( $block_category as $row) {
            // $cat_ID[$row['id']][] = $row; need if need function 'find_parent'
            $cat[$row['parent_id']][$row['id']] = $row;
        }
       
        $block_category_tree =  $this->build_tree($cat, 0); //SEND category tree to view

        return view('client.script',['user' => $user,'block_tree' => $block_category_tree]);
    }
    public function build_tree($cat, $parent_id, $only_parent = false){
            $tree = '<div class="child">';
            if (is_array($cat) and isset($cat[$parent_id])) {
                $tree .= '<ul style="list-style: none" class="dropdown">';
                if ($only_parent == false) {
                    foreach ($cat[$parent_id] as $cat_row) {
                      //  if(mb_strlen($cat_row['desc']) > 15) {
                            $tree .= '<li id="' . $cat_row['id'] . '"><div  class="col-xs-12 block_body"><div class="col-xs-12 block_title">' . $cat_row['name'] . '</div> <div class="col-xs-12 block_desc">' . mb_substr($cat_row['desc'], 0, 15) . '...' . '</div><div><span class="b_edit-'.$cat_row['id'].'"  data-name='.$cat_row['name'].' data-desc='.$cat_row['desc'].' onclick="edit_script('.$cat_row['id'].')">редиктировать</span><span onclick="add_script('.$cat_row['id'].')">Add</span><span onclick="show_script('.$cat_row['id'].')">show</span></div></div>';  //li -> will have a id as category id in database
                      //  } else {
                        //    $tree .= '<li onclick="test('.$cat_row['id'].')" id="' . $cat_row['id'] . '"><div class="col-xs-12" style="height:100px;background-color: #b4b9c0;">' . $cat_row['name'] . ' <div>'.$cat_row['desc'].'</div><div><a href="'.Config::get('app.url').'client/account/script/'.$cat_row['id'].'">редиктировать</a></div></div>';  //li -> will have a id as category id in database
                     //   }
                        $tree .= $this->build_tree($cat, $cat_row['id']);
                        $tree .= '</li>';
                    }
                } elseif (is_numeric($only_parent)) {
                    $category = $cat[$parent_id][$only_parent];
                    $tree .= '<li>' . $category['name'];
                    $tree .= $this->build_tree($cat, $category['id']);
                    $tree .= '</li>';
                }
                $tree .= '</ul>';
            } else return null;
            $tree .= '</div>';

            return $tree;
        }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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

        return response()->json([
            'success' => true,
            'message' => Lang::get('message.client.positiv_add_script')
        ], 200);
        die();
    }

    /**
     * @param array $data
     * @return static
     */
    protected function add(array $data){ //method to save registration user data to database
        if(empty($data['parent_id'])){
            $new_block = Script::create(['users_id' => Auth::user()->id,'name' => $data['name'],'desc' => $data['desc']]);
            return $new_block;
        } else {
            $new_block = Script::create(['parent_id' => $data['parent_id'],'users_id' => Auth::user()->id,'name' => $data['name'],'desc' => $data['desc']]);
            return $new_block;
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
        $user = User::where('id', Auth::user()->id)->first();
        $script = Script::where('id',$id)->first();
        return view('client.script_view', ['script' => $script,'user'=>$user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request) //edit script block
    {
        echo 'ОБНОВИТЬ В БАЗЕ';
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
}
