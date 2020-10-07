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
    <div class="row">
      <form method="post" action="<?php echo base_url()?>cleaner">
      <div class="col-md-4">
         <select onchange="get_locality_for_street(this.value)" id="city_multiselect" class="select" multiple name="city[]">
           <!-- <option value="" disabled selected>Select Area</option> -->
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
          <!-- <div class="multiselect">
            <div class="selectBox" onclick="showCheckboxes()">
              <select class="btn btn-default">
                <option>Select an option</option>
              </select>
              <div class="overSelect"></div>
            </div>

            <div id="checkboxes">
             <label for="one">
            <input type="checkbox" id="one" />First checkbox</label>
            <label for="two">
            <input type="checkbox" id="two" />Second checkbox</label>
            <label for="three">
            <input type="checkbox" id="three" />Third checkbox</label>
            </div>
        </div> -->
    </div>
      <div class="col-md-2">
        <button type="submit" value="" class="btn btn-info" style="padding: 7px 22px">Submit</button>

      </div>
      </form>
    </div>
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
          <h2>Additional Services </h2>
          <a href="<?php echo base_url()?>additional/add_new">
          <button style="float: right; width:10%">Add New</button></a>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">

          <table id="datatable" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>Service Name</th>
                <th>Price</th>
                <th>Area</th>
                <th>Building</th>
                <th>Status</th>
                <th>Operation</th>
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
                 foreach($additional as $key => $additional)
                 {
                  if($additional['status']==1)
                  {
                    $flag='Active';
                  }
                  else
                  {
                    $flag='In-active';
                  }
                  echo"
                  <tr>
                    <td>".$additional['service_name']."</td>
                    <td>".$additional['price']."</td>
                    <td>".$additional['city']."</td>
                    <td>".$additional['locality']."</td>";
                    echo "
                    <td>".$flag."</td>
                    <td>
                    <a href='".base_url()."additional/inactive_additional?id=".$additional['id']."' class='btn btn-danger btn-sm'><i class='fa fa-trash-o m-right-xs'></i>Delete
                      </a>
                       <a href='".base_url()."additional/edit_additional?id=".$additional['id']."' class='btn btn-info btn-sm'><i class='fa fa-trash-o m-right-xs'></i>Edit
                      </a>
                  </tr>";
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
    nonSelectedText: 'Select Area',
    enableFiltering: true,
    enableCaseInsensitiveFiltering: true,
    buttonWidth:'250px'
   });
});
function multify(){
  $('#locality_multiselect').multiselect({
   nonSelectedText: 'Select Area',
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
      $("#locality_ajax").html('<option disabled selected>Choose Area First</option>');
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
                  columns: [0, 1, 2, 3, 4]
              }
          },
          {
              extend: 'csvHtml5',
              title: 'Data export',
              exportOptions: {
                  columns: [0, 1, 2, 3, 4]
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
