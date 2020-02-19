<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
  <?php include_once(__DIR__ . '/partials/header.html'); ?>
	<title><?=$this->site_data->title;?></title>
	<?php include_once(__DIR__ . '/partials/stylesheets.html'); ?>
    <style type="text/css">
	</style>
</head>
<body>
    <?php include_once(__DIR__ . '/partials/navbar.html'); ?>
    <?= flash_messages() ?>
  
<main role="main" class="container">
  <div class="row">
    <div class="col-12" style="text-align: center">
      <img class="mb-4" src="http://www.cognitionholdings.co.za/img/logo" alt="" width="208" height="250">
    </div>
  </div>
  <div class="row">
    <div class="col-12" style="text-align: center">
        <h2>Login </h2>
    </div>
  </div>

  <div class="row">
    <div class="col-12" style="text-align: center !important; max-width:330px;margin:auto;">
    <form class="form-signin" method="post" action="/user/login" style="text-align: center !important; max-width: 330px;">
        <input type="hidden" name="<?=$this->site_data->csrf->name;?>" value="<?=$this->site_data->csrf->hash;?>" />
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" value="" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required value="">
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        <p class="mt-5 mb-3 text-muted">&copy; 2017-2019</p>
    </form>
    </div>
  </div>


    </main>
    
    <!--<center><b>You are not registered ?</b> <br></b><a href="<?php echo base_url('user'); ?>">Register here</a></center>-->
	<?php include_once(__DIR__ . '/partials/javascripts.html'); ?>
	<script>console.log({elapsed_time});</script>
</body>
</html>










