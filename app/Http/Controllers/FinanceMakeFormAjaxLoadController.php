<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Input;
use Auth;
use DB;
use Config;
use Helpers;
use App\Models\Account;
class FinanceMakeFormAjaxLoadController extends Controller
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
	 
	public function addMoreCashPvsDetailRows(){
		Helpers::companyDatabaseConnection($_GET['m']);
		$_GET['id'];
		$_GET['counter'];
		$accounts = new Account;
		$accounts = $accounts::orderBy('level1', 'ASC')
    				->orderBy('level2', 'ASC')
					->orderBy('level3', 'ASC')
					->orderBy('level4', 'ASC')
					->orderBy('level5', 'ASC')
					->orderBy('level6', 'ASC')
					->orderBy('level7', 'ASC')
    				->get();
	?>
		<tr id="removePvsRows_<?php echo $_GET['id']?>_<?php echo $_GET['counter']?>">
			<input type="hidden" name="pvsDataSection_<?php echo $_GET['id']?>[]" class="form-control requiredField" id="pvsDataSection_<?php echo $_GET['id']?>" value="<?php echo $_GET['counter']?>" />
			<td>
				<select class="form-control requiredField" name="account_id_<?php echo $_GET['id']?>_<?php echo $_GET['counter']?>" id="account_id_<?php echo $_GET['id']?>_<?php echo $_GET['counter']?>">
					<option value="">Select Account</option>
					<?php foreach($accounts as $row){?>
						<option value="<?php echo $row['id'];?>"><?php echo $row['code'];?> ---- <?php echo $row['name'];?></option>
					<?php }?>
				</select>
			</td>
			<td>
				<input placeholder="Debit" class="form-control d_amount_<?php echo $_GET['id']?> requiredField" maxlength="15" min="0" type="number" name="d_amount_<?php echo $_GET['id']?>_<?php echo $_GET['counter'] ?>" id="d_amount_<?php echo $_GET['id']?>_<?php echo $_GET['counter'] ?>" value="" onfocus="mainDisable('c_amount_<?php echo $_GET['id']?>_<?php echo $_GET['counter'] ?>','d_amount_<?php echo $_GET['id']?>_<?php echo $_GET['counter'] ?>');" onkeyup="sum('<?php echo $_GET['id']?>')" required="required"/>
			</td>
			<td>
				<input placeholder="Credit" class="form-control c_amount_<?php echo $_GET['id']?> requiredField" maxlength="15" min="0" type="number" name="c_amount_<?php echo $_GET['id']?>_<?php echo $_GET['counter'] ?>" id="c_amount_<?php echo $_GET['id']?>_<?php echo $_GET['counter'] ?>" value="" onfocus="mainDisable('d_amount_<?php echo $_GET['id']?>_<?php echo $_GET['counter'] ?>','c_amount_<?php echo $_GET['id']?>_<?php echo $_GET['counter'] ?>');" onkeyup="sum('<?php echo $_GET['id']?>')" required="required"/>
			</td>
			<td class="text-center"><a href="#" onclick="removePvsRows('<?php echo $_GET['id']?>','<?php echo $_GET['counter']?>'),sum('<?php echo $_GET['id']?>')" class="btn btn-xs btn-danger">Remove</a></td>
		</tr>
	<?php
	}
	 
	public function makeFormCashPaymentVoucher(){
	 	Helpers::companyDatabaseConnection($_GET['m']);
		$_GET['id'];
		$currentDate = date('Y-m-d');
		$accounts = new Account;
		$accounts = $accounts::orderBy('level1', 'ASC')
    				->orderBy('level2', 'ASC')
					->orderBy('level3', 'ASC')
					->orderBy('level4', 'ASC')
					->orderBy('level5', 'ASC')
					->orderBy('level6', 'ASC')
					->orderBy('level7', 'ASC')
    				->get();
	?>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<input type="hidden" name="pvsSection[]" id="pvsSection" class="form-control requiredField" value="<?php echo $_GET['id'];?>" />
			</div>		
		</div>
		<div class="row">
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<label class="sf-label">Slip No.</label>
						<input type="text" class="form-control requiredField" placeholder="Slip No" name="slip_no_<?php echo $_GET['id']?>" id="slip_no_<?php echo $_GET['id']?>" value="" />
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<label class="sf-label">PV Date.</label>
						 <span class="rflabelsteric"><strong>*</strong></span>
						<input type="date" class="form-control requiredField" max="<?php echo date('Y-m-d') ?>" name="pv_date_<?php echo $_GET['id']?>" id="pv_date_<?php echo $_GET['id']?>" value="<?php echo date('Y-m-d') ?>" />
					</div>
				</div>	
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<label class="sf-label">Description</label>
						 <span class="rflabelsteric"><strong>*</strong></span>
						<textarea name="description_<?php echo $_GET['id']?>" id="description_<?php echo $_GET['id']?>" style="resize:none;" class="form-control requiredField"></textarea>
					</div>
				</div>
			</div>
		</div>
		<div class="lineHeight">&nbsp;</div>
		<div class="well">
			<div class="panel">
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="table-responsive">
								<table id="buildyourform" class="table table-bordered  sf-table-th sf-table-form-padding">
									<thead>
										<tr>
											<th class="text-center">Account Head <span class="rflabelsteric"><strong>*</strong></span></th>
											<th class="text-center" style="width:150px;">Debit <span class="rflabelsteric"><strong>*</strong></span></th>
											<th class="text-center" style="width:150px;">Credit <span class="rflabelsteric"><strong>*</strong></span></th>
											<th class="text-center" style="width:150px;">Action</th>
										</tr>
									</thead>
									<tbody class="addMorePvsDetailRows_<?php echo $_GET['id']?>" id="addMorePvsDetailRows_<?php echo $_GET['id']?>">
										<?php for($j = 1 ; $j <= 2 ; $j++){?>
										<input type="hidden" name="pvsDataSection_<?php echo $_GET['id']?>[]" class="form-control" id="pvsDataSection_<?php echo $_GET['id']?>" value="<?php echo $j?>" />
										<tr>
											<td>
												<select class="form-control requiredField" name="account_id_<?php echo $_GET['id']?>_<?php echo $j?>" id="account_id_<?php echo $_GET['id']?>_<?php echo $j?>">
													<option value="">Select Account</option>
													<?php foreach($accounts as $row){?>
														<option value="<?php echo $row['id'];?>"><?php echo $row['code'];?> ---- <?php echo $row['name'];?></option>
													<?php }?>
												</select>
											</td>
											<td>
												<input placeholder="Debit" class="form-control requiredField d_amount_<?php echo $_GET['id']?>" maxlength="15" min="0" type="number" name="d_amount_<?php echo $_GET['id']?>_<?php echo $j ?>" id="d_amount_<?php echo $_GET['id']?>_<?php echo $j ?>" value="" onfocus="mainDisable('c_amount_<?php echo $_GET['id']?>_<?php echo $j ?>','d_amount_<?php echo $_GET['id']?>_<?php echo $j ?>');" onkeyup="sum('<?php echo $_GET['id']?>')" required="required"/>
											</td>
											<td>
												<input placeholder="Credit" class="form-control requiredField c_amount_<?php echo $_GET['id']?>" maxlength="15" min="0" type="number" name="c_amount_<?php echo $_GET['id']?>_<?php echo $j ?>" id="c_amount_<?php echo $_GET['id']?>_<?php echo $j ?>" value="" onfocus="mainDisable('d_amount_<?php echo $_GET['id']?>_<?php echo $j ?>','c_amount_<?php echo $_GET['id']?>_<?php echo $j ?>');" onkeyup="sum('<?php echo $_GET['id']?>')" required="required"/>
											</td>
											<td class="text-center">---</td>
										</tr>
										<?php }?>
									</tbody>
								</table>
								<table class="table table-bordered">
									<tbody>
										<tr>
											<td></td>
											<td style="width:150px;">
												<input 
												type="number"
												readonly="readonly"
												id="d_t_amount_<?php echo $_GET['id']?>"
												maxlength="15"
												min="0"
												name="d_t_amount_<?php echo $_GET['id']?>" 
												class="form-control requiredField text-right"
												value=""/>
											</td>
											<td style="width:150px;">
												<input 
												type="number"
												readonly="readonly"
												id="c_t_amount_<?php echo $_GET['id']?>"
												maxlength="15"
												min="0"
												name="c_t_amount_<?php echo $_GET['id']?>" 
												class="form-control requiredField text-right"
												value=""/>
											</td>
											<td style="width:150px;"></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
				<input type="button" class="btn btn-sm btn-primary" onclick="addMorePvsDetailRows('<?php echo $_GET['id']?>')" value="Add More PV's Rows" />
			</div>
		</div>
	<?php
	}
	
	
	
	
	public function addMoreBankPvsDetailRows(){
		Helpers::companyDatabaseConnection($_GET['m']);
		$_GET['id'];
		$_GET['counter'];
		$accounts = new Account;
		$accounts = $accounts::orderBy('level1', 'ASC')
    				->orderBy('level2', 'ASC')
					->orderBy('level3', 'ASC')
					->orderBy('level4', 'ASC')
					->orderBy('level5', 'ASC')
					->orderBy('level6', 'ASC')
					->orderBy('level7', 'ASC')
    				->get();
	?>
		<tr id="removePvsRows_<?php echo $_GET['id']?>_<?php echo $_GET['counter']?>">
			<input type="hidden" name="pvsDataSection_<?php echo $_GET['id']?>[]" class="form-control" id="pvsDataSection_<?php echo $_GET['id']?>" value="<?php echo $_GET['counter']?>" />
			<td>
				<select class="form-control" name="account_id_<?php echo $_GET['id']?>_<?php echo $_GET['counter']?>" id="account_id_<?php echo $_GET['id']?>_<?php echo $_GET['counter']?>">
					<option value="">Select Account</option>
					<?php foreach($accounts as $row){?>
						<option value="<?php echo $row['id'];?>"><?php echo $row['code'];?> ---- <?php echo $row['name'];?></option>
					<?php }?>
				</select>
			</td>
			<td>
				<input placeholder="Debit" class="form-control" maxlength="15" min="0" type="number" name="d_amount_<?php echo $_GET['id']?>_<?php echo $_GET['counter'] ?>" id="d_amount_<?php echo $_GET['id']?>_<?php echo $_GET['counter'] ?>" value="" onfocus="disable('c_amount_<?php echo $_GET['id']?>_<?php echo $_GET['counter'] ?>','d_amount_<?php echo $_GET['id']?>_<?php echo $_GET['counter'] ?>');" required="required"/>
			</td>
			<td>
				<input placeholder="Credit" class="form-control" maxlength="15" min="0" type="number" name="c_amount_<?php echo $_GET['id']?>_<?php echo $_GET['counter'] ?>" id="c_amount_<?php echo $_GET['id']?>_<?php echo $_GET['counter'] ?>" value="" onfocus="disable('d_amount_<?php echo $_GET['id']?>_<?php echo $_GET['counter'] ?>','c_amount_<?php echo $_GET['id']?>_<?php echo $_GET['counter'] ?>');" required="required"/>
			</td>
			<td class="text-center"><a href="#" onclick="removePvsRows('<?php echo $_GET['id']?>','<?php echo $_GET['counter']?>')" class="btn btn-xs btn-danger">Remove</a></td>
		</tr>
	<?php
	}
	 
	public function makeFormBankPaymentVoucher(){
	 	Helpers::companyDatabaseConnection($_GET['m']);
		$_GET['id'];
		$currentDate = date('Y-m-d');
		$accounts = new Account;
		$accounts = $accounts::orderBy('level1', 'ASC')
    				->orderBy('level2', 'ASC')
					->orderBy('level3', 'ASC')
					->orderBy('level4', 'ASC')
					->orderBy('level5', 'ASC')
					->orderBy('level6', 'ASC')
					->orderBy('level7', 'ASC')
    				->get();
	?>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<input type="hidden" name="pvsSection[]" id="pvsSection" class="form-control" value="<?php echo $_GET['id'];?>" />
			</div>		
		</div>
		<div class="row">
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<label class="sf-label">Slip No.</label>
						<span style="font-size:17px !important; color:#F5F5F5 !important;"><strong>*</strong></span>
						<input type="text" class="form-control" placeholder="Slip No" name="slip_no_<?php echo $_GET['id']?>" id="slip_no_<?php echo $_GET['id']?>" value="" />
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<label class="sf-label">PV Date.</label>
						<span style="font-size:17px !important; color:#F5F5F5 !important;"><strong>*</strong></span>
						<input type="date" class="form-control" max="<?php echo date('Y-m-d') ?>" name="pv_date_<?php echo $_GET['id']?>" id="pv_date_<?php echo $_GET['id']?>" value="<?php echo date('Y-m-d') ?>" />
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<label class="sf-label">Cheque No.</label>
						<span style="font-size:17px !important; color:#F5F5F5 !important;"><strong>*</strong></span>
						<input type="text" class="form-control" placeholder="Cheque No" name="cheque_no_<?php echo $_GET['id']?>" id="cheque_no_<?php echo $_GET['id']?>" value="" />
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<label class="sf-label">Cheque Date.</label>
						<span style="font-size:17px !important; color:#F5F5F5 !important;"><strong>*</strong></span>
						<input type="date" class="form-control" max="<?php echo date('Y-m-d') ?>" name="cheque_date_<?php echo $_GET['id']?>" id="cheque_date_<?php echo $_GET['id']?>" value="<?php echo date('Y-m-d') ?>" />
					</div>
				</div>	
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<label class="sf-label">Description</label>
						<span style="font-size:17px !important; color:#F00 !important;"><strong>*</strong></span>
						<textarea name="description_<?php echo $_GET['id']?>" id="description_<?php echo $_GET['id']?>" style="resize:none;" class="form-control"></textarea>
					</div>
				</div>
			</div>
		</div>
		<div class="lineHeight">&nbsp;</div>
		<div class="well">
			<div class="panel">
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="table-responsive">
								<table id="buildyourform" class="table table-bordered  sf-table-th sf-table-form-padding">
									<thead>
										<tr>
											<th class="text-center">Account Head<span style="font-size:17px !important; color:#F00 !important;"><strong>*</strong></span></th>
											<th class="text-center" style="width:150px;">Debit<span style="font-size:17px !important; color:#F00 !important;"><strong>*</strong></span></th>
											<th class="text-center" style="width:150px;">Credit<span style="font-size:17px !important; color:#F00 !important;"><strong>*</strong></span></th>
											<th class="text-center" style="width:150px;">Action<span style="font-size:17px !important; color:#F00 !important;"><strong>*</strong></span></th>
										</tr>
									</thead>
									<tbody class="addMorePvsDetailRows_<?php echo $_GET['id']?>" id="addMorePvsDetailRows_<?php echo $_GET['id']?>">
										<?php for($j = 1 ; $j <= 2 ; $j++){?>
										<input type="hidden" name="pvsDataSection_<?php echo $_GET['id']?>[]" class="form-control" id="pvsDataSection_<?php echo $_GET['id']?>" value="<?php echo $j?>" />
										<tr>
											<td>
												<select class="form-control" name="account_id_<?php echo $_GET['id']?>_<?php echo $j?>" id="account_id_<?php echo $_GET['id']?>_<?php echo $j?>">
													<option value="">Select Account</option>
													<?php foreach($accounts as $row){?>
														<option value="<?php echo $row['id'];?>"><?php echo $row['code'];?> ---- <?php echo $row['name'];?></option>
													<?php }?>
												</select>
											</td>
											<td>
												<input placeholder="Debit" class="form-control" maxlength="15" min="0" type="number" name="d_amount_<?php echo $_GET['id']?>_<?php echo $j ?>" id="d_amount_<?php echo $_GET['id']?>_<?php echo $j ?>" value="" onfocus="disable('c_amount_<?php echo $_GET['id']?>_<?php echo $j ?>','d_amount_<?php echo $_GET['id']?>_<?php echo $j ?>');" required="required"/>
											</td>
											<td>
												<input placeholder="Credit" class="form-control" maxlength="15" min="0" type="number" name="c_amount_<?php echo $_GET['id']?>_<?php echo $j ?>" id="c_amount_<?php echo $_GET['id']?>_<?php echo $j ?>" value="" onfocus="disable('d_amount_<?php echo $_GET['id']?>_<?php echo $j ?>','c_amount_<?php echo $_GET['id']?>_<?php echo $j ?>');" required="required"/>
											</td>
											<td class="text-center">---</td>
										</tr>
										<?php }?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
				<input type="button" class="btn btn-sm btn-primary" onclick="addMorePvsDetailRows('<?php echo $_GET['id']?>')" value="Add More PV's Rows" />
			</div>
		</div>
	<?php
	}
	
	public function addMoreCashRvsDetailRows(){
		Helpers::companyDatabaseConnection($_GET['m']);
		$_GET['id'];
		$_GET['counter'];
		$accounts = new Account;
		$accounts = $accounts::orderBy('level1', 'ASC')
    				->orderBy('level2', 'ASC')
					->orderBy('level3', 'ASC')
					->orderBy('level4', 'ASC')
					->orderBy('level5', 'ASC')
					->orderBy('level6', 'ASC')
					->orderBy('level7', 'ASC')
    				->get();
	?>
		<tr id="removeRvsRows_<?php echo $_GET['id']?>_<?php echo $_GET['counter']?>">
			<input type="hidden" name="rvsDataSection_<?php echo $_GET['id']?>[]" class="form-control" id="rvsDataSection_<?php echo $_GET['id']?>" value="<?php echo $_GET['counter']?>" />
			<td>
				<select class="form-control" name="account_id_<?php echo $_GET['id']?>_<?php echo $_GET['counter']?>" id="account_id_<?php echo $_GET['id']?>_<?php echo $_GET['counter']?>">
					<option value="">Select Account</option>
					<?php foreach($accounts as $row){?>
						<option value="<?php echo $row['id'];?>"><?php echo $row['code'];?> ---- <?php echo $row['name'];?></option>
					<?php }?>
				</select>
			</td>
			<td>
				<input placeholder="Debit" class="form-control" maxlength="15" min="0" type="number" name="d_amount_<?php echo $_GET['id']?>_<?php echo $_GET['counter'] ?>" id="d_amount_<?php echo $_GET['id']?>_<?php echo $_GET['counter'] ?>" value="" onfocus="disable('c_amount_<?php echo $_GET['id']?>_<?php echo $_GET['counter'] ?>','d_amount_<?php echo $_GET['id']?>_<?php echo $_GET['counter'] ?>');" required="required"/>
			</td>
			<td>
				<input placeholder="Credit" class="form-control" maxlength="15" min="0" type="number" name="c_amount_<?php echo $_GET['id']?>_<?php echo $_GET['counter'] ?>" id="c_amount_<?php echo $_GET['id']?>_<?php echo $_GET['counter'] ?>" value="" onfocus="disable('d_amount_<?php echo $_GET['id']?>_<?php echo $_GET['counter'] ?>','c_amount_<?php echo $_GET['id']?>_<?php echo $_GET['counter'] ?>');" required="required"/>
			</td>
			<td class="text-center"><a href="#" onclick="removeRvsRows('<?php echo $_GET['id']?>','<?php echo $_GET['counter']?>')" class="btn btn-xs btn-danger">Remove</a></td>
		</tr>
	<?php
	}
	 
	public function makeFormCashReceiptVoucher(){
	 	Helpers::companyDatabaseConnection($_GET['m']);
		$_GET['id'];
		$currentDate = date('Y-m-d');
		$accounts = new Account;
		$accounts = $accounts::orderBy('level1', 'ASC')
    				->orderBy('level2', 'ASC')
					->orderBy('level3', 'ASC')
					->orderBy('level4', 'ASC')
					->orderBy('level5', 'ASC')
					->orderBy('level6', 'ASC')
					->orderBy('level7', 'ASC')
    				->get();
	?>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<input type="hidden" name="rvsSection[]" id="rvsSection" class="form-control" value="<?php echo $_GET['id'];?>" />
			</div>		
		</div>
		<div class="row">
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<label class="sf-label">Slip No.</label>
						<span style="font-size:17px !important; color:#F5F5F5 !important;"><strong>*</strong></span>
						<input type="text" class="form-control" placeholder="Slip No" name="slip_no_<?php echo $_GET['id']?>" id="slip_no_<?php echo $_GET['id']?>" value="" />
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<label class="sf-label">RV Date.</label>
						<span style="font-size:17px !important; color:#F5F5F5 !important;"><strong>*</strong></span>
						<input type="date" class="form-control" max="<?php echo date('Y-m-d') ?>" name="rv_date_<?php echo $_GET['id']?>" id="rv_date_<?php echo $_GET['id']?>" value="<?php echo date('Y-m-d') ?>" />
					</div>
				</div>	
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<label class="sf-label">Description</label>
						<span style="font-size:17px !important; color:#F00 !important;"><strong>*</strong></span>
						<textarea name="description_<?php echo $_GET['id']?>" id="description_<?php echo $_GET['id']?>" style="resize:none;" class="form-control"></textarea>
					</div>
				</div>
			</div>
		</div>
		<div class="lineHeight">&nbsp;</div>
		<div class="well">
			<div class="panel">
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="table-responsive">
								<table id="buildyourform" class="table table-bordered  sf-table-th sf-table-form-padding">
									<thead>
										<tr>
											<th class="text-center">Account Head<span style="font-size:17px !important; color:#F00 !important;"><strong>*</strong></span></th>
											<th class="text-center" style="width:150px;">Debit<span style="font-size:17px !important; color:#F00 !important;"><strong>*</strong></span></th>
											<th class="text-center" style="width:150px;">Credit<span style="font-size:17px !important; color:#F00 !important;"><strong>*</strong></span></th>
											<th class="text-center" style="width:150px;">Action<span style="font-size:17px !important; color:#F00 !important;"><strong>*</strong></span></th>
										</tr>
									</thead>
									<tbody class="addMoreRvsDetailRows_<?php echo $_GET['id']?>" id="addMoreRvsDetailRows_<?php echo $_GET['id']?>">
										<?php for($j = 1 ; $j <= 2 ; $j++){?>
										<input type="hidden" name="rvsDataSection_<?php echo $_GET['id']?>[]" class="form-control" id="rvsDataSection_<?php echo $_GET['id']?>" value="<?php echo $j?>" />
										<tr>
											<td>
												<select class="form-control" name="account_id_<?php echo $_GET['id']?>_<?php echo $j?>" id="account_id_<?php echo $_GET['id']?>_<?php echo $j?>">
													<option value="">Select Account</option>
													<?php foreach($accounts as $row){?>
														<option value="<?php echo $row['id'];?>"><?php echo $row['code'];?> ---- <?php echo $row['name'];?></option>
													<?php }?>
												</select>
											</td>
											<td>
												<input placeholder="Debit" class="form-control" maxlength="15" min="0" type="number" name="d_amount_<?php echo $_GET['id']?>_<?php echo $j ?>" id="d_amount_<?php echo $_GET['id']?>_<?php echo $j ?>" value="" onfocus="disable('c_amount_<?php echo $_GET['id']?>_<?php echo $j ?>','d_amount_<?php echo $_GET['id']?>_<?php echo $j ?>');" required="required"/>
											</td>
											<td>
												<input placeholder="Credit" class="form-control" maxlength="15" min="0" type="number" name="c_amount_<?php echo $_GET['id']?>_<?php echo $j ?>" id="c_amount_<?php echo $_GET['id']?>_<?php echo $j ?>" value="" onfocus="disable('d_amount_<?php echo $_GET['id']?>_<?php echo $j ?>','c_amount_<?php echo $_GET['id']?>_<?php echo $j ?>');" required="required"/>
											</td>
											<td class="text-center">---</td>
										</tr>
										<?php }?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
				<input type="button" class="btn btn-sm btn-primary" onclick="addMoreRvsDetailRows('<?php echo $_GET['id']?>')" value="Add More RV's Rows" />
			</div>
		</div>
	<?php
	}
	
	public function addMoreBankRvsDetailRows(){
		Helpers::companyDatabaseConnection($_GET['m']);
		$_GET['id'];
		$_GET['counter'];
		$accounts = new Account;
		$accounts = $accounts::orderBy('level1', 'ASC')
    				->orderBy('level2', 'ASC')
					->orderBy('level3', 'ASC')
					->orderBy('level4', 'ASC')
					->orderBy('level5', 'ASC')
					->orderBy('level6', 'ASC')
					->orderBy('level7', 'ASC')
    				->get();
	?>
		<tr id="removeRvsRows_<?php echo $_GET['id']?>_<?php echo $_GET['counter']?>">
			<input type="hidden" name="rvsDataSection_<?php echo $_GET['id']?>[]" class="form-control" id="rvsDataSection_<?php echo $_GET['id']?>" value="<?php echo $_GET['counter']?>" />
			<td>
				<select class="form-control" name="account_id_<?php echo $_GET['id']?>_<?php echo $_GET['counter']?>" id="account_id_<?php echo $_GET['id']?>_<?php echo $_GET['counter']?>">
					<option value="">Select Account</option>
					<?php foreach($accounts as $row){?>
						<option value="<?php echo $row['id'];?>"><?php echo $row['code'];?> ---- <?php echo $row['name'];?></option>
					<?php }?>
				</select>
			</td>
			<td>
				<input placeholder="Debit" class="form-control" maxlength="15" min="0" type="number" name="d_amount_<?php echo $_GET['id']?>_<?php echo $_GET['counter'] ?>" id="d_amount_<?php echo $_GET['id']?>_<?php echo $_GET['counter'] ?>" value="" onfocus="disable('c_amount_<?php echo $_GET['id']?>_<?php echo $_GET['counter'] ?>','d_amount_<?php echo $_GET['id']?>_<?php echo $_GET['counter'] ?>');" required="required"/>
			</td>
			<td>
				<input placeholder="Credit" class="form-control" maxlength="15" min="0" type="number" name="c_amount_<?php echo $_GET['id']?>_<?php echo $_GET['counter'] ?>" id="c_amount_<?php echo $_GET['id']?>_<?php echo $_GET['counter'] ?>" value="" onfocus="disable('d_amount_<?php echo $_GET['id']?>_<?php echo $_GET['counter'] ?>','c_amount_<?php echo $_GET['id']?>_<?php echo $_GET['counter'] ?>');" required="required"/>
			</td>
			<td class="text-center"><a href="#" onclick="removeRvsRows('<?php echo $_GET['id']?>','<?php echo $_GET['counter']?>')" class="btn btn-xs btn-danger">Remove</a></td>
		</tr>
	<?php
	}
	 
	public function makeFormBankReceiptVoucher(){
	 	Helpers::companyDatabaseConnection($_GET['m']);
		$_GET['id'];
		$currentDate = date('Y-m-d');
		$accounts = new Account;
		$accounts = $accounts::orderBy('level1', 'ASC')
    				->orderBy('level2', 'ASC')
					->orderBy('level3', 'ASC')
					->orderBy('level4', 'ASC')
					->orderBy('level5', 'ASC')
					->orderBy('level6', 'ASC')
					->orderBy('level7', 'ASC')
    				->get();
	?>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<input type="hidden" name="rvsSection[]" id="rvsSection" class="form-control" value="<?php echo $_GET['id'];?>" />
			</div>		
		</div>
		<div class="row">
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<label class="sf-label">Slip No.</label>
						<span style="font-size:17px !important; color:#F5F5F5 !important;"><strong>*</strong></span>
						<input type="text" class="form-control" placeholder="Slip No" name="slip_no_<?php echo $_GET['id']?>" id="slip_no_<?php echo $_GET['id']?>" value="" />
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<label class="sf-label">RV Date.</label>
						<span style="font-size:17px !important; color:#F5F5F5 !important;"><strong>*</strong></span>
						<input type="date" class="form-control" max="<?php echo date('Y-m-d') ?>" name="rv_date_<?php echo $_GET['id']?>" id="rv_date_<?php echo $_GET['id']?>" value="<?php echo date('Y-m-d') ?>" />
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<label class="sf-label">Cheque No.</label>
						<span style="font-size:17px !important; color:#F5F5F5 !important;"><strong>*</strong></span>
						<input type="text" class="form-control" placeholder="Cheque No" name="cheque_no_<?php echo $_GET['id']?>" id="cheque_no_<?php echo $_GET['id']?>" value="" />
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<label class="sf-label">Cheque Date.</label>
						<span style="font-size:17px !important; color:#F5F5F5 !important;"><strong>*</strong></span>
						<input type="date" class="form-control" max="<?php echo date('Y-m-d') ?>" name="cheque_date_<?php echo $_GET['id']?>" id="cheque_date_<?php echo $_GET['id']?>" value="<?php echo date('Y-m-d') ?>" />
					</div>
				</div>	
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<label class="sf-label">Description</label>
						<span style="font-size:17px !important; color:#F00 !important;"><strong>*</strong></span>
						<textarea name="description_<?php echo $_GET['id']?>" id="description_<?php echo $_GET['id']?>" style="resize:none;" class="form-control"></textarea>
					</div>
				</div>
			</div>
		</div>
		<div class="lineHeight">&nbsp;</div>
		<div class="well">
			<div class="panel">
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="table-responsive">
								<table id="buildyourform" class="table table-bordered  sf-table-th sf-table-form-padding">
									<thead>
										<tr>
											<th class="text-center">Account Head<span style="font-size:17px !important; color:#F00 !important;"><strong>*</strong></span></th>
											<th class="text-center" style="width:150px;">Debit<span style="font-size:17px !important; color:#F00 !important;"><strong>*</strong></span></th>
											<th class="text-center" style="width:150px;">Credit<span style="font-size:17px !important; color:#F00 !important;"><strong>*</strong></span></th>
											<th class="text-center" style="width:150px;">Action<span style="font-size:17px !important; color:#F00 !important;"><strong>*</strong></span></th>
										</tr>
									</thead>
									<tbody class="addMoreRvsDetailRows_<?php echo $_GET['id']?>" id="addMoreRvsDetailRows_<?php echo $_GET['id']?>">
										<?php for($j = 1 ; $j <= 2 ; $j++){?>
										<input type="hidden" name="rvsDataSection_<?php echo $_GET['id']?>[]" class="form-control" id="rvsDataSection_<?php echo $_GET['id']?>" value="<?php echo $j?>" />
										<tr>
											<td>
												<select class="form-control" name="account_id_<?php echo $_GET['id']?>_<?php echo $j?>" id="account_id_<?php echo $_GET['id']?>_<?php echo $j?>">
													<option value="">Select Account</option>
													<?php foreach($accounts as $row){?>
														<option value="<?php echo $row['id'];?>"><?php echo $row['code'];?> ---- <?php echo $row['name'];?></option>
													<?php }?>
												</select>
											</td>
											<td>
												<input placeholder="Debit" class="form-control" maxlength="15" min="0" type="number" name="d_amount_<?php echo $_GET['id']?>_<?php echo $j ?>" id="d_amount_<?php echo $_GET['id']?>_<?php echo $j ?>" value="" onfocus="disable('c_amount_<?php echo $_GET['id']?>_<?php echo $j ?>','d_amount_<?php echo $_GET['id']?>_<?php echo $j ?>');" required="required"/>
											</td>
											<td>
												<input placeholder="Credit" class="form-control" maxlength="15" min="0" type="number" name="c_amount_<?php echo $_GET['id']?>_<?php echo $j ?>" id="c_amount_<?php echo $_GET['id']?>_<?php echo $j ?>" value="" onfocus="disable('d_amount_<?php echo $_GET['id']?>_<?php echo $j ?>','c_amount_<?php echo $_GET['id']?>_<?php echo $j ?>');" required="required"/>
											</td>
											<td class="text-center">---</td>
										</tr>
										<?php }?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
				<input type="button" class="btn btn-sm btn-primary" onclick="addMoreRvsDetailRows('<?php echo $_GET['id']?>')" value="Add More RV's Rows" />
			</div>
		</div>
	<?php
	}
	 
}