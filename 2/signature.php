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
             <input type="file" name="fileupload" id="fileupload" >
              <button onclick="loadFileAsText()" class="btn btn-primary">Load File</button>
              <div>
                <button onclick="encryption();" class="btn btn-primary">Sign </button>
                <button onclick="saveFile();" class="btn btn-primary">Download </button>
                <button onclick="decryption();" class="btn btn-primary">decryption </button>

              </div>
            <input type = "hidden" id="inputTextToSave"  />
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
      $sql = "SELECT * FROM `signtable` WHERE `username` = 'xx'";
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
//
        $cop[$i]=array_values($row)[6];
        $i++;
        $cop[$i]=array_values($row)[7];
        $i++;
        $cop[$i]=array_values($row)[8];
        $i++;
//
        $copy=$cop;
        }
      } 
      else {
        $error = "Tài khoản hoặc mật khẩu của bạn không chính xác";
      }
    
    mysqli_close($conn);
    ?>
<script type="text/javascript">
    var arr;
  function myfn() {
    arr= <?php echo json_encode($copy);?>;
    document.getElementById("username").value = arr[0];
    document.getElementById("companyName").value = arr[1];
    document.getElementById("mailAddress").value = arr[2];
    document.getElementById("address").value = arr[3];

  }

  function loadFileAsText() {
        var fileToLoad = document.getElementById("fileupload").files[0];

        var fileReader = new FileReader();
        fileReader.onload = function (fileLoadedEvent) {
            var textFromFileLoaded = fileLoadedEvent.target.result;
            document.getElementById("inputTextToSave").value = textFromFileLoaded;
        };
        fileReader.readAsText(fileToLoad, "UTF-8");

        
    }
    function saveFile() {
      var textToWrite = document.getElementById("inputTextToSave").value;
        var textFileAsBlob = new Blob([textToWrite], { type: 'text/plain' });
        var fileNameToSaveAs = document.getElementById("fileupload").files[0].name;

        var downloadLink = document.createElement("a");
        downloadLink.download = fileNameToSaveAs;
        downloadLink.innerHTML = "Download File";
        if (window.webkitURL != null) {
            // Chrome allows the link to be clicked
            // without actually adding it to the DOM.
            downloadLink.href = window.webkitURL.createObjectURL(textFileAsBlob);
        }
        else {
            // Firefox requires the link to be added to the DOM
            // before it can be clicked.
            downloadLink.href = window.URL.createObjectURL(textFileAsBlob);
            downloadLink.onclick = destroyClickedElement;
            downloadLink.style.display = "none";
            document.body.appendChild(downloadLink);
        }

        downloadLink.click();
    }

var prime = new Array(10000);
var count = 0;
var allText;
var bam;
var h_d = new Array(16);
var n = 1;
var e = 1;
var d = 1;




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
    allText = document.getElementById("inputTextToSave").value;
    //alert(allText);
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
  //  alert(temp.toLowerCase());
    bam = temp.toLowerCase();
    return temp.toLowerCase();
}


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

function encryption(){

    var arr1 = <?php echo json_encode($copy);?>;
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
//  hex_decimal11.forEach((value, key, map) => {
//     console.log(value, key, map);
// });
  var cb = SHA1();
  // var cb = "0123456789012345678901234567890123456789";
  var dai = cb.length-1;
  //alert("dai day: " + dai);
  
  
  // var dai = allText.length()-1;
  // aler("dai dau: " + dai);
  var M = 0;
  var mu = 1;
  n = arr[4];
  while(dai){
    
    //alert("dai day: " + dai);
    var x = cb.charAt(dai);
    //alert("ky tu: " + x + " type: " + (typeof x));
    //alert("h_d: k = " + x + "  value = " + h_d[x]);
    M = (M%n + (h_d[x]*mu)%n)%n;
    //M += (h_d[x]*mu);
    mu *= 16;
    dai--;
  }
  alert("m: " + M);
  //var c = 0;
  var e1 = e;
  e = arr[5];
  alert("a5: " + arr[5]);
   // alert("e: " + e);
   //
   
   //

  c = mul11(M, e);
  var today1 = new Date();
  var date1 = today1.getDate()+'-'+(today1.getMonth()+1)+'-'+today1.getFullYear();
  alert("c: " + c);
  alert("date: " + date1);
  document.getElementById("inputTextToSave").value = document.getElementById("inputTextToSave").value + "\n" + arr[0] + "\nemail: " + arr[2] + "\n" + c + "\n" + date1;
  return c;
}

function decryption(){
  var nd = document.getElementById("inputTextToSave").value;
  var mang_nd = nd.split('\n');
  // var p_user = nd.lastIndexOf("user:")+5;
  // var v_user = nd.slice(p_user,nd.length);
  var length_mang = mang_nd.length;
  var cc = mang_nd[length_mang-2]*1;
  var privateKey = arr[6];
  alert("pK: " + privateKey);
  var dm = 1;
  dm = mul11(cc, privateKey);
  alert("m: " + dm);
  for(var i = 4; i > 0; i--){
    alert(i + ": " + mang_nd[length_mang-i]);
  }
  // alert("c: " + c);
  // alert("type: " + typeof c);
}
 


</script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>