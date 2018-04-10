<?php

namespace App\Http\Controllers;
use Illuminate\Database\DatabaseManager;
use App\Http\Requests;
use Illuminate\Http\Request;
use Helpers;
use Input;
use Auth;
use DB;
use Config;
use Redirect;
use Session;
class FinanceAddDetailControler extends Controller
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
   
   	public function addAccountDetail(){
		Helpers::companyDatabaseConnection($_GET['m']);
		$parent_code = Input::get('account_id');
		$acc_name = Input::get('acc_name');
		$o_blnc = Input::get('o_blnc');
		$o_blnc_trans = Input::get('o_blnc_trans');
		$operational = Input::get('operational');
		$sent_code = $parent_code;
		$max_id = DB::selectOne('SELECT max(`id`) as id  FROM `accounts` WHERE `parent_code` LIKE \''.$parent_code.'\'')->id;
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
        $data1['name'] = $acc_name;
        $data1['parent_code'] = $parent_code;
        $data1['username'] 		 	= Auth::user()->name;
        $data1['branch_id'] 		 	= '';
        $data1['date']     		  = date("Y-m-d");
        $data1['time']     		  = date("H:i:s");
        $data1['action']     		  = 'create';
        $data1['operational']		= $operational;
		
		
		$acc_id = DB::table('accounts')->insertGetId($data1);
		
		
		//$acc_id = $data1->id;

		$data2['acc_id'] =	$acc_id;
        $data2['acc_code']=	$code;
        $data2['debit_credit']=	$o_blnc_trans;
		$data2['amount'] 	  = 	$o_blnc;
        $data2['opening_bal'] 	  = 	1;
       	$data2['username'] 		 	= Auth::user()->name;
        $data2['branch_id'] 		 	= '';
        $data2['date']     		  = date("Y-m-d");
        $data2['v_date']     		= date("Y-m-d");
        $data2['time']     		  = date("H:i:s");
        $data2['action']     		  = 'create';
		DB::table('transactions')->insert($data2);
		
		Helpers::reconnectMasterDatabase();
		return Redirect::to('finance/viewChartofAccountList?pageType='.Input::get('pageType').'&&parentCode='.Input::get('parentCode').'&&m='.$_GET['m'].'#SFR');
   	}
	
	function addCashPaymentVoucherDetail(){
		Helpers::companyDatabaseConnection($_GET['m']);
		
		$pvsSection = Input::get('pvsSection');
		foreach($pvsSection as $row){
			$str = DB::selectOne("select max(convert(substr(`pv_no`,4,length(substr(`pv_no`,4))-4),signed integer)) reg from `pvs` where substr(`pv_no`,-4,2) = ".date('m')." and substr(`pv_no`,-2,2) = ".date('y')."")->reg;
			$pv_no = 'cpv'.($str+1).date('my');
			$slip_no = Input::get('slip_no_'.$row);
			$pv_date = Input::get('pv_date_'.$row);
			$description = Input::get('description_'.$row);
			
			$data1['pv_date']   	= $pv_date;
			$data1['pv_no']   		= $pv_no;
			$data1['slip_no']   	= $slip_no;
			$data1['voucherType'] 	= 1;
			$data1['description']   = $description;
        	$data1['pv_status']  	= 1;
        	$data1['username'] 		= Auth::user()->name;
        	$data1['date'] 			= date('Y-m-d');
        	$data1['time'] 			= date('H:i:s');
        	DB::table('pvs')->insert($data1);
			$pvsDataSection = Input::get('pvsDataSection_'.$row);
			foreach($pvsDataSection as $row1){
				$d_amount =  Input::get('d_amount_'.$row.'_'.$row1.'');
                $c_amount =  Input::get('c_amount_'.$row.'_'.$row1.'');
				$account  =  Input::get('account_id_'.$row.'_'.$row1.'');
				if($d_amount !=""){
					$data2['debit_credit'] = 1;
                    $data2['amount'] = $d_amount;
				}else if($c_amount !=""){
					$data2['debit_credit'] = 0;
                    $data2['amount'] = $c_amount;
				}
				
				$data2['pv_no']   		= $pv_no;
				$data2['pv_date']   	= $pv_date;
				$data2['acc_id'] 		= $account;
				$data2['description']   = $description;
        		$data2['pv_status']   	= 1;
        		$data2['username'] 		= Auth::user()->name;
        		$data2['status']  		= 1;
        		$data2['date'] 			= date('Y-m-d');
        		$data2['time'] 			= date('H:i:s');
			
				DB::table('pv_data')->insert($data2);
			}
		}
		Helpers::reconnectMasterDatabase();
		Session::flash('dataInsert','successfully saved.');
		return Redirect::to('finance/viewCashPaymentVoucherList?pageType='.Input::get('pageType').'&&parentCode='.Input::get('parentCode').'&&m='.$_GET['m'].'#SFR');
	}

	function addBankPaymentVoucherDetail(){
		Helpers::companyDatabaseConnection($_GET['m']);
		
		$pvsSection = Input::get('pvsSection');
		foreach($pvsSection as $row){
			$str = DB::selectOne("select max(convert(substr(`pv_no`,4,length(substr(`pv_no`,4))-4),signed integer)) reg from `pvs` where substr(`pv_no`,-4,2) = ".date('m')." and substr(`pv_no`,-2,2) = ".date('y')."")->reg;
			$pv_no = 'bpv'.($str+1).date('my');
			$slip_no = Input::get('slip_no_'.$row);
			$pv_date = Input::get('pv_date_'.$row);
			$cheque_no = Input::get('cheque_no_'.$row);
			$cheque_date = Input::get('cheque_date_'.$row);
			$description = Input::get('description_'.$row);
			
			$data1['pv_date']   	= $pv_date;
			$data1['pv_no']   		= $pv_no;
			$data1['slip_no']   	= $slip_no;
			$data1['cheque_no']   		= $cheque_no;
			$data1['cheque_date']   	= $cheque_date;
			$data1['voucherType'] 	= 2;
			$data1['description']   = $description;
        	$data1['username'] 		= Auth::user()->name;
			$data1['pv_status']  	= 1;
        	$data1['date'] 			= date('Y-m-d');
        	$data1['time'] 			= date('H:i:s');
        	DB::table('pvs')->insert($data1);
			$pvsDataSection = Input::get('pvsDataSection_'.$row);
			foreach($pvsDataSection as $row1){
				$d_amount =  Input::get('d_amount_'.$row.'_'.$row1.'');
                $c_amount =  Input::get('c_amount_'.$row.'_'.$row1.'');
				$account  =  Input::get('account_id_'.$row.'_'.$row1.'');
				if($d_amount !=""){
					$data2['debit_credit'] = 1;
                    $data2['amount'] = $d_amount;
				}else if($c_amount !=""){
					$data2['debit_credit'] = 0;
                    $data2['amount'] = $c_amount;
				}
				
				$data2['pv_no']   		= $pv_no;
				$data2['pv_date']   	= $pv_date;
				$data2['acc_id'] 		= $account;
				$data2['description']   = $description;
        		$data2['pv_status']   	= 1;
        		$data2['username'] 		= Auth::user()->name;
				$data2['status']  		= 1;
        		$data2['date'] 			= date('Y-m-d');
        		$data2['time'] 			= date('H:i:s');
			
				DB::table('pv_data')->insert($data2);
			}
		}
		Helpers::reconnectMasterDatabase();
		Session::flash('dataInsert','successfully saved.');
		return Redirect::to('finance/viewBankPaymentVoucherList?pageType='.Input::get('pageType').'&&parentCode='.Input::get('parentCode').'&&m='.$_GET['m'].'#SFR');
	}
	
	function addCashReceiptVoucherDetail(){
		Helpers::companyDatabaseConnection($_GET['m']);
		
		$rvsSection = Input::get('rvsSection');
		foreach($rvsSection as $row){
			$str = DB::selectOne("select max(convert(substr(`rv_no`,4,length(substr(`rv_no`,4))-4),signed integer)) reg from `rvs` where substr(`rv_no`,-4,2) = ".date('m')." and substr(`rv_no`,-2,2) = ".date('y')."")->reg;
			$rv_no = 'crv'.($str+1).date('my');
			$slip_no = Input::get('slip_no_'.$row);
			$rv_date = Input::get('rv_date_'.$row);
			$description = Input::get('description_'.$row);
			
			$data1['rv_date']   	= $rv_date;
			$data1['rv_no']   		= $rv_no;
			$data1['slip_no']   	= $slip_no;
			$data1['voucherType'] 	= 1;
			$data1['description']   = $description;
        	$data1['rv_status']  	= 1;
        	$data1['username'] 		= Auth::user()->name;
        	$data1['date'] 			= date('Y-m-d');
        	$data1['time'] 			= date('H:i:s');
        	DB::table('rvs')->insert($data1);
			$rvsDataSection = Input::get('rvsDataSection_'.$row);
			foreach($rvsDataSection as $row1){
				$d_amount =  Input::get('d_amount_'.$row.'_'.$row1.'');
                $c_amount =  Input::get('c_amount_'.$row.'_'.$row1.'');
				$account  =  Input::get('account_id_'.$row.'_'.$row1.'');
				if($d_amount !=""){
					$data2['debit_credit'] = 1;
                    $data2['amount'] = $d_amount;
				}else if($c_amount !=""){
					$data2['debit_credit'] = 0;
                    $data2['amount'] = $c_amount;
				}
				
				$data2['rv_no']   		= $rv_no;
				$data2['rv_date']   	= $rv_date;
				$data2['acc_id'] 		= $account;
				$data2['description']   = $description;
        		$data2['rv_status']   	= 1;
				$data2['status']  		= 1;
        		$data2['username'] 		= Auth::user()->name;
        		$data2['date'] 			= date('Y-m-d');
        		$data2['time'] 			= date('H:i:s');
			
				DB::table('rv_data')->insert($data2);
			}
		}
		Helpers::reconnectMasterDatabase();
		Session::flash('dataInsert','successfully saved.');
		return Redirect::to('finance/viewCashReceiptVoucherList?pageType='.Input::get('pageType').'&&parentCode='.Input::get('parentCode').'&&m='.$_GET['m'].'#SFR');
	}
	
	
	function addBankReceiptVoucherDetail(){
		Helpers::companyDatabaseConnection($_GET['m']);
		
		$rvsSection = Input::get('rvsSection');
		foreach($rvsSection as $row){
			$str = DB::selectOne("select max(convert(substr(`rv_no`,4,length(substr(`rv_no`,4))-4),signed integer)) reg from `rvs` where substr(`rv_no`,-4,2) = ".date('m')." and substr(`rv_no`,-2,2) = ".date('y')."")->reg;
			$rv_no = 'brv'.($str+1).date('my');
			$slip_no = Input::get('slip_no_'.$row);
			$rv_date = Input::get('rv_date_'.$row);
			$cheque_no = Input::get('cheque_no_'.$row);
			$cheque_date = Input::get('cheque_date_'.$row);
			$description = Input::get('description_'.$row);
			
			$data1['rv_date']   	= $rv_date;
			$data1['rv_no']   		= $rv_no;
			$data1['slip_no']   	= $slip_no;
			$data1['cheque_no']   		= $cheque_no;
			$data1['cheque_date']   	= $cheque_date;
			$data1['voucherType'] 	= 2;
			$data1['description']   = $description;
        	$data1['rv_status']  	= 1;
        	$data1['username'] 		= Auth::user()->name;
        	$data1['date'] 			= date('Y-m-d');
        	$data1['time'] 			= date('H:i:s');
        	DB::table('rvs')->insert($data1);
			$rvsDataSection = Input::get('rvsDataSection_'.$row);
			foreach($rvsDataSection as $row1){
				$d_amount =  Input::get('d_amount_'.$row.'_'.$row1.'');
                $c_amount =  Input::get('c_amount_'.$row.'_'.$row1.'');
				$account  =  Input::get('account_id_'.$row.'_'.$row1.'');
				if($d_amount !=""){
					$data2['debit_credit'] = 1;
                    $data2['amount'] = $d_amount;
				}else if($c_amount !=""){
					$data2['debit_credit'] = 0;
                    $data2['amount'] = $c_amount;
				}
				
				$data2['rv_no']   		= $rv_no;
				$data2['rv_date']   	= $rv_date;
				$data2['acc_id'] 		= $account;
				$data2['description']   = $description;
        		$data2['rv_status']   	= 1;
        		$data2['status']  		= 1;
        		$data2['username'] 		= Auth::user()->name;
        		$data2['date'] 			= date('Y-m-d');
        		$data2['time'] 			= date('H:i:s');
			
				DB::table('rv_data')->insert($data2);
			}
		}
		Helpers::reconnectMasterDatabase();
		Session::flash('dataInsert','successfully saved.');
		return Redirect::to('finance/viewBankReceiptVoucherList?pageType='.Input::get('pageType').'&&parentCode='.Input::get('parentCode').'&&m='.$_GET['m'].'#SFR');
	}
}
