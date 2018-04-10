<?php $accType = Auth::user()->acc_type;?>
@extends('layouts.default')

@section('content')
	<div class="well">
		<div class="panel">
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
						@include('Hr.'.$accType.'hrMenu')
					</div>
					<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
						<div class="well">
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<span class="subHeadingLabelClass">View Employee List</span>
								</div>
							</div>
							<div class="lineHeight">&nbsp;</div>
							<div class="panel">
								<div class="panel-body">
									<div class="row">
										<div class="col-lg-12 col-md-12 col-sm-12col-xs-12">
											<div class="table-responsive">
												<table class="table table-bordered sf-table-list">
   													<thead>
														<th class="text-center col-sm-1">S.No</th>   
                                        				<th class="text-center col-sm-1">Emp.No</th>        
														<th class="text-center">Name</th>
														<th class="text-center">Contact No</th>
														<th class="text-center">Email</th>
														<th class="text-center">Salary</th>
														<th class="text-center col-sm-1">Action</th>
													</thead>
													<tbody>
														<?php $counter = 1;?>
														@foreach($employees as $key => $y)
															<tr>
																<td class="text-center"><?php echo $counter++;?></td>
																<td>{{ $y->emp_no}}</td>
																<td>{{ $y->emp_name}}</td>
																<td class="text-center">{{ $y->emp_contact_no}}</td>
																<td>{{ $y->emp_email}}</td>
																<td class="text-right"><?php echo number_format($y->emp_salary);?></td>
																<td class="text-center">
																	<a onclick="showDetailModelOneParamerter('hdc/viewEmployeeDetail','<?php echo $y->id;?>','View Employee Detail')" class="btn btn-xs btn-success">View</a>
																</td>
															</tr>
														@endforeach
													</tbody>
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
	</div>
@endsection