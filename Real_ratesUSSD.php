<?php 
	echo "this is ussd";
	if (!empty ($_POST)) {
		# necessary scripts required to run the application.
		require_once('dbconnector.php');
		require_once('AfricasTalkingGateway.php');
		require_once('config.php');

		//2. receive the POST from AT ie reads the variables send via POST from the gateway
		$sessionId=$_POST['sessionId'];
		$serviceCode=$_POST['serviceCode'];
		$phoneNumber=$_POST['phoneNumber'];
		$text=$_POST['text'];

		/*3. Explode the text to get the value of the latest interaction - think 544*1*5...5is the latest value
			//explode breaks a string into an array - contains a separor, string and a limit*/
		$textArray=explode('*', $text);
		$userResponse=trim(end($textArray));//trim removes characters

		//4. Set the default level of the user
		$level=0;

		//5. Check the level of the user from the DB and retain default level if none is found for this session
		$sql = "SELECT level from session_levels where session_id =".$sessionId." ";
		$levelQuery = $db->query($sql);
		if($result = $levelQuery->fetch_assoc()) {
  		$level = $result['level'];
	}

		//9. Serve the Services Menu 
	//9a. Check that the user actually typed something, else demote level and start at home
	switch ($userResponse) {
	    case " ":
	        if($level==0){
	        	//9b. Graduate user to next level & Serve Main Menu
	        	$sql = "INSERT INTO `session_levels`(`session_id`,`phoneNumber`,`level`) VALUES('".$sessionId."','".$phoneNumber."',1)";
	        	$db->query($sql);

	        	//Serve our services menu
				$response = " CON Choose a commodity to receive the rates for:\n";
				$response = " CON Choose a commodity to receive the rates for:\n";
	          	$response .= " 1. Bananas\n";
				$response .= " 2. Carrots\n";	
				$response .= " 3. Mangoes\n";
				$response .= " 4. Onions\n";		
				$response .= " 5. Potatoes\n";
				$response .= " 6. Tomatoes\n";
				$response .= " 7. Quit\n";
	  			// Print the response onto the page so that the gateway can read it
	  			header('Content-type: text/plain');
		  			echo $response;	

	        }
	        break;

	   case "0":
	       # if($level==0)
	   {
	        	//9b. Graduate user to next level & Serve Main Menu
	        	$sql = "INSERT INTO `session_levels`(`session_id`,`phoneNumber`,`level`) VALUES('".$sessionId."','".$phoneNumber."',1)";
	        	$db->query($sql);

	        	//Serve our services menu
				$response = " CON Choose a commodity to receive the rates for:\n";
	          	$response .= " 1. Bananas\n";
				$response .= " 2. Carrots\n";	
				$response .= " 3. Mangoes\n";
				$response .= " 4. Onions\n";		
				$response .= " 5. Potatoes\n";
				$response .= " 6. Tomatoes\n";
				$response .= " 7. Quit\n";
	  			// Print the response onto the page so that the gateway can read it
	  			header('Content-type: text/plain');
		  			echo $response;	

	        }
	        break;
  
	           
	    case "1":
	        if($level==1){
	        	//9d. Call the user and bridge to a sales person
	          	$response = "END You will receive the rates for bananas shortly.\n";


			$sql="SELECT CommodityName,Quantity, Mon_price FROM rates_week1 where CommodityName = Banana";

			if ($result=mysqli_query($con,$sql))
 			 {
 			 while ($obj=mysqli_fetch_object($result))
  			  {
   			 printf("%s (%s) (%s)\n", $obj->CommodityName,$obj->Quantity, $obj->Mon_price);
    		}
  			// Free result set
 			 mysqli_free_result($result);
			}
	  			// Print the response onto the page so that our gateway can read it
	  			header('Content-type: text/plain');
		  			echo $response;	

	        }
	        break;

	    case "2":
	        if($level==1){
	        	//9d. Call the user and bridge to a sales person
	          	$response = "END You will receive the rates for Carrots shortly.\n";

	          	$sql="SELECT CommodityName,Quantity, Mon_price FROM rates_week1 where CommodityName = Carrot";

				if ($result=mysqli_query($con,$sql))
 			 	{
 			 	while ($obj=mysqli_fetch_object($result))
  			 	 {
   			 	printf("%s (%s) (%s)\n", $obj->CommodityName,$obj->Quantity, $obj->Mon_price);
    			}
  				// Free result set
 				 mysqli_free_result($result);
				}
	  			// Print the response onto the page so that our gateway can read it
	  			header('Content-type: text/plain');
		  			echo $response;	

	        }
	        break;
	  		

	    case "3":
	        if($level==1){
	        	//9d. Call the user and bridge to a sales person
	          	$response = "END You will receive the rates for Maize shortly.\n";
	  			// Print the response onto the page so that our gateway can read it
	  			$sql="SELECT CommodityName,Quantity, Mon_price FROM rates_week1 where CommodityName = Maize";

			if ($result=mysqli_query($con,$sql))
 			 {
 			 while ($obj=mysqli_fetch_object($result))
  			  {
   			 printf("%s (%s) (%s)\n", $obj->CommodityName,$obj->Quantity, $obj->Mon_price);
    		}
  			// Free result set
 			 mysqli_free_result($result);
			}
	  			// Print the response onto the page so that our gateway can read it
	  			header('Content-type: text/plain');
		  			echo $response;	

	        }
	        
	        break;

	    case "4":
	        if($level==1){
	        	//9d. Call the user and bridge to a sales person
	          	$response = "END You will receive the rates for Onions shortly.\n";
	  			// Print the response onto the page so that our gateway can read it

	  			$sql="SELECT CommodityName,Quantity, Mon_price FROM rates_week1 where CommodityName = Onion";

			if ($result=mysqli_query($con,$sql))
 			 {
 			 while ($obj=mysqli_fetch_object($result))
  			  {
   			 printf("%s (%s) (%s)\n", $obj->CommodityName,$obj->Quantity, $obj->Mon_price);
    		}
  			// Free result set
 			 mysqli_free_result($result);
			}
	  			// Print the response onto the page so that our gateway can read it
	  			header('Content-type: text/plain');
		  			echo $response;	
	        }
	        break;
	    case "5":
	        if($level==1){
	        	//9d. Call the user and bridge to a sales person
	          	$response = "END You will receive the rates for Potatoes shortly.\n";
	  			// Print the response onto the page so that our gateway can read it
	  			$sql="SELECT CommodityName,Quantity, Mon_price FROM rates_week1 where CommodityName = Potato";

			if ($result=mysqli_query($con,$sql))
 			 {
 			 while ($obj=mysqli_fetch_object($result))
  			  {
   			 printf("%s (%s) (%s)\n", $obj->CommodityName,$obj->Quantity, $obj->Mon_price);
    		}
  			// Free result set
 			 mysqli_free_result($result);
			}

	  			header('Content-type: text/plain');
		  			echo $response;	 
	        }
	        break;
	          				
	    case "6":
	        if($level==1){
	        	//9d. Call the user and bridge to a sales person
	          	$response = "END You will receive the rates for Tomatoes shortly.\n";

	        $sql="SELECT CommodityName,Quantity, Mon_price FROM rates_week1 where CommodityName = Onion";

			if ($result=mysqli_query($con,$sql))
 			 {
 			 while ($obj=mysqli_fetch_object($result))
  			  {
   			 printf("%s (%s) (%s)\n", $obj->CommodityName,$obj->Quantity, $obj->Mon_price);
    		}
  			// Free result set
 			 mysqli_free_result($result);
			}

	  			// Print the response onto the page so that our gateway can read it
	  			header('Content-type: text/plain');
		  			echo $response;	 
	        }
	        break;

	    case "7":
	        if($level==1){
	        	//9d. Call the user and bridge to a sales person
	          	$response = "END Ensure to visit again to check the rates.\n";
	  			// Print the response onto the page so that our gateway can read it
	  			header('Content-type: text/plain');
		  			echo $response;	 
	        }
	        break;
	          
	    default:
	    	$response = "CON Invalid choice. Press 0 to go back and try again\n";
	    	
		    	// Print the response onto the page so that our gateway can read it
		  		header('Content-type: text/plain');
			  		echo $response;	
			  		break;
			  	}
			  }

 ?>