
<div class="right_col" role="main">


  <div class="row tile_count">


    <div class="col-md-4 col-sm-6 col-xs-12">
      <div class="x_panel ">
        <div class="x_title">
          <h2>Customers </h2>
<a href="#" onclick="history.go(-1);" style="display:none; align-items:center; position: absolute; top: 3px; left: 255px; color:#4caf50;"><i class="fa fa-long-arrow-left" style="font-size: 31px; color: #4caf50; margin-right:9px;"></i>Back</a>
          <div class="clearfix"></div>
        </div>
        <div class="row">
          <a href="<?php echo base_url('user');?>">
            <div class="col-md-12 text-center"><h1 id="number"><big><?php if($dashboard_data){ echo $dashboard_data['total_user'];} ?></big></h1></div>

          </a>
        </div>
      </div>
    </div>

    <div class="col-md-4 col-sm-6 col-xs-12">
      <div class="x_panel ">
        <div class="x_title">
          <h2>Cleaners </h2>

          <div class="clearfix"></div>
        </div>
        <div class="row">
        <a href="<?php echo base_url('cleaner');?>">
          <div class="col-md-12 text-center"><h1 id="number"><big><?php if($dashboard_data){ echo $dashboard_data['total_cleaners'];} ?></big></h1></div>
        </a>
        </div>
      </div>
    </div>

    <div class="col-md-4 col-sm-6 col-xs-12">
      <div class="x_panel ">
        <div class="x_title">
          <h2>Active Customers </h2>

          <div class="clearfix"></div>
        </div>
        <div class="row">

          <a href="<?php echo base_url('user/filter_function?flag=2');?>">
            <div class="col-md-12 text-center"><h1 id="number"><big><?php if($dashboard_data){ echo $dashboard_data['active_customer'];} ?></big></h1></div>
          </a>
        </div>
      </div>
    </div>
  </div>


  <div class="row tile_count">


    <div class="col-md-4 col-sm-6 col-xs-12">
      <div class="x_panel ">
        <div class="x_title">
          <h2>Cities </h2>

          <div class="clearfix"></div>
        </div>
        <div class="row">
           <a href="javascript:void(0);">
          <div class="col-md-12 text-center"><h1 id="number"><big><?php if($dashboard_data){echo $dashboard_data['total_city'];} ?></big></h1></div>
        </a>
        </div>
      </div>
    </div>

    <div class="col-md-4 col-sm-6 col-xs-12">
      <div class="x_panel ">
        <div class="x_title">
          <h2>Localities </h2>

          <div class="clearfix"></div>
        </div>
        <div class="row">
          <a href="javascript:void(0);">
          <div class="col-md-12 text-center"><h1 id="number"><big><?php if($dashboard_data){ echo $dashboard_data['total_locality'];} ?></big></h1></div>
        </a>
        </div>
      </div>
    </div>


    <div class="col-md-4 col-sm-6 col-xs-12">
      <div class="x_panel ">
        <div class="x_title">
          <h2>Packages </h2>

          <div class="clearfix"></div>
        </div>
        <div class="row">
          <a href="javascript:void(0);">
          <div class="col-md-12 text-center"><h1 id="number"><big><?php if($dashboard_data){echo $dashboard_data['total_packages'];} ?></big></h1></div>
        </a>
        </div>
      </div>
    </div>



  </div>



   <div class="col-md-4 col-sm-6 col-xs-12">
      <div class="x_panel ">
        <div class="x_title">
          <h2>Total Online Payment Collected</h2>

          <div class="clearfix"></div>
        </div>
        <div class="row">
           <a href="javascript:void(0);">
          <div class="col-md-12 text-center"><h1 id="number"><big><?php if($dashboard_data){echo number_format($dashboard_data['online_collected'], 2); } ?></big></h1></div>
        </a>
        </div>
      </div>
    </div>

     <div class="col-md-4 col-sm-6 col-xs-12">
      <div class="x_panel ">
        <div class="x_title">
          <h2>Total COD Collected</h2>

          <div class="clearfix"></div>
        </div>
        <div class="row">
           <a href="javascript:void(0);">
          <div class="col-md-12 text-center"><h1 id="number"><big><?php if($dashboard_data){echo number_format($dashboard_data['cod_collected'], 2);} ?></big></h1></div>
        </a>
        </div>
      </div>
    </div>

     <div class="col-md-4 col-sm-6 col-xs-12">
      <div class="x_panel ">
        <div class="x_title">
          <h2>Total COD Pending </h2>

          <div class="clearfix"></div>
        </div>
        <div class="row">
           <a href="<?php echo base_url('orders/index?cashtab=1')?>">
          <div class="col-md-12 text-center"><h1 id="number"><big><?php if($dashboard_data){echo number_format($dashboard_data['pending_cod'], 2);} ?></big></h1></div>
        </a>
        </div>
      </div>
    </div>










  <div class="row">



  </div>
</div>

<style>

#number
{

font-size: 50px;
margin-left: 50px;
margin-top: 10px;
}

</style>
