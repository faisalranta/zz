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
class PurchaseAddDetailControler extends Controller
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
   
   	public function addSupplierDetail(){
		Config::set(['database.connections.tenant.database' => Auth::user()->dbName]);
		Config::set(['database.connections.tenant.username' => 'root']);
		Config::set('database.default', 'tenant');
		DB::reconnect('tenant');
		
		$account_head = Input::get('account_head');
		$supplier_name = Input::get('supplier_name');
		$country = Input::get('country');
		$state = Input::get('state');
		$city = Input::get('city');
		$contact_no = Input::get('contact_no');
		$email = Input::get('email');
		$o_blnc_trans = Input::get('o_blnc_trans');
		$o_blnc = Input::get('o_blnc');
		$operational = '1';
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
        $data1['name'] = $supplier_name;
        $data1['parent_code'] = $account_head;
        $data1['username'] 		 	= '';
        $data1['branch_id'] 		 	= '';
        $data1['date']     		  = date("Y-m-d");
        $data1['time']     		  = date("H:i:s");
        $data1['action']     		  = 'create';
        $data1['operational']		= $operational;
		
		
		$acc_id = DB::table('accounts')->insertGetId($data1);
		
		
		$data2['acc_id']		     = $acc_id;
		$data2['name']     		   = $supplier_name;
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
		
		DB::table('supplier')->insert($data2);
		
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
		return Redirect::to('purchase/supplierAddNView');
   	}
	
	public function addCategoryDetail(){
		Config::set(['database.connections.tenant.database' => Auth::user()->dbName]);
		Config::set(['database.connections.tenant.username' => 'root']);
		Config::set('database.default', 'tenant');
		DB::reconnect('tenant');
		
		$account_head = Input::get('account_head');
		$category_name = Input::get('category_name');
		$wip_finish_g_form = 'fara';
		$branch_id = '';
		$username = '';
		$o_blnc_trans = 1;
		$o_blnc = 0;
		if($wip_finish_g_form == 'wip'){
			$tran_type = '1';
		}else if($wip_finish_g_form == 'finished_goods'){
			$tran_type = '2';
		}else if($wip_finish_g_form == 'fara'){
			$tran_type = '3';
		}
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
        $data1['name'] = $category_name;
        $data1['parent_code'] = $account_head;
        $data1['username'] 		 	= '';
        $data1['branch_id'] 		 	= '';
        $data1['date']     		  = date("Y-m-d");
        $data1['time']     		  = date("H:i:s");
        $data1['action']     		  = 'create';
        $data1['operational']		= 1;
		
		
		$acc_id = DB::table('accounts')->insertGetId($data1);
		
		$data2['main_ic']    	   = $category_name;
		$data2['acc_id']			= $acc_id;
		$data2['type']			  = 2;
		$data2['username']     	  = '';
		$data2['branch_id']     	 = '';
		$data2['date']     		  = date("Y-m-d");
		$data2['time']     		  = date("H:i:s");
		$data2['action']     		= 'create';
		$data2['tran_type']		= $tran_type;
		
		$m_id = DB::table('category')->insertGetId($data2);
		
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
		
		$data4['main_ic_id']     = $m_id;
		$data4['value'] 	      = 0;
		$data4['qty']     		= 0;
		$data4['date']     	   = date("Y-m-d");
		$data4['time']     	   = date("H:i:s");
		$data4['action']     	 = '1';//1 for opening
		$data4['username'] 	   = '';
		$data4['date']     	   = date("Y-m-d");
		$data4['time']     	   = date("H:i:s");
		$data4['branch_id'] 	  = '';
		DB::table('fara')->insert($data4);
		
		Config::set('database.default', 'mysql');
		DB::reconnect('mysql');
		return Redirect::to('purchase/categoryAddNView');
	}
	
	public function addSubItemDetail(){
		
		Config::set(['database.connections.tenant.database' => Auth::user()->dbName]);
		Config::set(['database.connections.tenant.username' => 'root']);
		Config::set('database.default', 'tenant');
		DB::reconnect('tenant');
		
		$category_name = Input::get('category_name');
		$sub_item_name = Input::get('sub_item_name');
		$opening_qty = Input::get('opening_qty');
		$username = '';
		$branch_id = '';
		$o_blnc_trans_form 		= 	1;
		$wip_finish_g_form = 'fara';
		$acc_id = DB::selectOne('select `acc_id` from `category` where `id` = '.$category_name.'')->acc_id;
		$parent_code = DB::selectOne('select code from `accounts` where `id` = '.$acc_id.'')->code;
		$max_id = DB::selectOne('SELECT max(`id`) as id  FROM `accounts` WHERE `parent_code` LIKE \''.$parent_code.'\'')->id;
		if($max_id == ''){
        	$code = $parent_code.'-1';
		}else{
			$max_code2 = DB::selectOne('SELECT `code`  FROM `accounts` WHERE `id` LIKE \''.$max_id.'\'')->code;
			$max_code2;
			$max = explode('-',$max_code2);
        	$code = $parent_code.'-'.(end($max)+1);
		}
		$level_array = explode('-',$code);
        $counter = 1;
        foreach($level_array as $level):
        	$data1['level'.$counter] = $level;
            $counter++;
       	endforeach;
		
		$data1['code'] = $code;
        $data1['name'] = $sub_item_name;
        $data1['parent_code'] = $parent_code;
        $data1['username'] 		 	= '';
        $data1['branch_id'] 		 	= '';
        $data1['date']     		  = date("Y-m-d");
        $data1['time']     		  = date("H:i:s");
        $data1['action']     		  = 'create';
        $data1['operational']		= 1;
		
		
		$acc_id_new = DB::table('accounts')->insertGetId($data1);
		
		$data2['acc_id']			= $acc_id_new;
		$data2['sub_ic']     		= $sub_item_name;
		$data2['main_ic_id']     	= $category_name;
		$data2['username']	 	  = $username;
		$data2['branch_id']         = $branch_id;
		$data2['date']     		  = date("Y-m-d");
		$data2['time']     		  = date("H:i:s");
		$data2['action']     		= 'create';
		
		$s_id = DB::table('subitem')->insertGetId($data2);
		
		$data3['acc_code']		  = $code;
		$data3['acc_id']		  = $acc_id_new;
		$data3['debit_credit']	=	1;
		$data3['opening_bal']	=	1;
		$data3['username'] 		= $username;
		$data3['branch_id'] 	   = $branch_id;
		$data3['v_date']     		= date("Y-m-d");
		$data3['date']     		= date("Y-m-d");
		$data3['time']     		= date("H:i:s");
		$data3['action']     	  = 'create';
		$data3['status']			=1;
		$data3['amount']		= '';
		DB::table('transactions')->insert($data3);
		
		$data4['main_ic_id']     = $category_name;
		$data4['sub_ic_id']     = $s_id;
		$data4['value'] 	      = 0;
		$data4['qty']     		= $opening_qty;
		$data4['date']     	   = date("Y-m-d");
		$data4['time']     	   = date("H:i:s");
		$data4['action']     	 = '1';//1 for opening
		$data4['username'] 	   = '';
		$data4['date']     	   = date("Y-m-d");
		$data4['time']     	   = date("H:i:s");
		$data4['branch_id'] 	  = '';
		DB::table('fara')->insert($data4);
		
		Config::set('database.default', 'mysql');
		DB::reconnect('mysql');
		return Redirect::to('purchase/subItemAddNView');
	}
}
