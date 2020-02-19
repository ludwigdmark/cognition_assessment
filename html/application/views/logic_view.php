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
        <h2>Logic Assessment </h2>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
    <ul class="list-group list-group-flush">
      <li class="list-group-item">1) C</li>
      <li class="list-group-item">2) B</li>
      <li class="list-group-item">3) D</li>
      <li class="list-group-item">4) C</li>
      <li class="list-group-item">5) B, C, D</li>
      <li class="list-group-item">6) A, B, E</li>
      <li class="list-group-item">7) C</li>
      <li class="list-group-item">8) C</li>
      <li class="list-group-item">9) B, C, E</li>      
    </ul>
    </div>
  </div>


    </main>
    
    <!--<center><b>You are not registered ?</b> <br></b><a href="<?php echo base_url('user'); ?>">Register here</a></center>-->
	<?php include_once(__DIR__ . '/partials/javascripts.html'); ?>
	<script>console.log({elapsed_time});</script>
</body>
</html>










