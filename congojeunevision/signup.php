<?php
      
		 echo("<!DOCTYPE html>"); 
		 echo("<head>"); 
	     echo('<meta charset="UTF-8">'); 
		 
         //If IE use the latest rendering engine 
         echo("<meta http-equiv='X-UA-Compatible' content='IE=edge'>"); 
		 
         //<!-- Set the page to the width of the device and set the zoon level -->
         echo('<meta name="viewport" content="width = device-width, initial-scale = 1">'); 
		 
         echo("<title>Congo Jeune Vision</title>"); 
         echo('<link rel="stylesheet" type="text/css" href="css/css/bootstrap.min.css">'); 
		 echo('<link rel="stylesheet" type="text/css" href="mycss/signin.css">');
		 echo('<link rel="stylesheet" type="text/css" href="mycss/stile.css">');
         echo("</head>"); //<!-- End header  -->
	
         echo("<body>"); //<!-- body of the site  -->
                echo('<div class="navbar navbar-inverse ">');//<!-- navbar div -->
				
                    echo('<div class="container-fluid">');//<!-- fluid navbar  -->
					
				        echo('<div class="navbar-header">');//<!-- navbar header  -->
						
						    //<!--  set button to display menu on mobile devices -->
					        echo('<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#mainnavbar">');
							
					           echo('<span class="sr-only"> </span>');
							   echo('<span class="icon-bar"> </span>');
							   echo('<span class="icon-bar"> </span>');
							   echo('<span class="icon-bar"> </span>');
							   
						    echo("</button>");
							//<!--  set the logo on the left -->
						    echo('<a class="navbar-brand" href="index.html"><img src="images/logo.jpg" ></a>');
					    echo("</div>");//<!-- ----------end div navbar header  -------------------------------------------------------------------------------->
						
					    echo('<div class="collapse navbar-collapse" id="mainnavbar">');//<!-- main navbar div  -->
						
						    //<!--  set the left side navbar -->
					        echo('<ul class="nav navbar-nav" >');
							            echo('<li> <a href="index.html">Acceuil<span class="sr-only">(current)</span></a></li>');
								        echo('<li > <a href="vision.html">Notre Vision</a></li>');
								        echo('<li > <a href="about.html">Notre Propos</a></li>');
								        echo('<li > <a href="signup.html">cree an account</a></li>');
										echo('<li > <a href="Patriotism.html">Patriotisme</a></li>');
										echo('<li > <a href="Action.html">Action</a></li>');
								        echo('<li > <a href="login.html">Login</a></li>');
								        echo('<li class="dropdown"> ');
										      echo('<a href="contact.html" class="dropdown-toggle" data-toggle="dropdown">Contacts Nous  <span class="caret"> </span></a>');
								              
								        echo('<ul class="dropdown-menu">');
										  
									        echo('<li><a href="#">Email</a></li>');
										    echo('<li><a href="#">Phone</a></li>');
										    echo('<li><a href="#">Parlez nous</a></li>');
											
										echo("</ul>");
								        echo("</li>");
										echo('<li > <a href="aide.html">Aide</a></li>');
							echo("</ul>");//<!-------------------------------------------------------------------------------------  end the left side navbar -->
							
							//<!--  set the right side navbar -->
							echo('<ul class="nav navbar-nav navbar-right" >');
							     echo('<li > <a href="index.html">Signout</a></li>');
							echo("</ul>");//<!---------------------------------------------------------------------------------------end the right side navbar -->
							
							echo('<form class="navbar-form navbar-left" role="search">');//<!--  search form -->
							
							        echo('<div class="form-group">');
								        echo('<input type="text" class="form-control" placeholder="Search">');
														
									    echo('</input>');
								    echo('</div>');
									
								    echo('<button type="submit" class="btn btn-primary">Submit</button>');
							echo('</form>');//<!------------------------------------------------------------------------------------------------  end form section -->
				        echo('</div>');//<!-- end container-fluid div section --------------------------------------------------------------------------------------->
																		
                    echo("</div>");//<!------------------------------------------------------------------------------------------- end container-fluid div section -->	
                    			
			        
			 echo("</div>"); //<!----------------------------------------------------------------------------------------- end navbar navbar-inverse div section -->
			//creating function protect
	   function protect($string)
	   {
		 
		  $string = mysql_real_escape_string(trim(strip_tags(addslashes($string))));
		  return $string;		  
		  
	   }//end function protect
	  
	   $key = md5("lombenathilumbokangufavorite@l'uniqueengenre");
	   	  
	   //encrypt function
	   function encrypt($string,$key)
	   {
		  
	     $string = rtrim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $string, MCRYPT_MODE_ECB))); 
		 return $string;
		  
	   }//end encrypt function
	   
	   //decrypt function
	    function decrypt($string,$key)
	    {
		  
		  $string = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, base64_decode($string), MCRYPT_MODE_ECB)); 
		  return $string;
		  
	    }//end decrypt function
	  
	    //hashString function
	    function hashString($string,$salt)
	    {
		 
		    $string = crypt($string,'1$'.$salt.'$');
		    return $string;
			  
	    }//end hashstring function
	  
	    //obtaining signup data from user by POST
	    $completeName= protect($_POST['fullname']);
	    $emailAddress= protect($_POST['email']);
	    $highschool= protect($_POST['ecole']);
	    $town= protect($_POST['provF']);
	    $currentCountry= protect($_POST['pays']);
	    $universty= protect($_POST['univ']);
	    $faculty= protect($_POST['optionf']);
	    $username= protect($_POST['usernamef']);
	    $password= protect($_POST['password']);
	    $repassword= protect($_POST['password2']);
	  
	    $salt = $password;
	    $salt = hash('sha256', $salt.$key);
	    
	 
			 
		//checkinh if any of the above variable is null
	    if($completeName == null or $emailAddress == null or $highschool==null or $town == null or 
	    $currentCountry == null or $universty == null or $faculty == null or $username == null or $password == null or $repassword == null)
	    {
		        echo('<div class="jumbotron">');
                    echo("One of the field wasn't fieled please fill all require field");		
		        echo("</div>");
		  
	    }
	        elseif($password != $repassword)
			{	 
			   echo('<div class="jumbotron">');
			   echo("<h2>Les deux mots de pass fournit ne correspondent plus,SVP essayer encore!!!<h2>"); 
		       echo("</div>");
							
	       }   
	       else
		   {   
	            //prepare data for validation
				$username = encrypt($username,$key);
	            $emailAddress = encrypt($emailAddress,$key);
				
			    $fetchusername=null;
	            $fetchEmail=null;
				
				//connect to the database server 
                $dbAccount= mysql_connect("localhost","root","asset") or die(mysql_error());
	  
	            //check successsful connection 
                if (!$dbAccount) 
			    {
			       echo('<div  class="jumbotron">');
				   
                        die('Un problem survenu lors du connection a notre reseau essayer encore!!!');
						
				   echo('</div>');
                }
                echo("");
	  
	            //selecting the database to be use
	            mysql_select_db("jeunevision_db",$dbAccount);
	  
	            
			    //check if username,emailaddress already exist in the database
			    $myquery = "select username,emailAddress from jeunevisionUsers WHERE username='".$username."' and emailAddress='".$emailAddress."'";
				
			    $resultset = mysql_query($myquery,$dbAccount);
                				
	            while($row = mysql_fetch_array($resultset))
	            {
		           
				   $fetchusername = $row['username']; 
		           $fetchEmail = $row['emailAddress'];
							   	  
				   if($fetchEmail == $emailAddress and $fetchusername == $username)
				   {
					   echo('<div  class="jumbotron">');
                             echo("<h3>Problem survenu:email address et nom d'utilisateur deja utilise,veuillez utilisez different donnees!!!</h3>");
				       echo('</div>');
					
				   }//endif
				   elseif($fetchEmail == $emailAddress and $fetchusername != $username)
				   {
					   echo('<div  class="jumbotron">');
                             echo("<h3>Problem survenu:votre email address est deja utiliser,SVP veuillez utilisez un autre email</h3>");
					   echo('</div>');
				   }//endif
				   
				   elseif($fetchusername == $username and $fetchEmail != $emailAddress)
				   {
					   echo('<div  class="jumbotron">');
                            echo("<h3>Problem survenu:votre nom d'utilisateur est deja utiliser,SVP choisissez quelque chose d'autre</h3>");
				       echo('</div>');
					
				   }//endif
		           	  
		        }//while
				
				if($fetchEmail != $emailAddress and $fetchusername!= $username)
		        {
			          
					  $fetchusername = decrypt($fetchusername,$key);
					  
					  //query to be perform
	                  $sql = "insert into jeunevisionUsers(completeName,emailAddress,highschool,town,currentCountry,university,falculty,username,password) 
	                  values('".encrypt($completeName,$key)."','".encrypt($emailAddress,$key)."','".encrypt($highschool,$key)."','".encrypt($town,$key)."',
	                  '".encrypt($currentCountry,$key)."','".encrypt($universty,$key)."','".encrypt($faculty,$key)."','".encrypt($username,$key)."','".hashString($password,$salt)."')";
	  
                      //execute query
	                  mysql_query($sql,$dbAccount)
				
		              or die("The error is : "  .mysql_error());
		  
		              echo('<div class="jumbotron">');
			
			          echo("<h2>Merci d'avoir rejoint congo jeune vision,votre compte est successfully cree!!!<h2>"); 
			
		              echo("</div>");
					  
		        }//endif
	           
		      
	       }//end else
	       echo('<script src="css/js/jquery.min.js"> </script>');//<!load jquery for css frameword-->	  
           echo('<script src="css/js/bootstrap.min.js"> </script>');//<!load js for css frameword-->
		   
	       echo("</body>"); 
		   echo("</html>");

?>