<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <title>e-Print</title>

    <!-- Bootstrap core CSS -->		
	<link rel="shortcut icon" href="assets/favicon.ico">
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/custom" rel="stylesheet">
	<style type="text/css">
	body {
	  padding-top: 12%;
	  padding-bottom: 40px;
	  background-color: #eee;
	}

	.form-signin {
	  max-width: 330px;
	  padding: 15px;
	  margin: 0 auto;
	}
	.form-signin .form-signin-heading,
	.form-signin .checkbox {
	  margin-bottom: 10px;
	}
	.form-signin .checkbox {
	  font-weight: normal;
	}
	.form-signin .form-control {
	  position: relative;
	  height: auto;
	  -webkit-box-sizing: border-box;
		 -moz-box-sizing: border-box;
			  box-sizing: border-box;
	  padding: 10px;
	  font-size: 16px;
	}
	.form-signin .form-control:focus {
	  z-index: 2;
	}
	.form-signin input[type="text"] {
	  margin-bottom: -1px;
	  border-bottom-right-radius: 0;
	  border-bottom-left-radius: 0;
	}
	.form-signin input[type="password"] {
	  margin-bottom: 10px;
	  border-top-left-radius: 0;
	  border-top-right-radius: 0;
	}
	</style>
	
  </head>

  <body>

    <div class="container">
	<?php
	include "koneksi.php";
	$qid = mysql_query('SELECT MAX(iduser) FROM user');
	list($id) = mysql_fetch_row($qid);
		$idbaru = $id + 1;
	if( isset( $_REQUEST['submit2'] ) ){
		$username = $_REQUEST['username'];
		$nickname = $_REQUEST['nickname'];
		$password = $_REQUEST['password'];
		$sql = mysql_query("insert into user values('$idbaru','$username','$password','2','$nickname@konsumen')");
		header('Location: ');

	}
	if( isset( $_REQUEST['submit'] ) ){
		$username = $_REQUEST['username'];
		$password = $_REQUEST['password'];
		
		$sql = mysql_query("SELECT iduser,username,admin,fullname FROM user WHERE username='$username' AND password='$password' ");
		
		if( mysql_num_rows($sql) > 0 ){
			list($iduser,$username,$admin,$fullname) = mysql_fetch_array($sql);
			
			//session_start();
			$_SESSION['iduser'] = $iduser;
			$_SESSION['username'] = $username;
			$_SESSION['admin'] = $admin;
			$_SESSION['fullname'] = $fullname;
			
			header("Location: ./admin.php");
			die();
		} else {
			//$err = '<strong>ERROR!</strong> Username dan Password tidak ditemukan.';
			//header('Location: ./?err='.urlencode($err));
			
			$_SESSION['err'] = '<strong>ERROR!</strong> Username dan Password tidak ditemukan.';
			header('Location: ./');
			die();
		}
		
	} else {
	?>
	<div class="tab-content">
	<div id="login" class="tab-pane fade in active">
     <form class="form-signin" method="post" action="" role="form">
		<?php
		if(isset($_SESSION['err'])){
			$err = $_SESSION['err'];
			echo '<div class="alert alert-warning alert-message">'.$err.'</div>';
		}
		?>
        <h2 align="center" class="form-signin-heading"><span class="glyphicon glyphicon-paperclip"></span> e-Print </h2>
        <input type="text" name="username" class="form-control" placeholder="Username"  required autofocus>
        <input type="password" name="password" class="form-control" placeholder="Password" required>
        <button class="btn btn-lg btn-info btn-block" type="submit" name="submit">Login</button>
		<a data-toggle="tab" href='#register'><h5 align='right'><u><em>Buat akun baru</u></em> ?</h5></a>
	</form>
	</div>
	<div id="register" class="tab-pane fade in">
    <form class="form-signin" method="post" action="" role="form">
		<?php
		if(isset($_SESSION['err'])){
			$err = $_SESSION['err'];
			echo '<div class="alert alert-warning alert-message">'.$err.'</div>';
		}
		?>
        <h2 align="center" class="form-signin-heading"><span class="glyphicon glyphicon-paperclip"></span> e-Print </h2>
        <input type="text" name="username" class="form-control" placeholder="Username" required autofocus>
		<input type="text" name="nickname" class="form-control" placeholder="Nickname" required>
        <input type="password" name="password" class="form-control" placeholder="Password" required>
        <button class="btn btn-lg btn-info btn-block" type="submit" name="submit2">Register</button>
		<a data-toggle="tab" href="#login"><h5 align='left'><u><em>Sudah punya akun</u></em> ?</h5></a>
	</form>
	</div>
	</div>
	<?php
	}
	?>
    </div> <!-- /container -->
	
	<!-- Bootstrap core JavaScript, Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
	
	<script type="text/javascript">
		$(".alert-message").alert().delay(1000).slideUp('slow');
	</script>
  </body>
</html>