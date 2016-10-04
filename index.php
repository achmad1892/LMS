<?php
   include_once('./include/connection.php');

   //cek type session
   if (isset($_SESSION['type']) && $_SESSION['type'] == 3) {
      header('location:./dashboard.php');
   } elseif (isset($_SESSION['type']) && $_SESSION['type'] != 3) {
      header('location:./admin/dashboard.php');
   }

   //cek apakah $_REQUEST['login'] diset
   if (isset($_REQUEST['login'])) {
      $user = mysqli_real_escape_string($mysqli, $_REQUEST['username']);
      $pass = mysqli_real_escape_string($mysqli, $_REQUEST['password']);

      if ($user == '' || $pass == '') {
         echo '<script type="text/javascript">alert("Username / Password harus diisi !!!");</script>';
      } else {
         $sql   = "SELECT * FROM t_siswa WHERE username = '$user' && password = MD5(MD5('$pass'))";
         $siswa = mysqli_query($mysqli, $sql);

         if (mysqli_num_rows($siswa) > 0) {
            $hasil = mysqli_fetch_array($siswa);

            $_SESSION['id']     = $hasil['nis'];
            $_SESSION['type']   = $hasil['type'];
            $_SESSION['kelas']  = $hasil['id_kelas'];
            timer();

            mysqli_query($mysqli, "UPDATE t_siswa SET login_status = 'Y' WHERE nis = '$hasil[nis]'");
            header('location:./dashboard.php');
         } else {
            echo '<script type="text/javascript">alert("Login Gagal !!!");</script>';
         }
      }
   } //end isset $_REQUEST['login']
?>

<!DOCTYPE html>
<html>
   <head>
      <title>E-Learning Login</title>
      <link href="./assets/css/materialize.min.css" rel="stylesheet" type="text/css" />
      <link href="./assets/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
      <link rel="shortcut icon" type="image/x-icon" href="./assets/img/favicon.ico" />
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
            background-color: #4caf50;
         }
         body {
            background-image: url(./assets/img/back.jpg);
         }
         h4 {
            margin-top: 5px;
         }
         .jarak {
            margin-bottom: 0px;
         }
      </style>
      <noscript>
         <meta http-equiv="refresh" content="0;URL='../include/noscript.html'">
      </noscript>
   </head>

   <body class="green lighten-3">
      <div class="row" style="margin-top:3%"> <!-- Start Row -->
         <div class="col l4 m4 s12 offset-l4 offset-m4">
            <div class="card z-depth-1">
               <div class="card-content row green white-text">
                  <div class="row jarak">
                     <div class="col m2 offset-m1"><img src="./assets/img/logo.png" width="40px" height="45px" /></div>
                     <div class="col m9"><h4>E - Learning</h4></div>
                  </div>
                  <div class="center"><img src="./assets/img/default.png" class="image"></div>
                  <h5 class="center jarak">User Login</h5>
               </div>
               <div class="card-action">
                  <form method="post" action=""> <!-- form start -->
                     <div class="row mepet">
                        <div class="input-field col s12">
                           <input id="user_prefix" type="text" class="validate" name="username" required="username" />
                           <label for="user_prefix">Username</label>
                        </div>
                     </div>
                     <div class="row mepet">
                        <div class="input-field col s12">
                           <input id="pass_prefix" type="password" class="validate" name="password" required="password" />
                           <label for="pass_prefix">Password</label>
                        </div>
                     </div>
                     <div class="row mepet">
                        <div class="input-field col s12">
                           <button class="btn waves-effect waves-light right green" type="submit" name="login">
                              Login <i class="fa fa-sign-in right"></i>
                           </button>
                        </div>
                     </div>
                  </form> <!-- end of form -->
               </div>
            </div>
         </div>
      </div><!-- end of Row -->
      <center><b><?php echo date('Y'); ?> &copy SMK Al-Husna Loceret</b></center>

      <script type="text/javascript" src="./assets/js/jquery.js"></script>
      <script type="text/javascript" src="./assets/js/materialize.min.js"></script>
   </body>
</html>
