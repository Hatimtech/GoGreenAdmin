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
.x_panel
{
  overflow-y: scroll;
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
.btn-group, .multiselect {
  width: 100%!important;
}

</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />
<a href="<?php echo base_url('dashboard'); ?>" style="display:flex; align-items:center; position: absolute; top: 3px; left: 255px; color:#4caf50;"><i class="fa fa-long-arrow-left" style="font-size: 31px; color: #4caf50; margin-right:9px;"></i>Back</a>
<div class="right_col" role="main" id="cool">
  <div class="page-title">
    <div class="row">
      <form method="post" action="<?php echo base_url()?>orders">
      <div class="col-md-4">
         <select onchange="get_locality_for_street(this.value)" id="city_multiselect" class="select" multiple name="city[]">
           <!-- <option value="" disabled selected>Select City</option> -->
          <?php
          $scity = (isset($_POST['city'])) ? $_POST['city'] : array();
          if(!empty($city)){foreach ($city as $key => $value) {
            $sel = (in_array($value['id'], $scity)) ? 'selected' : '' ;
            echo"<option $sel value=".$value['id'].">".ucfirst($value['name'])."</option>";}}
          ?>
          </select>
      </div>
      <div class="col-md-4">
        <select id="locality_multiselect" class="select" multiple name="locality_id[]">

        </select>
    </div>
      <div class="col-md-2">
        <button type="submit" value="" class="btn btn-info" style="padding: 7px 22px">Submit</button>

      </div>
      </form>
    </div>
    <div class="title_left">
      <h3>Orders</h3>

        <ul class="nav nav-tabs">
          <?php
          if($this->input->get('cashtab'))
          {
            $class ='active';
            $online_class='none';
          }
          else
          {
            $online_class = 'active';
            $class='none';
          }

          ?>
          <li class="<?php echo $online_class?>"><a href="<?php echo base_url()?>orders">Online</a></li>

          <li><a href="<?php echo base_url()?>orders/pending">Pending</a></li>
        </ul>

    </div>

    <div class="title_right">

    </div>
  </div>
  <div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <div class="row">
            <div class="col-md-3">

             <!-- <select onchange="get_locality_for_street(this.value)" class="select"><option value="" disabled selected>Select City</option>
              <?php if(!empty($city)){foreach ($city as $key => $value) {

                echo"<option value=".$value['id'].">".ucfirst($value['name'])."</option>";}}?>
              </select>
            </div>
            <div class="col-md-3">
              <select class="select" id="locality_ajax"><option>Choose City First</option>
              </select>
            </div>
            <div class="col-md-3">
              <select>
                <option>Street</option>


              </select>
            </div>
            <div class="col-md-3">
             <select>
              <option>Team</option>
            </select>
 -->
          </div>
        </div>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <font color="green">
          <?php echo $this->session->flashdata('remark_added');?>
          <?php echo $this->session->flashdata('status_changed');?>
          <?php echo $this->session->flashdata('data_registered');?>
        </font>
        <div class="filters text-center mt-1 mb-2 d-block clearfix">
          <form class="" action="" method="get">
            <?php if(isset($_GET['flag'])){ ?>
            <input type="hidden" name="flag" value="<?php echo $_GET['flag']; ?>">
            <?php } ?>
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
            <a href="?" class="btn btn-warning ml-2" name="button">Reset</a>
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
                <th>Order ID</th>
                <th>Date</th>
                <th>Activities</th>
                <th>Additional Services</th>
                <th>Customer Name</th>
                <th>Car Number</th>
                <th>Team</th>
                <th>Total Amount</th>
                <th>Partial</th>
                <th>Due amount</th>
                <th>Customer Number</th>
                <th>Transaction Id</th>
                <th>Remark</th>
                <th>City</th>
                <th>Locality</th>
                <th>Street</th>
                <th>Add Amount</th>
                <th>Team Assign</th>
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
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
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
              //echo"hello";die;
                 foreach($orders as $key => $value)
                 {

                  $due = $value['net_paid'] - $value['partial_payment'];

                  if($value['payment_status']==2)
                  {
                    $status = 'collected';
                  }
                  else
                  {
                    $status ='collected';
                  }

                  $data=array
                  (
                    'primary_id'=>$value['primary_id'],
                    'amount'=>$value['net_paid'],
                    'partial_amount'=>$value['partial_payment'],
                    'user_id'=>$value['user_id']
                  );
                  $remark_modal_data = json_encode($data);
                   $newsate = date('d-M-y',strtotime($value['purchase_date']));
                  // echo "<pre>"; print_r($orders); die;
                  echo"
                  <tr>
                    <td>".$value['orders_id']."</td>
                    <td>".$newsate."</td>
                    <td><a href='".base_url()."orders/activity?id=".$value['orders_id']."' class='text-primary'>View</a></td>
                    <td><a href='".base_url()."orders/additional?id=".$value['orders_id']."' class='text-primary'>View</a></td>
                    <td><a href=".base_url()."orders/get_customer_detail?id=".$value['user_id']."&&primary_id=".$value['primary_id'].">".$value['username']."</a></td>
                    <td>".$value['reg_no']."</td>
                    <td>".$value['team_name']."</td>
                    <td>".$value['net_paid']."</td>
                    <td>".$value['partial_payment']."</td>
                    <td>".$due."</td>
                    <td>".$value['phone_number']."</td>
                    <td>".$value['transaction_id']."</td>
                    <td>".$value['remark']."</td>
                    <td>".$value['city']."</td>
                    <td>".$value['locality']."</td>
                    <td>".$value['street']."</td>
                    <td><button href='' class='btn btn-primary' onclick='remark_modal(".$remark_modal_data.")'>Add</button></td>
                    <td><button href='' onclick='open_modal(".$value['primary_id'].")' class='btn btn-info'>Assign Team</button></td>";
                      // if($value['payment_status']==2 || $due==0)
                      // {
                      //   echo"<td><button class='btn btn-success'>Collected</button></td>";
                      // }
                      // else
                      // {
                      //    echo"<td><button onclick='update_payment_status_as_collect(".$value['primary_id'].")' class='btn btn-info'>Collect</button></td>";
                      // }
                      echo"
                      </tr>";
                 }
              ?>


             <!-- <tr>
                <td>Garrett Winters</td>
                <td>Accountant</td>
                <td>Tokyo</td>
                <td>63</td>
                 <td>Edinburgh</td>
                <td>61</td>
              </tr>
              <tr>
                <td>Ashton Cox</td>
                <td>Junior Technical Author</td>
                <td>San Francisco</td>
                <td>66</td>
                 <td>Edinburgh</td>
                <td>61</td>
              </tr>
              <tr>
                <td>Cedric Kelly</td>
                <td>Senior Javascript Developer</td>
                <td>Edinburgh</td>
                <td>22</td>
                 <td>Edinburgh</td>
                <td>61</td>
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
                 <td>Edinburgh</td>
                <td>61</td>
              </tr>
              <tr>
                <td>Michael Bruce</td>
                <td>Javascript Developer</td>
                <td>Singapore</td>
                <td>29</td>
                 <td>Edinburgh</td>
                <td>61</td>
              </tr>
              <tr>
                <td>Donna Snider</td>
                <td>Customer Support</td>
                <td>New York</td>
                <td>27</td>
                 <td>Edinburgh</td>
                <td>61</td>
              </tr>
              <tr>
                <td>Donna Snider</td>
                <td>Customer Support</td>
                <td>New York</td>
                <td>27</td>
                 <td>Edinburgh</td>
                <td>61</td>
              </tr>
              <tr>
                <td>Donna Snider</td>
                <td>Customer Support</td>
                <td>New York</td>
                <td>27</td>
                 <td>Edinburgh</td>
                <td>61</td>
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


<!-- modal for manuall team change -->
<div style="" class="modal fade" id="team_modal" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4  class="modal-title">Assign Team</h4>
          </div>
          <div class="modal-body" style="">
           <form method="post" action="<?php base_url();?>orders/change_team">
            <label>Team Name</label>
            <!-- <input required type="text" class="form-control" id="city_ajax_name" name="city" placeholder="City Name"> -->
            <select class="form-control" required id="modal_team_name" name="team_id">


            </select>
            <span id="modal_span" style="color: red"></span>
            <input type="hidden" name="payment_key" id="payment_key">
          </div>
          <div class="modal-footer">
            <input type="submit" class="btn btn-default" value="Update">
            <button style="" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </form>
          </div>
      </div>
    </div>
  </div>

  <!--/ moodal for manual team change -->



<!-- modal for Remark -->
<div style="" class="modal fade" id="remark" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4  class="modal-title">Add Partial Payment</h4>
          </div>
          <div class="modal-body" style="">
           <form method="post" action="<?php echo base_url();?>orders/add_remark">
            <input type="hidden" name="hidden_user_id" id="hidden_user_id">
            <label>Add amount</label>
            <input required type="number" class="form-control" id="partial_amount" name="partial_amount" placeholder="Enter Amount">
            <label>Add Remark</label>
            <input required type="text" class="form-control" id="remark" name="remark" placeholder="Write Remark Here..">
            <span id="remark_span" style="color: red"></span>
            <input type="hidden" name="payment_key_remark" id="payment_key_remark">
            <input type="hidden" id="outstanding_balance">
          </div>
          <div class="modal-footer">
            <input type="submit" id="remark_submit" class="btn btn-default to-update" value="Update">
            <button style="" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </form>
          </div>
      </div>
    </div>
  </div>

  <!--/ moodal for Remark -->





<script>

function open_modal(id)
{
  var primary_id = id;
   $.ajax
      ({
        type : "POST",
        url : "<?php echo base_url(); ?>orders/get_teams_working_on_this_order",
        dataType : "json",
        data : {"primary_id" : primary_id},
        success : function(data)
        {

          if(data==5)
          {
            $('#modal_span').html('No team to assiagn');
          }
          $('#modal_team_name').html(data);
          $('#team_modal').modal('show');
          $('#payment_key').val(primary_id);
         // $("#locality_ajax_table").html(data.dropdown);
             //alert('hello');
             console.log(data);
           },
           error : function(data) {
            alert('Something went wrong');
          }
        });
}

</script>

<script>
function remark_modal(data)
{
  console.log(data);
 //var primary_id = val;
  //alert(val);
  var primary_id = data.primary_id;
  var amount = data.amount;
  var partial_amount = data.partial_amount;
  var user_id = data.user_id;

  var outstanding_balance = amount - partial_amount;
 // return false;
 $('#payment_key_remark').val(primary_id);
 $('#outstanding_balance').val(outstanding_balance);
 $('#hidden_user_id').val(user_id);
 $('#remark').modal('show');
}

function update_payment_status_as_collect(id)
{
  var order_id = id;
  $.ajax
      ({
        type : "POST",
        url : "<?php echo base_url(); ?>orders/update_payment_status_as_collected",
        dataType : "json",
        data : {"order_id" : order_id},
        success : function(data)
        {

           location.reload();
         // $("#locality_ajax_table").html(data.dropdown);
             //alert('hello');
             console.log(data);
           },
           error : function(data) {
            alert('Something went wrong');
          }
        });
}

</script>

<script>

  $(document).ready(function(){
    document.getElementById("cool").style.minHeight = "697px";

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
                  columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13]
              }
          },
          {
              extend: 'csvHtml5',
              title: 'Data export',
              exportOptions: {
                  columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13]
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
$('#remark_submit').on('click',function(e){

if(confirm('Are you sure you want to update'))
{

  var outstanding_balance = parseInt($('#outstanding_balance').val());
  console.log(outstanding_balance);
  console.log('space');
  var partial_amount = parseInt($('#partial_amount').val());
  console.log(partial_amount);
  if(partial_amount > outstanding_balance )
  {
    alert('Partial Amount Should Be Less Than Equal To Total Due  Amount');
    e.preventDefault();
  }
}
else
{
  e.preventDefault();
  // do nothing
}
})

</script>
