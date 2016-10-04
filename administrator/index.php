<?php

   include_once("../include/connection.php");

   //cek apakah session sudah memiliki nilai
   if(isset($_SESSION['type']) && $_SESSION['type'] != 3) {
      header('location:./dashboard.php');
   } elseif (isset($_SESSION['type']) && $_SESSION['type'] == 3) {
      header('location:../');
   }

   //jika $_REQUEST['login'] di set
   if (isset($_REQUEST['login'])) {

      $user     = mysqli_real_escape_string($mysqli ,trim($_REQUEST['username']));
      $password = mysqli_real_escape_string($mysqli ,trim($_REQUEST['password']));
      $pass     = MD5(MD5($password));

      if ($user == '' || $pass == '') {
         echo '<script type="text/javascript">alert("Username / Password harus diisi !!!");</script>';
      } else {
         $sql   = "SELECT * FROM t_admin WHERE username = '$user' && password = '$pass' && login_status = 'N'";
         $admin = mysqli_query($mysqli, $sql);

         if (mysqli_num_rows($admin) > 0) {

            $data = mysqli_fetch_array($admin);

            $_SESSION['id']   = $data['id_admin'];
            $_SESSION['type'] = $data['type'];
            timer();

            mysqli_query($mysqli, "UPDATE t_admin SET login_status = 'Y' WHERE id_admin = '$data[id_admin]'");
            header('location:./dashboard.php');

         } else {

            $sql  = "SELECT * FROM t_guru WHERE username = '$user' && password = '$pass' && status = 'Y' && login_status = 'N'";
            $guru = mysqli_query($mysqli, $sql);

            if (mysqli_num_rows($guru) > 0) {

               $data = mysqli_fetch_array($guru);

               $_SESSION['id']   = $data['id_guru'];
               $_SESSION['type'] = $data['type'];
               timer();
               mysqli_query($mysqli, "UPDATE t_guru SET login_status = 'Y' WHERE id_guru = '$data[id_guru]'");
               header('location:./dashboard.php');

            } else {
               echo '<script type="text/javascript">alert("Login Gagal ! Silahkan ulangi lagi");</script>';
            }
         }
      }
   } //end if isset $_REQUEST['login']
?>

<!DOCTYPE html>
<html>

   <head>
      <title>User Login</title>
      <link href="../assets/css/materialize.min.css" rel="stylesheet" type="text/css" />
      <link href="../assets/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
      <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.ico" />
      <style type="text/css">
         .input-field label,
         .input-field .prefix{
           color: #0f0f0f;
           font-size: 18px;
         }
         .input-field input[type=text]:focus + label,
         .input-field input[type=password]:focus + label,
         .input-field .prefix.active{
           color: #4caf50;
           font-size: 18px;
           top: 1.5rem;
         }
         .input-field input[type=text]:focus,
         .input-field input[type=password]:focus{
           border-bottom: 1px solid #4caf50;
         }
         .mepet{
           margin-bottom: 0px;
         }
         .card .card-action {
           border-top: 0px;
         }
         .btn {
           border-radius: 4px;
           height: 30px;
           line-height: 30px;
           padding: 0 1rem;
         }
         .image {
           margin-top: 25px;
           border-radius: 100px;
           height: 100px;
           width: 100px;
           border: 2px solid #f8f8f8;
         }
         body {
           background-image: url(../assets/img/back.jpg);
         }
         h4 {
           margin-top: 7px;
         }
         .jarak {
           margin-bottom: 0px;
         }
      </style>
      <noscript>
         <meta http-equiv="refresh" content="0;URL='../include/noscript.html'">
      </noscript>
   </head>

   <body>
      <div class="row" style="margin-top:3%"> <!-- start row content -->

         <div class="col l4 m4 s12 offset-l4 offset-m4"> <!-- start col -->

            <div class="card z-depth-3"> <!-- start card -->

               <div class="card-content row green white-text"><!-- start card-content -->
                  <div class="row jarak">
                     <div class="col m2 offset-m1"><img src="../assets/img/logo.png" width="45px" height="50px" /></div>
                     <div class="col m9"><h4>E - Learning</h4></div>
                  </div>
                  <div class="center"><img src="../assets/img/default.png" class="image"></div>
                  <h5 class="center jarak">Administrator Login</h5>
               </div>
               <div class="card-action">
                  <form method="post" action=""> <!-- start form -->
                     <div class="row mepet"> <!-- start row username -->
                        <div class="input-field col s12">
                           <input id="user_prefix" type="text" class="validate" name="username" required="username" />
                           <label for="user_prefix">Username</label>
                        </div>
                     </div> <!-- end row username -->

                     <div class="row mepet"> <!-- start row password -->
                        <div class="input-field col s12">
                           <input id="pass_prefix" type="password" class="validate" name="password" required="password" />
                           <label for="pass_prefix">Password</label>
                        </div>
                     </div><!-- end row password -->

                     <div class="row mepet"> <!-- start row button -->
                        <div class="input-field col s12">
                           <button class="btn waves-effect waves-light right green" type="submit" name="login">
                              Login <i class="fa fa-sign-in right"></i>
                           </button>
                        </div>
                     </div><!-- end row button -->
                  </form> <!-- end form -->
               </div><!-- end card-content -->
            </div> <!-- end card -->
         </div><!-- end col -->
      </div> <!-- end row content -->

      <center><b><?php echo date('Y'); ?> &copy SMK Al-Husna Loceret</b></center>

      <script type="text/javascript" src="../assets/js/jquery.js"></script>
      <script type="text/javascript" src="../assets/js/materialize.min.js"></script>
   </body>

</html>
