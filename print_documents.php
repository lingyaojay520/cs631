<!DOCTYPE html>
<html>
<body>
<?php

    if(isset($_POST['submit'])){

        if(isset($_GET['go'])){

            $name = $_POST['publisher'];
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
					$query = "SELECT * FROM Publisher NATURAL JOIN Document WHERE PUBLISHERID = $name";

					($execut = mysqli_query($db, $query)or die (mysqli_error($db)));

                }
                else{

                    $query = "SELECT * FROM Publisher NATURAL JOIN Document WHERE PUBNAME LIKE '%".$name."%'";

                    ($execut = mysqli_query($db, $query)or die (mysqli_error($db)));

                }
                    if(mysqli_num_rows($execut)>0){

                        echo "<h2>Document information results:</h2>\n";
                                   
                        while($result = mysqli_fetch_array($execut, MYSQLI_ASSOC)){
                                            
                            $DocID = $result['DOCID']; 
                            $docTitle = $result['TITLE'];
                            $publisherID = $result['PUBLISHERID'];
                            $publisherName = $result['PUBNAME'];
                            //Print search results.
                            echo  "<ul>\n"; 
                            echo  "<li> Document ID: " . $DocID . "</li>\n"; 
                            echo  "<li> Document Title: " . $docTitle . "</li>\n"; 
                            echo  "<li> Publisher ID: " . $publisherID . "</li>\n"; 
                            echo  "<li> Publisher Name: " . $publisherName . "</li>\n"; 
                            echo  "</ul>";
                }
                    }
                    else{

                        echo "This publisher does not publish any document yet";
                    }
		}
	}
  	else{
        echo "<p> Please enter a search query</p>";
  	}
?>

</body> 
</html>