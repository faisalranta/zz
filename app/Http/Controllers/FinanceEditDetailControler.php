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
class FinanceEditDetailControler extends Controller
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
   	function muzzamil(){
   		return 'Kese ho Kia howa';
   	}
   	function editCashPaymentPendingVoucherDetail(){
		Helpers::companyDatabaseConnection($_GET['m']);
		
		$pv_no = Input::get('pv_no');

		DB::table('pvs')->where('pv_no', $pv_no)->delete();
		DB::table('pv_data')->where('pv_no', $pv_no)->delete();	


		
		$slip_no = Input::get('slip_no');
		$pv_date = Input::get('pv_date');
		$description = Input::get('description');
		
		$data1['pv_date']   	= $pv_date;
		$data1['pv_no']   		= $pv_no;
		$data1['slip_no']   	= $slip_no;
		$data1['voucherType'] 	= 1;
		$data1['description']   = $description;
        $data1['username'] 		= Auth::user()->name;
        $data1['pv_status']  	= 1;
        $data1['date'] 			= date('Y-m-d');
        $data1['time'] 			= date('H:i:s');

        DB::table('pvs')->insert($data1);
		
        $pvsDataSection = Input::get('pvsDataSection_1');
		foreach($pvsDataSection as $row1){
			$d_amount =  Input::get('d_amount_1_'.$row1.'');
            $c_amount =  Input::get('c_amount_1_'.$row1.'');
			$account  =  Input::get('account_id_1_'.$row1.'');
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
		echo 'Done';
		Helpers::reconnectMasterDatabase();
		Session::flash('dataEdit','successfully edit.');
	}

	function editCashPaymentApproveVoucherDetail(){
		Helpers::companyDatabaseConnection($_GET['m']);
		
		$pv_no = Input::get('pv_no');

		DB::table('pvs')->where('pv_no', $pv_no)->delete();
		DB::table('pv_data')->where('pv_no', $pv_no)->delete();	
		DB::table('transactions')->where('voucher_no', $pv_no)->delete();


		
		$slip_no = Input::get('slip_no');
		$pv_date = Input::get('pv_date');
		$description = Input::get('description');
		
		$data1['pv_date']   	= $pv_date;
		$data1['pv_no']   		= $pv_no;
		$data1['slip_no']   	= $slip_no;
		$data1['voucherType'] 	= 1;
		$data1['description']   = $description;
        $data1['username'] 		= Auth::user()->name;
        $data1['pv_status']  	= 2;
        $data1['date'] 			= date('Y-m-d');
        $data1['time'] 			= date('H:i:s');

        DB::table('pvs')->insert($data1);
		
        $pvsDataSection = Input::get('pvsDataSection_1');
		foreach($pvsDataSection as $row1){
			$d_amount =  Input::get('d_amount_1_'.$row1.'');
            $c_amount =  Input::get('c_amount_1_'.$row1.'');
			$account  =  Input::get('account_id_1_'.$row1.'');
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
        	$data2['pv_status']   	= 2;
        	$data2['username'] 		= Auth::user()->name;
        	$data2['status']  		= 1;
        	$data2['date'] 			= date('Y-m-d');
        	$data2['time'] 			= date('H:i:s');
        	
			DB::table('pv_data')->insert($data2);
		}
		

		$tableTwoDetail = DB::table('pv_data')
        ->where('pv_no', $pv_no)
        ->where('pv_status', '2')->get();
        Helpers::reconnectMasterDatabase();
        foreach ($tableTwoDetail as $row2) {
        	$vouceherType = 2;
            $voucherNo = $row2->pv_no;
            $voucherDate = $row2->pv_date;

            $data3['acc_id'] = $row2->acc_id;
            $data3['acc_code'] = Helpers::getAccountCodeByAccId($row2->acc_id,$_GET['m']);
            $data3['particulars'] = $row2->description;
            $data3['opening_bal'] = '0';
            $data3['debit_credit'] = $row2->debit_credit;
            $data3['amount'] = $row2->amount;
            $data3['voucher_no'] = $voucherNo;
            $data3['voucher_type'] = $vouceherType;
            $data3['v_date'] = $voucherDate;
            $data3['date'] = date("Y-m-d");
            $data3['time'] = date("H:i:s");
            $data3['username'] = Auth::user()->name;

            DB::table('transactions')->insert($data3);
            Helpers::reconnectMasterDatabase();
        }
        echo 'Done';
       	Helpers::reconnectMasterDatabase();
		Session::flash('dataEdit','successfully edit.');
	}

	function editBankPaymentPendingVoucherDetail(){
		Helpers::companyDatabaseConnection($_GET['m']);
		
		$pv_no = Input::get('pv_no');

		DB::table('pvs')->where('pv_no', $pv_no)->delete();
		DB::table('pv_data')->where('pv_no', $pv_no)->delete();	


		
		$slip_no = Input::get('slip_no');
		$pv_date = Input::get('pv_date');
		$description = Input::get('description');
		$cheque_no = Input::get('cheque_no');
		$cheque_date = Input::get('cheque_date');

		$data1['pv_date']   	= $pv_date;
		$data1['pv_no']   		= $pv_no;
		$data1['slip_no']   	= $slip_no;
		$data1['cheque_no']   	= $cheque_no;
		$data1['cheque_date']   = $cheque_date;
		$data1['voucherType'] 	= 2;
		$data1['description']   = $description;
        $data1['username'] 		= Auth::user()->name;
        $data1['pv_status']  	= 1;
        $data1['date'] 			= date('Y-m-d');
        $data1['time'] 			= date('H:i:s');

        DB::table('pvs')->insert($data1);
		
        $pvsDataSection = Input::get('pvsDataSection_1');
		foreach($pvsDataSection as $row1){
			$d_amount =  Input::get('d_amount_1_'.$row1.'');
            $c_amount =  Input::get('c_amount_1_'.$row1.'');
			$account  =  Input::get('account_id_1_'.$row1.'');
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
		echo 'Done';
		Helpers::reconnectMasterDatabase();
		Session::flash('dataEdit','successfully edit.');
	}

	function editBankPaymentApproveVoucherDetail(){
		Helpers::companyDatabaseConnection($_GET['m']);
		
		$pv_no = Input::get('pv_no');

		DB::table('pvs')->where('pv_no', $pv_no)->delete();
		DB::table('pv_data')->where('pv_no', $pv_no)->delete();	
		DB::table('transactions')->where('voucher_no', $pv_no)->delete();


		
		$slip_no = Input::get('slip_no');
		$pv_date = Input::get('pv_date');
		$description = Input::get('description');
		$cheque_no = Input::get('cheque_no');
		$cheque_date = Input::get('cheque_date');

		$data1['pv_date']   	= $pv_date;
		$data1['pv_no']   		= $pv_no;
		$data1['slip_no']   	= $slip_no;
		$data1['cheque_no']   	= $cheque_no;
		$data1['cheque_date']   = $cheque_date;
		$data1['voucherType'] 	= 2;
		$data1['description']   = $description;
        $data1['username'] 		= Auth::user()->name;
        $data1['pv_status']  	= 2;
        $data1['date'] 			= date('Y-m-d');
        $data1['time'] 			= date('H:i:s');

        DB::table('pvs')->insert($data1);
		
        $pvsDataSection = Input::get('pvsDataSection_1');
		foreach($pvsDataSection as $row1){
			$d_amount =  Input::get('d_amount_1_'.$row1.'');
            $c_amount =  Input::get('c_amount_1_'.$row1.'');
			$account  =  Input::get('account_id_1_'.$row1.'');
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
        	$data2['pv_status']   	= 2;
        	$data2['username'] 		= Auth::user()->name;
        	$data2['status']  		= 1;
        	$data2['date'] 			= date('Y-m-d');
        	$data2['time'] 			= date('H:i:s');
        	
			DB::table('pv_data')->insert($data2);
		}
		

		$tableTwoDetail = DB::table('pv_data')
        ->where('pv_no', $pv_no)
        ->where('pv_status', '2')->get();
        Helpers::reconnectMasterDatabase();
        foreach ($tableTwoDetail as $row2) {
        	$vouceherType = 2;
            $voucherNo = $row2->pv_no;
            $voucherDate = $row2->pv_date;

            $data3['acc_id'] = $row2->acc_id;
            $data3['acc_code'] = Helpers::getAccountCodeByAccId($row2->acc_id,$_GET['m']);
            $data3['particulars'] = $row2->description;
            $data3['opening_bal'] = '0';
            $data3['debit_credit'] = $row2->debit_credit;
            $data3['amount'] = $row2->amount;
            $data3['voucher_no'] = $voucherNo;
            $data3['voucher_type'] = $vouceherType;
            $data3['v_date'] = $voucherDate;
            $data3['date'] = date("Y-m-d");
            $data3['time'] = date("H:i:s");
            $data3['username'] = Auth::user()->name;

            DB::table('transactions')->insert($data3);
            Helpers::reconnectMasterDatabase();
        }
        echo 'Done';
       	Helpers::reconnectMasterDatabase();
		Session::flash('dataEdit','successfully edit.');
	}


	function editCashReceiptPendingVoucherDetail(){
		Helpers::companyDatabaseConnection($_GET['m']);
		
		$rv_no = Input::get('rv_no');

		DB::table('rvs')->where('rv_no', $rv_no)->delete();
		DB::table('rv_data')->where('rv_no', $rv_no)->delete();	


		
		$slip_no = Input::get('slip_no');
		$rv_date = Input::get('rv_date');
		$description = Input::get('description');
		
		$data1['rv_date']   	= $rv_date;
		$data1['rv_no']   		= $rv_no;
		$data1['slip_no']   	= $slip_no;
		$data1['voucherType'] 	= 1;
		$data1['description']   = $description;
        $data1['username'] 		= Auth::user()->name;
        $data1['rv_status']  	= 1;
        $data1['date'] 			= date('Y-m-d');
        $data1['time'] 			= date('H:i:s');

        DB::table('rvs')->insert($data1);
		
        $rvsDataSection = Input::get('rvsDataSection_1');
		foreach($rvsDataSection as $row1){
			$d_amount =  Input::get('d_amount_1_'.$row1.'');
            $c_amount =  Input::get('c_amount_1_'.$row1.'');
			$account  =  Input::get('account_id_1_'.$row1.'');
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
        	$data2['username'] 		= Auth::user()->name;
        	$data2['status']  		= 1;
        	$data2['date'] 			= date('Y-m-d');
        	$data2['time'] 			= date('H:i:s');
        	
			DB::table('rv_data')->insert($data2);
		}
		echo 'Done';
		Helpers::reconnectMasterDatabase();
		Session::flash('dataEdit','successfully edit.');
	}

	function editCashReceiptApproveVoucherDetail(){
		Helpers::companyDatabaseConnection($_GET['m']);
		
		$rv_no = Input::get('rv_no');

		DB::table('rvs')->where('rv_no', $rv_no)->delete();
		DB::table('rv_data')->where('rv_no', $rv_no)->delete();	
		DB::table('transactions')->where('voucher_no', $rv_no)->delete();


		
		$slip_no = Input::get('slip_no');
		$rv_date = Input::get('rv_date');
		$description = Input::get('description');
		
		$data1['rv_date']   	= $rv_date;
		$data1['rv_no']   		= $rv_no;
		$data1['slip_no']   	= $slip_no;
		$data1['voucherType'] 	= 1;
		$data1['description']   = $description;
        $data1['username'] 		= Auth::user()->name;
        $data1['rv_status']  	= 2;
        $data1['date'] 			= date('Y-m-d');
        $data1['time'] 			= date('H:i:s');

        DB::table('rvs')->insert($data1);
		
        $rvsDataSection = Input::get('rvsDataSection_1');
		foreach($rvsDataSection as $row1){
			$d_amount =  Input::get('d_amount_1_'.$row1.'');
            $c_amount =  Input::get('c_amount_1_'.$row1.'');
			$account  =  Input::get('account_id_1_'.$row1.'');
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
        	$data2['rv_status']   	= 2;
        	$data2['username'] 		= Auth::user()->name;
        	$data2['status']  		= 1;
        	$data2['date'] 			= date('Y-m-d');
        	$data2['time'] 			= date('H:i:s');
        	
			DB::table('rv_data')->insert($data2);
		}
		

		$tableTwoDetail = DB::table('rv_data')
        ->where('rv_no', $rv_no)
        ->where('rv_status', '2')->get();
        Helpers::reconnectMasterDatabase();
        foreach ($tableTwoDetail as $row2) {
        	$vouceherType = 2;
            $voucherNo = $row2->rv_no;
            $voucherDate = $row2->rv_date;

            $data3['acc_id'] = $row2->acc_id;
            $data3['acc_code'] = Helpers::getAccountCodeByAccId($row2->acc_id,$_GET['m']);
            $data3['particulars'] = $row2->description;
            $data3['opening_bal'] = '0';
            $data3['debit_credit'] = $row2->debit_credit;
            $data3['amount'] = $row2->amount;
            $data3['voucher_no'] = $voucherNo;
            $data3['voucher_type'] = $vouceherType;
            $data3['v_date'] = $voucherDate;
            $data3['date'] = date("Y-m-d");
            $data3['time'] = date("H:i:s");
            $data3['username'] = Auth::user()->name;

            DB::table('transactions')->insert($data3);
            Helpers::reconnectMasterDatabase();
        }
        echo 'Done';
       	Helpers::reconnectMasterDatabase();
		Session::flash('dataEdit','successfully edit.');
	}


	function editBankReceiptPendingVoucherDetail(){
		Helpers::companyDatabaseConnection($_GET['m']);
		
		$rv_no = Input::get('rv_no');

		DB::table('rvs')->where('rv_no', $rv_no)->delete();
		DB::table('rv_data')->where('rv_no', $rv_no)->delete();	


		
		$slip_no = Input::get('slip_no');
		$rv_date = Input::get('rv_date');
		$description = Input::get('description');
		$cheque_no = Input::get('cheque_no');
		$cheque_date = Input::get('cheque_date');

		$data1['rv_date']   	= $rv_date;
		$data1['rv_no']   		= $rv_no;
		$data1['slip_no']   	= $slip_no;
		$data1['cheque_no']   	= $cheque_no;
		$data1['cheque_date']   = $cheque_date;
		$data1['voucherType'] 	= 2;
		$data1['description']   = $description;
        $data1['username'] 		= Auth::user()->name;
        $data1['rv_status']  	= 1;
        $data1['date'] 			= date('Y-m-d');
        $data1['time'] 			= date('H:i:s');

        DB::table('rvs')->insert($data1);
		
        $rvsDataSection = Input::get('rvsDataSection_1');
		foreach($rvsDataSection as $row1){
			$d_amount =  Input::get('d_amount_1_'.$row1.'');
            $c_amount =  Input::get('c_amount_1_'.$row1.'');
			$account  =  Input::get('account_id_1_'.$row1.'');
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
        	$data2['pv_status']   	= 1;
        	$data2['username'] 		= Auth::user()->name;
        	$data2['status']  		= 1;
        	$data2['date'] 			= date('Y-m-d');
        	$data2['time'] 			= date('H:i:s');
        	
			DB::table('rv_data')->insert($data2);
		}
		echo 'Done';
		Helpers::reconnectMasterDatabase();
		Session::flash('dataEdit','successfully edit.');
	}

	function editBankReceiptApproveVoucherDetail(){
		Helpers::companyDatabaseConnection($_GET['m']);
		
		$rv_no = Input::get('rv_no');

		DB::table('rvs')->where('rv_no', $rv_no)->delete();
		DB::table('rv_data')->where('rv_no', $rv_no)->delete();	
		DB::table('transactions')->where('voucher_no', $rv_no)->delete();


		
		$slip_no = Input::get('slip_no');
		$rv_date = Input::get('rv_date');
		$description = Input::get('description');
		$cheque_no = Input::get('cheque_no');
		$cheque_date = Input::get('cheque_date');

		$data1['rv_date']   	= $rv_date;
		$data1['rv_no']   		= $rv_no;
		$data1['slip_no']   	= $slip_no;
		$data1['cheque_no']   	= $cheque_no;
		$data1['cheque_date']   = $cheque_date;
		$data1['voucherType'] 	= 2;
		$data1['description']   = $description;
        $data1['username'] 		= Auth::user()->name;
        $data1['rv_status']  	= 2;
        $data1['date'] 			= date('Y-m-d');
        $data1['time'] 			= date('H:i:s');

        DB::table('rvs')->insert($data1);
		
        $rvsDataSection = Input::get('rvsDataSection_1');
		foreach($rvsDataSection as $row1){
			$d_amount =  Input::get('d_amount_1_'.$row1.'');
            $c_amount =  Input::get('c_amount_1_'.$row1.'');
			$account  =  Input::get('account_id_1_'.$row1.'');
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
        	$data2['rv_status']   	= 2;
        	$data2['username'] 		= Auth::user()->name;
        	$data2['status']  		= 1;
        	$data2['date'] 			= date('Y-m-d');
        	$data2['time'] 			= date('H:i:s');
        	
			DB::table('rv_data')->insert($data2);
		}
		

		$tableTwoDetail = DB::table('rv_data')
        ->where('rv_no', $rv_no)
        ->where('rv_status', '2')->get();
        Helpers::reconnectMasterDatabase();
        foreach ($tableTwoDetail as $row2) {
        	$vouceherType = 2;
            $voucherNo = $row2->rv_no;
            $voucherDate = $row2->rv_date;

            $data3['acc_id'] = $row2->acc_id;
            $data3['acc_code'] = Helpers::getAccountCodeByAccId($row2->acc_id,$_GET['m']);
            $data3['particulars'] = $row2->description;
            $data3['opening_bal'] = '0';
            $data3['debit_credit'] = $row2->debit_credit;
            $data3['amount'] = $row2->amount;
            $data3['voucher_no'] = $voucherNo;
            $data3['voucher_type'] = $vouceherType;
            $data3['v_date'] = $voucherDate;
            $data3['date'] = date("Y-m-d");
            $data3['time'] = date("H:i:s");
            $data3['username'] = Auth::user()->name;

            DB::table('transactions')->insert($data3);
            Helpers::reconnectMasterDatabase();
        }
        echo 'Done';
       	Helpers::reconnectMasterDatabase();
		Session::flash('dataEdit','successfully edit.');
	}
}
