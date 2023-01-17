<?php
if (isset($_SESSION['errors'])) {
?>
	<div class="position-fixed bottom-0 end-0 p-3 align-items-center" style="z-index: 11">
		<div id="errorToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
			<div class="toast-header bg-danger text-white">
				<strong class="me-auto" id="succesName"><?php
				echo end($_SESSION['errors']);
				?></strong>
				<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
			</div>
			<div class="toast-body">
				<?php
                foreach($_SESSION['errors'] as $error){
					if($error != end($_SESSION['errors']))
                    echo '<strong>'.$error.'</strong><br>';
                }
                  ?>
			</div>
		</div>
	</div>
	<script>
		window.addEventListener('DOMContentLoaded', (event) => {
			showToast('errorToast');
		});
	</script>
<?php
unset($_SESSION['errors']);
}
if (isset($_SESSION['success'])) {
?>
	<div class="position-fixed bottom-0 end-0 p-3 align-items-center" style="z-index: 11">
		<div id="successToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
			<div class="toast-header bg-success text-white">
				<strong class="me-auto" id="succesName">Siker</strong>
				<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
			</div>
			<div class="toast-body">
				<?php echo '<strong>'.$_SESSION['success'].'</strong>' ?>
			</div>
		</div>
	</div>
	<script>
		window.addEventListener('DOMContentLoaded', (event) => {
			showToast('successToast');
		});
	</script>
<?php
unset($_SESSION['success']);
}
?>