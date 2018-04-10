<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use DB;
use Config;
use App\Models\Account;
use App\Models\Countries;
class SalesController extends Controller
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
    public function toDayActivity()
    {
        return view('Sales.toDayActivity');
    }
	
	public function cashCustomerAddNView()
	{
		$countries = new Countries;
		$countries = $countries::where('status', '=', 1)->get();
		Config::set(['database.connections.tenant.database' => Auth::user()->dbName]);
		Config::set(['database.connections.tenant.username' => 'root']);
		Config::set('database.default', 'tenant');
		DB::reconnect('tenant');
		$accounts = new Account;
		$accounts = $accounts::orderBy('level1', 'ASC')
    				->orderBy('level2', 'ASC')
					->orderBy('level3', 'ASC')
					->orderBy('level4', 'ASC')
					->orderBy('level5', 'ASC')
					->orderBy('level6', 'ASC')
					->orderBy('level7', 'ASC')
					->where('name','=','Cash Customers')
    				->get();
		return view('Sales.cashCustomerAddNView',compact('accounts','countries'));
	}
	
	public function creditCustomerAddNView()
	{
		$countries = new Countries;
		$countries = $countries::where('status', '=', 1)->get();
		Config::set(['database.connections.tenant.database' => Auth::user()->dbName]);
		Config::set(['database.connections.tenant.username' => 'root']);
		Config::set('database.default', 'tenant');
		DB::reconnect('tenant');
		$accounts = new Account;
		$accounts = $accounts::orderBy('level1', 'ASC')
    				->orderBy('level2', 'ASC')
					->orderBy('level3', 'ASC')
					->orderBy('level4', 'ASC')
					->orderBy('level5', 'ASC')
					->orderBy('level6', 'ASC')
					->orderBy('level7', 'ASC')
					->where('name','=','Credit Customers')
    				->get();
		return view('Sales.creditCustomerAddNView',compact('accounts','countries'));
	}
}
