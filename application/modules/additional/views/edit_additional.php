
<?php
/* * ***********************
 * PAGE: TO Add The packages.
 * #COPYRIGHT: Ripenapps
 * @AUTHOR: vicky kashyap
 * CREATOR: 04/07/2018.
 * UPDATED: --/--/----.
 * codeigniter framework
 * *** *********************/
?>
<a href="<?php echo base_url('additional'); ?>" style="display:flex; align-items:center; position: absolute; top: 3px; left: 255px; color:#4caf50;"><i class="fa fa-long-arrow-left" style="font-size: 31px; color: #4caf50; margin-right:9px;"></i>Back</a>
<div class="right_col" id="cool" role="main">
  <div class="page-title">
    <div class="title_left">
    </div>
    <div class="title_right">
    </div>
  </div>

  <div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
       <div class="x_title">
        <h2>Edit Clener </h2>
        <?php if($this->session->flashdata('phone_exist'))
          {
            //echo"alresdy exist";die;
            echo"<div style='margin-left: 150px;'>";
            echo"<font color='red'>Email Already Exist</font>";
            echo"</div>";
          }
          ?>

        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form method="post" action="<?php echo base_url()?>additional/edit_additional?id=<?php echo $additional['id'];?>" id="" data-parsley-validate class="form-horizontal form-label-left">
          <?php //print_r($additional); die;?>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="firstname">Service Name <!-- <span class="required">*</span> -->
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" value="<?php echo $additional['service_name']?>" id="service-name" name="service_name" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Service Price <!-- <span class="required">*</span> -->
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="number" step="0.01" min="0.01" required value="<?php echo $additional['price']?>" id="price" name="price" class="form-control col-md-7 col-xs-12">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Select Area <!-- <span class="required">*</span> -->
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">

              <select name="city" onchange="get_city(this.value)"  class="form-control" required>
                <option value="">Select</option>
                 <?php if($additional['cleaner_status']==2)// cleaner is not free or assiagned in another team
              {?>
                <option value="<?php echo $additional['city_id']?>"  selected><?php echo $additional['city']?></option>
              <?php }
              else
              {
                   // print_r($cities); die;


                foreach ($cities as $key => $value)
                    {

                      if($value['id']==$additional['city_id'])
                      {

                        $selected = 'selected';

                      }
                      else{

                        $selected='';
                      }

                      echo"<option ".$selected." value='".$value['id']."'>".$value['name']."</option>";
                    }
              }
               ?>


              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Select Building <!-- <span class="required">*</span> -->
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select  name="locality" id='locality_select'  class="form-control" required>
                <option value="">Select</option>
                <option value="<?php echo $additional['locality_id']?>"  selected><?php echo $additional['locality']?></option>
              </select>
            </div>
          </div>


          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
              <button type="submit" class="btn btn-success">Submit</button>
            </div>
          </div>
        </form>
      </div>
    </div><!--x panel-->
  </div>
</div>
</div>
<script>

 function get_city(val)
 {
  var city_id = val;
  // alert(city_id);

  $.ajax
  ({
    type : "POST",
    url : "<?php echo base_url(); ?>cleaner/get_locality",
    dataType : "json",
    data : {"city_id" : city_id},
    success : function(data)
    {
       $("#locality_select").html(data);
       console.log(data);
     },
     error : function(data) {
      alert('Something went wrong');
    }
  });
 }

</script>
