<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Job;

class NormalUsersController extends Controller
{
    


	public function index(){
        return view('auth.visitorDashboard');
    }

    public function nuViewJobsList(){
    	$jobs = new Job;
		$jobs = $jobs::orderBy('id')->get();
        return view('auth.viewJobsListForUsers',compact('jobs'));
    }

    public function ViewandApplyDetail(){
    	echo '<br />'.$_GET['id'];
        echo '<br />'.$_GET['m'];
        return '<br />'.'Make Here View and Apply Job Section';
    }
}
