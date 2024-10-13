<!DOCTYPE html>
<html lang="en">

<head>
  <title>INFS3202 Project</title>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap.css">
  <script src="https://pro.fontawesome.com/releases/v6.0.0-beta2/js/all.js" crossorigin="anonymous"></script>

  <script>
    // Show select image using file input.
    function readURL(input) {
      $('#default_img').show();
      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
          $('#select')
            .attr('src', e.target.result)
            .width(300)
            .height(200);

        };

        reader.readAsDataURL(input.files[0]);
      }
    }
  </script>
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">UT</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <?php if (session()->get('username')) { ?>
            <a href="<?php echo base_url(); ?>dashboard">
              <i class="fa-solid fa-house-chimney"></i>
            </a> <!--// only redirect to dashboard if user is logged in -->
          <?php } else { ?>
            <a href="<?php echo base_url(); ?>"> 
            <i class="fa-solid fa-house-chimney"></i>
           </a>
          <?php } ?>
        </li>
      </ul>
      <ul class="navbar-nav my-lg-0">

    </div>

    <?php if (session()->get('username')) { ?>
      <a href="<?php echo base_url(); ?>profile"> Profile </a>
      <a class="mx-4" href="<?php echo base_url(); ?>login/logout"> Logout </a>

    <?php } else { ?>
      <a class="mx-4" href="<?php echo base_url(); ?>register"> Sign Up </a>
      <a class="mx-4" href="<?php echo base_url(); ?>"> Login </a>
    <?php } ?>
  </nav>
  <div class="container">

</html>