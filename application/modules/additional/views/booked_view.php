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
<a href="<?php echo base_url('dashboard'); ?>" style="display:flex; align-items:center; position: absolute; top: 3px; left: 255px; color:#4caf50;"><i class="fa fa-long-arrow-left" style="font-size: 31px; color: #4caf50; margin-right:9px;"></i>Back</a>
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
          <h2>Booked Additional Services </h2>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <div class="filters text-center mt-1 mb-2 d-block clearfix">
            <form class="" action="" method="get">
              <?php $reset=''; if(isset($_GET['id'])){ ?>
              <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
              <?php $reset = "id=".$_GET['id']; } ?>
              <span id="fthold">
                <input type="radio" name="ft" value="1" class="ftf" <?php echo (isset($_GET['ft']) && $_GET['ft'] == '1') ? 'checked' : ''; ?>> Today
                <input type="radio" name="ft" value="2" class="ftf" <?php echo (isset($_GET['ft']) && $_GET['ft'] == '2') ? 'checked' : ''; ?>> This Week
                <input type="radio" name="ft" value="3" class="ftf" <?php echo (isset($_GET['ft']) && $_GET['ft'] == '3') ? 'checked' : ''; ?>> This Month
                <input type="radio" name="ft" value="4" class="ftf" <?php echo (isset($_GET['ft']) && $_GET['ft'] == '4') ? 'checked' : ''; ?>> This Quarter
                <input type="radio" name="ft" value="5" class="ftf" <?php echo (isset($_GET['ft']) && $_GET['ft'] == '5') ? 'checked' : ''; ?>> This Year
                <input type="radio" name="ft" value="6" class="ftf" id="customft" <?php echo (isset($_GET['ft']) && $_GET['ft'] == '6') ? 'checked' : ''; ?>> Custom
              </span>
              <div style="max-width:600px; margin:20px auto; display:<?php echo (isset($_GET['ft']) && $_GET['ft'] == '6') ? 'block' : 'none'; ?>;" class="row" id="ftcustom">
                <div class="col-md-6">
                    <input type="text" value="<?php echo (isset($_GET['ftfr'])) ? $_GET['ftfr'] : ''; ?>" class="form-control has-feedback-left" id="single_cal2" placeholder="From Date" aria-describedby="inputSuccess2Status2" name="ftfr">
                    <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                </div>
                <div class="col-md-6">
                  <input type="text" value="<?php echo (isset($_GET['ftto'])) ? $_GET['ftto'] : ''; ?>" class="form-control has-feedback-left" id="custom_calender" placeholder="To Date" aria-describedby="inputSuccess2Status2" name="ftto">
                  <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                </div>
              </div>
              <button class="btn btn-success ml-2" name="button">Filter</button>
              <a href="?<?php echo $reset; ?>" class="btn btn-warning ml-2" name="button">Reset</a>
            </form>
            <script type="text/javascript">

              document.getElementById("fthold").addEventListener("click", function(){
                if(document.getElementById("customft").checked){
                  document.getElementById("ftcustom").style.display = "block";
                }else{
                  document.getElementById("ftcustom").style.display = "none";
                }
              })
            </script>
          </div>
          <table id="datatable" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>Purchase Date</th>
                <th>User</th>
                <th>Service Name</th>
                <th>Amount</th>
                <th>Transaction ID</th>
                <th>Status</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
              </tr>
            </tfoot>


            <tbody id="">
              <?php
              function status($str){
                switch ($str) {
                  case '1':
                    return '<span class="text-success">Completed</span>';
                    break;
                  case '0':
                    return '<span class="text-warning">Pending</span>';
                    break;
                  case '0':
                    return '<span class="text-danger">Rejected</span>';
                    break;

                  default:
                    return '';
                    break;
                }
              }
                 foreach($additional as $key => $add)
                 {
                  echo"
                  <tr>
                    <td>".$add['purchase_date']."</td>
                    <td>".$add['name']."</td>
                    <td>".$add['service_name']."</td>
                    <td>".$add['amount']."</td>
                    <td>".$add['transaction_id']."</td>
                    <td>".status($add['status'])."</td></tr>";
                 }
              ?>

             <!--  <tr>
                <td>Tiger Nixon</td>
                <td>System Architect</td>
                <td>Edinburgh</td>
                <td>61</td>
              </tr>
              <tr>
                <td>Garrett Winters</td>
                <td>Accountant</td>
                <td>Tokyo</td>
                <td>63</td>
              </tr>
              <tr>
                <td>Ashton Cox</td>
                <td>Junior Technical Author</td>
                <td>San Francisco</td>
                <td>66</td>
              </tr>
              <tr>
                <td>Cedric Kelly</td>
                <td>Senior Javascript Developer</td>
                <td>Edinburgh</td>
                <td>22</td>
              </tr>
              <tr>
                <td>Airi Satou</td>
                <td>Accountant</td>
                <td>Tokyo</td>
                <td>33</td>
              </tr>
              <tr>
                <td>Brielle Williamson</td>
                <td>Integration Specialist</td>
                <td>New York</td>
                <td>61</td>
              </tr>
              <tr>
                <td>Michael Bruce</td>
                <td>Javascript Developer</td>
                <td>Singapore</td>
                <td>29</td>
              </tr>
              <tr>
                <td>Donna Snider</td>
                <td>Customer Support</td>
                <td>New York</td>
                <td>27</td>
              </tr>
              <tr>
                <td>Donna Snider</td>
                <td>Customer Support</td>
                <td>New York</td>
                <td>27</td>
              </tr>
              <tr>
                <td>Donna Snider</td>
                <td>Customer Support</td>
                <td>New York</td>
                <td>27</td>
              </tr> -->

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>





  <div class="row">



  </div>
</div>




<script>
$(document).ready(function(){
  <?php if(isset($_POST['city'])){ ?>
    $("#city_multiselect").change();
  <?php } ?>
    multify();
  $('#city_multiselect').multiselect({
    nonSelectedText: 'Select City',
    enableFiltering: true,
    enableCaseInsensitiveFiltering: true,
    buttonWidth:'250px'
   });
});
function multify(){
  $('#locality_multiselect').multiselect({
   nonSelectedText: 'Select City',
   enableFiltering: true,
   enableCaseInsensitiveFiltering: true,
   buttonWidth:'250px'
  });
}
</script>
<script>
  function get_locality_for_street(val)
 {

    var id =   $('#city_multiselect').val();
   // alert(id);

    if (typeof id !== 'undefined' && id.length > 0)
    {
    // the array is defined and has at least one element
    var sel = '<?php echo (isset($_POST['locality_id'])) ? implode("|", $_POST['locality_id']) : ''; ?>';
        $.ajax
        ({
            type : "POST",
            url : "<?php echo base_url(); ?>cleaner/get_locality_for_street",
            dataType : "json",
            data : {"city_id" : id, selected: sel},
            success : function(data) {
              $("#locality_multiselect").html(data.option).multiselect('rebuild');
            },
            error : function(data) {
                alert('Something went wrong');
            }
        });
    }
    else
    {
      $("#locality_ajax").html('<option disabled selected>Choose City First</option>');
    }
  }
</script>
<script>
var expanded = false;

function showCheckboxes() {
  var checkboxes = document.getElementById("checkboxes");
  if (!expanded) {
    checkboxes.style.display = "block";
    expanded = true;
  } else {
    checkboxes.style.display = "none";
    expanded = false;
  }
}
</script>


<script>

  $(document).ready(function(){
    $("#datatable").dataTable().fnDestroy()
    $('#datatable').dataTable({
      initComplete: function() {
          this.api().columns().every(function() {
              var column = this;
              var select = $('<select><option value="">All</option></select>')
                  .appendTo($(column.footer()).empty())
                  .on("click", function(e) {
                      e.stopPropagation();
                  })
                  .on('change', function() {
                      var val = $.fn.dataTable.util.escapeRegex(
                          $(this).val()
                      );
                      column.search(val ? '^' + val + '$' : '', true, false).draw();
                      //console.log($(this).val());
                      //column.search(val).draw();
                  });

              column.data().unique().sort().each(function(d, j) {
                  d = d.replace(/(<([^>]+)>)/ig, "");
                  if(select.find('option[value="' + d + '"]').length <= 0){
                    select.append('<option value="' + d + '">' + d + '</option>');
                  }
              });
          });
          // $("#datatable tfoot select option").val(function(idx, val) {
          //   $(this).siblings('[value="'+ val +'"]').remove();
          // });
      },
      dom: 'lBfrtip',
      buttons: [{
              extend: 'excelHtml5',
              title: 'Data export',
              exportOptions: {
                  columns: [0, 1, 2, 3, 4, 5]
              }
          },
          {
              extend: 'csvHtml5',
              title: 'Data export',
              exportOptions: {
                  columns: [0, 1, 2, 3, 4, 5]
              }
          },
      ],
      ordering: true,
      oLanguage: {
          "sSearch": "Search:"
      }
  });
});

</script>
