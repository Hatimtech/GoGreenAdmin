<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
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
<a href="<?php echo base_url('dashboard'); ?>" style="display:flex; align-items:center; position: absolute; top: 3px; left: 255px; color:#4caf50;"><i class="fa fa-long-arrow-left" style="font-size: 31px; color: #4caf50; margin-right:9px;"></i>Back</a>
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
          <form method="post" action="<?php echo base_url('push_notification/send')?>" id="pushForm">
            <input type="hidden" name="for" value="users">
            <div class="form-group">
              <input type="text" name="title" value="" placeholder="Notification Title" required class="form-control">
            </div>
            <div class="form-group">
              <textarea name="message" rows="8" class="form-control" required placeholder="Notification Message"></textarea>
            </div>
            <div class="form-group">
              <label class="text-danger">This field is for app testing only, will be removed when we move to live</label>
              <textarea name="additional" rows="8" class="form-control" required placeholder="Additional Data">{
 "'item_id" : "1",
 "item_type" : "package",
 "type_id" : "10"
}</textarea>
            </div>
            <div class="form-group">
              <label class="text-danger">Select one or more users or leave it blank to send push notification to all users</label>
              <select name="users[]" theme="google"  placeholder="Select Your Favorite" id="users" data-search="true"  class="form-control" multiple>

                <?php
                  if(!empty($users))
                  {
                    foreach ($users as $key => $value)
                    {
                      echo"<option value='".$value['device_type']."^".$value['device_token']."'>".$value['name']." (".$value['email'].")</option>";
                    }
                  }
                ?>
              </select>
            </div>
            <div class="form-group">
              <button class="btn btn-primary">Send Now</button>
            </div>
         </form>

        </div>
      </div>
    </div>
  </div>





  <div class="row">



  </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script type="text/javascript">
$("#users").select2({
  placeholder: "Select Users"
});
</script>
