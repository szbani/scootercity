<?php  
if(isset($_SESSION['errors'])) {
	$errors = $_SESSION['errors'];

	if(count($errors) > 0){
		?>
<?php foreach($errors as $error){?>
			<p><?php echo $error ?></p>
<?php
		}
	}
	unset($errors);
	unset($_SESSION['errors']);
}
?>
