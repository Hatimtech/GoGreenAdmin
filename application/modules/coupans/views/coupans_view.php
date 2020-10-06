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
<a href="<?php echo base_url('dashboard'); ?>" style="display:flex; align-items:center; position: absolute; top: 3px; left: 255px; color:#4caf50;"><i class="fa fa-long-arrow-left" style="font-size: 31px; color: #4caf50; margin-right:9px;"></i>Back</a>
<div class="right_col" role="main">
  <div class="page-title">
    <div class="title_left">
      <?php if($this->session->flashdata('succ'))
      {
        //echo"alresdy exist";die;
        echo"<div style='margin-left: 150px;'>";
        echo"<font color='green'>".$this->session->flashdata('succ')."</font>";
        echo"</div>";
      }
      echo $this->session->flashdata('coupan_del');
      ?>
    </div>

    <div class="title_right">

    </div>
  </div>
  <div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Coupons </h2>
          <a href="<?php echo base_url()?>coupans/add_coupans">
          <button style="float: right;">Add New Offer</button></a>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <div class="filters text-center mt-1 mb-2 d-block clearfix">
            <form class="" action="" method="get">
              <?php $reset=''; if(isset($_GET['flag'])){ ?>
              <input type="hidden" name="flag" value="<?php echo $_GET['flag']; ?>">
              <?php $reset = "flag=".$_GET['flag']; } ?>
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
                <th>Offer Name</th>
                <th>Valid From</th>
                <th>Valid To</th>
                <th>Coupon Code</th>
                <th>Discount %</th>
                <th>Fixed Discount %</th>
                <th>Minimum Order</th>
                <th>User Type</th>
                <th>Max Discount</th>
                <th>Operations</th>
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
              </tr>
            </tfoot>
            <tbody id="">
              <?php
                 foreach($coupans as $key => $value)
                 {
                  if($value['user_type'] == 1)
                  {
                    $user_type = 'NEW USER';
                  }else if($value['user_type'] == 3)
                  {
                    $user_type = 'BOTH';
                  }
                  else
                  {
                    $user_type = 'EXISTING USER';
                  }

                   $valid_from = date('d-M-y',strtotime($value['valid_from']));
                   $valid_upto = date('d-M-y',strtotime($value['valid_upto']));
                  echo"
                  <tr>
                    <td>".$value['offer_name']."</td>
                    <td>".$valid_from."</td>
                    <td>".$valid_upto."</td>
                    <td>".$value['coupan_code']."</td>
                    <td>".$value['discount']."</td>
                    <td>".$value['FixedDiscount']."</td>
                    <td>".$value['minimum_order']."</td>
                    <td>".$user_type."</td>
                    <td>".$value['max_discount']."</td>
                    <td>
                      <a href='".base_url()."coupans/delete_coupans?id=".$value['id']."' class='btn btn-danger btn-sm'><i class='fa fa-trash-o m-right-xs'></i>Delete
                      </a>
                      <a href='".base_url()."coupans/add_coupans?id=".$value['id']."' class='btn btn-info btn-sm'><i class='fa fa-edit m-right-xs'></i>Edit
                      </a>
                    </td>
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
                  columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
              }
          },
          {
              extend: 'csvHtml5',
              title: 'Data export',
              exportOptions: {
                  columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
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
