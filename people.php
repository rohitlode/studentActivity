<?php include("index.php"); ?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<title>Student Activity Website</title>
</head>
<body>
<div id="evnt" class="container" style="width: 100%">
  <div class="eventsSearch mt-2" style="width: 100%">
		<form id="psearch">
			<div class="form-group" style="width: 100%">
	      <input type="text" id="first" class="form-control" value="" style="width: 100%" placeholder="Enter First Name">
	    </div>
			<div class="form-group" style="width: 100%">
	      <input type="text" class="form-control" id="last" value="" style="width: 100%" placeholder="Enter Last Name">
	    </div>
			<div class="form-group" style="width: 100%">
	      <input type="text" class="form-control" id="dept" value="" style="width: 100%" placeholder="Enter Department">
	    </div>
			<button  type="submit" class="btn btn-success" name="button">Search</button>
		</form>
  </div>
</div>
<!-- <center> -->
<div id="searchedPeeps">

</div>
<!-- </center> -->
<!-- <div class="container"> -->
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<script type="text/javascript">
function getInput(e){
	console.log(e.value);
	if(!e.value)
		getResponse(e.value).then(res=>{console.log(res)});
	}
	$(document).ready(function(){
		$('#psearch').submit(function(e) {
			e.preventDefault();
			var first = $(this).find('#first').val();
			var last = $(this).find('#last').val();
			var dept = $(this).find('#dept').val();
			console.log(first, last, dept);
			$.ajax({
				url: 'action.php',
				method: 'GET',
				data: {first:first, last:last, dept: dept},
				success: function(response){
					console.log('Successs', response);
					$('#searchedPeeps').html(response);
				}
			});
		});
	});
//
// function getResponse(query) {
// 	var xhr = new XMLHttpRequest();
// 	// var token_ = "akZPVNym9WhJNT6DyAgSBVUCz4IYuJtm2NECXE0p";
// 	return new Promise((resolve, reject) => {
//
// 		xhr.onreadystatechange = (e) => {
// 			if (xhr.readyState == 4 && xhr.status === 200) {
// 				// console.log('SUCCESS', xhr.responseText);
// 				resolve(JSON.parse(xhr.responseText));
// 			} else {
// 				console.warn('request_error');
// 			}
// 		};
//
// 		xhr.open("GET", "action.php?query="+query);
// 		xhr.send();
// 	});
// 	}

</script>
</body>
</html>
