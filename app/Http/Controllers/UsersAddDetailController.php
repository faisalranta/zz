<?php

namespace App\Http\Controllers;
use Illuminate\Database\DatabaseManager;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\MainMenuTitle;
use Input;
use Auth;
use DB;
use Config;
use Redirect;
class UsersAddDetailController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
    	$this->middleware('auth');
	}

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
   	public function addMainMenuTitleDetail(){
		$main_menu_id = Input::get('main_menu_name');
		$title = Input::get('title_name');
		$title_id = preg_replace('/\s+/', '', $title);
		
		$data1['main_menu_id'] =	$main_menu_id;
		$data1['title'] = $title;
		$data1['title_id'] = $title_id;
        $data1['date']     		  = date("Y-m-d");
        DB::table('main_menu_title')->insert($data1);
	}
	
	public function addSubMenuDetail(){
		
		$main_navigation_name = Input::get('main_navigation_name');
		$explodeMainNavigation = explode('_',$main_navigation_name);
		$subNavigationTitleName = Input::get('sub_navigation_title_name');
		$subNavigationUrl = Input::get('sub_navigation_url');
		$mainNavigationName = $explodeMainNavigation[0];
		$mainNavigationTitleId = $explodeMainNavigation[1];
		
		$max_id = DB::selectOne('SELECT max(`id`) as id  FROM `menu` WHERE `m_parent_code` = '.$mainNavigationName.'')->id;
		
		if($max_id == ''){
        	$code = $mainNavigationName.'-1';
		}else{
			$max_code2 = DB::selectOne('SELECT `m_code` FROM `menu` WHERE `m_parent_code` = '.$explodeMainNavigation[0].'')->m_code;
			$max_code2;
			$max_code2;
			$max = explode('-',$max_code2);
        	$code = $mainNavigationName.'-'.(end($max)+1);
		}
		$data1['m_code'] =	$code;
		$data1['m_parent_code'] = $explodeMainNavigation[0];
		$data1['m_type'] = '';
        $data1['m_main_title']     		  = $explodeMainNavigation[1];
		$data1['name'] = $subNavigationTitleName;
		$data1['m_controller_name'] = $subNavigationUrl;
        $data1['date']     		  = date("Y-m-d");
        DB::table('menu')->insert($data1);
	}
	
	function addRoleDetail(){
		$role_name = Input::get('role_name');
		$role_description = Input::get('role_description');
		$hr_control	= Input::get('ChartOfAccount_checkbox');
		$MainMenuTitles = new MainMenuTitle;
		$MainMenuTitles = $MainMenuTitles->groupBy('main_menu_id')->get();
		$str = DB::selectOne("select max(convert(substr(`role_no`,4,length(substr(`role_no`,4))-4),signed integer)) reg from `roles` where substr(`role_no`,-4,2) = ".date('m')." and substr(`role_no`,-2,2) = ".date('y')."")->reg;
		$role_no = 'rps'.($str+1).date('my');
		$data1['role_no'] = $role_no;
		$data1['name'] = $role_name;
		$data1['description'] = $role_description;
		DB::table('roles')->insert($data1);
		foreach($MainMenuTitles as $row1){
			$MainMenuTitlesSub = new MainMenuTitle;
			$MainMenuTitlesSub = $MainMenuTitlesSub->where('main_menu_id','=',$row1->main_menu_id)->get();
			foreach($MainMenuTitlesSub as $row2){
				$labelControlDetail	= Input::get(''.$row2->title_id.'_checkbox');
				if(!empty($labelControlDetail)){
					$role_no;
					$row2->title;
					$lableNameId = Input::get(''.$row2->title_id.'_checkbox_id');
					$data2['role_no'] = $role_no;
					$data2['menu_id'] = $lableNameId;
					foreach($labelControlDetail as $row3 => $y){
						$data2['right_'.strtolower($y).''] = 1;
					}
					DB::table('role_detail')->insert($data2);
					unset($data2);
				}
			}
		}
		return Redirect::to('users/createRoleForm');
	}
}
