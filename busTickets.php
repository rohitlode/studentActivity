<?php include("index.php"); ?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<title>Student Activity Website</title>
</head>
<body>
  <div class="container">
    <h2 class="text-center"> <b>Welcome to student transport section </b></h2>
    <h3 class="text-center"> Choose your zone and purchase tickets </h3>
    <div class="card text-center">
  <div class="card-header">
    <ul class="nav nav-tabs card-header-tabs">
      <li class="nav-item">
        <a onclick="navigate(this,'tickets')" id="ticket" class="nav-link active" href="#">Tickets</a>
      </li>
      <li class="nav-item">
        <a onclick="navigate(this,'monthcard')" id="monthc" class="nav-link" href="#">Monthly Card</a>
      </li>
    </ul>
  </div>
  <?php
    include 'config.php';
    $stmt1 = $conn->prepare("select * from bustickets where id like 'MBP%'");
    $stmt1->execute();
    $row = $stmt1->get_result()->fetch_assoc(); ?>
  <div class="card-body">
    <div id="monthcard" style="display:none">
      <div class="details">
        <h5 class="details"hidden><?=$row['details']?></h5>
        <h5> One Card Anywhere, Anytime </h5>
        <p>Travel in any zone with this card</p>
        <p>Covers all three zones : A, B, C</p>
        <p class="id"hidden><?=$row['id']?></p>
        <p class="timings"><?=$row['timings']?></p>
        <p class="price"><b>Cost:</b> $<?=$row['price']?></p>
        <p class="type"hidden>Month Card</p>
        <button type="button" class="btn btn-success addtocart" name="button">Add to Cart</button>
      </div>
    </div>
    <div id="tickets">
      <?php
      $stmt = $conn->prepare("select * from bustickets where id not like 'MBP%'");
      $stmt->execute();
      $re = $stmt->get_result();
      while($row = $re->fetch_assoc()):  ?>
      <div class="flip-card details">
        <div class="flip-card-inner">
          <div class="flip-card-front">
            <img src="bus/bus.jpg" alt="Bus Image" height="198" width="298">
            <h5 id="zone" class="id">Zone <?=$row['id']?></h5>
            <p class="type" hidden>Ticket</p>
          </div>
          <div class="flip-card-back">
            <div class="Details">
              <h5 class="details"><?=$row['details']?></h5>
              <p class="timings"><?=$row['timings']?></p>
              <p class="price"><b>Cost:</b> $<?=$row['price']?></p>
              <button type="button" class="btn btn-success addtocart" name="button">Add to Cart</button>
            </div>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
    </div>
  </div>


</div>
  </div>
  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

  <!-- Popper JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

  <!-- Latest compiled JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script src="https://kit.fontawesome.com/a076d05399.js"></script>
  <script type="text/javascript">
  function navigate(obj,clas){
    console.log(obj.className);
    console.log(document.getElementById(clas).classList);
    if(clas=='tickets'){
      document.getElementById(clas).style.display = "block";
      document.getElementById('monthcard').style.display = "none";
      document.getElementById('monthc').classList.remove("active");
      document.getElementById('ticket').classList.add("active");
    }
    else {
      document.getElementById(clas).style.display = "block";
      document.getElementById('tickets').style.display = "none";
      document.getElementById('ticket').classList.remove("active");
      document.getElementById('monthc').classList.add("active");
      // obj.className = "nav-link active";
    }

  }
  	$(document).ready(function(){
      $(".addtocart").click(function(e){
        var here = $(this).closest(".details");
        console.log(here);
        var bustype = here.find(".type").html();
        var id = here.find(".id").html();
        id= bustype=='ticket'?"Zone "+id.split(' ')[1]:id;
        var price = here.find(".price").html();
        price =price.split('$')[1];
        var details = here.find(".details").html();
        var timings = here.find(".timings").html();
        console.log(id, price, bustype, details, timings);
        $.ajax({
          url: 'action.php',
          method: 'post',
          data: {id:id, price:price, bustype:bustype, details:details, timings: timings},
          success: function(response){
            console.log(response);
            if(response=="success"){
              window.location.href = "individual_checkout.php?name=bus&type="+bustype;
            }
          }
        })
      });
  		$(".addItemBtn").click(function(e){
  			e.preventDefault();
  			var $form = $(this).closest(".form-submit");
  			var pid = $form.find(".pid").val();
  			var pname = $form.find(".pname").val();
  			var pprice = $form.find(".pprice").val();
  			var pimage = $form.find(".pimage").val();
  			var pcode = $form.find(".pcode").val();
  			console.log("Sent");
  			console.log(pname, pid);
  			$.ajax({
  				url: 'action.php',
  				method: 'POST',
  				data: {pid:pid, pname:pname, pprice:pprice, pimage:pimage, pcode:pcode},
  				success: function(response){
  					console.log("success");
  					$("#message").html(response);
  					update_cart();
  					window.scrollTo(0,0);
  				}
  			});
  		});
  		update_cart();
  		function update_cart(){
  			$.ajax({
  				url: 'action.php',
  				method: 'GET',
  				data: {counter: "cart_item"},
  				success: function(response){
  					$("#cart-item").html(response);
  				}
  			});
  		}
  	})
  </script>
  </body>
  </html>
