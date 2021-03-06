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
<div class="right_col" id="cool" role="main">
  <div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <div class="row">
            <div class="col-md-2">
                <h2>Users </h2>
            </div>
            <div class="col-md-2">
             <?php echo $this->session->flashdata('stop_succs');?>
             <?php echo $this->session->flashdata('user_active');?>
<div class="title_left">
                 <a href="<?php echo base_url('add_customer')?>" class="btn btn-info">Add User</a>
               </div>
            </div>
            <div class="col-md-2">
              <div class="title_left">
                <a href="<?php echo base_url()?>user/excel_export" class="btn btn-info">Export Data</a>
              </div>
            </div>
            <div class="col-md-3">
               <select  class="form-control" id="filter_id" onchange="location = this.value;">
                  <option value="<?php echo base_url()?>user">All Renewal Type</option>
                 <option value="<?php echo base_url()?>user/filter_function?flag=5">Default Renewal</option>
                 <option value="<?php echo base_url()?>user/filter_function?flag=6">Auto Renewal</option>
               </select>
            </div>
            <div class="col-md-3">
               <select  class="form-control" id="filter_id" onchange="location = this.value;">
                  <option value="<?php echo base_url()?>user">All Users</option>
                 <option value="<?php echo base_url()?>user/filter_function?flag=2">Active Users</option>
                 <option value="<?php echo base_url()?>user/filter_function?flag=3">Inactive Users</option>
                 <option value="<?php echo base_url()?>user/filter_function?flag=4">Users With No Car</option>
               </select>
            </div>

          </div>

          <div class="clearfix"></div>
        </div>
        <div class="x_content">

          <table id="datatable" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>#</th>
                <th>Date</th>
                <th>Name</th>
                <th>Phone Number</th>
                <th>Email</th>
                <th>Area</th>
                <th>Building</th>
                <th>Street</th>
                <th>Number Of Cars</th>
                <th>Active Cars</th>
                <th>Operation</th>
                <th>Stop Services</th>
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
              </tr>
            </tfoot>


            <tbody id="">
              <?php
                    //echo"<pre>";print_r($users); die;
                 foreach($users as $key => $user)
                 {
                     $id = $users[$key]['id'];

                     $is_stop = $users[$key]['service_stop'];

                     // check user have currently package active or not

                    $package_id =  is_user_active($id);


                   // $expiry_date = $users[$key]['expiry_date'];
                    $newsate = date('d-M-y',strtotime($users[$key]['created_at']));


                    if($package_id)
                    {
                       $disabled="disabled";
                       $href="#";

                         //to stop package
                        $href_to_stop = base_url()."user/stop_package?id=".$id;
                        $stop_button = "";

                    }
                    else
                    {
                      //package is not active
                      //to delete user
                      $disabled="";
                      $href=base_url()."user/delete_user?id=".$users[$key]['id'];

                      //to stop package
                       $href_to_stop = "#";
                       $stop_button = "disabled";
                    }
                    $phone_number = $users[$key]['phone_number'];
                    $email = $users[$key]['email'];
                    // $result = substr($phone_number, 0, 4);
                    // if($result!='+971')
                    // {
                    //   $phone_number = $users[$key]['phone_number'];
                    // }
                    // echo $result; die;
                    echo"
                    <tr>
                      <td>".($key+1)."</td>
                      <td>".$newsate."</td>
                     <td><a  class='for_hover' href = '".base_url()."user/get_user_car_details?id=".$users[$key]['id']."'>".$users[$key]['name']."</a></td></a>
                      <td><span class='noedit actual'>".$phone_number."</span> <input type='text' data-id='".$users[$key]['id']."' value='".$phone_number."' placeholder='Phone Number' required class='edit edited'><button class='btn btn-success edit doneEdit' type='button'><i class='fa fa-check cancelEdit'></i></button><button class='btn btn-warning edit cancelEdit' type='button'><i class='fa fa-times'></i></button> <i class='fa fa-pencil text-warning noedit editPhone'></i></td>
                      <td><span class='noedit actual'>".$email."</span> <input type='text' data-id='".$users[$key]['id']."' value='".$email."' placeholder='Email' required class='edit edited'><button class='btn btn-success edit doneEdit2' type='button'><i class='fa fa-check cancelEdit'></i></button><button class='btn btn-warning edit cancelEdit' type='button'><i class='fa fa-times'></i></button> <i class='fa fa-pencil text-warning noedit editPhone'></i></td>
                      <td>".$users[$key]['city']."</td>
                      <td>".$users[$key]['locality']."</td>
                      <td>".$users[$key]['street']."</td>

                      <td>".$users[$key]['no_of_cars']."</td>
                      <td>".$users[$key]['active_cars']."</td>";
                      if($users[$key]['user_status']==1)
                      {
                        echo"<td><a  ".$disabled." href='".$href."' class='btn btn-warning to_inactive'>Inactive</td>";
                      }
                      else
                      {
                        echo"<td><a  ".$disabled." href='".base_url('user/activate_user?id='.$id.'')."' class='btn btn-success to_activate'>Active</td>";
                      }
                      if($is_stop ==1)
                      {
                        echo"
                      <td><a ".$stop_button." href='".$href_to_stop."'  class='btn btn-info for_pop_up'>Stop</a></td>";
                      }
                      else
                      {
                        echo "<td><a href='".base_url('user/stop_package?id='.$id.'&flagg=2')."' class='btn btn-info for_pop_up_renew'>Renew</a></td>";
                      }
                      echo"
                    </tr>";
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


<?php
  // echo base_url(uri_string());
?>

<script>
  $( document ).ready(function() {
  document.getElementById("cool").style.minHeight = "697px";
var url =   window.location.href;
// console.log(url);
$('#filter_id').val(url);

  });
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
                  columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
              }
          },
          {
              extend: 'csvHtml5',
              title: 'Data export',
              exportOptions: {
                  columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
              }
          },
      ],
      ordering: true,
      oLanguage: {
          "sSearch": "Search:"
      }
  });
    // $('#datatable').dataTable({
    //
    //
    //         dom: 'lBfrtip',
    //         buttons: [
    //                   {
    //             extend: 'excelHtml5',
    //             title: 'Data export',
    //              exportOptions: {
    //                    columns: [ 8,0, 1, 2,3,4,5,6,7]
    //             }
    //         },
    //         {
    //             extend: 'csvHtml5',
    //             title: 'Data export',
    //             exportOptions: {
    //                  columns: [ 8,0, 1, 2,3,4,5,6,7]
    //             }
    //         },
    // ],
    //
    //  ordering: true,
    // oLanguage: {
    //   "sSearch": "Search:"
    // },
    //         columnDefs : [
    //             {
    //                 'searchable'    : true,
    //                 'targets'       : [1,2,3]
    //             },
    //         ],
    //         "bStateSave": true,
    //         "fnStateSave": function (oSettings, oData) {
    //             localStorage.setItem('offersDataTables', JSON.stringify(oData));
    //         },
    //         "fnStateLoad": function (oSettings) {
    //             return JSON.parse(localStorage.getItem('offersDataTables'));
    //         }
    //
    //
    //       });
});
</script>
<script>
 function filter_user(val)
 {
  var filter_val = val;
  if(filter_val==1)   // all user
  {
    ///alert('hey');
    window.location = "user";
  }
  $.ajax
    ({
        type : "POST",
        url : "<?php echo base_url(); ?>user/filter_function",
        dataType : "json",
        data : {"flag" : filter_val},
        success : function(data) {
             $("#locality_ajax").html(data.option);
             //$("#locality_ajax_table").html(data.dropdown);
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
        $(document).on('click', '.for_pop_up', function () {
        return confirm('Are you sure you want to stop services?');
    });
        $(document).on('click', '.for_pop_up_renew', function () {
        return confirm('Are you sure you want to renew services?');
    });
        $(document).on('click', '.to_inactive', function () {
          var attr = $(this).attr('disabled');
          if(typeof attr !== typeof undefined && attr !== false){
            return false;
          }else{
            return confirm('Are you sure you want to inactivate the user?');
          }

    });
        $(document).on('click', '.to_activate', function () {
        return confirm('Are you sure you want to activate the user?');
    });
    $(document).ready(function(){
      $("body").on("click", ".editPhone", function(){
        $(this).parent("td").find(".noedit").hide();
        $(this).parent("td").find(".edit").show();
      });
      $("body").on("click", ".cancelEdit", function(){
        $(this).parent("td").find(".edit").hide();
        $(this).parent("td").find(".noedit").show();
      });
      $("body").on("click", ".doneEdit", function(){
        var v = $(this).parent("td").find(".edited").val();
        var i = $(this).parent("td").find(".edited").attr("data-id");
        var dis = $(this);
        if(v == ''){
          alert("Enter Phone Number");
        }else {

          $.ajax({
            method: "POST",
            url: "<?php echo base_url()?>user/update",
            data: {id: i, phone: v, email: -1}
          }).done(function(data){
            console.log(data);
            if(data.trim() == '1'){
              dis.parent("td").find(".actual").text(v);
              dis.parent("td").find(".edit").hide();
              dis.parent("td").find(".noedit").show();
            }
          }).fail(function(data){
            alert(data);
          });
        }

      });

      $("body").on("click", ".doneEdit2", function(){
        var v = $(this).parent("td").find(".edited").val();
        var i = $(this).parent("td").find(".edited").attr("data-id");
        var dis = $(this);
        if(v == ''){
          alert("Enter Email");
        }else {

          $.ajax({
            method: "POST",
            url: "<?php echo base_url()?>user/update",
            data: {id: i, email: v, phone:-1}
          }).done(function(data){
            console.log(data);
            if(data.trim() == '1'){
              dis.parent("td").find(".actual").text(v);
              dis.parent("td").find(".edit").hide();
              dis.parent("td").find(".noedit").show();
            }
          }).fail(function(data){
            alert(data);
          });
        }

      });
    });
    </script>
