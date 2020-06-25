<?php include("header.php"); ?>
<br>
<div class="content">
	
	<?php  ?>
	<?php 
	if (isset($_GET['id'])){
		if (($_GET['id']==1)) {
			include("register.php");
		}
		else if ($_GET['id']==2)
		{
			include("signature.php");
		}
	}
	else
	{
		include("login.php");
	}
	?>
</div>
