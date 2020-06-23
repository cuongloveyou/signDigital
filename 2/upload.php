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
            echo $cont;
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
//
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
    //
    //var 
    // readTextFile('file:////C:/Users/Admin/Desktop/test.txt');
    var allText = <?php echo $cont; ?>;
    alert(allText);
    //
    msg = Utf8Encode(allText);
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
    alert(temp.toLowerCase());
    return temp.toLowerCase();
}
//

            function decryption() {
                var h_d = new Array(16);
                var arr= <?php echo json_encode($copy);?>;
                var c = <?php echo $csign; ?>;
                // var cont = <?php echo $cont; ?>;
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
  var cb = SHA1();
  alert("cb: " + cb);
  var dai = cb.length-1;
  var M = 0;
  var mu = 1;
  n = arr[4];
  while(dai){
    var x = cb.charAt(dai);
    M = (M%n + (h_d[x]*mu)%n)%n;
    mu *= 16;
    dai--;
  }
  alert("m: " + M);


                alert("c = " + c);
                n = arr[0];
                var privateKey = arr[1];
                alert("pK: " + n + " " + privateKey);
                var dm = 1;
                dm = mul11(c, privateKey);
                alert("m: " + dm);
                if(dm == M){
                    alert("met vl");
                }
            }

        </script>