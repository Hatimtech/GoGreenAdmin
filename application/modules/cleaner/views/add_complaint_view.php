
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
<a href="<?php echo base_url('cleaner/complaints'); ?>" style="display:flex; align-items:center; position: absolute; top: 3px; left: 255px; color:#4caf50;"><i class="fa fa-long-arrow-left" style="font-size: 31px; color: #4caf50; margin-right:9px;"></i>Back</a>
<div class="right_col" id="cool" role="main">
  <div>


    <div class="title_right">

    </div>
  </div>

  <div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
       <div class="x_title">
        <h2><?php echo $title; ?></h2>
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
      <?php

       ?>
      <div class="x_content">
        <form method="post" action="<?php echo base_url()?>cleaner/insert_complaint" id="" data-parsley-validate class="form-horizontal form-label-left">
          <input type="hidden" name="id" value="<?php echo (isset($_GET['id'])) ? $_GET['id'] : ''; ?>">
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="firstname">Complaint Title
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="first_name" name="title" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo (isset($complaint['title'])) ? $complaint['title'] : ''; ?>">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Complaint Content <!-- <span class="required">*</span> -->
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <textarea type="text" id="last-name" name="content" class="form-control col-md-7 col-xs-12"><?php echo (isset($complaint['content'])) ? $complaint['content'] : ''; ?></textarea>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Select Cleaner <!-- <span class="required">*</span> -->
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select name="cleaner_id" required class="form-control">
                <option value="" disabled selected>Select City</option>
                <?php
                  if(!empty($cleaners))
                  {
                    foreach ($cleaners as $key => $value) {
                      $sel = ($value['id'] == $complaint['cleaner_id']) ? 'selected' : '';
                      echo"<option value='".$value['id']."' $sel>".$value['first_name']." ".$value['last_name']."</option>";
                    }
                  }

                ?>
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
  //alert(city_id);

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
