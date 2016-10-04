<?php
   include_once('./include/connection.php');

   ob_start();

   if (empty($_SESSION['type']) || $_SESSION['type'] != 3 || empty($_REQUEST['id'])) {
      header('location:./');
   }

   //set session kerjakan
   $id  = mysqli_real_escape_string($mysqli, $_REQUEST['id']);

   $sql = "SELECT * FROM t_header_soal JOIN t_index_mapel ON t_header_soal.id_index = t_index_mapel.id_index JOIN t_mapel ON t_index_mapel.id_mapel = t_mapel.id_mapel WHERE id_header = '$id'";
   $dat = mysqli_fetch_array(mysqli_query($mysqli, $sql));
?>

<!DOCTYPE html>
<html>
   <head>
      <title>Test <?php echo $dat['nama_mapel']; ?></title>
      <link href="./assets/css/materialize.min.css" rel="stylesheet" type="text/css" />
      <link href="./assets/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
      <link href="./assets/css/style.css" type="text/css" rel="stylesheet" />
      <style type="text/css">
         .side-nav{
            margin-top: 0px;
            height: 100%;
         }
         .top{
            vertical-align: top;
         }
         .garisbawah {
     	      padding-bottom: 5px;
     	      border-bottom: 1px dotted #CCC;
         }
         .card .btn {
            border-radius: 4px;
            height: 30px;
            line-height: 30px;
            padding: 0 1rem;
         }
      </style>
   </head>

   <body onload="init(),noBack()" onpageshow="if (event.persisted) noBack();" onunload="keluar();">
      <?php include_once('test.php'); ?>

      <script type="text/javascript">

      var waktunya;
      waktunya = <?php echo $dat['waktu'] ?>;
      var waktu;
      var jalan = 0;
      var habis = 0;

      function init(){ checkCookie(); mulai(); };

      function keluar(){
         if( habis == 0){
            setCookie('<?php echo $_SESSION['id']; ?>',waktu,365);
         } else {
            setCookie('<?php echo $_SESSION['id']; ?>',0,-1);
         }
      };

      function mulai(){
         jam   = Math.floor(waktu/3600);
         sisa  = waktu%3600;
         menit = Math.floor(sisa/60);
         sisa2 = sisa%60
         detik = sisa2%60;

         if(detik < 10){
            detikx = "0"+detik;
         } else {
            detikx = detik;
         }

         if(menit < 10){
            menitx = "0"+menit;
         } else {
            menitx = menit;
         }

         if(jam < 10){
            jamx = "0"+jam;
         } else {
            jamx = jam;
         }

         document.getElementById("divwaktu").innerHTML = jamx+" Jam : "+menitx+" Menit : "+detikx +" Detik";
         waktu --;
         if(waktu > 0){
            t = setTimeout("mulai()",1000);
            jalan = 1;
         } else {
            if(jalan==1){
               clearTimeout(t);
            }

            habis = 1;
            var submit = document.getElementById("save");
            submit.click();
         }
      };

      function selesai(){
         if(jalan == 1){
            clearTimeout(t);
         }
         habis = 1;
         var submit = document.getElementById("save");
         submit.click();
      };

      function getCookie(c_name){
         if (document.cookie.length > 0){
            c_start=document.cookie.indexOf(c_name + "=");
            if (c_start!=-1){
               c_start=c_start + c_name.length+1;
               c_end=document.cookie.indexOf(";",c_start);
               if (c_end==-1) c_end=document.cookie.length;
               return unescape(document.cookie.substring(c_start,c_end));
            }
         }
         return "";
      };

      function setCookie(c_name,value,expiredays){
         var exdate = new Date();
         exdate.setDate(exdate.getDate()+expiredays);
         document.cookie=c_name+ "=" +escape(value)+((expiredays==null) ? "" : ";expires="+exdate.toGMTString());
      };

      function checkCookie(){
         waktuy=getCookie('<?php echo $_SESSION['id']; ?>');
         if (waktuy!=null && waktuy!=""){
            waktu = waktuy;
         } else {
            waktu = waktunya;
            setCookie('<?php echo $_SESSION['id']; ?>',waktunya,7);
         }
      };

      window.history.forward();
      function noBack(){ window.history.forward(); };
      </script>
   </body>
</html>
<?php
   ob_flush();
?>
