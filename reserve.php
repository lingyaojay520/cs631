<!DOCTYPE html>
<html>
<body>
<?php

    session_start();
    $readerID = $_SESSION['mysession'];

    if(isset($_POST['submit'])){

        if(isset($_GET['go'])){

        	date_default_timezone_set('America/New_York'); //set time zone for EST

            $name = $_POST['reserve'];
            //To connect the my database
            $db = mysqli_connect("sql1.njit.edu");
            //To check datbase connect successfuly.
            if (mysqli_connect_errno()) {
           
                echo "That is failed to connect to mysql: " . mysqli_connect_error();
            }

                //To select database from my database system
				mysqli_select_db($db, $qq24);
                //if search by document id
				if(is_numeric($name)){

                    $curr_date = date("Y-m-d");

					$query = "SELECT * FROM Copy NATURAL JOIN Document WHERE DOCID = $name";

					($execut = mysqli_query($db, $query)or die (mysqli_error($db)));


                     if(mysqli_num_rows($execut)>0){

                            echo "<h2>Document reserve confirmation:</h2>\n";

                            $count = 1;
                
                            while($result = mysqli_fetch_array($execut, MYSQLI_ASSOC) ){

                                   $doc = $result['DOCID'];
                                   $copy = $result['COPYNO'];
                                   $LIB  = $result['LIBID'];
                                   
                                   if($count == 1){

	                                   	$query2 = "INSERT INTO Reserves(READERID, DOCID, COPYNO, LIBID, DTIME) VALUES ('$readerID', '$doc', '$copy', '$LIB', '$curr_date')";

	                             	   	($execut2 = mysqli_query($db, $query2) or die(mysqli_error($db)));

	                             	   	$count ++;
	                             	   	
	                             	   	$DocID = $result['DOCID'];
	                             	   	$readId = $readerID; 
	                             	   	$lib   = $result['LIBID'];
			                            $docTitle = $result['TITLE'];
			                            $reserveDate = $curr_date;

			                            //print reserved results.  
			                            echo  "<ul>\n"; 
			                            echo  "<li> Reader ID: " . $readId . "</li>\n";
			                            echo  "<li> Library ID: " . $lib . "</li>\n"; 
			                            echo  "<li> Document ID: " . $DocID . "</li>\n";  
			                            echo  "<li> Document Title: " . $docTitle . "</li>\n"; 
			                            echo  "<li> Reserved Date: " . $reserveDate . "</li>\n";
			                            echo  "<li> *NOTE* Library will help you to hold 24 hours! ". "</li>\n";
			                            echo  "</ul>";

                                   }
                                   else{

                                   		break;
                                   }

                            }
                    }

        		}
            else{
                echo "Invalid document ID";
          	}
		}
	}
	
  	else{
        echo "<p> Please enter a search query</p>";
  	}
?>

</body> 
</html>