<?php

namespace App\Http\Controllers;
use Illuminate\Database\DatabaseManager;
use App\Http\Requests;
use Illuminate\Http\Request;
use Input;
use Auth;
use DB;
use Config;
use Redirect;
class SalesAddDetailControler extends Controller
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
   
   	public function addCashCustomerDetail(){
		Config::set(['database.connections.tenant.database' => Auth::user()->dbName]);
		Config::set(['database.connections.tenant.username' => 'root']);
		Config::set('database.default', 'tenant');
		DB::reconnect('tenant');
		
		$account_head = Input::get('account_head');
		$customer_name = Input::get('customer_name');
		$country = Input::get('country');
		$state = Input::get('state');
		$city = Input::get('city');
		$contact_no = Input::get('contact_no');
		$email = Input::get('email');
		$o_blnc_trans = Input::get('o_blnc_trans');
		$o_blnc = Input::get('o_blnc');
		$operational = '1';
		$customer_type = '2';
		$sent_code = $account_head;
		
		$max_id = DB::selectOne('SELECT max(`id`) as id  FROM `accounts` WHERE `parent_code` LIKE \''.$account_head.'\'')->id;
		if($max_id == ''){
        	$code = $sent_code.'-1';
		}else{
			$max_code2 = DB::selectOne('SELECT `code`  FROM `accounts` WHERE `id` LIKE \''.$max_id.'\'')->code;
			$max_code2;
			$max = explode('-',$max_code2);
        	$code = $sent_code.'-'.(end($max)+1);
		}
			
        $level_array = explode('-',$code);
        $counter = 1;
        foreach($level_array as $level):
        	$data1['level'.$counter] = $level;
            $counter++;
       	endforeach;
       	$data1['code'] = $code;
        $data1['name'] = $customer_name;
        $data1['parent_code'] = $account_head;
        $data1['username'] 		 	= '';
        $data1['branch_id'] 		 	= '';
        $data1['date']     		  = date("Y-m-d");
        $data1['time']     		  = date("H:i:s");
        $data1['action']     		  = 'create';
        $data1['operational']		= $operational;
		
		
		$acc_id = DB::table('accounts')->insertGetId($data1);
		
		
		$data2['acc_id']		     = $acc_id;
		$data2['name']     		   = $customer_name;
		$data2['country']     		= $country;
		$data2['province']     	   = $state;
		$data2['city']     	       = $city;
		$data2['contact']   		    = $contact_no;									
		$data2['email']   		      = $email;												
		$data2['username']	 	   = '';
		$data2['branch_id']      	  = '';
		$data2['date']     		   = date("Y-m-d");
		$data2['time']     		   = date("H:i:s");			
		$data2['action']     		 = 'create';
		$data2['customer_type']     = $customer_type;
		
		DB::table('customers')->insert($data2);
		
		$data3['acc_id'] =	$acc_id;
        $data3['acc_code']=	$code;
        $data3['debit_credit']=	$o_blnc_trans;
		$data3['amount'] 	  = 	$o_blnc;
        $data3['opening_bal'] 	  = 	1;
       	$data3['username'] 		 	= '';
        $data3['branch_id'] 		 	= '';
        $data3['date']     		  = date("Y-m-d");
        $data3['v_date']     		= date("Y-m-d");
        $data3['time']     		  = date("H:i:s");
        $data3['action']     		  = 'create';
		DB::table('transactions')->insert($data3);
		
		Config::set('database.default', 'mysql');
		DB::reconnect('mysql');
		return Redirect::to('sales/cashCustomerAddNView');
   	}
	
	
	public function addCreditCustomerDetail(){
		Config::set(['database.connections.tenant.database' => Auth::user()->dbName]);
		Config::set(['database.connections.tenant.username' => 'root']);
		Config::set('database.default', 'tenant');
		DB::reconnect('tenant');
		
		$account_head = Input::get('account_head');
		$customer_name = Input::get('customer_name');
		$country = Input::get('country');
		$state = Input::get('state');
		$city = Input::get('city');
		$contact_no = Input::get('contact_no');
		$email = Input::get('email');
		$o_blnc_trans = Input::get('o_blnc_trans');
		$o_blnc = Input::get('o_blnc');
		$operational = '1';
		$customer_type = '3';
		$sent_code = $account_head;
		
		$max_id = DB::selectOne('SELECT max(`id`) as id  FROM `accounts` WHERE `parent_code` LIKE \''.$account_head.'\'')->id;
		if($max_id == ''){
        	$code = $sent_code.'-1';
		}else{
			$max_code2 = DB::selectOne('SELECT `code`  FROM `accounts` WHERE `id` LIKE \''.$max_id.'\'')->code;
			$max_code2;
			$max = explode('-',$max_code2);
        	$code = $sent_code.'-'.(end($max)+1);
		}
			
        $level_array = explode('-',$code);
        $counter = 1;
        foreach($level_array as $level):
        	$data1['level'.$counter] = $level;
            $counter++;
       	endforeach;
       	$data1['code'] = $code;
        $data1['name'] = $customer_name;
        $data1['parent_code'] = $account_head;
        $data1['username'] 		 	= '';
        $data1['branch_id'] 		 	= '';
        $data1['date']     		  = date("Y-m-d");
        $data1['time']     		  = date("H:i:s");
        $data1['action']     		  = 'create';
        $data1['operational']		= $operational;
		
		
		$acc_id = DB::table('accounts')->insertGetId($data1);
		
		
		$data2['acc_id']		     = $acc_id;
		$data2['name']     		   = $customer_name;
		$data2['country']     		= $country;
		$data2['province']     	   = $state;
		$data2['city']     	       = $city;
		$data2['contact']   		    = $contact_no;									
		$data2['email']   		      = $email;												
		$data2['username']	 	   = '';
		$data2['branch_id']      	  = '';
		$data2['date']     		   = date("Y-m-d");
		$data2['time']     		   = date("H:i:s");			
		$data2['action']     		 = 'create';
		$data2['customer_type']     = $customer_type;
		
		DB::table('customers')->insert($data2);
		
		$data3['acc_id'] =	$acc_id;
        $data3['acc_code']=	$code;
        $data3['debit_credit']=	$o_blnc_trans;
		$data3['amount'] 	  = 	$o_blnc;
        $data3['opening_bal'] 	  = 	1;
       	$data3['username'] 		 	= '';
        $data3['branch_id'] 		 	= '';
        $data3['date']     		  = date("Y-m-d");
        $data3['v_date']     		= date("Y-m-d");
        $data3['time']     		  = date("H:i:s");
        $data3['action']     		  = 'create';
		DB::table('transactions')->insert($data3);
		
		Config::set('database.default', 'mysql');
		DB::reconnect('mysql');
		return Redirect::to('sales/creditCustomerAddNView');
   	}
}
