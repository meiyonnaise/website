<div class="container">
      <div class="col-4 offset-4">
			<?php echo form_open(base_url().'register/verify_email/code'); ?>     
					<div class="form-group">
						<input  type="text" class="form-control" placeholder="Verification Code" required="required" name="verificationCode">
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block">Submit</button>
					</div>
			<?php echo form_close(); ?>
	</div>
</div>
