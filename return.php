<!DOCTYPE html>
<html>
<body>
<?php
    session_start();
    $readerID = $_SESSION['mysession'];
    if(isset($_POST['submit'])){

        if(isset($_GET['go'])){

            $name = $_POST['return'];
            //To connect the my database
            $db = mysqli_connect("sql1.njit.edu","qq24","1989123","qq24");
            //To check datbase connect successfuly.
            if (mysqli_connect_errno()) {
           
                echo "That is failed to connect to mysql: " . mysqli_connect_error();
            }
                //To select database from my database system
				mysqli_select_db($db, $qq24);

		    if(is_numeric($name)){

		        $query_check = "SELECT DOCID FROM Borrows WHERE $name = DOCID AND READERID = $readerID";

		        ($result_check = mysqli_query($db,$query_check) or die(mysqli_error()));

		        if(mysqli_num_rows($result_check) > 0){

		        	date_default_timezone_set('America/New_York'); //set time zone for EST

		        	$compare_date = "SELECT RDTIME FROM Borrows WHERE DOCID =$name AND READERID = $readerID"; //select RDTIME for compare does it exist

		        	($exeCompare = mysqli_query($db, $compare_date) or die(mysqli_error()));

		            $curr_date = date('Y-m-d');

		            $database_data = mysqli_fetch_array($exeCompare);

		            $old_data =($database_data['RDTIME']);
		            
		            $def_date ="0000-00-00";

		            if($curr_date === $old_data ||(($old_data < $curr_date) && ($old_data != $def_date))){

		            	echo "Your document has been returned!";
		            }

		            else{

		               	$query_date = "UPDATE Borrows SET RDTIME ='$curr_date' WHERE DOCID = $name AND READERID = $readerID";

		                ($execut = mysqli_query($db, $query_date)or die (mysqli_error($db)));

		                $query = "SELECT * FROM Borrows NATURAL JOIN Document WHERE DOCID = $name AND READERID = $readerID";

		                ($execut = mysqli_query($db, $query)or die (mysqli_error($db)));

		                if(mysqli_num_rows($execut)>0){

		                echo "<h2>Document Return confirmation:</h2>\n";
		                               
		                while($result = mysqli_fetch_array($execut, MYSQLI_ASSOC)){     

		                        $ReadID = $result['READERID']; 
		                        $DocTitle = $result['TITLE'];
		                        $docID = $result['DOCID'];
		                        $libID = $result['LIBID'];
		                        $bdTime = $result['BDTIME'];
		                        $rdTIME = $result['RDTIME'];
		                      
		                        //Print search results.
		                        echo  "<ul>\n";
		                        echo  "<li> Returned Document Title: " . $DocTitle . "</li>\n";
		                        echo  "<li> Returned Document ID: " . $docID . "</li>\n";
		                        echo  "<li> Your Reader ID: " . $ReadID . "</li>\n"; 
		                        echo  "<li> Your Library ID: " . $libID . "</li>\n"; 
		                        echo  "<li> Borrow Date: " . $bdTime . "</li>\n";
		                        echo  "<li> Return Date: " . $rdTIME . "</li>\n";
		                        echo  "</ul>";
			                }
		                }
		            }
		        }      
			            else{
			                echo "Your enter document ID cannot be found, or you do not borrow this document. Please re-check!";
			            }
		    }
		    else{
		        echo "Invalid document ID";
		    }
		      
			}
		}
  	else{
        echo "<p> Please enter your document id number</p>";
  	}
?>
</body> 
</html>