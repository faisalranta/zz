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
use Helpers;
use Auth;

class FinanceDeleteController extends Controller
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
    public function deleteCompanyFinanceTwoTableRecords(){
		$m = $_GET['m'];
        Helpers::companyDatabaseConnection($m);
        $voucherStatus = $_GET['voucherStatus'];
        $rowStatus = $_GET['rowStatus'];
        $columnValue = $_GET['columnValue'];
        $columnOne = $_GET['columnOne'];
        $columnTwo = $_GET['columnTwo'];
        $columnThree = $_GET['columnThree'];
        $tableOne = $_GET['tableOne'];
        $tableTwo = $_GET['tableTwo'];
        

        $updateDetails = array(
            $columnThree => 2,
            'delete_username' => Auth::user()->name
        );

        DB::table($tableOne)
        ->where($columnOne, $columnValue)
        ->update($updateDetails);

        DB::table($tableTwo)
        ->where($columnOne, $columnValue)
        ->update($updateDetails);

        Session::flash('dataDelete','successfully delete.');
        Helpers::reconnectMasterDatabase();
    }

    public function repostCompanyFinanceTwoTableRecords(){
        $m = $_GET['m'];
        Helpers::companyDatabaseConnection($m);
        $voucherStatus = $_GET['voucherStatus'];
        $rowStatus = $_GET['rowStatus'];
        $columnValue = $_GET['columnValue'];
        $columnOne = $_GET['columnOne'];
        $columnTwo = $_GET['columnTwo'];
        $columnThree = $_GET['columnThree'];
        $tableOne = $_GET['tableOne'];
        $tableTwo = $_GET['tableTwo'];
        

        $updateDetails = array(
            $columnThree => 1,
            'delete_username' => ''
        );

        DB::table($tableOne)
        ->where($columnOne, $columnValue)
        ->update($updateDetails);

        DB::table($tableTwo)
        ->where($columnOne, $columnValue)
        ->update($updateDetails);

        Session::flash('dataRepost','successfully repost.');
        Helpers::reconnectMasterDatabase();
    }

    public function approveCompanyFinanceTwoTableRecords(){

        $m = $_GET['m'];
        Helpers::companyDatabaseConnection($m);
        $voucherStatus = $_GET['voucherStatus'];
        $rowStatus = $_GET['rowStatus'];
        $columnValue = $_GET['columnValue'];
        $columnOne = $_GET['columnOne'];
        $columnTwo = $_GET['columnTwo'];
        $columnThree = $_GET['columnThree'];
        $tableOne = $_GET['tableOne'];
        $tableTwo = $_GET['tableTwo'];
        

        $updateDetails = array(
            $columnTwo => 2,
            'approve_username' => Auth::user()->name
        );

        DB::table($tableOne)
        ->where($columnOne, $columnValue)
        ->update($updateDetails);

        DB::table($tableTwo)
        ->where($columnOne, $columnValue)
        ->update($updateDetails);

        $tableTwoDetail = DB::table($tableTwo)
        ->where($columnOne, $columnValue)
        ->where($columnTwo, '2')->get();
        Helpers::reconnectMasterDatabase();

        foreach ($tableTwoDetail as $row) {
            if($tableOne == 'pvs'){
                $vouceherType = 2;
                $voucherNo = $row->pv_no;
                $voucherDate = $row->pv_date;
            }else if($tableOne == 'rvs'){
                $vouceherType = 3;
                $voucherNo = $row->rv_no;
                $voucherDate = $row->rv_date;
            }
            $data['acc_id'] = $row->acc_id;
            $data['acc_code'] = Helpers::getAccountCodeByAccId($row->acc_id,$m);
            $data['particulars'] = $row->description;
            $data['opening_bal'] = '0';
            $data['debit_credit'] = $row->debit_credit;
            $data['amount'] = $row->amount;
            $data['voucher_no'] = $voucherNo;
            $data['voucher_type'] = $vouceherType;
            $data['v_date'] = $voucherDate;
            $data['date'] = date("Y-m-d");
            $data['time'] = date("H:i:s");
            $data['username'] = Auth::user()->name;

            DB::table('transactions')->insert($data);
            Helpers::reconnectMasterDatabase();
        }
        Helpers::reconnectMasterDatabase();
        Session::flash('dataApprove','successfully approve.');
        
    }


    public function deleteCompanyFinanceThreeTableRecords(){
        $m = $_GET['m'];
        Helpers::companyDatabaseConnection($m);
        $voucherStatus = $_GET['voucherStatus'];
        $rowStatus = $_GET['rowStatus'];
        $columnValue = $_GET['columnValue'];
        $columnOne = $_GET['columnOne'];
        $columnTwo = $_GET['columnTwo'];
        $columnThree = $_GET['columnThree'];
        $tableOne = $_GET['tableOne'];
        $tableTwo = $_GET['tableTwo'];
        $tableThree = $_GET['tableThree'];
        

        $updateDetails = array(
            $columnThree => 2,
            'delete_username' => Auth::user()->name
        );

        DB::table($tableOne)
        ->where($columnOne, $columnValue)
        ->update($updateDetails);

        DB::table($tableTwo)
        ->where($columnOne, $columnValue)
        ->update($updateDetails);

        DB::table($tableThree)
        ->where('voucher_no', $columnValue)
        ->update($updateDetails);

        Session::flash('dataDelete','successfully delete.');
        Helpers::reconnectMasterDatabase();
    }


    public function repostCompanyFinanceThreeTableRecords(){
        $m = $_GET['m'];
        Helpers::companyDatabaseConnection($m);
        $voucherStatus = $_GET['voucherStatus'];
        $rowStatus = $_GET['rowStatus'];
        $columnValue = $_GET['columnValue'];
        $columnOne = $_GET['columnOne'];
        $columnTwo = $_GET['columnTwo'];
        $columnThree = $_GET['columnThree'];
        $tableOne = $_GET['tableOne'];
        $tableTwo = $_GET['tableTwo'];
        $tableThree = $_GET['tableThree'];
        

        $updateDetails = array(
            $columnThree => 1,
            'delete_username' => ''
        );

        DB::table($tableOne)
        ->where($columnOne, $columnValue)
        ->update($updateDetails);

        DB::table($tableTwo)
        ->where($columnOne, $columnValue)
        ->update($updateDetails);

        DB::table($tableThree)
        ->where('voucher_no', $columnValue)
        ->update($updateDetails);

        Session::flash('dataRepost','successfully repost.');
        Helpers::reconnectMasterDatabase();
    }
}
