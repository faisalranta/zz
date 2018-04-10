<?php $accType = Auth::user()->acc_type;?>
@extends('layouts.default')

@section('content')
	<div class="well">
		<div class="panel">
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
						@include('Finance.'.$accType.'financeMenu')
					</div>
					<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
						<div class="well">
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<span class="subHeadingLabelClass">View Chart of Account</span>
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
                                        				<th class="text-center col-sm-1">Code</th>        
														<th class="text-center">Account Name</th>
														<th class="text-center col-sm-1">Action</th>
													</thead>
													<tbody>
														<?php $counter = 1;?>
														@foreach($accounts as $key => $y)
															<?php
																$array = explode('-',$y->code);				
																$level = count($array);
															?>				
															
															<tr>
																<td class="text-center"><?php echo $counter++;?></td>
																<td>{{ $y->code}}</td>
																<td>
																	@if($level == 1)
																		{{ $y->name}}
																	@elseif($level == 2)
																		{{ '&emsp;&emsp;'. $y->name}}
																	@elseif($level == 3)
																		{{ '&emsp;&emsp;&emsp;&emsp;'. $y->name}}
																	@elseif($level == 4)
																		{{ '&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;'. $y->name}}			
																	@elseif($level == 5)
																		{{ '&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;'. $y->name}}						
																	@elseif($level == 6)
																		{{ '&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;'. $y->name}}									
																	@elseif($level == 7)
																		{{ '&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;'. $y->name}}
																	@endif
																</td>
																<td></td>
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