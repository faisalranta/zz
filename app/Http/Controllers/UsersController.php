<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\MainMenuTitle;
use Input;
use Auth;
use DB;
use Config;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
   
   	public function toDayActivity(){
		return view('Users.toDayActivity');
   	}
	
	public function createUsersForm(){
		return view('Users.createUsersForm');
	}
	
	public function createMainMenuTitleForm(){
		return view('Users.createMainMenuTitleForm');
	}
	
	public function createSubMenuForm(){
		$MainMenuTitles = new MainMenuTitle;
		$MainMenuTitles = $MainMenuTitles::where('status', '=', '1')->get();
		return view('Users.createSubMenuForm',compact('MainMenuTitles'));
	}
	
	public function createRoleForm(){
		return view('Users.createRoleForm');
	}
	
	public function viewRoleList(){
		return view('Users.viewRoleList');
	}
}
