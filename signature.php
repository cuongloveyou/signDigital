<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
  <link rel="stylesheet" href="https://static.pingendo.com/bootstrap/bootstrap-4.3.1.css">
</head>

<body onload="myfn()">
  <div class="py-5">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <div class="container">
            <div class="row">
              <div class="col-md-12">
                <h4 class="text-uppercase"><i><b>Thông tin tài khoản</b></i></h4>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <form id="c_form-h" class="" method="POST">
                  <div class="form-group row"> <label for="inputmailh" class="col-form-label col-3" style="">Tài khoản</label>
                    <div class="col-10 col-md-7" style="">
                      <input type="text" class="form-control" id="username"> </div>
                  </div>
                  <div class="form-group row"> <label for="inputmailh" class="col-form-label col-3" style="">Tên công ty</label>
                    <div class="col-10 col-md-7" style="">
                      <input type="text" class="form-control" id="companyName"> </div>
                  </div>
                  <div class="form-group row"> <label for="inputmailh" class="col-form-label col-3" style="">Mail</label>
                    <div class="col-10 col-md-7" style="">
                      <input type="text" class="form-control" id="mailAddress"> </div>
                  </div>
                  <div class="form-group row"> <label for="inputmailh" class="col-form-label col-3" style="">Địa chỉ</label>
                    <div class="col-10 col-md-7" style="">
                      <input type="text" class="form-control" id="address"> </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6" >
          <div class="container">
            <div class="row">
              <div class="col-md-12" id="check">
                <h4 class="text-uppercase"><i><b>ký lên tài liệu</b></i></h4>
              </div>
            </div>
          </div>
          <div class="container">
            <form action="/signupload.php" method="post" enctype="multipart/form-data"> Chọn file để upload: <input type="file" name="fileupload" id="fileupload">
              <input type="submit" value="Submit" name="submit" class="btn btn-primary">
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php
    $conn = mysqli_connect('localhost', 'root', 'vertrigo', 'signbase');
    if (!$conn) {
      die("Kết nối thất bại: " . mysqli_connect_error());
    }
    mysqli_set_charset($conn, 'UTF8');
    $error = "";
      $sql = "SELECT * FROM `signtable` WHERE `username` = 'rwus'";
      $i=0;
      $result = mysqli_query($conn, $sql);
      if (mysqli_num_rows($result) > 0) 
      {
      while($row = mysqli_fetch_assoc($result)) {
        $cop[$i]= array_values($row)[1];
        $i++;
        $cop[$i]=array_values($row)[3];
        $i++;
        $cop[$i]=array_values($row)[4];
        $i++;
        $cop[$i]=array_values($row)[5];
        $i++;
        $copy=$cop;
        }
      } 
      else {
        $error = "Tài khoản hoặc mật khẩu của bạn không chính xác";
      }
    
    mysqli_close($conn);
    ?>
<script language="javascript">
  function myfn() {
    var arr= <?php echo json_encode($copy);?>;
    document.getElementById("username").value = arr[0];
    document.getElementById("companyName").value = arr[1];
    document.getElementById("mailAddress").value = arr[2];
    document.getElementById("address").value = arr[3];

  }
</script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>