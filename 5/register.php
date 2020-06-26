<!DOCTYPE html>
<?php

		$conn = mysqli_connect('localhost', 'root', 'vertrigo', 'signbase');
		if (!$conn) {
			die("Kết nối thất bại: " . mysqli_connect_error());
		}
		mysqli_set_charset($conn, 'UTF8');
		$error = "";
		if($_SERVER["REQUEST_METHOD"] == "POST") {
			$username = $_POST['username'];
			$password = $_POST['password'];
			$companyName = $_POST['companyName'];
			$mailAddress = $_POST['mailAddress'];
			$address = $_POST['address'];
			$privateKey = $_POST['privateKey'];
			$publicKey = $_POST['publicKey'];
			
			$moduleNumber = $_POST['moduleNumber'];

			$sql = "SELECT * FROM `signtable` WHERE `username` = '$username'";

			$result = mysqli_query($conn, $sql);
			if (mysqli_num_rows($result) > 0) 
			{
				$error = "Tài khoản đã tồn tại";
			} 
			else {

				$sql212 = "SELECT * FROM `signtable` WHERE `moduleNumber` = '$moduleNumber' AND `publicKey` = '$publicKey' AND `privateKey` = '$privateKey'  ";
				$result212 = mysqli_query($conn, $sql212);
				if (mysqli_num_rows($result212) > 0) 
				{
				 	echo "<script> window.onload = function() {
    					 	createKey();
 					}; </script>";
				} 
				else{				

				
				$sql2 = "INSERT INTO `signtable`(`username`, `password`, `companyName`, `mailAddress`, `address`, `moduleNumber`, `publicKey`, `privateKey`) VALUES ('$username','$password','$companyName','$mailAddress','$address','$moduleNumber','$publicKey','$privateKey')";
				$result2 = mysqli_query($conn, $sql2);
				header("location: index.php");
				}
			}
		}
		mysqli_close($conn);
?>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
  <link rel="stylesheet" href="https://static.pingendo.com/bootstrap/bootstrap-4.3.1.css">
  <script type="text/javascript" src="tao_khoa_rsa_hdh.js" ></script>
</head>

<body onload="createKey()">
  <div class="py-5 mx-5" style="">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h4 class="text-uppercase"><i><b>Đăng ký</b></i></h4>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <form id="c_form-h" class="" method="POST">
            <div class="form-group row"> <label for="inputmailh" class="col-2 col-form-label" style="">Tài khoản</label>
              <div class="col-10 col-md-4" style="">
                <input type="text" class="form-control" id="inputmailh" name="username"> </div>
            </div>
            <div class="form-group row"> <label for="inputpasswordh" class="col-2 col-form-label" style="">Mật khẩu</label>
              <div class="col-10 col-md-4" style="">
                <input type="password" class="form-control" id="inputpasswordh" name="password"> </div>
            </div>
            <div class="form-group row"> <label for="inputmailh" class="col-2 col-form-label" style="">Tên công ty</label>
              <div class="col-10 col-md-4" style="">
                <input type="text" class="form-control" id="inputmailh" name="companyName"> </div>
            </div>
            <div class="form-group row"> <label for="inputmailh" class="col-2 col-form-label" style="">Mail</label>
              <div class="col-10 col-md-4" style="">
                <input type="text" class="form-control" id="inputmailh" name="mailAddress"> </div>
            </div>
            <div class="form-group row"> <label for="inputmailh" class="col-2 col-form-label" style="">Địa chỉ</label>
              <div class="col-10 col-md-4" style="">
                <input type="text" class="form-control" id="inputmailh" name="address"> </div>
            </div>
	    <div class="col-10 col-md-4" style="">
                <input type="hidden" class="form-control" id="n" name="moduleNumber"  ></div>
            <div class="col-10 col-md-4" style="">
                <input type="hidden" class="form-control" id="e" name="publicKey" > </div>
            <div class="col-10 col-md-4" style="">
                <input type="hidden" class="form-control" id="d" name="privateKey" > </div>
            <button type="submit" class="btn btn-primary" >Submit</button>
            <div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>