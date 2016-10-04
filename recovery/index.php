<?php
   include_once('../include/connection.php');


   if (isset($_REQUEST['submit'])) {
      $pass = $_REQUEST['password'];

      if ($pass == 'alhusna') {
         mysqli_query($mysqli, "UPDATE t_admin SET username = 'admin', password = MD5(MD5('admin')), login_status = 'N' WHERE id_admin = 'A1'");
         header('location:../administrator');
      } else {
         echo '<script type="text/javascript">alert("Sandi Recovery salah!!!");</script>';
      }
   }
?>

<!DOCTYPE html>
<html>
   <head>
      <title>E-Learning Recovery</title>
      <link href="../assets/css/materialize.min.css" rel="stylesheet" type="text/css" />
      <link href="../assets/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
      <style type="text/css">
         .input-field label,
         .input-field .prefix{
            color: #0f0f0f;
         }
         .input-field input[type=text]:focus + label,
         .input-field input[type=password]:focus + label,
         .input-field .prefix.active{
            color: #4caf50;
         }
         .input-field input[type=text]:focus,
         .input-field input[type=password]:focus{
            border-bottom: 1px solid #4caf50;
         }
         .mepet{
            margin-bottom: 0px;
         }
         body {
            background-image: url(../assets/img/back.jpg);
         }
      </style>
   </head>

   <body class="green lighten-3">
      <div class="row" style="margin-top:8%">
         <div class="col l4 m4 s12 offset-l4 offset-m4">
            <div class="card z-depth-1">
               <div class="card-content green white-text">
                  <h4 class="center">E-Learning Admin Recovery</h4>
               </div>
               <div class="card-action">
                  <form method="post" action="">
                     <div class="row mepet">
                        Masukkan kode recovery !!!
                     </div>
                     <br />
                     <div class="row mepet">
                        <div class="input-field col s12">
                           <i class="fa fa-key prefix"></i>
                           <input id="pass_prefix" type="password" class="validate" name="password" required="password" />
                           <label for="pass_prefix">Code Recovery</label>
                        </div>
                     </div>
                     <div class="row mepet">
                        <div class="input-field col s12">
                           <button class="btn waves-effect waves-light right green" type="submit" name="submit">
                              Submit <i class="fa fa-send right"></i>
                           </button>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
      <center><b><?php echo date('Y'); ?> &copy SMK Al-Husna Loceret</b></center>

      <script type="text/javascript" src="../assets/js/jquery.js"></script>
      <script type="text/javascript" src="../assets/js/materialize.min.js"></script>
   </body>
</html>
