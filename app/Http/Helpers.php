<?php 
	class Helpers{
		public static function test(){
			echo "hello";
		}

		public static function getCompanyName($param1){
			echo $companyName = DB::selectOne('select `name` from `company` where `id` = '.$param1.'')->name;
		}

		public static function dispalyVoucherAmountforEdit($param1,$param2,$param3,$param4,$param5,$param6){
			$dispalyAmountVoucher = DB::selectOne('select `amount` from '.$param2.' where `id` = '.$param6.' and `debit_credit` = '.$param5.'');
			if($dispalyAmountVoucher == ''){
				return '';
			}else{
				return $dispalyAmountVoucher->amount;
			}
		}

		public static function displayApproveDeleteRepostButton($param1,$param2,$param3,$param4,$param5,$param6,$param7){
			if($param5 == 'pv_no'){
				$tableOne = 'pvs';
				$tableTwo = 'pv_data';
			}else if($param5 == 'rv_no'){
				$tableOne = 'rvs';
				$tableTwo = 'rv_data';
			}
			if($param3 == 1 && $param2 == 1){
		?>
			<button class="delete-modal btn btn-xs btn-primary btn-xs" data-dismiss="modal" aria-hidden="true" onclick="approveCompanyFinanceTwoTableRecords('<?php echo $param1 ?>','<?php echo $param2;?>','<?php echo $param3 ?>','<?php echo $param4 ?>','<?php echo $param5 ?>','<?php echo $param6 ?>','<?php echo $param7 ?>','<?php echo $tableOne;?>','<?php echo $tableTwo;?>')">
                <span class="glyphicon glyphicon-ok"></span> Approve Voucher
           	</button>
			<button class="delete-modal btn btn-xs btn-danger btn-xs" data-dismiss="modal" aria-hidden="true" onclick="deleteCompanyFinanceTwoTableRecords('<?php echo $param1 ?>','<?php echo $param2;?>','<?php echo $param3 ?>','<?php echo $param4 ?>','<?php echo $param5 ?>','<?php echo $param6 ?>','<?php echo $param7 ?>','<?php echo $tableOne;?>','<?php echo $tableTwo;?>')">
                <span class="glyphicon glyphicon-trash"></span> Delete Voucher
           	</button>
		<?php
			}else if($param3 == 2 && $param2 == 1){
		?>
			<button class="delete-modal btn btn-xs btn-warning btn-xs" data-dismiss="modal" aria-hidden="true" onclick="repostCompanyFinanceTwoTableRecords('<?php echo $param1 ?>','<?php echo $param2;?>','<?php echo $param3 ?>','<?php echo $param4 ?>','<?php echo $param5 ?>','<?php echo $param6 ?>','<?php echo $param7 ?>','<?php echo $tableOne;?>','<?php echo $tableTwo;?>')">
                <span class="glyphicon glyphicon-edit"></span> Repost Voucher
           	</button>
		<?php
			}
		}

		public static function getAccountNameByAccId($param1,$param2){
			static::companyDatabaseConnection($param2);
			echo $accountName = DB::selectOne('select `name` from `accounts` where `id` = '.$param1.'')->name;
			static::reconnectMasterDatabase();
		}

		public static function getAccountCodeByAccId($param1,$param2){
			static::companyDatabaseConnection($param2);
			return $accountCode = DB::selectOne('select `code` from `accounts` where `id` = '.$param1.'')->code;
			static::reconnectMasterDatabase();
		}

		public static function companyDatabaseConnection($param1){
			$d = DB::selectOne('select `dbName` from `company` where `id` = '.$param1.'')->dbName;
			Config::set(['database.connections.tenant.database' => $d]);
			Config::set(['database.connections.tenant.username' => 'root']);
			Config::set('database.default', 'tenant');
			DB::reconnect('tenant');
		}

		public static function reconnectMasterDatabase(){
			Config::set('database.default', 'mysql');
			DB::reconnect('mysql');
		}

		public static function changeDateFormat($param1){
			$date = date_create($param1);
			echo date_format($date,"d-m-Y");
		}

		public static function checkVoucherStatus($param1,$param2){
			if($param1 == 1 && $param2 == 1){
				echo 'Pending';
			}else if($param2 == 2){
				echo 'Deleted';
			}else if($param2 == 3){
				echo 'Decline';
			}else if($param1 == 2 && $param2 == 1){
				echo 'Approve';
			}
		}

		public static function changeActionButtons($param1,$param2,$param3,$param4,$param5,$param6,$param7,$param8,$param9){
			if($param5 == 'pv_no'){
				$tableOne = 'pvs';
				$tableTwo = 'pv_data';
			}else if($param5 == 'rv_no'){
				$tableOne = 'rvs';
				$tableTwo = 'rv_data';
			}
		?>
			<?php
				if($param3 == 1 && $param2 == 1){
			?>
				<button class="edit-modal btn btn-xs btn-info" onclick="showMasterTableEditModel('<?php echo $param8;?>','<?php echo $param4 ?>','<?php echo $param9 ?>','<?php echo $param1?>')">
                	<span class="glyphicon glyphicon-edit"> P</span>
          		</button>
          		<button class="delete-modal btn btn-xs btn-danger btn-xs" onclick="deleteCompanyFinanceTwoTableRecords('<?php echo $param1 ?>','<?php echo $param2;?>','<?php echo $param3 ?>','<?php echo $param4 ?>','<?php echo $param5 ?>','<?php echo $param6 ?>','<?php echo $param7 ?>','<?php echo $tableOne; ?>','<?php echo $tableTwo;?>')">
                	<span class="glyphicon glyphicon-trash"> P</span>
           		</button>
			<?php
				}else if($param3 == 2 && $param2 == 1){
			?>
				<button class="delete-modal btn btn-xs btn-warning btn-xs" onclick="repostCompanyFinanceTwoTableRecords('<?php echo $param1 ?>','<?php echo $param2;?>','<?php echo $param3 ?>','<?php echo $param4 ?>','<?php echo $param5 ?>','<?php echo $param6 ?>','<?php echo $param7 ?>','<?php echo $tableOne; ?>','<?php echo $tableTwo;?>')">
                	<span class="glyphicon glyphicon-edit"> P</span>
           		</button>
			<?php
				}
			?>


			<?php
				if($param3 != 2 && $param2 == 2){
			?>
				<button class="edit-modal btn btn-xs btn-info" onclick="showMasterTableEditModel('<?php echo $param8;?>','<?php echo $param4 ?>','<?php echo $param9 ?>','<?php echo $param1?>')">
                	<span class="glyphicon glyphicon-edit"> A</span>
          		</button>
          		<button class="delete-modal btn btn-xs btn-danger btn-xs" onclick="deleteCompanyFinanceThreeTableRecords('<?php echo $param1 ?>','<?php echo $param2;?>','<?php echo $param3 ?>','<?php echo $param4 ?>','<?php echo $param5 ?>','<?php echo $param6 ?>','<?php echo $param7 ?>','<?php echo $tableOne; ?>','<?php echo $tableTwo;?>','transactions')">
                	<span class="glyphicon glyphicon-trash"> A</span>
           		</button>
			<?php
				}else if($param3 == 2 && $param2 == 2){
			?>
				<button class="delete-modal btn btn-xs btn-warning btn-xs" onclick="repostCompanyFinanceThreeTableRecords('<?php echo $param1 ?>','<?php echo $param2;?>','<?php echo $param3 ?>','<?php echo $param4 ?>','<?php echo $param5 ?>','<?php echo $param6 ?>','<?php echo $param7 ?>','<?php echo $tableOne; ?>','<?php echo $tableTwo;?>','transactions')">
                	<span class="glyphicon glyphicon-edit"> A</span>
           		</button>
			<?php
				}
			?>
		<?php
		}

	}
?>