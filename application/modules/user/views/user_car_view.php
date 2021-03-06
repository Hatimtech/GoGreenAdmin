<?php

/* * ***********************
 * PAGE: TO Listing The User.
 * #COPYRIGHT: Ripenapps
 * @AUTHOR: vicky kashyap
 * CREATOR: 04/06/2018.
 * UPDATED: --/--/----.
 * codeigniter framework
 * *** */
?>
<style>
.x_title span {
    color: #607D8B;
}
.for_hover:hover
{
  text-decoration: underline;
}
</style>
<style>
#datatable-responsive_paginate{
  display:none !important;

}
</style>
<a href="<?php echo base_url().$back; ?>" style="display:flex; align-items:center; position: absolute; top: 3px; left: 255px; color:#4caf50;"><i class="fa fa-long-arrow-left" style="font-size: 31px; color: #4caf50; margin-right:9px;"></i>Back</a>
<div class="right_col" role="main">
  <div class="page-title">
    <div class="title_left">
      <h3><?php if(!empty($personal_detail))
            {
              // print_r($personal_detail); die;
              echo $personal_detail['name'];
            }?></h3>
    </div>
    <div class="title_right">

    </div>
  </div>
  <div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <div class="row" style="text-align: center;">
            <div class="col-md-1">
              <!-- <a href="<?php echo base_url()?>user?page=0"><span class="fa fa-backward"></span></a> -->
            </div>
            <div class="col-md-3"><span class=" fa fa-user">&nbsp;&nbsp;&nbsp;&nbsp;</span><?php if(!empty($personal_detail))
            {
              // print_r($personal_detail); die;
              echo $personal_detail['t_name'];
            }?></div>
            <div class="col-md-3"><span class=" fa fa-envelope">&nbsp;&nbsp;&nbsp;&nbsp;</span><?php if(!empty($personal_detail))
            {
              echo $personal_detail['email'];
            }?></div>
            <div class="col-md-3" style=""><span class=" fa fa-phone">&nbsp;&nbsp;&nbsp;&nbsp;</span><?php if(!empty($personal_detail))
            {
              echo $personal_detail['phone_number'];
            }?></div>
          </div>

          <!-- <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="#">Settings 1</a>
                </li>
                <li><a href="#">Settings 2</a>
                </li>
              </ul>
            </li>
            <li><a class="close-link"><i class="fa fa-close"></i></a>
            </li>
          </ul> -->
          <div class="clearfix">

          </div>
        </div>
        <div class="x_content">
			<span style="color:green; display:none" id="myElem">
             <?php echo $this->session->flashdata('cancel_package');?>
            </span>
            <div class="row">

                <div class="col-md-4"></div>
                <div class="col-md-4">
                  <div class="row">
                    <ul style="background-color: #E1DFDE;" class="nav nav-tabs nav-justified">
                      <li style="background-color: #4caf50; font-size:15px; font-weight: 500;"><a href="#" style="color: #fff;">Cars</a></li>
                      <li><a href="<?php echo base_url('user/get_user_balance_details?id='.$user_id.'');?>">Account Statement</a></li>
                    </ul>

                  </div>



                </div>
                <div class="col-md-4"></div>

            </div>
          <table id="datatable" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>Brand</th>
                <th>Model</th>
                <th>Reg No</th>
                <th>Location</th>
                <th>Team</th>
                <th>Package</th>
                <th>Expiry Date</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>


            <tbody id="">
               <?php
              if(!empty($user_detail1))
              {
				  $currentDate= strtotime(date("Y-m-d"));
             //echo "<pre>"; print_r($user_detail); die;
                   foreach($user_detail1 as $key1 => $user_detail)
                   {
					   $i= 1;
				foreach($user_detail as $key => $ss)
                   {
					   //echo "<pre>"; print_r($user_detail); die;
					   if($i== 1){
                   // echo "<pre>";print_r(strtotime($user_detail[$key]['is_package'])); die;
      // if($user_detail[$key]['is_package']==2 && ($currentDate < strtotime($user_detail[$key]['expiry_date'])))
      if($user_detail[$key]['is_package']==2 )
                      {
                        $status = "Active";
                      }
                      else{
                        $status = "Inactive";
                      }
					  if($user_detail[$key]['expiry_date'] && $user_detail[$key]['is_package']==2){
						   $cancel = 'Cancel Package';
						  $url = base_url()."user/cancel_package?id=".$user_detail[$key]['package_id']."&u_id=".$user_detail[$key]['package_user_id'];
						  $url1 = "<a class='for_hover confirmation btn btn-warning to_inactive' href=".$url." >".$cancel."</a>";

					  }else{
						 // $cancel = 'NA';
						  $url1 = '<div class="btn btn-warning to_inactive">NA</div>';
					  }

                    //print_r($users); die;
                    echo"
                    <tr>
                     <td>".$user_detail[$key]['brand']."</td>
                     <td>".$user_detail[$key]['model']."</td>
                      <td>".$user_detail[$key]['reg_no']."</td>
                      <td>".$user_detail[$key]['city']."-".$user_detail[$key]['locality']."-".$user_detail[$key]['street']."</td>
                      <td>".$user_detail[$key]['team']."</td>
                      <td><a class='for_hover' href='".base_url()."user/purchase_history?id=".$user_detail[$key]['package_id']."&u_id=".$user_detail[$key]['package_user_id']."'>".$user_detail[$key]['package_type']."</a></td>
                      <td>".$user_detail[$key]['expiry_date']."</td>
                      <td>".$status."</td>
                      <td>".$url1."</td>
                    </tr>";
					   }
					$i++;
                   }

			  }
              }
              ?>



            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>






  <div class="row">



  </div>
</div>

<script type="text/javascript">
$("#myElem").show();
setTimeout(function() { $("#myElem").hide(); }, 5000);

    $('.confirmation').on('click', function () {
        return confirm('Are you sure want to cancel this package?');
    });
</script>
