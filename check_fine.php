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
            $db = mysqli_connect("sql1.njit.edu","qq24","1989123","qq24");
            //To check datbase connect successfuly.
            if (mysqli_connect_errno()) {
           
                echo "That is failed to connect to mysql: " . mysqli_connect_error();
            }
                //To select database from my database system
				mysqli_select_db($db, $qq24);
				//function dateDiffIndays to calculate two date diff
                function dateDiffInDays($date1, $date2)  
                { 
                    // Calulating the difference in timestamps 
                    $diff = strtotime($date2) - strtotime($date1); 
                      
                    // 1 day = 24 hours 
                    // 24 * 60 * 60 = 86400 seconds 
                    return abs(round($diff / 86400)); 
                } 

                //if search by document id
				// if(is_numeric($name)){

					date_default_timezone_set('America/New_York'); //set time zone for EST

                    echo "<h2>Checking fines resluts:</h2>";

					$query_date = "SELECT BDTIME, RDTIME, DOCID FROM Borrows NATURAL JOIN Reader WHERE READERID = $readerID";

					($execut = mysqli_query($db, $query_date) or die (mysqli_error($db)));

                    $curr_date = date('Y-m-d');

                    if(mysqli_num_rows($execut)>0){

                        $base_day = 20;
                        $base_fine = 0.6;

                        while($data = mysqli_fetch_array($execut)){

                            if($data['RDTIME'] == "0000-00-00"){

                            	echo "Your document ID = ". $data['DOCID'] . " does not return yet<br>";
                                
                                if((dateDiffInDays($curr_date, $data['BDTIME'])) > $base_day){

                                    $fine_day = (dateDiffInDays($curr_date, $data['BDTIME']) - $base_day);

                                    $total_fine = ($fine_day * $base_fine);

                                    $query = "UPDATE Reader SET FINE = $total_fine WHERE READERID = $readerID";

                                    ($execut2 = mysqli_query($db, $query) or die(mysqli_error())); 

                                    //Print results.
                                    $docID = $data['DOCID'];
                                    $readID = $readerID;
                                    $Borrows_date = $data['BDTIME'];
                                    $Today = $curr_date;
                                    $docOVER_DUE = $fine_day;
                                    $total_penalty = $total_fine;

                                    echo  "<ul>\n"; 
                                    echo  "<li> Document ID: " . $docID . "</li>\n"; 
                                    echo  "<li> Reader ID: " . $readID . "</li>\n"; 
                                    echo  "<li> Borrows Date: " . $Borrows_date . "</li>\n";
                                    echo  "<li> Today's Date: " . $Today . "</li>\n";
                                    echo  "<li> You have overdue " . $docOVER_DUE . " days". "</li>\n";
                                    echo  "<li> You have to pay $" . $total_penalty . " dollars penalty till today". "</li>\n"; 
                                    echo  "</ul>";
                                }

                                else{


                                    $query = "UPDATE Reader SET FINE = 0 WHERE READERID = $readerID";

                                    ($execut2 = mysqli_query($db, $query) or die (mysqli_error())); 

                                    $fine_day = (dateDiffInDays($curr_date, $data['BDTIME']));
                                    $docID = $data['DOCID'];
                                    $readID = $readerID;
                                    $Borrows_date = $data['BDTIME'];
                                    $Today = $curr_date;
                                    $docOVER_DUE = $fine_day;
                                    $conti_read = ($base_day - $docOVER_DUE);

                                    echo  "<ul>\n"; 
									echo  "<li> Document ID: " . $docID . "</li>\n";
                                    echo  "<li> Reader ID: " . $readID . "</li>\n"; 
                                    echo  "<li> Borrows Date: " . $Borrows_date . "</li>\n";
                                    echo  "<li> Today's Date: " . $Today . "</li>\n";
                                    echo  "<li> You still can read " . $conti_read . " days"."</li>\n";
                                    echo  "<li> You do not have any penalty till today</li>\n"."<br>";
                                    echo  "</ul>";

                                }
                            }

                            else{

                                if(dateDiffInDays($data['RDTIME'], $data['BDTIME']) > $base_day){

                                    $fine_day = (dateDiffInDays($data['RDTIME'], $data['BDTIME']) - $base_day);

                                    $total_fine = ($fine_day * $base_fine);

                                    $query = "UPDATE Reader SET FINE = $total_fine WHERE READERID = $readerID";
                                    ($execut2 = mysqli_query($db, $query) or die(mysqli_error())); 

                                    //Print results.
                                    $docID = $data['DOCID'];
                                    $readID = $readerID;
                                    $Borrows_date = $data['BDTIME'];
                                    $Return_date = $data['RDTIME'];
                                    $docOVER_DUE = $fine_day;
                                    $total_penalty = $total_fine;

                                    echo  "<ul>\n"; 
                                    echo  "<li> Document ID: " . $docID . "</li>\n"; 
                                    echo  "<li> Reader ID: " . $readID . "</li>\n"; 
                                    echo  "<li> Borrows Date: " . $Borrows_date . "</li>\n";
                                    echo  "<li> Return Date: " . $Return_date . "</li>\n";
                                    echo  "<li> You have overdue " . $docOVER_DUE . " days". "</li>\n";
                                    echo  "<li> You had paid $" . $total_penalty . " dollars penalty by your returned date". "</li>\n"."<br>"; 
                                    echo "</ul>";

                                }
                                else{

                                    $query = "UPDATE Reader SET FINE = 0 WHERE READERID = $readerID";

                                    ($execut2 = mysqli_query($db, $query) or die(mysqli_error())); 

                                    $fine_day = (dateDiffInDays($data['RDTIME'], $data['BDTIME']));

                                    $docID = $data['DOCID'];
                                    $readID = $readerID;
                                    $Borrows_date = $data['BDTIME'];
                                    $Return_date = $data['RDTIME'];
                                    $docOVER_DUE = $fine_day;
                                

                                    echo  "<ul>\n"; 
									echo  "<li> Document ID: " . $docID . "</li>\n";
                                    echo  "<li> Reader ID: " . $readID . "</li>\n";
                                    echo  "<li> Borrows Date: " . $Borrows_date . "</li>\n";
                                    echo  "<li> Return Date: " . $Return_date . "</li>\n";
                                    echo  "<li> Your document was returned before due date</li>\n";
                                    echo  "<li> You do not have any penalty till today</li>\n";
                                    echo  "</ul>";
                                }
                            }
                        }

                    }
                    else{
                        echo "You does not borrow any document yet";
                    }
                // }
                // else{
                //     echo "Invalid reader id number";
                // }
	// 	}
	// }
 //  	else{
 //        echo "<p> Please enter a search query</p>";
 //  	}
?>
</body> 
</html>