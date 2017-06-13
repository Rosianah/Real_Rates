<?php

if(!empty($_POST) && !empty($_POST['phoneNumber'])){
	require_once('dbConnector.php');
	require_once('AfricasTalkingGateway.php');
	require_once('config.php');

	// receive the POST from Africas Talking
	$sessionId     =$_POST['sessionId'];
	$serviceCode   =$_POST['serviceCode'];
	$phoneNumber   =$_POST['phoneNumber'];
	$text          =$_POST['text'];

	// Explode the text like 544*4
	$textArray=explode('*', $text);
	$userResponse=trim(end($textArray));

	//user defaul
	$level=0;

	// Check the level of the user from the Database 
	$sql = "select level from session_levels where session_id ='".$sessionId." '";
	$levelQuery = $db->query($sql);
	if($result = $levelQuery->fetch_assoc()) {
  		$level = $result['level'];
	}	
	
		switch ($userResponse) {
			    case "":
			        if($level==0){
			        	//Serve Main Menu
			        	$sql9b = "INSERT INTO `session_levels`(`session_id`,`phoneNumber`,`level`) VALUES('".$sessionId."','".$phoneNumber."',1)";//Make the level 1
			        	$db->query($sql1);

			        	//services menu
						$response = "CON Welcome to Real Rates. Choose a cattegory to get rates for.\n";
						$response .= " 1. Fruits.\n";
						$response .= " 2. Vegetables\n";
						$response .= " 3. Cereals\n";
						$response .= " 4. Quit\n";							
																										

			  			// Print the response onto the page so that AT gateway can read it
			  			header('Content-type: text/plain');
 			  			echo $response;						
			        }
			        break;  
			        
			        
			     case "0":
			        if($level==0){
			        	//Take user to next level & Serve Main Menu
			        	$sql9b = "INSERT INTO `session_levels`(`session_id`,`phoneNumber`,`level`) VALUES('".$sessionId."','".$phoneNumber."',1)";
			        	$db->query($sql1b);

			        	//services menu
						$response = "CON Welcome to Real Rates. Choose a cattegory to get rates for.\n";
						$response .= " 1. Fruits.\n";
						$response .= " 2. Vegetables\n";
						$response .= " 3. Cereals\n";
						$response .= " 4. Quit\n";							
																										

			  			// Print the response onto the page so that AT gateway can read it
			  			header('Content-type: text/plain');
 			  			echo $response;						
			        }
			        break;  
			        
			        case "1":
			        if($level==1){
			        	//Display fruits menu
						$response = "CON Choose a fruit to ge the rates for\n";
						$response .= " 1. Bananas\n";
						$response .= " 2. Mangoes\n";	
						$response .= " 3. Oranges\n";
						$response .= " 4. Tomatoes\n";
						$response .= " 5. Quit\n";						

						//Update sessions to level 3
				    	$sqlLvl9="UPDATE `session_levels` SET `level`=3 where `session_id`='".$sessionId."'";
				    	$db->query($sql1c);

			  			// Print the response onto the page so that our gateway can read it
			  			header('Content-type: text/plain');
 			  			echo $response;	 
			        }
			        break;
			        
			        case "2":
			        if($level==1){
			        	$response = " CON Choose a commodity to receive the rates for:\n";
	        			$response .= " 1. Potatoes\n";
						$response .= " 2. Carrots\n";	
						$response .= " 3. Onions\n";
						$response .= " 4. Quit\n";
						
						//Update sessions to level 4
				    	$sqlLvl9="UPDATE `session_levels` SET `level`=4 where `session_id`='".$sessionId."'";
				    	$db->query($sql1c);

			  			// Print the response onto the page so that our gateway can read it
			  			header('Content-type: text/plain');
 			  			echo $response;	 
			        }
			        break;
			        
			        case "3":
			        if($level==1){
			        	//Display Cereals menu
						$response = "CON Choose a fruit to ge the rates for\n";
						$response .= " 1. Maize\n";
						$response .= " 2. Wheat\n";	
						$response .= " 3. Beans\n";
						$response .= " 4. Green grams\n";
						$response .= " 5. Quit\n";						

						//Update sessions to level 5
				    	$sqlLvl9="UPDATE `session_levels` SET `level`=5 where `session_id`='".$sessionId."'";
				    	$db->query($sql1c);

			  			// Print the response onto the page so that our gateway can read it
			  			header('Content-type: text/plain');
 			  			echo $response;	 
			        }
			        break;
			        
			        case "4":
	    		    if($level==1){	        			
	          			$response = "END Ensure to visit again to check the rates.\n";
	  					// Print the response onto the page so that our gateway can read it
	  					header('Content-type: text/plain');
		  				echo $response;	 
	    			 }
	    			 break;
	    			 
	    			 default:
	    				if($level==1){
				        // Return user to Main Menu & Demote user's level
				    	 $response = "CON You have to choose a service.\n";
				       	 $response .= "Press 0 to go back.\n";
				    	 //demote
				       	 $sqlLevelDemote="UPDATE `session_levels` SET `level`=0 where `session_id`='".$sessionId."'";
				       	 $db->query($sqlLevelDemote);
	
				    	// Print the response onto the page so that our gateway can read it
				  		 header('Content-type: text/plain');
	 			  		 echo $response;	
			    	}
			    	
			    	else {
			    		switch ($level){
			    			case 3:
			    			//3a. Get rates from the db
							switch ($userResponse) {
					    		case "1":
						    		// Find the fruit in the db
									$sql7 = "SELECT * FROM fruits_week1 WHERE CommodityName LIKE 'b%' LIMIT 1";
									$fruitQuery=$db->query($sql3);
									$fruitAvailable=$fruitQuery->fetch_assoc();
	
								//Respond with user the rates
									$response = "END Today's rates.\n";
									$response .= "Real Rates.\n";
									$response .= "Name: ".$fruitAvailable['CommodityName']."\n";
									$response .= "Amount: ".$fruitAvailable['Quantity']."\n";
									$response .= "price: ".$fruitAvailable['Mon_Price']."\n";	
						  			// Print the response onto the page so that our gateway can read it
			  						header('Content-type: text/plain');
 									echo $response;		        			       	
				        		break;	

							 case "2":
					    		    	// Find the fruit in the db
									$sql7 = "SELECT * FROM fruits_week1 WHERE CommodityName LIKE 'm%' LIMIT 1";
									$fruitQuery=$db->query($sql3a);
									$fruitAvailable=$fruitQuery->fetch_assoc();
	
								//Respond with user the rates
									$response = "END Today's rates.\n";
									$response .= "Real Rates.\n";
									$response .= "Name: ".$fruitAvailable['CommodityName']."\n";
									$response .= "Amount: ".$fruitAvailable['Quantity']."\n";
									$response .= "price: ".$fruitAvailable['Mon_Price']."\n";	
						  			// Print the response onto the page so that our gateway can read it
			  						header('Content-type: text/plain');
 									echo $response;	
					    		break;

					    	case "3":
					        		 	// Find the fruit in the db
									$sql7 = "SELECT * FROM fruits_week1 WHERE CommodityName LIKE 'o%r%' LIMIT 1";
									$fruitQuery=$db->query($sql3b);
									$fruitAvailable=$fruitQuery->fetch_assoc();
	
								//Respond with user the rates
									$response = "END Today's rates.\n";
									$response .= "Real Rates.\n";
									$response .= "Name: ".$fruitAvailable['CommodityName']."\n";
									$response .= "Amount: ".$fruitAvailable['Quantity']."\n";
									$response .= "price: ".$fruitAvailable['Mon_Price']."\n";	
						  			// Print the response onto the page so that our gateway can read it
			  						header('Content-type: text/plain');
 									echo $response;	
 							break;
 							
 							case "4":
					        		 	// Find the fruit in the db
									$sql7 = "SELECT * FROM fruits_week1 WHERE CommodityName LIKE 'o%n%' LIMIT 1";
									$fruitQuery=$db->query($sql3b);
									$fruitAvailable=$fruitQuery->fetch_assoc();
	
								//Respond with user the rates
									$response = "END Today's rates.\n";
									$response .= "Real Rates.\n";
									$response .= "Name: ".$fruitAvailable['CommodityName']."\n";
									$response .= "Amount: ".$fruitAvailable['Quantity']."\n";
									$response .= "price: ".$fruitAvailable['Mon_Price']."\n";	
						  			// Print the response onto the page so that our gateway can read it
			  						header('Content-type: text/plain');
 									echo $response;	
 							break;


					    	default:
								$response = "END Apologies, something went wrong... \n";
					  				// Print the response onto the page so that our gateway can read it
					  				header('Content-type: text/plain');
					  				echo $response;	
					    	break;
							}				
		        		break;
		        		
		        			case 4:			    		
							switch ($userResponse) {
					    		case "1":
						    		// Find the fruit in the db
									$sql7 = "SELECT * FROM vegetables_week1 WHERE CommodityName LIKE 'b%' LIMIT 1";
									$vegetablesQuery=$db->query($sql4);
									$vegetableAvailable=$vegetableQuery->fetch_assoc();
	
								//Respond with user the rates
									$response = "END Today's rates.\n";
									$response .= "Real Rates.\n";
									$response .= "Name: ".$vegetableAvailable['CommodityName']."\n";
									$response .= "Amount: ".$vegetableAvailable['Quantity']."\n";
									$response .= "price: ".$vegetableAvailable['Mon_Price']."\n";	
						  			// Print the response onto the page so that our gateway can read it
			  						header('Content-type: text/plain');
 									echo $response;		        			       	
				        		break;	

							 case "2":
					    		    	// Find the fruit in the db
									$sql7 = "SELECT * FROM vegetables_week1 WHERE CommodityName LIKE 'm%' LIMIT 1";
									$vegetableQuery=$db->query($sql4a);
									$vegetableAvailable=$vegetableQuery->fetch_assoc();
	
								//Respond with user the rates
									$response = "END Today's rates.\n";
									$response .= "Real Rates.\n";
									$response .= "Name: ".$vegetableAvailable['CommodityName']."\n";
									$response .= "Amount: ".$vegetableAvailable['Quantity']."\n";
									$response .= "price: ".$vegetableAvailable['Mon_Price']."\n";	
						  			// Print the response onto the page so that our gateway can read it
			  						header('Content-type: text/plain');
 									echo $response;	
					    		break;

					    	case "3":
					        		 	// Find the fruit in the db
									$sql7 = "SELECT * FROM vegetables_week1 WHERE CommodityName LIKE 'o%r%' LIMIT 1";
									$vegetableQuery=$db->query($sql4b);
									$vegetableAvailablee=$vegetableQuery->fetch_assoc();
	
								//Respond with user the rates
									$response = "END Today's rates.\n";
									$response .= "Real Rates.\n";
									$response .= "Name: ".$vegetableAvailable['CommodityName']."\n";
									$response .= "Amount: ".$vegetableAvailable['Quantity']."\n";
									$response .= "price: ".$vegetableAvailable['Mon_Price']."\n";	
						  			// Print the response onto the page so that our gateway can read it
			  						header('Content-type: text/plain');
 									echo $response;	
 							break;
 							
 							case "4":
					        		 	// Find the fruit in the db
									$sql7 = "SELECT * FROM vegetables_week1 WHERE CommodityName LIKE 'o%n%' LIMIT 1";
									$vegetableQuery=$db->query($sql4c);
									$vegetableAvailable=$vegetableQuery->fetch_assoc();
	
								//Respond with user the rates
									$response = "END Today's rates.\n";
									$response .= "Real Rates.\n";
									$response .= "Name: ".$vegetableAvailable['CommodityName']."\n";
									$response .= "Amount: ".$vegetableAvailable['Quantity']."\n";
									$response .= "price: ".$vegetableAvailable['Mon_Price']."\n";	
						  			// Print the response onto the page so that our gateway can read it
			  						header('Content-type: text/plain');
 									echo $response;	
 							break;


					    	default:
								$response = "END Apologies, something went wrong... \n";
					  				// Print the response onto the page so that our gateway can read it
					  				header('Content-type: text/plain');
					  				echo $response;	
					    	break;
							}				
		        		break;	
		        	  default:
						$response = "END Apologies, something went wrong... \n";
				  		// Print the response onto the page so that our gateway can read it
				  		header('Content-type: text/plain');
					  	echo $response;	
				    	break; 	}
					}
				}
			}
				 else {
				//10. Check that user response is not empty
				 	$userResponse = null;
					if ($userResponse == " ") 
					{				
						switch ($level) {			    		
					   	 case 1:
					   	 case 3:
					   	 case 4:					    	
				    		
	        				$response = "CON This field is not supposed to be empty. Please enter your choice \n";

					  		// Print the response onto the page so that our gateway can read it
					  		header('Content-type: text/plain');
	 				  		echo $response;	
					        break;
						  
					    default:
				    	// End the session
						$response = "END Apologies, something went wrong... \n";

				  		// Print the response onto the page so that our gateway can read it
				  		header('Content-type: text/plain');
	 			  		echo $response;	
				        break;
			}
		}
		}
			
?>
	         