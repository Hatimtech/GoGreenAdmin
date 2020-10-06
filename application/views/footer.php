<footer>
          <!-- <div class="pull-right">
            Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
          </div> -->
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->



    <script>
        $(document).on('click', '.btn-danger', function (e) {
          // e.preventDefault();
          var attr = $(this).attr('disabled');
          if(typeof attr !== typeof undefined && attr !== false){
            return false;
          }else{
            return confirm('Are you sure you want to delete?');
          }

          // if($(this).is(":disabled")){
          //   return false;
          // }else{
          //   return confirm('Are you sure you want to delete?');
          // }
    });
    </script>
    <script src="<?php echo base_url_custom; ?>/vendors/jquery/dist/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.min.js" ></script>
    <!-- Bootstrap -->
    <script src="<?php echo base_url_custom; ?>/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url_custom; ?>/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?php echo base_url_custom; ?>/vendors/nprogress/nprogress.js"></script>
    <!-- Chart.js -->
    <script src="<?php echo base_url_custom; ?>/vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- gauge.js -->
    <script src="<?php echo base_url_custom; ?>/vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="<?php echo base_url_custom; ?>/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="<?php echo base_url_custom; ?>/vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="<?php echo base_url_custom; ?>/vendors/skycons/skycons.js"></script>
    <!-- Flot -->
    <script src="<?php echo base_url_custom; ?>/vendors/Flot/jquery.flot.js"></script>
    <script src="<?php echo base_url_custom; ?>/vendors/Flot/jquery.flot.pie.js"></script>
    <script src="<?php echo base_url_custom; ?>/vendors/Flot/jquery.flot.time.js"></script>
    <script src="<?php echo base_url_custom; ?>/vendors/Flot/jquery.flot.stack.js"></script>
    <script src="<?php echo base_url_custom; ?>/vendors/Flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    <script src="<?php echo base_url_custom; ?>/vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="<?php echo base_url_custom; ?>/vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="<?php echo base_url_custom; ?>/vendors/flot.curvedlines/curvedLines.js"></script>
    <!-- DateJS -->
    <script src="<?php echo base_url_custom; ?>/vendors/DateJS/build/date.js"></script>
    <!-- JQVMap -->
    <script src="<?php echo base_url_custom; ?>/vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="<?php echo base_url_custom; ?>/vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="<?php echo base_url_custom; ?>/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="<?php echo base_url_custom; ?>/vendors/moment/min/moment.min.js"></script>
    <script src="<?php echo base_url_custom; ?>/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

     <!-- validator -->
    <script src="<?php echo base_url_custom; ?>/vendors/validator/validator.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="<?php echo base_url_custom; ?>/build/js/custom.js"></script>



    <!--tables script-->
    <script src="<?php echo base_url_custom; ?>/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url_custom; ?>/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="<?php echo base_url_custom; ?>/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url_custom; ?>/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="<?php echo base_url_custom; ?>/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="<?php echo base_url_custom; ?>/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="<?php echo base_url_custom; ?>/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url_custom; ?>/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="<?php echo base_url_custom; ?>/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="<?php echo base_url_custom; ?>/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo base_url_custom; ?>/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="<?php echo base_url_custom; ?>/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="<?php echo base_url_custom; ?>/vendors/jszip/dist/jszip.min.js"></script>
    <script src="<?php echo base_url_custom; ?>/vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="<?php echo base_url_custom; ?>/vendors/pdfmake/build/vfs_fonts.js"></script>
    <script type="text/javascript">
      // $(document).ready(function(){
      //   if ( $( ".fa-long-arrow-left" ).length ) {
      //       console.log("exist");
      //   }else{
      //     $(".right_col").before('<a href="#" onclick="history.go(-1);" style="display:flex; align-items:center; position: absolute; top: 3px; left: 255px; color:#4caf50;"><i class="fa fa-long-arrow-left" style="font-size: 31px; color: #4caf50; margin-right:9px;"></i>Back</a>');
      //   }
      //
      // });
    </script>
  </body>
</html>
