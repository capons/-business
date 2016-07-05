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
            'name' => 'required|min:6|max:50',
            'desc' => 'required|min:6|max:255',
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

        return view('client.script',['user' => $user,'block_category' => $block_category,'block_tree' => $block_category_tree]);
    }
    public function build_tree($cat, $parent_id, $only_parent = false){
            $tree = '<div style="width: 50%;margin: 0 auto">';
            if (is_array($cat) and isset($cat[$parent_id])) {
                $tree .= '<ul type="circle" id="category-tree">';
                if ($only_parent == false) {
                    foreach ($cat[$parent_id] as $cat_row) {
                        $tree .= '<li id="' . $cat_row['id'] . '">'.$cat_row['name'].' |'.$cat_row['desc'];  //li -> will have a id as category id in database
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
}
