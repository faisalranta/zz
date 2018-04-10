<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\category;
use App\Models\Account;
use App\Models\Pvs;
use App\Models\Pvs_data;
use App\Models\Rvs;
use App\Models\Rvs_data;
use Helpers;
use Input;
use Auth;
use DB;
use Config;
class FinanceController extends Controller
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
   		return view('Finance.toDayActivity');
   	}
	
	public function viewChartofAccountList(){
		Helpers::companyDatabaseConnection($_GET['m']);
		$accounts = new Account;
		$accounts = $accounts::orderBy('level1', 'ASC')
    				->orderBy('level2', 'ASC')
					->orderBy('level3', 'ASC')
					->orderBy('level4', 'ASC')
					->orderBy('level5', 'ASC')
					->orderBy('level6', 'ASC')
					->orderBy('level7', 'ASC')
    				->get();
		
   		return view('Finance.viewChartofAccountList',compact('accounts'));
		Helpers::reconnectMasterDatabase();
   	}
	
	public function createAccountForm(){
		Helpers::companyDatabaseConnection($_GET['m']);
		$accounts = new Account;
		$accounts = $accounts::orderBy('level1', 'ASC')
    				->orderBy('level2', 'ASC')
					->orderBy('level3', 'ASC')
					->orderBy('level4', 'ASC')
					->orderBy('level5', 'ASC')
					->orderBy('level6', 'ASC')
					->orderBy('level7', 'ASC')
    				->get();
   		return view('Finance.createAccountForm',compact('accounts'));
		Helpers::reconnectMasterDatabase();
   	}
	
	public function ccoa(){
		return view('Finance.ccoa');
	}
	
	public function ccoa_detail(){
		Helpers::companyDatabaseConnection($_GET['m']);
		$category = new category;
		$category->name = Input::get('cName');
		$category->save();
		return view('Finance.ccoa');
		Helpers::reconnectMasterDatabase();
	}
	
	
	public function createCashPaymentVoucherForm(){
		Helpers::companyDatabaseConnection($_GET['m']);
		$accounts = new Account;
		$accounts = $accounts::orderBy('level1', 'ASC')
    				->orderBy('level2', 'ASC')
					->orderBy('level3', 'ASC')
					->orderBy('level4', 'ASC')
					->orderBy('level5', 'ASC')
					->orderBy('level6', 'ASC')
					->orderBy('level7', 'ASC')
    				->get();
   		Helpers::reconnectMasterDatabase();
   		return view('Finance.createCashPaymentVoucherForm',compact('accounts'));

   	}
	
	public function viewCashPaymentVoucherList(){
		Helpers::companyDatabaseConnection($_GET['m']);
		$currentMonthStartDate = date('Y-m-01');
    	$currentMonthEndDate   = date('Y-m-t');
		$accounts = new Account;
		$accounts = $accounts::orderBy('level1', 'ASC')
    				->orderBy('level2', 'ASC')
					->orderBy('level3', 'ASC')
					->orderBy('level4', 'ASC')
					->orderBy('level5', 'ASC')
					->orderBy('level6', 'ASC')
					->orderBy('level7', 'ASC')
    				->get();
		$pvs = new Pvs;
		$pvs = $pvs::whereBetween('pv_date',[$currentMonthStartDate,$currentMonthEndDate])
					 ->where('voucherType','=','1')
					 ->where('status','=','1')
					 ->get();
		Helpers::reconnectMasterDatabase();
		return view('Finance.viewCashPaymentVoucherList',compact('accounts','pvs'));
	}

	public function editCashPaymentVoucherForm(){
		Helpers::companyDatabaseConnection($_GET['m']);
		$accounts = new Account;
		$accounts = $accounts::orderBy('level1', 'ASC')
    				->orderBy('level2', 'ASC')
					->orderBy('level3', 'ASC')
					->orderBy('level4', 'ASC')
					->orderBy('level5', 'ASC')
					->orderBy('level6', 'ASC')
					->orderBy('level7', 'ASC')
    				->get();
   		Helpers::reconnectMasterDatabase();
   		return view('Finance.editCashPaymentVoucherForm',compact('accounts'));

   	}

	
	public function createBankPaymentVoucherForm(){
		Helpers::companyDatabaseConnection($_GET['m']);
		$accounts = new Account;
		$accounts = $accounts::orderBy('level1', 'ASC')
    				->orderBy('level2', 'ASC')
					->orderBy('level3', 'ASC')
					->orderBy('level4', 'ASC')
					->orderBy('level5', 'ASC')
					->orderBy('level6', 'ASC')
					->orderBy('level7', 'ASC')
    				->get();
   		Helpers::reconnectMasterDatabase();
   		return view('Finance.createBankPaymentVoucherForm',compact('accounts'));

   	}
	
	public function viewBankPaymentVoucherList(){
		Helpers::companyDatabaseConnection($_GET['m']);
		$currentMonthStartDate = date('Y-m-01');
    	$currentMonthEndDate   = date('Y-m-t');
		$accounts = new Account;
		$accounts = $accounts::orderBy('level1', 'ASC')
    				->orderBy('level2', 'ASC')
					->orderBy('level3', 'ASC')
					->orderBy('level4', 'ASC')
					->orderBy('level5', 'ASC')
					->orderBy('level6', 'ASC')
					->orderBy('level7', 'ASC')
    				->get();
		$pvs = new Pvs;
		$pvs = $pvs::whereBetween('pv_date',[$currentMonthStartDate,$currentMonthEndDate])
					 ->where('voucherType','=','2')
					 ->get();
		Helpers::reconnectMasterDatabase();
		return view('Finance.viewBankPaymentVoucherList',compact('accounts','pvs'));
	}

	public function editBankPaymentVoucherForm(){
		Helpers::companyDatabaseConnection($_GET['m']);
		$accounts = new Account;
		$accounts = $accounts::orderBy('level1', 'ASC')
    				->orderBy('level2', 'ASC')
					->orderBy('level3', 'ASC')
					->orderBy('level4', 'ASC')
					->orderBy('level5', 'ASC')
					->orderBy('level6', 'ASC')
					->orderBy('level7', 'ASC')
    				->get();
   		Helpers::reconnectMasterDatabase();
   		return view('Finance.editBankPaymentVoucherForm',compact('accounts'));

   	}
	
	public function createCashReceiptVoucherForm(){
		Helpers::companyDatabaseConnection($_GET['m']);
		$accounts = new Account;
		$accounts = $accounts::orderBy('level1', 'ASC')
    				->orderBy('level2', 'ASC')
					->orderBy('level3', 'ASC')
					->orderBy('level4', 'ASC')
					->orderBy('level5', 'ASC')
					->orderBy('level6', 'ASC')
					->orderBy('level7', 'ASC')
    				->get();
   		Helpers::reconnectMasterDatabase();
   		return view('Finance.createCashReceiptVoucherForm',compact('accounts'));
	}
	
	public function viewCashReceiptVoucherList(){
		Helpers::companyDatabaseConnection($_GET['m']);
		$currentMonthStartDate = date('Y-m-01');
    	$currentMonthEndDate   = date('Y-m-t');
		$accounts = new Account;
		$accounts = $accounts::orderBy('level1', 'ASC')
    				->orderBy('level2', 'ASC')
					->orderBy('level3', 'ASC')
					->orderBy('level4', 'ASC')
					->orderBy('level5', 'ASC')
					->orderBy('level6', 'ASC')
					->orderBy('level7', 'ASC')
    				->get();
		$rvs = new Rvs;
		$rvs = $rvs::whereBetween('rv_date',[$currentMonthStartDate,$currentMonthEndDate])
					 ->where('voucherType','=','1')
					 ->get();
		Helpers::reconnectMasterDatabase();
		return view('Finance.viewCashReceiptVoucherList',compact('accounts','rvs'));
	}

	public function editCashReceiptVoucherForm(){
		Helpers::companyDatabaseConnection($_GET['m']);
		$accounts = new Account;
		$accounts = $accounts::orderBy('level1', 'ASC')
    				->orderBy('level2', 'ASC')
					->orderBy('level3', 'ASC')
					->orderBy('level4', 'ASC')
					->orderBy('level5', 'ASC')
					->orderBy('level6', 'ASC')
					->orderBy('level7', 'ASC')
    				->get();
   		Helpers::reconnectMasterDatabase();
   		return view('Finance.editCashReceiptVoucherForm',compact('accounts'));
	}
	
	public function createBankReceiptVoucherForm(){
		Helpers::companyDatabaseConnection($_GET['m']);
		$accounts = new Account;
		$accounts = $accounts::orderBy('level1', 'ASC')
    				->orderBy('level2', 'ASC')
					->orderBy('level3', 'ASC')
					->orderBy('level4', 'ASC')
					->orderBy('level5', 'ASC')
					->orderBy('level6', 'ASC')
					->orderBy('level7', 'ASC')
    				->get();
   		Helpers::reconnectMasterDatabase();
   		return view('Finance.createBankReceiptVoucherForm',compact('accounts'));
	}
	
	public function viewBankReceiptVoucherList(){
		Helpers::companyDatabaseConnection($_GET['m']);
		$currentMonthStartDate = date('Y-m-01');
    	$currentMonthEndDate   = date('Y-m-t');
		$accounts = new Account;
		$accounts = $accounts::orderBy('level1', 'ASC')
    				->orderBy('level2', 'ASC')
					->orderBy('level3', 'ASC')
					->orderBy('level4', 'ASC')
					->orderBy('level5', 'ASC')
					->orderBy('level6', 'ASC')
					->orderBy('level7', 'ASC')
    				->get();
		$rvs = new Rvs;
		$rvs = $rvs::whereBetween('rv_date',[$currentMonthStartDate,$currentMonthEndDate])
					 ->where('voucherType','=','2')
					 ->get();
		Helpers::reconnectMasterDatabase();
		return view('Finance.viewBankReceiptVoucherList',compact('accounts','rvs'));
	}

	public function editBankReceiptVoucherForm(){
		Helpers::companyDatabaseConnection($_GET['m']);
		$accounts = new Account;
		$accounts = $accounts::orderBy('level1', 'ASC')
    				->orderBy('level2', 'ASC')
					->orderBy('level3', 'ASC')
					->orderBy('level4', 'ASC')
					->orderBy('level5', 'ASC')
					->orderBy('level6', 'ASC')
					->orderBy('level7', 'ASC')
    				->get();
   		Helpers::reconnectMasterDatabase();
   		return view('Finance.editBankReceiptVoucherForm',compact('accounts'));
	}
	
}
