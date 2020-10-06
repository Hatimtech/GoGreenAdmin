
<style>
.for_hover:hover
{
 text-decoration: underline;
}
.edit{
  display: none;
}
.noedit{
  display: block;
}
.fa-pencil{
  cursor: pointer;
}
</style>
<a href="<?php echo base_url().'push_notification/'.$for; ?>" style="display:flex; align-items:center; position: absolute; top: 3px; left: 255px; color:#4caf50;"><i class="fa fa-long-arrow-left" style="font-size: 31px; color: #4caf50; margin-right:9px;"></i>Back</a>
<div class="right_col" id="cool" role="main">
  <div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <div class="row">
            <div class="col-md-3">
                <h2>Push Notification </h2>

            </div>

          </div>

          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <div class="col-md-12">
          <label for="">FCM Response</label>

          </div>
          <div class="col-md-12">
          <textarea name="name" rows="10" class="form-control"><?php echo $res; ?></textarea>

          </div>
          <div class="col-md-12 mt-2">
            <br><br>
            <a href="<?php echo base_url().'push_notification/'.$for; ?>" class="btn btn-primary">Back</a>
          </div>

        </div>
      </div>
    </div>
  </div>





  <div class="row">



  </div>
</div>
