<?php
session_start();
?>
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
            $csign = $_POST['csign'];
            $cont = $_POST['cont'];
            $sql = "SELECT * FROM `signtable` WHERE `username` = '$username'";
            $i=0;
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) 
            {        
                while($row = mysqli_fetch_assoc($result)) {
                $cop[$i]=array_values($row)[6];
                $i++;
                $cop[$i]=array_values($row)[8];
                $i++;
                $cop[$i]=array_values($row)[1];
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
                $error = "Tài khoản đã ký không có trong hệ thống";
            }
        }
        mysqli_close($conn);
        ?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body onload="decryption()">
  
</body>
</html>
        <script type="text/javascript">
        var n;
        function mul11(a, b){
              if(b == 0 ){
                return 1;
              }
              else if(b < 100000){
                return (a*mul11(a, b-1))%(n);
              }
              else{
                var k = mul11(a,b/2)%n;
                if(b%2 == 0){
                  return (k*k)%n ;
                }
                else{
                  return ((k*k)%n*a)%n;
                }
              }
              
            }

            function decryption() {
                var h_d = new Array(16);
                var arr= <?php echo json_encode($copy);?>;
                var c = <?php echo $csign; ?>;

                for(var i = 0; i < 10; i++){
                    var j = i + "";
                    h_d[j] = i;
                  } 

                  h_d["a"] = 10;
                  h_d["b"] = 11;
                  h_d["c"] = 12;
                  h_d["d"] = 13;
                  h_d["e"] = 14;
                  h_d["f"] = 15;
                  var cb = <?php echo json_encode($cont); ?>;
                  var dai = cb.length-1;
                  var M = 0;
                  var mu = 1;
                  n = arr[0];
                  while(dai){
                    var x = cb.charAt(dai);
                    M = (M%n + (h_d[x]*mu)%n)%n;
                    mu *= 16;
                    dai--;
                  }

                n = arr[0];
                var privateKey = arr[1];
                var dm = 1;
                dm = mul11(c, privateKey);
                var tt = "bad signature";
                if(dm == M){
                    tt = "";
                    tt += "user:  " + arr[2] + "\n";
                    tt += "email:  " + arr[4] + "\n";
                    tt += "company: " + arr[3] + "\n";
                    tt += "address: " + arr[5] + "\n";
                    tt += "good signature";
                }
                if (window.confirm(tt))
                {
                    document.location = 'index.php';
                }
                
            }

        </script>