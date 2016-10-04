<?php
   if(empty($_SESSION['type'])) {
      header("location:../");
   }
?>
   <div class="row"> <!-- start row -->
      <?php
      if($_SESSION['type'] == 3){
         echo '<a href="../">';
      } else {
         echo '<a href="../administrator/">';
      }
      ?>
      <div class="col m2">
         <div class="card yellow darken-4 center">
            <div class="card-content white-text">
               <i class="fa fa-desktop fa-2x"></i>
               <p>Dashboard</p>
            </div>
         </div>
      </div>
      </a>
      <a href="index.php?page=list">
         <div class="col m2">
            <div class="card green darken-1 center">
               <div class="card-content white-text">
                  <i class="fa fa-list fa-2x"></i>
                  <p>Thread Anda</p>
               </div>
            </div>
         </div>
      </a>
      <a href="index.php?page=add">
         <div class="col m2">
            <div class="card blue darken-1 center">
               <div class="card-content white-text">
                  <i class="fa fa-pencil-square-o fa-2x"></i>
                  <p>Tulis Thread</p>
               </div>
            </div>
         </div>
      </a>
   </div> <!-- end row -->
