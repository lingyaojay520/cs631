<!DOCTYPE html>
<html>
<body>
<?php
    session_start();
    $readerID = $_SESSION['mysession'];
    
    // if(isset($_POST['submit'])){

    //     if(isset($_GET['go'])){

            // $name = $_POST['readerID'];
            //To connect the my database
            $db = mysqli_connect("sql1.njit.edu");
            //To check datbase connect successfuly.
            if (mysqli_connect_errno()) {
           
                echo "That is failed to connect to mysql: " . mysqli_connect_error();
            }

                //To select database from my database system
				mysqli_select_db($db, $qq24);
                //if search by document id
				// if(is_numeric($name)){
					$query = "SELECT * FROM Reserves NATURAL JOIN Document WHERE READERID = $readerID";

					($execut = mysqli_query($db, $query)or die (mysqli_error($db)));


                    if(mysqli_num_rows($execut)>0){

                        echo "<h2>Reserved document results:</h2>\n";
                                   
                        while($result = mysqli_fetch_array($execut, MYSQLI_ASSOC)){
                                            
                            $DocID = $result['DOCID']; 
                            $docTitle = $result['TITLE'];
                            $ReaderID = $result['READERID'];
                            $reserveDate = $result['DTIME'];
                            $copyNo = $result['COPYNO'];
                            $libID = $result['LIBID'];
                            //Print search results.
                            echo  "<ul>\n"; 
                            echo  "<li> Document ID: " . $DocID . "</li>\n"; 
                            echo  "<li> Document Title: " . $docTitle . "</li>\n"; 
                            echo  "<li> Copy Number: " . $copyNo . "</li>\n"; 
                            echo  "<li> Library ID: " . $libID . "</li>\n"; 
                            echo  "<li> Reader ID: " . $ReaderID . "</li>\n";
                            echo  "<li> Reserved Date: " . $reserveDate . "</li>\n";
                            echo  "</ul>";
                }
                    }
                    else{

                        echo "You do not reserve any document yet.";
                    }
				// }

				// else{

    //         		echo "Invalid Reader ID";
 			// 	}
	// 	}
	// }
 //  	else{
 //        echo "<p> Please enter a search query</p>";
 //  	}
?>

</body> 
</html>