<!DOCTYPE html>
<html>
<body>
<?php
       //To connect the my database
       $db = mysqli_connect("sql1.njit.edu","qq24","1989123","qq24");

       //To check datbase connect successfuly.
       if (mysqli_connect_errno()) {
           
           echo "That is failed to connect to mysql: " . mysqli_connect_error();
       }

       //To select database from my database system

       mysqli_select_db($db, $qq24);

       $username = "yl854";
       $passcode = "yao123";
       $type = "Reader";
       $pass_has = password_hash($passcode, PASSWORD_DEFAULT);

       $query_insert = "INSERT INTO Login(USERTYPE, USERNAME, USERPASSWORD) VALUES('$type', '$username', '$pass_has')";

       ($exec = mysqli_query($db, $query_insert) or die (mysqli_error($db)) );
      

      echo mysqli_insert_id($db);

      mysqli_close($db);      
      
?>

</body> 
</html>