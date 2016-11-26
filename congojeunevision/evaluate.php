<?php		 
	 
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
	
	
	    
	
	
	    $fetchusername=null;
	    $fetchpassword=null;
		
	    //connect to database
	    $dbAccount = mysql_connect("localhost","root","asset") or die(mysql_error());
	  
	    //check successsful connection 
        if (!$dbAccount) {
            die('Could not connect to remote server' );//. mysql_error()
        }
   
	    //Prepare data for validation
	    $salt = $password;
	    $salt = hash('sha256', $salt.$key);
	 
	    $username = encrypt($username,$key);
	    $password = hashString($password,$salt);
		
	    //get credential from user
	    $username = protect($_POST['email']);
        $password = protect($_POST['password']);
	 
        //select the database in use
	    $selectdb = mysql_select_db("jeunevision_db",$dbAccount);

        $sql="select username,password from jeunevisionusers where username='".$username."' OR password='".$password."'";
        $resultset = mysql_query($sql,$dbAccount);
	    		   
	    //resultset has some data not equl to null
	    while($row = mysql_fetch_array($resultset))
	    {
		 
		      $fetchusername = $row['username']; 
		      $fetchpassword = $row['password'];
			   	
		      //user doensnt provide correct credentials
		     if($fetchusername != $username or $fetchpassword != $password)
		     {
			
			    echo('<div class="jumbotron">');
                   echo("<h3>Desolez nom d'utilisateur ou mot password ne correspondent plus,essayez encore!!!</h3>");
                   echo('<a class="btn btn-lg btn-success btn-block"  href="login.html" role="button">Login avec des donnee correct</a>');					  
		       echo("</div>");
						
		     }
		     //user match username and password
		     if($fetchusername == $username and $fetchpassword == $password )
		     {
			    $fetchusername = decrypt($fetchusername,$key);
			 
			    echo('<div class="jumbotron">');
                    echo($fetchusername." <h3>Welcome to congo jeunne vision</h3>");		
		        echo("</div>");
		     }
			 
			 
		}//end while
	    
		if($fetchusername != $username and $fetchpassword != $password)
	    {
		
		  echo('<div class="jumbotron">');
              echo("<h3>Desolez vous ne faites pas parti de nos utilisateur,SVP cree un account!!!</h3>");
              echo('<a class="btn btn-lg btn-success btn-block"  href="signup.html" role="button">Je veux cree an account</a>');
              echo('<a class="btn btn-lg btn-success btn-block"  href="login.html" role="button">Je veux essayez de login encore</a>');			  
		  echo("</div>"); 
		 
		 
	    }//endif
 ?>