<?php
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