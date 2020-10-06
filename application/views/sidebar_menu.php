 <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <!-- <h3>General</h3> -->
                <ul class="nav side-menu">

                  <!--side items of gogreen-->

                  <li><a href="<?php echo base_url('dashboard')?>"><i class="fa fa-desktop"></i> Dashboard <span class=""></span></a></li>
                   <!-- <li><a><i class="fa fa-toggle-off"></i>Assignment<span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu">
                        <li><a href="<?php //echo base_url('manual')?>"><i class="fa fa-clone"></i>Search Customer <span class=""></span></a></li>
                        <li><a href="<?php //echo base_url('add_customer')?>"><i class="fa fa fa-user"></i>Add Customer <span class=""></span></a></li>
                      </ul>
                    </li> -->
                    <li><a href="<?php  echo base_url('manual'); ?>"><i class="fa fa-toggle-off"></i> Assignment <span class=""></span></a></li>
                  <!-- <li><a href="<?php // echo base_url('user')?>"><i class="fa fa-user"></i> Users <span class=""></span></a></li> -->
                  <li><a><i class="fa fa-user"></i>Users <span class="fa fa-chevron-down"></span></a>
                     <ul class="nav child_menu">
                       <li><a href="<?php echo base_url('add_customer')?>">Add User <span class=""></span></a></li>
                       <li><a href="<?php echo base_url('user')?>"> View Users <span class=""></span></a></li>
                       <li><a href="<?php echo base_url('user/archived')?>"> Archived Users <span class=""></span></a></li>
                     </ul>
                   </li>
                  <li><a href="<?php echo base_url('orders')?>"><i class="fa fa-database"></i> Orders <span class=""></span></a></li>
                     <li><a href="<?php echo base_url('car')?>"><i class="fa fa-car"></i> Cars <span class=""></span></a></li>

                   <li><a><i class="fa fa-gift"></i>Coupons <span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu">
                        <li><a href="<?php echo base_url('coupans')?>">for Main Packages <span class=""></span></a></li>
                        <li><a href="<?php echo base_url('additional_coupons')?>"> for Additional Services <span class=""></span></a></li>
                      </ul>
                    </li>

                  <li><a><i class="fa fa-paint-brush"></i> Cleaners <span class="fa fa-chevron-down"></span></a>
                     <ul class="nav child_menu">
                       <li><a href="<?php echo base_url('cleaner')?>">List <span class=""></span></a></li>
                       <li><a href="<?php echo base_url('cleaner/collection')?>"> Collection Files <span class=""></span></a></li>
                       <li><a href="<?php echo base_url('cleaner/complaints')?>"> Complaints <span class=""></span></a></li>
                     </ul>
                   </li>
                  <li><a  href="<?php echo base_url('location')?>"><i class="fa fa-map"></i> Locations <span class=""></span></a></li>
                    <li><a href="<?php echo base_url('packages')?>"><i class="fa fa-server"></i> Packages <span class=""></span></a></li>

                    <li><a><i class="fa fa-plus"></i> Additional Services <span class="fa fa-chevron-down"></span></a>
                       <ul class="nav child_menu">
                         <li><a href="<?php echo base_url('additional')?>">List <span class=""></span></a></li>
                         <li><a href="<?php echo base_url('additional/booked')?>"> Booked Services <span class=""></span></a></li>
                       </ul>
                     </li>
                          <li><a href="<?php echo base_url('teams')?>"><i class="fa fa fa-star-half-o"></i> Teams <span class=""></span></a></li>
                            <li><a href="<?php echo base_url('admin/change_password')?>"><i class="fa fa fa-exchange"></i> Change Password <span class=""></span></a></li>

                            <li><a><i class="fa fa-bell"></i>Push Notification <span class="fa fa-chevron-down"></span></a>
                               <ul class="nav child_menu">
                                 <li><a href="<?php echo base_url('push_notification')?>">to Users <span class=""></span></a></li>
                                 <li><a href="<?php echo base_url('push_notification/cleaners')?>">to Cleaners <span class=""></span></a></li>
                               </ul>
                             </li>
                              <li><a href="<?php echo base_url('admin/logout')?>"><i class="fa fa fa-rocket"></i>Logout<span class=""></span></a></li>
                </ul>
              </div>


            </div>

            </div>
        </div>
