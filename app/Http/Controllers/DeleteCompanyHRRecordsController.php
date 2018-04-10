<?php

namespace App\Http\Controllers;
//namespace App\Http\Controllers\Auth
//use Auth;
//use App\User;
use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
use Config;
use Redirect;
use Session;

class DeleteCompanyHRRecordsController extends Controller
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
    public function deleteRowCompanyHRRecords()
    {
		$companyId = $_GET['companyId'];
        $d = DB::selectOne('select `dbName` from `company` where `id` = '.$companyId.'')->dbName;
        Config::set(['database.connections.tenant.database' => $d]);
        Config::set(['database.connections.tenant.username' => 'root']);
        Config::set('database.default', 'tenant');
        DB::reconnect('tenant');
        
        $recordId = $_GET['recordId'];
        $tableName = $_GET['tableName'];
        DB::update('update '.$tableName.' set status = ? where id = ?',['2',$recordId]);
        Session::flash('dataDelete','successfully delete.');
    }
}
