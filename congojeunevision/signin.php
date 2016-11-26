 <!DOCTYPE html> 
		  <head> 
	        <meta charset="UTF-8"> 
		 
            
            <meta http-equiv='X-UA-Compatible' content='IE=edge'> 
		 
            <!-- Set the page to the width of the device and set the zoon level -->
            <meta name="viewport" content="width = device-width, initial-scale = 1"> 
		 
            <title>Congo Jeune Vision</title> 
			
            <link rel="stylesheet" type="text/css" href="css/css/bootstrap.min.css"> 
		    <link rel="stylesheet" type="text/css" href="mycss/signin.css">
		    <link rel="stylesheet" type="text/css" href="mycss/stile.css">
			
          </head> <!-- End header  -->
	
            <body> <!-- body of the site  -->
                <div class="navbar navbar-inverse "><!-- navbar div -->
				
                    <div class="container-fluid"><!-- fluid navbar  -->
					
				        <div class="navbar-header"><!-- navbar header  -->
						
						       <!--  set button to display menu on mobile devices -->
					           <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#mainnavbar">
							       <span class="sr-only"> </span>
							       <span class="icon-bar"> </span>
							       <span class="icon-bar"> </span>
							       <span class="icon-bar"> </span>
							   </button>
							<!--  set the logo on the left -->
						    <a class="navbar-brand" href="index.html"><img src="images/logo.jpg" ></a>
					    </div><!-- ----------end div navbar header  -------------------------------------------------------------------------------->
						
					    <div class="collapse navbar-collapse" id="mainnavbar"><!-- main navbar div  -->
						
						    <!--  set the left side navbar -->
					         <ul class="nav navbar-nav" >
							            <li> <a href="index.html">Acceuil<span class="sr-only">(current)</span></a></li>
								        <li > <a href="vision.html">Notre Vision</a></li>
								        <li > <a href="about.html">Notre Propos</a></li>
								        <li > <a href="signup.html">cree an account</a></li>
										<li > <a href="Patriotism.html">Patriotisme</a></li>
										<li > <a href="Action.html">Action</a></li>
								        <li > <a href="login.html">Login</a></li>
								        <li class="dropdown"> 
										      <a href="contact.html" class="dropdown-toggle" data-toggle="dropdown">Contacts Nous  <span class="caret"> </span></a>
								              
								        <ul class="dropdown-menu">
										  
									        <li><a href="#">Email</a></li>
										    <li><a href="#">Phone</a></li>
										    <li><a href="#">Parlez nous</a></li>
											
										</ul>
								        </li>
										<li > <a href="aide.html">Aide</a></li>
							</ul><!--end the left side navbar -->
							
							<!--set the right side navbar -->
							<ul class="nav navbar-nav navbar-right" >
							     <li > <a href="index.html">Signout</a></li>
							</ul> <!--end the right side navbar -->
							
							<form class="navbar-form navbar-left" role="search"><!--  search form -->
							
							        <div class="form-group">
								        <input type="text" class="form-control" placeholder="Search">
														
									    </input>
								    </div>
									
								    <button type="submit" class="btn btn-primary">Submit</button>
							</form><!-- end form section -->
				        </div><!--end container-fluid div section-->
																		
                    </div><!--end container-fluid div section -->	
                    			
			        
			 </div> <!--end navbar navbar-inverse div section -->
		 
<?php	 
	   function protect($string)
	   {
		 
		  $string = mysql_real_escape_string(trim(strip_tags(addslashes($string))));
		  
		  return $string;		  
		  
	   }
		
	   $key = md5("lombenathilumbokangufavorite@l'uniqueengenre");	 
	   
	   
	   function encrypt($string,$key)
	   {
		  
	     $string = rtrim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $string, MCRYPT_MODE_ECB))); 
		 return $string;
		  
	   }
	   
	   
	   function decrypt($string,$key)
	   {
		  
		  $string = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, base64_decode($string), MCRYPT_MODE_ECB)); 
		  return $string;
		  
	   }
	  
	  
	   function hashString($string,$salt)
	   {
		 
		    $string = crypt($string,'1$'.$salt.'$');
		    return $string;
			  
	   }
	
	    $fetchusername=null;
	    $fetchpassword=null;
		
	   
	    $dbAccount = mysql_connect("localhost","root","asset") or die(mysql_error());
	  
	    
        if (!$dbAccount) 
		{
            die('Could not connect to remote server' );
        }
   
	    
	    $salt = $password;
	    $salt = hash('sha256', $salt.$key);
	 
	    $username = encrypt($username,$key);
	    $password = hashString($password,$salt);
		
	  
	    $username = protect($_POST['email']);
        $password = protect($_POST['password']);
	 
       
	    $selectdb = mysql_select_db("jeunevision_db",$dbAccount);

        $sql="select username,password from jeunevisionusers where username='".$username."' OR password='".$password."'";
        $resultset = mysql_query($sql,$dbAccount);
	    		   
	    
	    while($row = mysql_fetch_array($resultset))
	    {
		 
		     $fetchusername = $row['username']; 
		     $fetchpassword = $row['password'];
			   	
		      
		     if($fetchusername != $username or $fetchpassword != $password)
		     {
			
			    echo('<div class="jumbotron">');
                   echo("<h3>Desolez nom d'utilisateur ou mot password ne correspondent plus,essayez encore!!!</h3>");
                   echo('<a class="btn btn-lg btn-success btn-block"  href="login.html" role="button">Login avec des donnee correct</a>');					  
		        echo("</div>");
						
		     }
		     
		     else if($fetchusername == $username and $fetchpassword == $password )
		     {
			    $fetchusername = decrypt($fetchusername,$key);
			 
			    echo('<div class="jumbotron">');
                    echo($fetchusername." <h3>Welcome to congo jeunne vision</h3>");		
		        echo("</div>");
		     }
			 
			 
		}
	    
		if($fetchusername != $username and $fetchpassword != $password)
	    {
		
		  echo('<div class="jumbotron">');
              echo("<h3>Desolez vous ne faites pas parti de nos utilisateur,SVP cree un account!!!</h3>");
              echo('<a class="btn btn-lg btn-success btn-block"  href="signup.html" role="button">Je veux cree an account</a>');
              echo('<a class="btn btn-lg btn-success btn-block"  href="login.html" role="button">Je veux essayez de login encore</a>');			  
		  echo("</div>"); 
		 
		 
	    }
 ?>
	 
        <script src="css/js/jquery.min.js"> </script><!--load jquery for css frameword-->	  
        <script src="css/js/bootstrap.min.js"> </script><!--load js for css frameword-->
		   
	    </body>
  </html>
		
