@include('includes._normalUserNavigation')
<br />
<div class="container-fluid">
    <div class="well">
        <div class="panel">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="well">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <span class="subHeadingLabelClass">View Jobs List</span>
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
                                                        <th class="text-center">S.No</th>
                                                        <th class="text-center">Job Title</th>
                                                        <th class="text-center">Job Type</th>
                                                        <th class="text-center">Designation</th>
                                                        <th class="text-center">Qualification</th>
                                                        <th class="text-center">Shift Type</th>
                                                        <th class="text-center">Action</th>
                                                    </thead>
                                                    <tbody>
                                                        <?php $counter = 1;?>
                                                        <?php
                                                            $companyList = DB::select('select `name`,`dbName`,`id` from `company` where `status` = 1');
                                                            foreach($companyList as $row1){

                                                        ?>
                                                            <tr>
                                                                <td colspan="3"><?php echo $row1->name;?></td>
                                                                <td colspan="4"><?php echo $row1->dbName;?></td>
                                                            </tr>
                                                            <?php 
                                                                Config::set(['database.connections.tenant.database' => $row1->dbName]);
                                                                Config::set(['database.connections.tenant.username' => 'root']);
                                                                Config::set('database.default', 'tenant');
                                                                DB::reconnect('tenant');
                                                                $viewJobsList = DB::select('select * from `requesthiring` where `status` = 1 and `RequestHiringStatus` = 1');
                                                                Config::set('database.default', 'mysql');
                                                                DB::reconnect('mysql');
                                                                $counter2 = 1;
                                                                foreach ($viewJobsList as $row2) {
                                                                ?>
                                                                <tr>
                                                                    <td class="text-center"><?php echo $counter2++;?></td>
                                                                    <td><?php echo $row2->RequestHiringTitle;?></td>
                                                                    <td>
                                                                        <?php $JobTypes = DB::selectOne('select id,`job_type_name` from job_type where company_id = '.$row1->id.' and id ='.$row2->job_type_id.'');
                                                                        print_r($JobTypes->job_type_name);
                                                                        ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php $Designations = DB::selectOne('select id,`designation_name` from designation where company_id = '.$row1->id.' and id ='.$row2->designation_id.'');
                                                                        print_r($Designations->designation_name);
                                                                        ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php $Qualifications = DB::selectOne('select id,`qualification_name` from qualification where company_id = '.$row1->id.' and id ='.$row2->qualification_id.'');
                                                                        print_r($Qualifications->qualification_name);
                                                                        ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php $ShiftTypes = DB::selectOne('select id,`shift_type_name` from shift_type where company_id = '.$row1->id.' and id ='.$row2->shift_type_id.'');
                                                                        print_r($ShiftTypes->shift_type_name);
                                                                        ?>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <a onclick="showDetailModelOneParamerter('nu/ViewandApplyDetail','<?php echo $row2->id;?>','<?php echo $row1->id;?>','View and Apply Job Detail')" class="btn btn-xs btn-success">Apply Job</a>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                                }
                                                            ?>
                                                        <?php 
                                                            }
                                                        ?>
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
</div>
<script>
    function showDetailModelOneParamerter(url,id,m,modalName){
        $.ajax({
            url: '<?php echo url('/')?>/'+url+'',
            type: "GET",
            data: {id:id,m:m},
            success:function(data) {
                
                jQuery('#showDetailModelOneParamerter').modal('show', {backdrop: 'false'});
                jQuery('#showDetailModelOneParamerter .modalTitle').html(modalName);
                jQuery('#showDetailModelOneParamerter .modal-body').html('<div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><div class="loader"></div></div></div>');
                setTimeout(function(){
                    jQuery('#showDetailModelOneParamerter .modal-body').html(data);
                },1000);
                
                
            }
        });
    }
</script>
<div class="modal fade" id="showDetailModelOneParamerter">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style=" padding: 15px; background-color: #f7f7f7; border-bottom: 5px solid #9170E4; width: 100%;">
                <div class="row">
                    <div class="col-md-4 col-sm-1 col-xs-12 text-center">
                        <a style="float: left; font-size: 15px; 
                        color: #9170E4; margin-right:10px; margin: -9px 0px -31px 0px;" class="triangle-obtuse top">Logo Area</a>
                    </div>
                    <div class="col-md-4 col-sm-1 col-xs-12 text-center">
                        <span class="modalTitle subHeadingLabelClass"></span>
                    </div>
                    <div class="col-md-4 col-sm-1 col-xs-12 text-right">
                        <button type="button" class="btn btn-lg btn-danger" data-dismiss="modal" aria-hidden="true">Close</button>
                    </div>
                </div>
            </div>
            <div  class="modal-body"></div>
            <div class="modal-footer" style=" padding: 15px; background-color: #f7f7f7; border-top: 5px solid #9170E4; width: 100%;">
                <div class="row">
                    <div class="text-center">
                        &copy; <?php echo date('Y')?> Innovative-net.com |<a href="http://www.innovative-net.com/" target="_blank"  > Designed by : innovative-net.com</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>