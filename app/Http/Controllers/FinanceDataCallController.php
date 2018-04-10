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
use App\Models\Transactions;
use Helpers;
use Input;
use Auth;
use DB;
use Config;
use Session;
use PDF;
class FinanceDataCallController extends Controller
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
   
   	public function viewCashPaymentVoucherDetail(){
		$id = $_GET['id'];
		$m = $_GET['m'];
		$currentDate = date('Y-m-d');
		Helpers::companyDatabaseConnection($m);
		$pvs = DB::table('pvs')->where('pv_no','=',$id)->get();
		Helpers::reconnectMasterDatabase();
		foreach ($pvs as $row) {
	?>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
			<?php echo Helpers::displayApproveDeleteRepostButton($m,$row->pv_status,$row->status,$row->pv_no,'pv_no','pv_status','status');?>
		</div>
		<div style="line-height:5px;">&nbsp;</div>
    	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        	<div class="well">   
            	<div class="row">
                	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    	<div class="row">
                        	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-4">
                            	<label style="border-bottom:2px solid #000 !important;">Printed On Date&nbsp;:&nbsp;</label><label style="border-bottom:2px solid #000 !important;"><?php echo Helpers::changeDateFormat($currentDate);?></label>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5">
                				<div class="row">
                    				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center" 
                                    style="font-size: 30px !important; font-style: inherit;
    								font-family: -webkit-body; font-weight: bold;">
                        				<?php echo Helpers::getCompanyName($m);?>
                        			</div>
                        			<br />
                        			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center" 
                                    style="font-size: 20px !important; font-style: inherit;
    								font-family: -webkit-body; font-weight: bold;">
                        			<?php Helpers::checkVoucherStatus($row->pv_status,$row->status);?>
                    				</div>
                    			</div>
                			</div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-right">
                            	<?php $nameOfDay = date('l', strtotime($currentDate)); ?>
                            	<label style="border-bottom:2px solid #000 !important;">Printed On Day&nbsp;:&nbsp;</label><label style="border-bottom:2px solid #000 !important;"><?php echo '&nbsp;'.$nameOfDay;?></label>

                            </div>
                        </div>
                        <div style="line-height:5px;">&nbsp;</div>
                        <div class="row">
                        	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        		<div style="width:30%; float:left;">
                        			<table  class="table table-bordered table-striped table-condensed tableMargin">
                            			<tbody>
                                			<tr>
                                    			<td style="width:40%;">PV No.</td>
                                        		<td style="width:60%;"><?php echo $row->pv_no;?></td>
                                   			</tr>
                                   			<tr>
                                    			<td style="width:40%;">Slip No.</td>
                                        		<td style="width:60%;"><?php echo $row->slip_no;?></td>
                                   			</tr>
                                    		<tr>
                                    			<td>PV Date</td>
                                        		<td><?php echo Helpers::changeDateFormat($row->pv_date);?></td>
                                  			</tr>
                              			</tbody>
                           			</table>
                      			</div>
                        	</div>
                        	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		                    	<div class="table-responsive">
		                        	<table  class="table table-bordered table-striped table-condensed tableMargin">
		                            	<thead>
		                                	<tr>
		                                    	<th class="text-center" style="width:50px;">S.No</th>
		                                        <th class="text-center">Account</th>
		                                        <th class="text-center" style="width:150px;">Debit</th>
		                                        <th class="text-center" style="width:150px;">Credit</th>
		                                  	</tr>
		                               	</thead>
		                                <tbody>
		                                	<?php
		                                		Helpers::companyDatabaseConnection($m);
												$pvsDetail = DB::table('pv_data')->where('pv_no','=',$id)->get();
												Helpers::reconnectMasterDatabase();
		                                		$counter = 1;
		                                		$g_t_debit = 0;
												$g_t_credit = 0;
		                                		foreach ($pvsDetail as $row2) {
		                                	?>
		                                		<tr>
		                                			<td class="text-center"><?php echo $counter++;?></td>
		                                			<td><?php  echo Helpers::getAccountNameByAccId($row2->acc_id,$m);?></td>
		                                			<td class="debit_amount text-right">
		                                				<?php 
		                                					if($row2->debit_credit == 1){
		                                						$g_t_credit += $row2->amount;
		                                						echo number_format($row2->amount,0);
                                            				}else{}
                                            			?>
                                            		</td>
                                        			<td class="credit_amount text-right">
                                        				<?php 
                                        					if($row2->debit_credit == 0){
                                        						$g_t_debit += $row2->amount;
                                        						echo number_format($row2->amount,0);
                                        					}else{}
                                        				?>
                                        			</td>
		                                		</tr>
		                                	<?php
		                                		}
		                                	?>
		                                	<tr class="sf-table-total">
                                				<td colspan="2">
                                    				<label for="field-1" class="sf-label"><b>Total</b></label>
                                    			</td>
                                    			<td class="text-right"><b><?php echo number_format($g_t_credit,0);?></b></td> 
                                    			<td class="text-right"><b><?php echo number_format($g_t_debit,0);?></b></td>
                                    		</tr>
		                                </tbody>
		                            </table>
		                        </div>
		                    </div>
		                    <div style="line-height:8px;">&nbsp;</div>
		                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		                    	<div class="row">
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		    							<div class="table-responsive">
		                					<table  class="table table-bordered table-striped table-condensed tableMargin">
		                    					<thead>
		                							<tr>
		                            					<th>Description</th>
		                                				<th colspan="5"><?php echo $row->description;?></th>
		                          					</tr>
		                            				<tr>
		                            					<th style="width:15%;">Printed On</th>
		                                				<th style="width:15%;"><?php echo Auth::user()->name; ?></th>
		                                				<th style="width:15%;">Created By</th>
		                                				<th style="width:15%;"><?php echo $row->username;?></th>
		                                				<th style="width:20%;">Received By</th>
		                                				<th style="width:20%;"></th>
		                          					</tr>
		                      					</thead>
		                   					</table>
		              					</div>
		    						</div>
								</div>
		                    </div>
                        </div>
                    </div>
              	</div>
           	</div>
       	</div>
   	</div>
	<?php
		}

	}
	
	public function viewBankPaymentVoucherDetail(){
		$id = $_GET['id'];
		$m = $_GET['m'];
		$currentDate = date('Y-m-d');
		Helpers::companyDatabaseConnection($m);
		$pvs = DB::table('pvs')->where('pv_no','=',$id)->get();
		Helpers::reconnectMasterDatabase();
		foreach ($pvs as $row) {
	?>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
			<?php echo Helpers::displayApproveDeleteRepostButton($m,$row->pv_status,$row->status,$row->pv_no,'pv_no','pv_status','status');?>
		</div>
		<div style="line-height:5px;">&nbsp;</div>
    	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        	<div class="well">   
            	<div class="row">
                	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    	<div class="row">
                        	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-4">
                            	<label style="border-bottom:2px solid #000 !important;">Printed On Date&nbsp;:&nbsp;</label><label style="border-bottom:2px solid #000 !important;"><?php echo Helpers::changeDateFormat($currentDate);?></label>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5">
                				<div class="row">
                    				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center" 
                                    style="font-size: 30px !important; font-style: inherit;
    								font-family: -webkit-body; font-weight: bold;">
                        				<?php echo Helpers::getCompanyName($m);?>
                        			</div>
                        			<br />
                        			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center" 
                                    style="font-size: 20px !important; font-style: inherit;
    								font-family: -webkit-body; font-weight: bold;">
                        			<?php Helpers::checkVoucherStatus($row->pv_status,$row->status);?>
                    				</div>
                    			</div>
                			</div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-right">
                            	<?php $nameOfDay = date('l', strtotime($currentDate)); ?>
                            	<label style="border-bottom:2px solid #000 !important;">Printed On Day&nbsp;:&nbsp;</label><label style="border-bottom:2px solid #000 !important;"><?php echo '&nbsp;'.$nameOfDay;?></label>

                            </div>
                        </div>
                        <div style="line-height:5px;">&nbsp;</div>
                        <div class="row">
                        	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        		<div style="width:30%; float:left;">
                        			<table  class="table table-bordered table-striped table-condensed tableMargin">
                            			<tbody>
                                			<tr>
                                    			<td style="width:40%;">PV No.</td>
                                        		<td style="width:60%;"><?php echo $row->pv_no;?></td>
                                   			</tr>
                                   			<tr>
                                    			<td style="width:40%;">Slip No.</td>
                                        		<td style="width:60%;"><?php echo $row->slip_no;?></td>
                                   			</tr>
                                    		<tr>
                                    			<td>PV Date</td>
                                        		<td><?php echo Helpers::changeDateFormat($row->pv_date);?></td>
                                  			</tr>
                              			</tbody>
                           			</table>
                      			</div>
                      			<div style="width:30%; float:right;">
                        			<table  class="table table-bordered table-striped table-condensed tableMargin">
                            			<tbody>
                                			<tr>
                                    			<td style="width:40%;">Cheque No.</td>
                                        		<td style="width:60%;"><?php echo $row->cheque_no;?></td>
                                   			</tr>
                                   			<tr>
                                    			<td>Cheque Date</td>
                                        		<td><?php echo Helpers::changeDateFormat($row->cheque_date);?></td>
                                  			</tr>
                              			</tbody>
                           			</table>
                      			</div>
                        	</div>
                        	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		                    	<div class="table-responsive">
		                        	<table  class="table table-bordered table-striped table-condensed tableMargin">
		                            	<thead>
		                                	<tr>
		                                    	<th class="text-center" style="width:50px;">S.No</th>
		                                        <th class="text-center">Account</th>
		                                        <th class="text-center" style="width:150px;">Debit</th>
		                                        <th class="text-center" style="width:150px;">Credit</th>
		                                  	</tr>
		                               	</thead>
		                                <tbody>
		                                	<?php
		                                		Helpers::companyDatabaseConnection($m);
												$pvsDetail = DB::table('pv_data')->where('pv_no','=',$id)->get();
												Helpers::reconnectMasterDatabase();
		                                		$counter = 1;
		                                		$g_t_debit = 0;
												$g_t_credit = 0;
		                                		foreach ($pvsDetail as $row2) {
		                                	?>
		                                		<tr>
		                                			<td class="text-center"><?php echo $counter++;?></td>
		                                			<td><?php  echo Helpers::getAccountNameByAccId($row2->acc_id,$m);?></td>
		                                			<td class="debit_amount text-right">
		                                				<?php 
		                                					if($row2->debit_credit == 1){
		                                						$g_t_credit += $row2->amount;
		                                						echo number_format($row2->amount,0);
                                            				}else{}
                                            			?>
                                            		</td>
                                        			<td class="credit_amount text-right">
                                        				<?php 
                                        					if($row2->debit_credit == 0){
                                        						$g_t_debit += $row2->amount;
                                        						echo number_format($row2->amount,0);
                                        					}else{}
                                        				?>
                                        			</td>
		                                		</tr>
		                                	<?php
		                                		}
		                                	?>
		                                	<tr class="sf-table-total">
                                				<td colspan="2">
                                    				<label for="field-1" class="sf-label"><b>Total</b></label>
                                    			</td>
                                    			<td class="text-right"><b><?php echo number_format($g_t_credit,0);?></b></td> 
                                    			<td class="text-right"><b><?php echo number_format($g_t_debit,0);?></b></td>
                                    		</tr>
		                                </tbody>
		                            </table>
		                        </div>
		                    </div>
		                    <div style="line-height:8px;">&nbsp;</div>
		                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		                    	<div class="row">
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		    							<div class="table-responsive">
		                					<table  class="table table-bordered table-striped table-condensed tableMargin">
		                    					<thead>
		                							<tr>
		                            					<th>Description</th>
		                                				<th colspan="5"><?php echo $row->description;?></th>
		                          					</tr>
		                            				<tr>
		                            					<th style="width:15%;">Printed On</th>
		                                				<th style="width:15%;"><?php echo Auth::user()->name; ?></th>
		                                				<th style="width:15%;">Created By</th>
		                                				<th style="width:15%;"><?php echo $row->username;?></th>
		                                				<th style="width:20%;">Received By</th>
		                                				<th style="width:20%;"></th>
		                          					</tr>
		                      					</thead>
		                   					</table>
		              					</div>
		    						</div>
								</div>
		                    </div>
                        </div>
                    </div>
              	</div>
           	</div>
       	</div>
   	</div>
	<?php
		}

	}
	
	public function viewCashReceiptVoucherDetail(){
		$id = $_GET['id'];
		$m = $_GET['m'];
		$currentDate = date('Y-m-d');
		Helpers::companyDatabaseConnection($m);
		$rvs = DB::table('rvs')->where('rv_no','=',$id)->get();
		Helpers::reconnectMasterDatabase();
		foreach ($rvs as $row) {
	?>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
			<?php echo Helpers::displayApproveDeleteRepostButton($m,$row->rv_status,$row->status,$row->rv_no,'rv_no','rv_status','status');?>
		</div>
		<div style="line-height:5px;">&nbsp;</div>
    	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        	<div class="well">   
            	<div class="row">
                	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    	<div class="row">
                        	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-4">
                            	<label style="border-bottom:2px solid #000 !important;">Printed On Date&nbsp;:&nbsp;</label><label style="border-bottom:2px solid #000 !important;"><?php echo Helpers::changeDateFormat($currentDate);?></label>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5">
                				<div class="row">
                    				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center" 
                                    style="font-size: 30px !important; font-style: inherit;
    								font-family: -webkit-body; font-weight: bold;">
                        				<?php echo Helpers::getCompanyName($m);?>
                        			</div>
                        			<br />
                        			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center" 
                                    style="font-size: 20px !important; font-style: inherit;
    								font-family: -webkit-body; font-weight: bold;">
                        			<?php Helpers::checkVoucherStatus($row->rv_status,$row->status);?>
                    				</div>
                    			</div>
                			</div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-right">
                            	<?php $nameOfDay = date('l', strtotime($currentDate)); ?>
                            	<label style="border-bottom:2px solid #000 !important;">Printed On Day&nbsp;:&nbsp;</label><label style="border-bottom:2px solid #000 !important;"><?php echo '&nbsp;'.$nameOfDay;?></label>

                            </div>
                        </div>
                        <div style="line-height:5px;">&nbsp;</div>
                        <div class="row">
                        	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        		<div style="width:30%; float:left;">
                        			<table  class="table table-bordered table-striped table-condensed tableMargin">
                            			<tbody>
                                			<tr>
                                    			<td style="width:40%;">RV No.</td>
                                        		<td style="width:60%;"><?php echo $row->rv_no;?></td>
                                   			</tr>
                                   			<tr>
                                    			<td style="width:40%;">Slip No.</td>
                                        		<td style="width:60%;"><?php echo $row->slip_no;?></td>
                                   			</tr>
                                    		<tr>
                                    			<td>RV Date</td>
                                        		<td><?php echo Helpers::changeDateFormat($row->rv_date);?></td>
                                  			</tr>
                              			</tbody>
                           			</table>
                      			</div>
                        	</div>
                        	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		                    	<div class="table-responsive">
		                        	<table  class="table table-bordered table-striped table-condensed tableMargin">
		                            	<thead>
		                                	<tr>
		                                    	<th class="text-center" style="width:50px;">S.No</th>
		                                        <th class="text-center">Account</th>
		                                        <th class="text-center" style="width:150px;">Debit</th>
		                                        <th class="text-center" style="width:150px;">Credit</th>
		                                  	</tr>
		                               	</thead>
		                                <tbody>
		                                	<?php
		                                		Helpers::companyDatabaseConnection($m);
												$rvsDetail = DB::table('rv_data')->where('rv_no','=',$id)->get();
												Helpers::reconnectMasterDatabase();
		                                		$counter = 1;
		                                		$g_t_debit = 0;
												$g_t_credit = 0;
		                                		foreach ($rvsDetail as $row2) {
		                                	?>
		                                		<tr>
		                                			<td class="text-center"><?php echo $counter++;?></td>
		                                			<td><?php  echo Helpers::getAccountNameByAccId($row2->acc_id,$m);?></td>
		                                			<td class="debit_amount text-right">
		                                				<?php 
		                                					if($row2->debit_credit == 1){
		                                						$g_t_credit += $row2->amount;
		                                						echo number_format($row2->amount,0);
                                            				}else{}
                                            			?>
                                            		</td>
                                        			<td class="credit_amount text-right">
                                        				<?php 
                                        					if($row2->debit_credit == 0){
                                        						$g_t_debit += $row2->amount;
                                        						echo number_format($row2->amount,0);
                                        					}else{}
                                        				?>
                                        			</td>
		                                		</tr>
		                                	<?php
		                                		}
		                                	?>
		                                	<tr class="sf-table-total">
                                				<td colspan="2">
                                    				<label for="field-1" class="sf-label"><b>Total</b></label>
                                    			</td>
                                    			<td class="text-right"><b><?php echo number_format($g_t_credit,0);?></b></td> 
                                    			<td class="text-right"><b><?php echo number_format($g_t_debit,0);?></b></td>
                                    		</tr>
		                                </tbody>
		                            </table>
		                        </div>
		                    </div>
		                    <div style="line-height:8px;">&nbsp;</div>
		                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		                    	<div class="row">
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		    							<div class="table-responsive">
		                					<table  class="table table-bordered table-striped table-condensed tableMargin">
		                    					<thead>
		                							<tr>
		                            					<th>Description</th>
		                                				<th colspan="5"><?php echo $row->description;?></th>
		                          					</tr>
		                            				<tr>
		                            					<th style="width:15%;">Printed On</th>
		                                				<th style="width:15%;"><?php echo Auth::user()->name; ?></th>
		                                				<th style="width:15%;">Created By</th>
		                                				<th style="width:15%;"><?php echo $row->username;?></th>
		                                				<th style="width:20%;">Received By</th>
		                                				<th style="width:20%;"></th>
		                          					</tr>
		                      					</thead>
		                   					</table>
		              					</div>
		    						</div>
								</div>
		                    </div>
                        </div>
                    </div>
              	</div>
           	</div>
       	</div>
   	</div>
	<?php
		}

	}
	
	public function viewBankReceiptVoucherDetail(){
		$id = $_GET['id'];
		$m = $_GET['m'];
		$currentDate = date('Y-m-d');
		Helpers::companyDatabaseConnection($m);
		$rvs = DB::table('rvs')->where('rv_no','=',$id)->get();
		Helpers::reconnectMasterDatabase();
		foreach ($rvs as $row) {
	?>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
			<?php echo Helpers::displayApproveDeleteRepostButton($m,$row->rv_status,$row->status,$row->rv_no,'rv_no','rv_status','status');?>
		</div>
		<div style="line-height:5px;">&nbsp;</div>
    	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        	<div class="well">   
            	<div class="row">
                	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    	<div class="row">
                        	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-4">
                            	<label style="border-bottom:2px solid #000 !important;">Printed On Date&nbsp;:&nbsp;</label><label style="border-bottom:2px solid #000 !important;"><?php echo Helpers::changeDateFormat($currentDate);?></label>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5">
                				<div class="row">
                    				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center" 
                                    style="font-size: 30px !important; font-style: inherit;
    								font-family: -webkit-body; font-weight: bold;">
                        				<?php echo Helpers::getCompanyName($m);?>
                        			</div>
                        			<br />
                        			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center" 
                                    style="font-size: 20px !important; font-style: inherit;
    								font-family: -webkit-body; font-weight: bold;">
                        			<?php Helpers::checkVoucherStatus($row->rv_status,$row->status);?>
                    				</div>
                    			</div>
                			</div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-right">
                            	<?php $nameOfDay = date('l', strtotime($currentDate)); ?>
                            	<label style="border-bottom:2px solid #000 !important;">Printed On Day&nbsp;:&nbsp;</label><label style="border-bottom:2px solid #000 !important;"><?php echo '&nbsp;'.$nameOfDay;?></label>

                            </div>
                        </div>
                        <div style="line-height:5px;">&nbsp;</div>
                        <div class="row">
                        	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        		<div style="width:30%; float:left;">
                        			<table  class="table table-bordered table-striped table-condensed tableMargin">
                            			<tbody>
                                			<tr>
                                    			<td style="width:40%;">RV No.</td>
                                        		<td style="width:60%;"><?php echo $row->rv_no;?></td>
                                   			</tr>
                                   			<tr>
                                    			<td style="width:40%;">Slip No.</td>
                                        		<td style="width:60%;"><?php echo $row->slip_no;?></td>
                                   			</tr>
                                    		<tr>
                                    			<td>RV Date</td>
                                        		<td><?php echo Helpers::changeDateFormat($row->rv_date);?></td>
                                  			</tr>
                              			</tbody>
                           			</table>
                      			</div>
                      			<div style="width:30%; float:right;">
                        			<table  class="table table-bordered table-striped table-condensed tableMargin">
                            			<tbody>
                                			<tr>
                                    			<td style="width:40%;">Cheque No.</td>
                                        		<td style="width:60%;"><?php echo $row->cheque_no;?></td>
                                   			</tr>
                                   			<tr>
                                    			<td>Cheque Date</td>
                                        		<td><?php echo Helpers::changeDateFormat($row->cheque_date);?></td>
                                  			</tr>
                              			</tbody>
                           			</table>
                      			</div>
                        	</div>
                        	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		                    	<div class="table-responsive">
		                        	<table  class="table table-bordered table-striped table-condensed tableMargin">
		                            	<thead>
		                                	<tr>
		                                    	<th class="text-center" style="width:50px;">S.No</th>
		                                        <th class="text-center">Account</th>
		                                        <th class="text-center" style="width:150px;">Debit</th>
		                                        <th class="text-center" style="width:150px;">Credit</th>
		                                  	</tr>
		                               	</thead>
		                                <tbody>
		                                	<?php
		                                		Helpers::companyDatabaseConnection($m);
												$rvsDetail = DB::table('rv_data')->where('rv_no','=',$id)->get();
												Helpers::reconnectMasterDatabase();
		                                		$counter = 1;
		                                		$g_t_debit = 0;
												$g_t_credit = 0;
		                                		foreach ($rvsDetail as $row2) {
		                                	?>
		                                		<tr>
		                                			<td class="text-center"><?php echo $counter++;?></td>
		                                			<td><?php  echo Helpers::getAccountNameByAccId($row2->acc_id,$m);?></td>
		                                			<td class="debit_amount text-right">
		                                				<?php 
		                                					if($row2->debit_credit == 1){
		                                						$g_t_credit += $row2->amount;
		                                						echo number_format($row2->amount,0);
                                            				}else{}
                                            			?>
                                            		</td>
                                        			<td class="credit_amount text-right">
                                        				<?php 
                                        					if($row2->debit_credit == 0){
                                        						$g_t_debit += $row2->amount;
                                        						echo number_format($row2->amount,0);
                                        					}else{}
                                        				?>
                                        			</td>
		                                		</tr>
		                                	<?php
		                                		}
		                                	?>
		                                	<tr class="sf-table-total">
                                				<td colspan="2">
                                    				<label for="field-1" class="sf-label"><b>Total</b></label>
                                    			</td>
                                    			<td class="text-right"><b><?php echo number_format($g_t_credit,0);?></b></td> 
                                    			<td class="text-right"><b><?php echo number_format($g_t_debit,0);?></b></td>
                                    		</tr>
		                                </tbody>
		                            </table>
		                        </div>
		                    </div>
		                    <div style="line-height:8px;">&nbsp;</div>
		                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		                    	<div class="row">
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		    							<div class="table-responsive">
		                					<table  class="table table-bordered table-striped table-condensed tableMargin">
		                    					<thead>
		                							<tr>
		                            					<th>Description</th>
		                                				<th colspan="5"><?php echo $row->description;?></th>
		                          					</tr>
		                            				<tr>
		                            					<th style="width:15%;">Printed On</th>
		                                				<th style="width:15%;"><?php echo Auth::user()->name; ?></th>
		                                				<th style="width:15%;">Created By</th>
		                                				<th style="width:15%;"><?php echo $row->username;?></th>
		                                				<th style="width:20%;">Received By</th>
		                                				<th style="width:20%;"></th>
		                          					</tr>
		                      					</thead>
		                   					</table>
		              					</div>
		    						</div>
								</div>
		                    </div>
                        </div>
                    </div>
              	</div>
           	</div>
       	</div>
   	</div>
	<?php
		}

	}

	
	public function filterCashPaymentVoucherList(){
		$fromDate = $_GET['fromDate'];
		$toDate = $_GET['toDate'];
		$m = $_GET['m'];
		$counter = 1;
		$makeTotalAmount = 0;
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
		$pvs = new Pvs;
		$pvs = $pvs::whereBetween('pv_date',[$fromDate,$toDate])
					 ->where('voucherType','=','1')
					 ->get();
		
	?>
	<tr>
    	<td colspan="8">
		<?php if(Session::has('dataDelete')){?>
    		<div class="row">
		    	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">&nbsp;</div>
		    	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
		    		<div class="alert alert-danger"><span class="glyphicon glyphicon-ok"></span><em><?php echo session('dataDelete')?></em>
		    		</div>
		    	</div>
		    </div>
		<?php }?>
		<?php if(Session::has('dataRepost')){?>
    		<div class="row">
		    	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">&nbsp;</div>
		    	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
		    		<div class="alert alert-warning"><span class="glyphicon glyphicon-ok"></span><em><?php echo session('dataRepost')?></em>
		    		</div>
		    	</div>
		    </div>
		<?php }?>

		<?php if(Session::has('dataApprove')){?>
    		<div class="row">
		    	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">&nbsp;</div>
		    	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
		    		<div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em><?php echo session('dataApprove')?></em>
		    		</div>
		    	</div>
		    </div>
		<?php }?>

		<?php if(Session::has('dataEdit')){?>
    		<div class="row">
		    	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">&nbsp;</div>
		    	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
		    		<div class="alert alert-info"><span class="glyphicon glyphicon-ok"></span><em><?php echo session('dataEdit')?></em>
		    		</div>
		    	</div>
		    </div>
		<?php }?>
		</td>
	</tr>
	<?php
		foreach ($pvs as $row1) {
	?>
		<tr>
			<td class="text-center"><?php echo $counter++;?></td>
			<td class="text-center"><?php echo $row1['pv_no'];?></td>
			<td class="text-center"><?php echo Helpers::changeDateFormat($row1['pv_date']);?></td>
			<td class="text-center">
				<?php 
					$d_acc = DB::selectOne('select accounts.name name from `pv_data` 
					inner join `accounts` on accounts.id = pv_data.acc_id where pv_data.debit_credit = 1 and pv_data.pv_no = \''.$row1['pv_no'].'\'')->name;				
					
					$c_acc = DB::selectOne('select accounts.name name from `pv_data` 
					inner join `accounts` on accounts.id = pv_data.acc_id where pv_data.debit_credit = 0 and pv_data.pv_no = \''.$row1['pv_no'].'\'')->name;				
																			
					$debit_amount = DB::selectOne("select sum(`amount`) total from `pv_data` where `debit_credit` = 1 and `pv_no` = '".$row1['pv_no']."'")->total;
																			
					$credit_amount = DB::selectOne("select sum(`amount`) total from `pv_data` where `debit_credit` = 0 and `pv_no` = '".$row1['pv_no']."'")->total;				
					echo 'Dr = '.$d_acc.'['.number_format($debit_amount,0).'] / Cr = '.$c_acc.'['.number_format($credit_amount,0).']';		
				?>
			</td>
			<td class="text-center"><?php Helpers::checkVoucherStatus($row1['pv_status'],$row1['status']);?></td>
			<td class="text-right">
				<?php $makeTotalAmount += $debit_amount;?>
				<?php echo number_format($debit_amount,0);?>
			</td>
			<td class="text-right">
				<?php echo number_format($makeTotalAmount,0);?>
			</td>
			<td class="text-center">
				<a onclick="showDetailModelOneParamerter('fdc/viewCashPaymentVoucherDetail','<?php echo $row1['pv_no'];?>','View Cash P.V Detail')" class="btn btn-xs btn-success"><span class="glyphicon glyphicon-eye-open"></span></a>
				
				<?php Helpers::changeActionButtons($m,$row1['pv_status'],$row1['status'],$row1['pv_no'],'pv_no','pv_status','status','finance/editCashPaymentVoucherForm','Cash P.V. Edit Detail Form');?>
			</td>
		</tr>
	<?php
		}
	?>	
		<script type="text/javascript">
			setTimeout(function() {
        		$('.alert-danger').fadeOut('fast');
        	}, 500);

        	setTimeout(function() {
        		$('.alert-warning').fadeOut('fast');
        	}, 500);

        	setTimeout(function() {
        		$('.alert-success').fadeOut('fast');
        	}, 500);

        	setTimeout(function() {
        		$('.alert-info').fadeOut('fast');
        	}, 500);
		</script>
	<?php
		Helpers::reconnectMasterDatabase();
	}



	public function filterBankPaymentVoucherList(){
		$fromDate = $_GET['fromDate'];
		$toDate = $_GET['toDate'];
		$m = $_GET['m'];
		$counter = 1;
		$makeTotalAmount = 0;
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
		$pvs = new Pvs;
		$pvs = $pvs::whereBetween('pv_date',[$fromDate,$toDate])
					 ->where('voucherType','=','2')
					 ->get();
		
	?>
	<tr>
    	<td colspan="8">
		<?php if(Session::has('dataDelete')){?>
    		<div class="row">
		    	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">&nbsp;</div>
		    	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
		    		<div class="alert alert-danger"><span class="glyphicon glyphicon-ok"></span><em><?php echo session('dataDelete')?></em>
		    		</div>
		    	</div>
		    </div>
		<?php }?>
		<?php if(Session::has('dataRepost')){?>
    		<div class="row">
		    	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">&nbsp;</div>
		    	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
		    		<div class="alert alert-warning"><span class="glyphicon glyphicon-ok"></span><em><?php echo session('dataRepost')?></em>
		    		</div>
		    	</div>
		    </div>
		<?php }?>

		<?php if(Session::has('dataApprove')){?>
    		<div class="row">
		    	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">&nbsp;</div>
		    	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
		    		<div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em><?php echo session('dataApprove')?></em>
		    		</div>
		    	</div>
		    </div>
		<?php }?>

		<?php if(Session::has('dataEdit')){?>
    		<div class="row">
		    	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">&nbsp;</div>
		    	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
		    		<div class="alert alert-info"><span class="glyphicon glyphicon-ok"></span><em><?php echo session('dataEdit')?></em>
		    		</div>
		    	</div>
		    </div>
		<?php }?>
		</td>
	</tr>
	<?php
		foreach ($pvs as $row1) {
	?>
		<tr>
			<td class="text-center"><?php echo $counter++;?></td>
			<td class="text-center"><?php echo $row1['pv_no'];?></td>
			<td class="text-center"><?php echo Helpers::changeDateFormat($row1['pv_date']);?></td>
			<td class="text-center">
				<?php 
					$d_acc = DB::selectOne('select accounts.name name from `pv_data` 
					inner join `accounts` on accounts.id = pv_data.acc_id where pv_data.debit_credit = 1 and pv_data.pv_no = \''.$row1['pv_no'].'\'')->name;				
					
					$c_acc = DB::selectOne('select accounts.name name from `pv_data` 
					inner join `accounts` on accounts.id = pv_data.acc_id where pv_data.debit_credit = 0 and pv_data.pv_no = \''.$row1['pv_no'].'\'')->name;				
																			
					$debit_amount = DB::selectOne("select sum(`amount`) total from `pv_data` where `debit_credit` = 1 and `pv_no` = '".$row1['pv_no']."'")->total;
																			
					$credit_amount = DB::selectOne("select sum(`amount`) total from `pv_data` where `debit_credit` = 0 and `pv_no` = '".$row1['pv_no']."'")->total;				
					echo 'Dr = '.$d_acc.'['.number_format($debit_amount,0).'] / Cr = '.$c_acc.'['.number_format($credit_amount,0).']';		
				?>
			</td>
			<td class="text-center"><?php Helpers::checkVoucherStatus($row1['pv_status'],$row1['status']);?></td>
			<td class="text-right">
				<?php $makeTotalAmount += $debit_amount;?>
				<?php echo number_format($debit_amount,0);?>
			</td>
			<td class="text-right">
				<?php echo number_format($makeTotalAmount,0);?>
			</td>
			<td class="text-center">
				<a onclick="showDetailModelOneParamerter('fdc/viewBankPaymentVoucherDetail','<?php echo $row1['pv_no'];?>','View Bank P.V Detail')" class="btn btn-xs btn-success"><span class="glyphicon glyphicon-eye-open"></span></a>
				
				<?php Helpers::changeActionButtons($m,$row1['pv_status'],$row1['status'],$row1['pv_no'],'pv_no','pv_status','status','finance/editBankPaymentVoucherForm','Bank P.V. Edit Detail Form');?>
			</td>
		</tr>
	<?php
		}
	?>	
		<script type="text/javascript">
			setTimeout(function() {
        		$('.alert-danger').fadeOut('fast');
        	}, 500);

        	setTimeout(function() {
        		$('.alert-warning').fadeOut('fast');
        	}, 500);

        	setTimeout(function() {
        		$('.alert-success').fadeOut('fast');
        	}, 500);

        	setTimeout(function() {
        		$('.alert-info').fadeOut('fast');
        	}, 500);
		</script>
	<?php
		Helpers::reconnectMasterDatabase();
	}


	public function filterCashReceiptVoucherList(){
		$fromDate = $_GET['fromDate'];
		$toDate = $_GET['toDate'];
		$m = $_GET['m'];
		$counter = 1;
		$makeTotalAmount = 0;
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
		$rvs = new Rvs;
		$rvs = $rvs::whereBetween('rv_date',[$fromDate,$toDate])
					 ->where('voucherType','=','1')
					 ->get();
		
	?>
	<tr>
    	<td colspan="8">
		<?php if(Session::has('dataDelete')){?>
    		<div class="row">
		    	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">&nbsp;</div>
		    	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
		    		<div class="alert alert-danger"><span class="glyphicon glyphicon-ok"></span><em><?php echo session('dataDelete')?></em>
		    		</div>
		    	</div>
		    </div>
		<?php }?>
		<?php if(Session::has('dataRepost')){?>
    		<div class="row">
		    	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">&nbsp;</div>
		    	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
		    		<div class="alert alert-warning"><span class="glyphicon glyphicon-ok"></span><em><?php echo session('dataRepost')?></em>
		    		</div>
		    	</div>
		    </div>
		<?php }?>

		<?php if(Session::has('dataApprove')){?>
    		<div class="row">
		    	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">&nbsp;</div>
		    	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
		    		<div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em><?php echo session('dataApprove')?></em>
		    		</div>
		    	</div>
		    </div>
		<?php }?>

		<?php if(Session::has('dataEdit')){?>
    		<div class="row">
		    	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">&nbsp;</div>
		    	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
		    		<div class="alert alert-info"><span class="glyphicon glyphicon-ok"></span><em><?php echo session('dataEdit')?></em>
		    		</div>
		    	</div>
		    </div>
		<?php }?>
		</td>
	</tr>
	<?php
		foreach ($rvs as $row1) {
	?>
		<tr>
			<td class="text-center"><?php echo $counter++;?></td>
			<td class="text-center"><?php echo $row1['rv_no'];?></td>
			<td class="text-center"><?php echo Helpers::changeDateFormat($row1['rv_date']);?></td>
			<td class="text-center">
				<?php 
					$d_acc = DB::selectOne('select accounts.name name from `rv_data` 
					inner join `accounts` on accounts.id = rv_data.acc_id where rv_data.debit_credit = 1 and rv_data.rv_no = \''.$row1['rv_no'].'\'')->name;				
					
					$c_acc = DB::selectOne('select accounts.name name from `rv_data` 
					inner join `accounts` on accounts.id = rv_data.acc_id where rv_data.debit_credit = 0 and rv_data.rv_no = \''.$row1['rv_no'].'\'')->name;				
																			
					$debit_amount = DB::selectOne("select sum(`amount`) total from `rv_data` where `debit_credit` = 1 and `rv_no` = '".$row1['rv_no']."'")->total;
																			
					$credit_amount = DB::selectOne("select sum(`amount`) total from `rv_data` where `debit_credit` = 0 and `rv_no` = '".$row1['rv_no']."'")->total;				
					echo 'Dr = '.$d_acc.'['.number_format($debit_amount,0).'] / Cr = '.$c_acc.'['.number_format($credit_amount,0).']';		
				?>
			</td>
			<td class="text-center"><?php Helpers::checkVoucherStatus($row1['rv_status'],$row1['status']);?></td>
			<td class="text-right">
				<?php $makeTotalAmount += $debit_amount;?>
				<?php echo number_format($debit_amount,0);?>
			</td>
			<td class="text-right">
				<?php echo number_format($makeTotalAmount,0);?>
			</td>
			<td class="text-center">
				<a onclick="showDetailModelOneParamerter('fdc/viewCashReceiptVoucherDetail','<?php echo $row1['rv_no'];?>','View Cash R.V Detail')" class="btn btn-xs btn-success"><span class="glyphicon glyphicon-eye-open"></span></a>
				
				<?php Helpers::changeActionButtons($m,$row1['rv_status'],$row1['status'],$row1['rv_no'],'rv_no','rv_status','status','finance/editCashReceiptVoucherForm','Cash R.V. Edit Detail Form');?>
			</td>
		</tr>
	<?php
		}
	?>	
		<script type="text/javascript">
			setTimeout(function() {
        		$('.alert-danger').fadeOut('fast');
        	}, 500);

        	setTimeout(function() {
        		$('.alert-warning').fadeOut('fast');
        	}, 500);

        	setTimeout(function() {
        		$('.alert-success').fadeOut('fast');
        	}, 500);

        	setTimeout(function() {
        		$('.alert-info').fadeOut('fast');
        	}, 500);
		</script>
	<?php
		Helpers::reconnectMasterDatabase();
	}


	public function filterBankReceiptVoucherList(){
		$fromDate = $_GET['fromDate'];
		$toDate = $_GET['toDate'];
		$m = $_GET['m'];
		$counter = 1;
		$makeTotalAmount = 0;
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
		$rvs = new Rvs;
		$rvs = $rvs::whereBetween('rv_date',[$fromDate,$toDate])
					 ->where('voucherType','=','2')
					 ->get();
		
	?>
	<tr>
    	<td colspan="8">
		<?php if(Session::has('dataDelete')){?>
    		<div class="row">
		    	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">&nbsp;</div>
		    	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
		    		<div class="alert alert-danger"><span class="glyphicon glyphicon-ok"></span><em><?php echo session('dataDelete')?></em>
		    		</div>
		    	</div>
		    </div>
		<?php }?>
		<?php if(Session::has('dataRepost')){?>
    		<div class="row">
		    	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">&nbsp;</div>
		    	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
		    		<div class="alert alert-warning"><span class="glyphicon glyphicon-ok"></span><em><?php echo session('dataRepost')?></em>
		    		</div>
		    	</div>
		    </div>
		<?php }?>

		<?php if(Session::has('dataApprove')){?>
    		<div class="row">
		    	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">&nbsp;</div>
		    	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
		    		<div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em><?php echo session('dataApprove')?></em>
		    		</div>
		    	</div>
		    </div>
		<?php }?>

		<?php if(Session::has('dataEdit')){?>
    		<div class="row">
		    	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">&nbsp;</div>
		    	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
		    		<div class="alert alert-info"><span class="glyphicon glyphicon-ok"></span><em><?php echo session('dataEdit')?></em>
		    		</div>
		    	</div>
		    </div>
		<?php }?>
		</td>
	</tr>
	<?php
		foreach ($rvs as $row1) {
	?>
		<tr>
			<td class="text-center"><?php echo $counter++;?></td>
			<td class="text-center"><?php echo $row1['rv_no'];?></td>
			<td class="text-center"><?php echo Helpers::changeDateFormat($row1['rv_date']);?></td>
			<td class="text-center">
				<?php 
					$d_acc = DB::selectOne('select accounts.name name from `rv_data` 
					inner join `accounts` on accounts.id = rv_data.acc_id where rv_data.debit_credit = 1 and rv_data.rv_no = \''.$row1['rv_no'].'\'')->name;				
					
					$c_acc = DB::selectOne('select accounts.name name from `rv_data` 
					inner join `accounts` on accounts.id = rv_data.acc_id where rv_data.debit_credit = 0 and rv_data.rv_no = \''.$row1['rv_no'].'\'')->name;				
																			
					$debit_amount = DB::selectOne("select sum(`amount`) total from `rv_data` where `debit_credit` = 1 and `rv_no` = '".$row1['rv_no']."'")->total;
																			
					$credit_amount = DB::selectOne("select sum(`amount`) total from `rv_data` where `debit_credit` = 0 and `rv_no` = '".$row1['rv_no']."'")->total;				
					echo 'Dr = '.$d_acc.'['.number_format($debit_amount,0).'] / Cr = '.$c_acc.'['.number_format($credit_amount,0).']';		
				?>
			</td>
			<td class="text-center"><?php Helpers::checkVoucherStatus($row1['rv_status'],$row1['status']);?></td>
			<td class="text-right">
				<?php $makeTotalAmount += $debit_amount;?>
				<?php echo number_format($debit_amount,0);?>
			</td>
			<td class="text-right">
				<?php echo number_format($makeTotalAmount,0);?>
			</td>
			<td class="text-center">
				<a onclick="showDetailModelOneParamerter('fdc/viewBankReceiptVoucherDetail','<?php echo $row1['rv_no'];?>','View Bank R.V Detail')" class="btn btn-xs btn-success"><span class="glyphicon glyphicon-eye-open"></span></a>
				
				<?php Helpers::changeActionButtons($m,$row1['rv_status'],$row1['status'],$row1['rv_no'],'rv_no','rv_status','status','finance/editBankReceiptVoucherForm','Bank R.V. Edit Detail Form');?>
			</td>
		</tr>
	<?php
		}
	?>	
		<script type="text/javascript">
			setTimeout(function() {
        		$('.alert-danger').fadeOut('fast');
        	}, 500);

        	setTimeout(function() {
        		$('.alert-warning').fadeOut('fast');
        	}, 500);

        	setTimeout(function() {
        		$('.alert-success').fadeOut('fast');
        	}, 500);

        	setTimeout(function() {
        		$('.alert-info').fadeOut('fast');
        	}, 500);
		</script>
	<?php
		Helpers::reconnectMasterDatabase();
	}
	
  public function filterViewLedgerReport(){
    $fromDate = $_GET['fromDate'];
    $toDate = $_GET['toDate'];
    $m = $_GET['m'];
    $account_id = $_GET['account_id'];
    $counter = 1;
    $makeTotalAmount = 0;
    Helpers::companyDatabaseConnection($_GET['m']);
    
    $transactions = new Transactions;
    $transactions = $transactions::whereBetween('v_date',[$fromDate,$toDate])
           ->where('status','=','1')
           ->where('acc_id','=',$account_id)
           ->get();
    return view('finance.filterViewLedgerReport',compact('transactions','fromDate','toDate'));
    Helpers::reconnectMasterDatabase();
  }
	
	
}
