<div class="container">
      <div class="col-4 offset-4">
			<?php echo form_open(base_url().'reset_password'); ?>
				<h2 class="text-center">Forgot your password?</h2>       
					<div class="form-group">
                        <p class = "text-center"> Please enter the email that you signed up with. </p>
						<input  type="text" class="form-control" placeholder="Email" required="required" name="email">
					</div>
                    <div class="form-group">
					<?php echo $error; ?>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block">Reset Password</button>
					</div>   
			<?php echo form_close(); ?>
	</div>
</div>
