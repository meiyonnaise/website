<div class="container">
	<div class="col-4 offset-4">
		<?php echo form_open(base_url() . 'register/form'); ?>
		<?php if (isset($validation)) : ?>
			<div class="alert alert-danger"><?= $validation->listErrors() ?></div>
		<?php endif; ?>
		<h2 class="text-center">Sign Up</h2>
		<div class="form-group">
			<input type="text" class="form-control" placeholder="Username" required="required" name="username">
		</div>
		<div class="form-group">
			<input type="password" class="form-control" placeholder="Password" required="required" name="password" , id="password">
		</div>
		<div class="form-group">
			<input type="text" class="form-control" placeholder="Email" required="required" name="email">
		</div>
		<div class="form-group">
			<input type="text" class="form-control" placeholder="Phone Number" required="required" name="phoneNumber">
		</div>
		<div class="form-group">
			<input type="text" class="form-control" placeholder="First Name" required="required" name="firstName">
		</div>
		<div class="form-group">
			<input type="text" class="form-control" placeholder="Last Name" required="required" name="lastName">
		</div>
		<div class="form-group">
			<input type="text" class="form-control" placeholder="Sex" required="required" name="sex">
		</div>

		<div class="form-group">
		</div>
		<div class="form-group">
			<button type="submit" class="btn btn-primary btn-block">Register</button>
		</div>
		<?php echo form_close(); ?>
	</div>
</div>