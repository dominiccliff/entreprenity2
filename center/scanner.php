<?php
$locId = $_SESSION['locId'];
$result = getUsersForLocation($locId);
//print_r($result);
?>
<div class="">
		<div class="container">
			<div>
				<h1>THIS IS TEST PAGE</h1>
			</div>
			<div class="row">
	            <div class="col-md-12">
	            					<h3 style="color:white;">ENTER QR CODE HERE:</h3>
	              <input name="userIdentifier" id="userIdentifier" type="text" autofocus >
<!--	              <button name="submit" id="clicksubmit" value="submit" type="submit">Submit</button>-->
	            </div>
	      </div>
		</div>
	</div>
	<div class="clearfix"></div>
	
	<h3 style="color: white;text-align:center;">CHECKED IN DETAILS</h3>
	<div class="">
		<div class="container">
	<table style="border: 1px solid black;
    border-collapse: collapse; color:gold;">
	<thead>
	
	
	</thead>
	<tbody>
	  <tr>
    <th>Sl No </th>
    <th>Client ID</th> 
    <th>Name</th>
    <th>Date</th>
   <!-- <th>Check Type</th>-->
    <th>Check IN  Time</th>
    <th>Check OUT Time</th>
    <th>Total hours used</th>
    <!--<th>Check In</th>
    <th>Check Out</th>
    <th>Total hrs</th>-->
  </tr>
<?php 
$index=1;
foreach($result as $row) {

?>

  <tr>
  		 <td><?php  echo $index;?></td>
	    <td><?php echo $row['vofClientId'];?></td>
	    <td><?php echo $row['firstname']." ".$row['lastname'];?></td>
	    <td><?php echo $row['loginDate'];?></td>
	   
	      <td><?php echo $row['checkIn'];?></td>
	      <td><?php echo $row['checkout'];?></td>
	      
	      <td><?php
	      if($row)
	      $datetime1 = strtotime($row['checkIn']);
			$datetime2 = strtotime($row['checkout']);
			
			$secs = $datetime2 - $datetime1;// == <seconds between the two times>
			$days = $secs / 3600;
	      	$sub=	$days;
	      
	       echo $sub; ?></td>
    <!--<td>10 am</td>
    <td>5 pm</td>
    <td>7</td>-->
  </tr>
  
  <?php
		   $index++;
}
  ?>


	
	
	</tbody>
	
	
	
	
	</table>
	
	
		</div>
	</div>
	
   <div id="successModal" class="modal fade in" >
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <img id="checkedInUserImage" class="img-circle" src="" alt="Avatar">
              </div>
              <div id="welcomeMsgDiv" class="modal-body" style="color:black;">
                  <div class="arrow-down"></div>
                  <p>Welcome, <span id="checkedInUser"></span>!</p>
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#successModal">CONTINUE</button>
              </div>
          </div>
      </div>
  </div>

  <div id="failureModal" class="modal fade in" >
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                   <img id="errorIcon" class="img-circle" src="../assets/img/qr-code-scanner-fail.png" alt="Avatar" width="80">
                   <h1>Code Scanning Failed!</h1>
              </div>
              <div id="errorMsgDiv" class="modal-body" style="color:black;">
                  <div class="arrow-down"></div>
                  <p>Please try again</p>
                  <button type="button" id="failbutton" class="btn btn-primary" data-toggle="modal" data-target="#failureModal">TRY AGAIN</button>
              </div>
          </div>
      </div>
  </div>
	
	
	<script src="jquery-1.11.2.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<script type="text/javascript">
    $(document).ready(function(){

		$(document).on('input','#userIdentifier',function (e) 
		{
			e.preventDefault();
			var userIdentifier		=		$("#userIdentifier").val();
			if(userIdentifier)
			{
            checkUser(userIdentifier);
			}	   	
				  
				   
		});  
		
		
		
		$(document).on('click','#clicksubmit',function (e) 
		{
			e.preventDefault();
			var userIdentifier		=		$("#userIdentifier").val();
			if(userIdentifier)
			{
            checkUser(userIdentifier);
			}
		});     	   	
    	
    });
     function AddParameter(form, name, value) {
        var $input = $("<input />").attr("type", "hidden")
                                .attr("name", name)
                                .attr("value", value);
        form.append($input);
    } 

    function checkUser(userIdentifier)
    {
 				var dataString = { send : true , credential : userIdentifier };
				var post_url = "authenticate.php";
			 	$.ajax({
				   url: post_url,
				   data: dataString,
				   type: "POST",
				   dataType: 'json',
				   beforeSend: function ( xhr ) 
				   {  
		            //showLoader();
		         },
				   success: function(data)
				   { 
				   	//hideLoader(); 	
						if(data.success == true)
						{
			           //alert("You have successfully checked in!");
			          // $("#checkedInUser").html(data.firstname + " " + data.lastname);
//			            $("#checkedInUserImage").attr("src", data.avatar);
//						  $('#successModal').show();
//			           setTimeout(function(){
//						      $("#successModal").hide();
//						  }, 5000);
			           //$("#activeUsersTable > tbody").append("<tr><td><img src='"+string+data.avatar+"'></td><td>"+data.firstname+" "+data.lastname+"</td><td>"+data.company+"</td><td>"+data.checkInDateTime+"</td></tr>");
						  
						  
						   var post_url = "checkprofile.php";
					      var $form = $("<form/>").attr("id", "data_form")
					                      .attr("action",  post_url)
					                      .attr("method", "post");
					      $("body").append($form);
					
					      //Append the values to be send
					      AddParameter($form, "qrcode", userIdentifier);
					
					      //Send the Form
					      $form[0].submit();
						} 
						else 
						{
			           //alert("The credentials not match!");
			           $('#failureModal').show();
			           setTimeout(function(){
						      $("#failureModal").hide();
						  }, 5000);
						  
			         }				   	
				   	$("#userIdentifier").val('');	
				   	$("#userIdentifier").focus();		   	
				   }
				   
				});//end of ajax
				$("#userIdentifier").focus();	   
    
    }

	 
	</script>
	<style>
	table{
		float: none;
		width: inherit;
		color: lightyellow;
	}
	table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
	}
	th, td {
    padding: 1px;
	}
	th{
		background-color: dimgray;
	
	}
</style>