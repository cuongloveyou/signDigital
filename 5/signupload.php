<?php
    $target_name = basename($_FILES["fileupload"]["name"]);
	$target_file   = "uploads/" . $target_name;

    if (move_uploaded_file($_FILES["fileupload"]["tmp_name"], $target_file))
    {
        $msg = "Ký lên văn bản thành công";
    }
    else
    {
        $msg = "Có lỗi rồi Đại Vương ơi";
    }
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
  <link rel="stylesheet" href="https://static.pingendo.com/bootstrap/bootstrap-4.3.1.css">
</head>

<body onload="sign()">
<?php include("header.php"); ?>
  <div class="py-5">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h5 class="text-uppercase" ><b><?php echo $msg ?></b></h5>
          <a href="/download.php?filename=<?php echo $target_name?>" >Download</a>
        </div>
      </div>
    </div>
  </div>
  <table>
 <tr><td>Text to Save:</td></tr>
 <tr>
  <td colspan="3">
   <textarea id="inputTextToSave" style="width:512px;height:256px"></textarea>
  </td>
 </tr>
 <tr>
  <td>Filename to Save As:</td>
  <td><input id="inputFileNameToSaveAs"></input></td>
  <td><button onclick="saveTextAsFile()">Save Text to File</button></td>
 </tr>
 <tr>
  <td>Select a File to Load:</td>
  <td><input type="file" id="fileToLoad"></td>
  <td><button onclick="loadFileAsText()">Load Selected File</button><td>
 </tr>
</table>

<script type='text/javascript'>

    function saveTextAsFile() {
        var textToWrite = document.getElementById("inputTextToSave").value;
        var textFileAsBlob = new Blob([textToWrite], { type: 'text/plain' });
        var fileNameToSaveAs = document.getElementById("inputFileNameToSaveAs").value;

        var downloadLink = document.createElement("a");
        downloadLink.download = fileNameToSaveAs;
        downloadLink.innerHTML = "Download File";
        if (window.webkitURL != null) {
            downloadLink.href = window.webkitURL.createObjectURL(textFileAsBlob);
        }
        else {
            downloadLink.href = window.URL.createObjectURL(textFileAsBlob);
            downloadLink.onclick = destroyClickedElement;
            downloadLink.style.display = "none";
            document.body.appendChild(downloadLink);
        }

        downloadLink.click();
    }

    function destroyClickedElement(event) {
        document.body.removeChild(event.target);
    }

    function loadFileAsText() {
        var fileToLoad = document.getElementById("fileToLoad").files[0];

        var fileReader = new FileReader();
        fileReader.onload = function (fileLoadedEvent) {
            var textFromFileLoaded = fileLoadedEvent.target.result;
            document.getElementById("inputTextToSave").value = textFromFileLoaded + "\n" + "abc";
        };
        fileReader.readAsText(fileToLoad, "UTF-8");
    }

</script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>