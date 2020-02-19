<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
  <?php include_once(__DIR__ . '/partials/header.html'); ?>
	<title><?= $this->site_data->title ?></title>
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
          <div class="btn-group" role="group" aria-label="Basic example">
            <a type="button" class="btn btn-secondary" href="/complexquery">Regenerate Data and View</a>
            <a type="button" class="btn btn-secondary" href="?animallovers">Animal Lovers with only 1 document linked</a>
            <a type="button" class="btn btn-secondary" href="?childrensports">Children & Sport Lovers</a>
            <a type="button" class="btn btn-secondary" href="?nodocs">Unique Interests and the count of people without documents linked to their interests</a>
            <a type="button" class="btn btn-secondary" href="?manydocs">People with 5 or 6 interests with at least one of the interests having multiple documents</a>
          </div>
        </div>
      </div>
            <br>
      <div class="row">
        <div class="col-12" style="text-align: center">
            <h2><?php echo $name;?></h2>
            <br>
            <div id="table_placeholder">
            </div>
            <br>
            <h4>Query for result set:</h4>
            <code id="table_query">
            <?php echo $query;?>
            </code>
            <br>
            <br>
            <br>
            <h4>Query for generating tables:</h4>
            <code id="all_queries">
            <?php echo $all;?>
            </code>
            <br>
            <br>
            <br>
            <br>
        </div>
      </div>
    </main>
    
	<?php include_once(__DIR__ . '/partials/javascripts.html'); ?>
  <script>console.log({elapsed_time});</script>
  <script>

    var query_data = JSON.parse('<?php echo json_encode($results);?>');

    var header = "<thead><tr><th>" + Object.keys(query_data[0]).join("</th><th>") + "</th></tr></thead>";
    var body = "<tbody>";
    query_data.forEach(row=>{
      body += "<tr><td>" + Object.values(row).join("</td><td>") + "</td></tr>";
    })
    body += "</tbody>";
    var table = "<table class='table datatable compact' width=100%>" + header + body + "</table>";


    $("#table_placeholder").html(table);

  </script>
</body>
</html>










