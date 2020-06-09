<?php
	$target_file   = "uploads/" . basename($_FILES["fileupload"]["name"]);

    if (move_uploaded_file($_FILES["fileupload"]["tmp_name"], $target_file))
    {
        echo "File ". basename( $_FILES["fileupload"]["name"])." Đã upload thành công";
        header("location: index.php");
    }
    else
    {
        echo "Có lỗi xảy ra khi upload file.";
    }
?>