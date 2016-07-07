<?php

namespace App\Http\Controllers\manager;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\User;
use App\model\DB\Script;
use Illuminate\Support\Facades\App;

class ManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $manager = User::where('id', Auth::user()->id)->first();

        $manager_task = DB::table('users')
            ->join('scripts', 'users.parent_id', '=', 'scripts.users_id')
            ->select('scripts.id','scripts.parent_id','scripts.name','scripts.desc')
            ->where ('users.id', '=' , Auth::user()->id)
            ->get();
        /*
        $manager_task = json_decode(json_encode($manager_task), true); //object convert to array

        //builde category tree
        $cat = array();
        //В цикле формируем массив разделов, ключом будет id родительской категории, а также массив разделов, ключом будет id категории
        //$data['parent_categories'] all goods category
        foreach ( $manager_task as $row) {
            // $cat_ID[$row['id']][] = $row; need if need function 'find_parent'
            $cat[$row['parent_id']][$row['id']] = $row;
        }

        $manager_task_tree =  $this->build_tree($cat, 0); //SEND category tree to view
        */
        
        return view ('manager.index',['manager_task' => $manager_task/*$manager_task_tree*/,'manager' => $manager]);
    }

    /**
     * @param $cat
     * @param $parent_id
     * @param bool $only_parent
     * @return null|string
     */
    private function build_tree($cat, $parent_id, $only_parent = false){ //create block tree and return build tree
        $tree = '<div class="child">';
        if (is_array($cat) and isset($cat[$parent_id])) {
            $tree .= '<ul style="list-style: none" class="dropdown">';
            if ($only_parent == false) {
                foreach ($cat[$parent_id] as $cat_row) {
                    if(mb_strlen($cat_row['desc']) > 15) { //if description > 15 character in length
                        $tree .= '<li id="' . $cat_row['id'] . '"><div  class="col-xs-12 block_body"><div class="col-xs-12 block_title">' . $cat_row['name'] . '</div> <div><span id="m-desc-res-'.$cat_row['id'].'" class="glyphicon glyphicon-zoom-in b-s-b" data-m_desc="'.$cat_row['desc'].'" onclick="show_script_m('.$cat_row['id'].')"></span><a class="manager_home" href="'.App::make('url')->to('/').'/manager/account'.'">на главную</a></div></div>';  //li -> will have a id as category id in database
                    } else {                               //if description < 15 character in length
                        $tree .= '<li id="' . $cat_row['id'] . '"><div  class="col-xs-12 block_body"><div class="col-xs-12 block_title">' . $cat_row['name'] . '</div> <div><span id="m-desc-res-'.$cat_row['id'].'" class="glyphicon glyphicon-zoom-in b-s-b" data-m_desc="'.$cat_row['desc'].'" onclick="show_script_m('.$cat_row['id'].')"></span><a class="manager_home" href="'.App::make('url')->to('/').'/manager/account'.'">на главную</a></div></div>';  //li -> will have a id as category id in database
                    }
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
