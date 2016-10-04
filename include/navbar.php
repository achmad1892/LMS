<?php
   if(empty($_SESSION['type'])) {
      header("location:./");
   }
?>
   <div class="navbar-fixed"> <!-- start div navbar -->
      <nav class="green"> <!-- start nav -->
         <div class="nav-wrapper container"> <!-- start nav-wrapper -->
            <a href="./" class="brand-logo">
               <img src="../assets/img/forum.png" width="190" height="50">
            </a>
            <a href="#" data-activates="mobile-demo" class="button-collapse">
               <i class="fa fa-bars"></i>
            </a>
            <ul class="right hide-on-med-and-down">
               <?php
               if(empty($_REQUEST['page'])){
                  ?>
                  <li>
                     <form method="post" action="">
                        <div class="row">
                           <div class="input-field col m10">
                              <input id="search" type="text" name="search" placeholder="cari topik...">
                           </div>
                           <div class="input-field col m2">
                              <button type="submit" name="submit" class="back">
                                 <i class="fa fa-search"></i>
                              </button>
                           </div>
                        </div>
                     </form>
                  </li>
                  <?php
               }
               ?>
            </ul>
         </div> <!-- end nav-wrapper -->
      </nav> <!-- end nav -->
   </div> <!-- end div nav -->
