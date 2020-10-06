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
select
{
    width: 50%;
    height: 25px;
}
</style>
<a href="<?php echo base_url('orders'); ?>" style="display:flex; align-items:center; position: absolute; top: 3px; left: 255px; color:#4caf50;"><i class="fa fa-long-arrow-left" style="font-size: 31px; color: #4caf50; margin-right:9px;"></i>Back</a>
<div class="right_col" role="main">
  <div class="page-title">
    <div class="title_left">
      <h3>Orders</h3>
        <ul class="nav nav-tabs">
          <li class=""><a href="<?php echo base_url()?>orders">Online</a></li>
          <!-- <li class=""><a href="<?php //echo base_url()?>orders/index?cashtab=1">Cash</a></li> -->
          <li class="active"><a href="<?php echo base_url()?>pending">Pending</a></li>
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
          </div>
        </div>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
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
                <th>Date</th>
                <th>Order ID</th>
                <th>Amount to be collected </th>
                <th>Customer Name</th>
                <th>Phone Number</th>
                <th>Type</th>
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
              //echo"hello";die;
                 foreach($pending_orders as $key => $value)
                 { $newsate = date('d-M-y',strtotime($value['purchase_date']));
                    //print_r($orders); die;
                  echo"
                  <tr>
                    <td>".$newsate."</td>
                    <td>".$value['orders_id']."</td>

                    <td>".$value['net_paid']."</td>
                    <td>".$value['name']."</td>
                    <td>".$value['phone_number']."</td>
                    <td>COD</td>
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
