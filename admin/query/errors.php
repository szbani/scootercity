<?php
if (isset($_SESSION['errors'])) {
	$errors = $_SESSION['errors'];

	if (count($errors) > 0) {
?>
		<div class="alert alert-danger alert-dismissible fade show" role="alert">
			<?php foreach ($errors as $error) { ?>
				<strong><?php echo $error ?><br></strong>
			<?php
			}
			?>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
<?php
	}
	unset($errors);
	unset($_SESSION['errors']);
}
?>