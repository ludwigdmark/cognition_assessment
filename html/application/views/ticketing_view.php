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
            <h2>Ticketing</h2>
            <br>
            <div id="table_placeholder">
            </div>
            <?php include_once(__DIR__ . '/partials/ticket_form.html'); ?>
        </div>
      </div>
    </main>
    
    <!--<center><b>You are not registered ?</b> <br></b><a href="<?php echo base_url('user'); ?>">Register here</a></center>-->
	<?php include_once(__DIR__ . '/partials/javascripts.html'); ?>
  <script>console.log({elapsed_time});</script>
  <script>


$(document).ready(()=>{
    
    $.fn.dataTable.ext.search.push(
        function (settings, data, dataIndex) {
            var min = $('#min').datepicker("getDate");
            var max = $('#max').datepicker("getDate");
            var startDate = new Date(data[2]);
            if (min == null && max == null) { return true; }
            if (min == null && startDate <= max) { return true;}
            if(max == null && startDate >= min) {return true;}
            if (startDate <= max && startDate >= min) { return true; }
            return false;
        }
    );

    function pop_form(data) {

      $("#cell_input").val(data.cellno);
      $("#email_input").val(data.created_for);
      $("#fullname_input").val(data.fullname);
      $("#type_input").val(data.ticket_type);
      $("#body_input").val(data.ticket_details.text);
      $("#location_input").val(data.logged_location);
      $("#status_input").val(data.ticket_status);

      if (data.ticket_status == "Opened") $("#status_input").css("background-color", "orange").css("color", "white");
      if (data.ticket_status == "Pending") $("#status_input").css("background-color", "blue").css("color", "white");
      if (data.ticket_status == "Closed") $("#status_input").css("background-color", "green").css("color", "white");

      $("#form_complete").text("Update Ticket");

      $("#ticket_form").attr("action", "/ticketing/" + data.id);

    }

    var ticket_data = JSON.parse('<?php echo json_encode($tickets);?>');
    if (ticket_data.length >= 1) {

      $("#ticket_form").remove();

      var header = "<thead><tr><th>" + Object.keys(ticket_data[0]).join("</th><th>") + "</th><th>View</th></tr></thead>";
      var body = "<tbody>";
      ticket_data.forEach(row=>{
        body += "<tr><td>" + Object.values(row).join("</td><td>") + "</td><td><a href='https://cognition.daleludwig.co.za/ticketing/" + row["id"] + "'>View</a></td></tr>";
      })
      body += "</tbody>";
      var table = "<table class='table datatable compact' width=100%>" + header + body + "</table>";

      $("#table_placeholder").html(`
              <div class="form-row">
                <div class="form-group col-sm-3">
                  <label>Start Date:</label>
                  <input name="min" class="form-control" id="min" type="text">
                </div>
                <div class="form-group col-sm-3">
                  <label>End Date:</label>
                  <input name="max" class="form-control" id="max" type="text">
                </div>
              </div>
              ` + table);

    } else if (ticket_data.length == 1) {

      pop_form(ticket_data[0]);

    } else if (typeof ticket_data == "object") {

      pop_form(ticket_data);

    }

    if (<?php if ($this->session->userdata('guest') && !$this->session->userdata('loggedin')) echo "true"; else echo "false"; ?>) {
      
      $("#ticket_form *").prop('readonly', true).attr("disabled", true); 

    }

  </script>
</body>
</html>










