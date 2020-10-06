<a href="./complaints" style="display:flex; align-items:center; position: absolute; top: 3px; left: 255px; color:#4caf50;"><i class="fa fa-long-arrow-left" style="font-size: 31px; color: #4caf50; margin-right:9px;"></i>Back</a>
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
#datatable-responsive_paginate{
  display:none !important;

}
.repliesDiv{
  max-height: 390px;
  border: 1px solid #ddd;
  padding: 15px;
  margin-bottom: 10px;
  border-radius: 5px;
  overflow: auto;
}
.reply{
  padding: 10px;
  background: #777777;
  margin-bottom: 10px;
  color: #ffffff;
  font-size: 16px;
  border-radius: 4px;
  width: fit-content;
  max-width: 80%;
  clear: both;
}
.reply h6{
  margin: 0;
  margin-top: 10px;
  font-size: 9px;
  font-weight: normal;
}
.sent{

}
.received{
  float: right;
  background: #1abb9c;
}
.select
{
    min-width: 48%;
    /*margin: 2px 0 10px 7px;*/
    padding: 4px;
}
.multiselect
{
  width: 65%;
}
.selectBox {
  position: relative;
}
.overSelect {
  position: absolute;
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
}
.btn .caret {
    margin-left: 0;
    float: right;
    text-align: right;
    margin: 9px 0 0 0;
}
.btn, .buttons, .modal-footer .btn+.btn, button {
    margin-bottom: 0px;
    margin-right: 0px;
}
.btn-group, .multiselect {
  width: 100%!important;
}
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />
<a href="<?php echo base_url('cleaner/complaints'); ?>" style="display:flex; align-items:center; position: absolute; top: 3px; left: 255px; color:#4caf50;"><i class="fa fa-long-arrow-left" style="font-size: 31px; color: #4caf50; margin-right:9px;"></i>Back</a>
<div class="right_col" role="main">
  <div class="page-title"  style="padding:40px 0 50px;">

    <div class="title_left">
      <?php echo $this->session->flashdata('cleaner_delleted');?>
      <?php if($this->session->flashdata('cleaner_added'))
      {
        //echo"alresdy exist";die;
        echo"<div style='margin-left: 150px;'>";
        echo"<font color='green'>Cleaner Added Succesfully</font>";
        echo"</div>";
      }
      ?>
    </div>

    <div class="title_right">

    </div>
  </div>
  <div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Complaint Replies </h2>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <div class="repliesDiv clearfix" id="repliesDiv">
            <?php
            foreach ($replies as $key => $value) {
              if($value['created_by'] == $this->session->userdata('authorized')){
                echo "<div class='reply sent'>".$value['content']."<h6>".$value['created_at']."</h6></div>";
              }else{
                echo "<div class='reply received'>".$value['content']."<h6>".$value['created_at']."</h6></div>";
              }

            }
            ?>
          </div>
          <div class="replySection">
            <div class="row">
              <div class="col-md-8">
                <textarea name="name" class="form-control" id="msg" placeholder="Message"></textarea>
              </div>
              <div class="col-md-4">
                <button type="button" id="send" name="button" class="btn btn-primary">Send</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>





  <div class="row">



  </div>
</div>



<script>

  $(document).ready(function(){
      var objDiv = document.getElementById("repliesDiv");
      objDiv.scrollTop = objDiv.scrollHeight;
      $("#send").on("click", function(){
          var msg = $("#msg").val();
          $.ajax({
            method: "POST",
            url: "<?php echo base_url()?>cleaner/insert_reply",
            data: {msg: msg, id: <?php echo $_GET['id']; ?>}
          }).done(function(data){
            $("#repliesDiv").html(data);
            $("#msg").val('');
            var objDiv = document.getElementById("repliesDiv");
            objDiv.scrollTop = objDiv.scrollHeight;
          });
      });
      getReplies();
  });

function getReplies(){
  $.ajax({
    method: "GET",
    url: "<?php echo base_url()?>cleaner/get_replies",
    data: {id: <?php echo $_GET['id']; ?>}
  }).done(function(data){
    $("#repliesDiv").html(data);

    setTimeout(function(){
      getReplies();
    }, 3000);
  });
}
</script>
