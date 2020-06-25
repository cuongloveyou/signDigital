<?php
session_start();
?>
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

			$sql = "SELECT * FROM `signtable` WHERE `username` = '$username' AND `password` = '$password'";

			$result = mysqli_query($conn, $sql);
			if (mysqli_num_rows($result) > 0) 
			{
                $_SESSION['username'] = $username;
				header("location: signature-2.html?id=1");
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
                
                <form action="/upload.php" method="post" enctype="multipart/form-data">
                <input type="hidden" class="form-control" name="username" id = "usersigned">
          <input type="hidden" class="form-control" name="csign" id = "csign">
            <input type = "hidden" id="inputTextToSave" name = "cont" />
            <button onclick="decryption();" class="btn btn-primary">Decryption </button>
          <!-- <input type="submit" value="Kiểm tra" name="submit" class="btn btn-primary"> -->
      </form>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script  type="text/javascript">
    var s = "";
    function loadFileAsText() {
        var fileToLoad = document.getElementById("fileupload").files[0];

        var fileReader = new FileReader();
        fileReader.onload = function (fileLoadedEvent) {
            var textFromFileLoaded = fileLoadedEvent.target.result;
            document.getElementById("inputTextToSave").value = textFromFileLoaded;
        };
        fileReader.readAsText(fileToLoad, "UTF-8");

        
    }


    function SHA1 () {
    function rotate_left(n,s) {
        var t4 = ( n<<s ) | (n>>>(32-s));
        return t4;
    };
    function lsb_hex(val) {
        var str="";
        var i;
        var vh;
        var vl;
        for( i=0; i<=6; i+=2 ) {
            vh = (val>>>(i*4+4))&0x0f;
            vl = (val>>>(i*4))&0x0f;
            str += vh.toString(16) + vl.toString(16);
        }
        return str;
    };

    function cvt_hex(val) {
        var str="";
        var i;
        var v;
        for( i=7; i>=0; i-- ) {
            v = (val>>>(i*4))&0x0f;
            str += v.toString(16);
        }
        return str;
    };
    function Utf8Encode(string) {
        string = string.replace(/\r\n/g,"\n");
        var utftext = "";
        for (var n = 0; n < string.length; n++) {
            var c = string.charCodeAt(n);
            if (c < 128) {
                utftext += String.fromCharCode(c);
            }
            else if((c > 127) && (c < 2048)) {
                utftext += String.fromCharCode((c >> 6) | 192);
                utftext += String.fromCharCode((c & 63) | 128);
            }
            else {
                utftext += String.fromCharCode((c >> 12) | 224);
                utftext += String.fromCharCode(((c >> 6) & 63) | 128);
                utftext += String.fromCharCode((c & 63) | 128);
            }
        }
        return utftext;
    };
    var blockstart;
    var i, j;
    var W = new Array(80);
    var H0 = 0x67452301;
    var H1 = 0xEFCDAB89;
    var H2 = 0x98BADCFE;
    var H3 = 0x10325476;
    var H4 = 0xC3D2E1F0;
    var A, B, C, D, E;
    var temp;
    msg = Utf8Encode(s);
    var msg_len = msg.length;
    var word_array = new Array();
    for( i=0; i<msg_len-3; i+=4 ) {
        j = msg.charCodeAt(i)<<24 | msg.charCodeAt(i+1)<<16 |
        msg.charCodeAt(i+2)<<8 | msg.charCodeAt(i+3);
        word_array.push( j );
    }
    switch( msg_len % 4 ) {
        case 0:i = 0x080000000;break;
        case 1:i = msg.charCodeAt(msg_len-1)<<24 | 0x0800000; break;   
        case 2:
            i = msg.charCodeAt(msg_len-2)<<24 | msg.charCodeAt(msg_len-1)<<16 | 0x08000;
        break;
        case 3:
            i = msg.charCodeAt(msg_len-3)<<24 | msg.charCodeAt(msg_len-2)<<16 | msg.charCodeAt(msg_len-1)<<8    | 0x80;
        break;
    }
    word_array.push( i );
    while( (word_array.length % 16) != 14 ) word_array.push( 0 );
    word_array.push( msg_len>>>29 );
    word_array.push( (msg_len<<3)&0x0ffffffff );
    for ( blockstart=0; blockstart<word_array.length; blockstart+=16 ) {
        for( i=0; i<16; i++ ) W[i] = word_array[blockstart+i];
        for( i=16; i<=79; i++ ) W[i] = rotate_left(W[i-3] ^ W[i-8] ^ W[i-14] ^ W[i-16], 1);
        A = H0;
        B = H1;
        C = H2;
        D = H3;
        E = H4;
        for( i= 0; i<=19; i++ ) {
            temp = (rotate_left(A,5) + ((B&C) | (~B&D)) + E + W[i] + 0x5A827999) & 0x0ffffffff;
            E = D;
            D = C;
            C = rotate_left(B,30);
            B = A;
            A = temp;
        }
        for( i=20; i<=39; i++ ) {
            temp = (rotate_left(A,5) + (B ^ C ^ D) + E + W[i] + 0x6ED9EBA1) & 0x0ffffffff;
            E = D;
            D = C;
            C = rotate_left(B,30);
            B = A;
            A = temp;
        }
        for( i=40; i<=59; i++ ) {
            temp = (rotate_left(A,5) + ((B&C) | (B&D) | (C&D)) + E + W[i] + 0x8F1BBCDC) & 0x0ffffffff;
            E = D;
            D = C;
            C = rotate_left(B,30);
            B = A;
            A = temp;
        }
        for( i=60; i<=79; i++ ) {
            temp = (rotate_left(A,5) + (B ^ C ^ D) + E + W[i] + 0xCA62C1D6) & 0x0ffffffff;
            E = D;
            D = C;
            C = rotate_left(B,30);
            B = A;
            A = temp;
        }
        H0 = (H0 + A) & 0x0ffffffff;
        H1 = (H1 + B) & 0x0ffffffff;
        H2 = (H2 + C) & 0x0ffffffff;
        H3 = (H3 + D) & 0x0ffffffff;
        H4 = (H4 + E) & 0x0ffffffff;
    }
    var temp = cvt_hex(H0) + cvt_hex(H1) + cvt_hex(H2) + cvt_hex(H3) + cvt_hex(H4);
    return temp.toLowerCase();
}

function giai_ma_hexa(s){
    var gm = "";
    // var x = s.charAt(0) + s.charAt(1);
    // alert(String.fromCharCode(parseInt(x.toString(16),16)));
    for(var i = 0; i < s.length; i += 2){
        var x = s.charAt(i) + s.charAt(i+1);
        gm += String.fromCharCode(parseInt(x.toString(16),16));
    }
    return gm;
}

    function decryption(){
        var nd = document.getElementById("inputTextToSave").value;

        var mang_nd = nd.split('\n');
        var length_mang = mang_nd.length;
        document.getElementById("usersigned").value = giai_ma_hexa(mang_nd[length_mang-4].toString());
        document.getElementById("csign").value = giai_ma_hexa(mang_nd[length_mang-2].toString());
        // var s = "";
        for (var i = 0; i < length_mang - 5; i++) {
          s += giai_ma_hexa(mang_nd[i]) + '\n';
        }
        s += giai_ma_hexa(mang_nd[length_mang - 5]);
        var mb = SHA1();
        document.getElementById("inputTextToSave").value = mb;
     }

  </script>


  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>