<div class="container">
      <div class="col-4 offset-4">

            <?php if (isset($validation)): ?>
                <div class="alert alert-danger">
                        <?php foreach ($validation->getErrors() as $error): ?>
                            <li><?php echo esc($error) ?></li>
                        <?php endforeach; ?>
                </div>
            <?php endif; ?>

			<?php echo form_open(base_url().'reset_password/'.$token); ?>
				<h2 class="text-center">Reset your password</h2>       
                <!-- echo an error saying link is expired. -->
					<div class="form-group">
                        <p class = "text-center"> Enter new password</p>
						<input  type="password" class="form-control" placeholder="Password" required="required" name="password" id="password">
                        <p class = "text-center"> Confirm your password.</p>
                        <input  type="password" class="form-control" placeholder="Confirm Password" required="required" name="passwordconf" id="passwordconf">
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block">Reset Password</button>
					</div>   
			<?php echo form_close(); ?>
	</div>
</div>
