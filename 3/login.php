<!DOCTYPE html>
<?php
		//$conn = mysqli_connect('localhost', 'root', 'vertrigo', 'test');
		$conn = mysqli_connect('localhost', 'root', 'vertrigo', 'signbase');
		if (!$conn) {
			die("Kết nối thất bại: " . mysqli_connect_error());
		}
		mysqli_set_charset($conn, 'UTF8');
		$error = "";
		if($_SERVER["REQUEST_METHOD"] == "POST") {
			$username = $_POST['username'];
			$password = $_POST['password'];

			$sql = "SELECT * FROM `signtable` WHERE `username` = '$username' AND `password` = '$password'";

			$result = mysqli_query($conn, $sql);
			if (mysqli_num_rows($result) > 0) 
			{
        
				header("location: signature-2.html");
			} 
			else {
				$error = "Tài khoản hoặc mật khẩu của bạn không chính xác";
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
</head>

<body>
  <div class="py-5" style="">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <form id="c_form-h" class="" method="POST">
            <h4 class="text-uppercase"><i><b>Đăng nhập</b></i></h4>
            <div class="form-group row"> <label for="inputmailh" class="col-2 col-form-label" style="">E-mail</label>
              <div class="col-10 col-md-7" style="">
                <input type="text" class="form-control" name="username" > </div>
            </div>
            <div class="form-group row"> <label for="inputpasswordh" class="col-2 col-form-label" style="">Password</label>
              <div class="col-10 col-md-7" style="">
                <input type="password" class="form-control" name="password" > </div>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
            <div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>
          </form>
          <div class="container">
            <div class="row">
              <div class="pt-2">
                <h6 class=""><a href="/register-1.html">Đăng ký</a></h6>
              </div>
            </div>
          </div>
          <div class="container">
            <div class="row">
              <div class="col-md-12">
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="container">
            <div class="row">
              <div class="col-md-12">
                <h4 class="text-uppercase"><i><b>KIỂM tra chữ ký</b></i></h4>
              </div>
            </div>
          </div>
          <div class="container">
             <input type="file" name="fileupload" id="fileupload" >
              <button onclick="loadFileAsText()" class="btn btn-primary">Load File</button>
              <div>
                <button onclick="decryption();" class="btn btn-primary">decryption </button>
                <form action="/upload.php" method="post" enctype="multipart/form-data">
          Chọn file để upload:
          <input type="text" class="form-control" name="username" id = "usersigned">
          <input type="text" class="form-control" name="csign" id = "csign">
            <input type = "hidden" id="inputTextToSave" name = "cont" />
          <input type="submit" value="Kiểm tra" name="submit" class="btn btn-primary">
      </form>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script  type="text/javascript">

    function loadFileAsText() {
        var fileToLoad = document.getElementById("fileupload").files[0];

        var fileReader = new FileReader();
        fileReader.onload = function (fileLoadedEvent) {
            var textFromFileLoaded = fileLoadedEvent.target.result;
            document.getElementById("inputTextToSave").value = textFromFileLoaded;
        };
        fileReader.readAsText(fileToLoad, "UTF-8");

        
    }

    function layDuLieu(){
      //var nd = document.getElementById("inputTextToSave").value;
        //var mang_nd = nd.split('\n');
        //var length_mang = mang_nd.length;
        //var user = 
        
        }

    function decryption(){
        var nd = document.getElementById("inputTextToSave").value;
        var mang_nd = nd.split('\n');
  // var p_user = nd.lastIndexOf("user:")+5;
  // var v_user = nd.slice(p_user,nd.length);
        var length_mang = mang_nd.length;
        var cc = mang_nd[length_mang-2]*1;
        document.getElementById("usersigned").value = mang_nd[length_mang-4];
        document.getElementById("csign").value = mang_nd[length_mang-2];
        var s = "";
        for (var i = 0; i < length_mang - 4; i++) {
          s += mang_nd[i] + '\n';
        }
        document.getElementById("inputTextToSave").value = s;

        /*for(var i = 4; i > 0; i--){
            alert(i + ": " + mang_nd[length_mang-i]);
        }*/
      alert(s);
        var privateKey = arr[6];
        alert("pK: " + privateKey);
        var dm = 1;
        dm = mul11(1319, privateKey);
        alert("m: " + dm);
  // alert("c: " + c);
  // alert("type: " + typeof c);
     }

  </script>


  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>