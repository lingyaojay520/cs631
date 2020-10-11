<?php
  
  	session_start();
	$user=$_POST['userName'];
	$pass=$_POST['password'];

	$db=mysqli_connect("sql1.njit.edu","qq24","1989123","qq24");
	if (mysqli_connect_errno()){
		echo "Fail to Connect to Mysql: ". mysqli_connect_errno();
	}

	mysqli_select_db( $db, $qq24 );

	$query_insert = "SELECT USERPASSWORD FROM Login WHERE USERNAME='$user'";
  $exec=mysqli_query($db, $query_insert) or die (mysqli_error($db));
  $row=mysqli_fetch_assoc($exec);

  if (password_verify($pass, $row['USERPASSWORD'])){

        $query_insert = "SELECT USERTYPE FROM Login WHERE USERNAME='$user'";
        $exec=mysqli_query($db, $query_insert) or die (mysqli_error($db));
        $row=mysqli_fetch_assoc($exec);
        $query_sid = "SELECT ReaderID FROM Login WHERE USERNAME='$user'";
        $execone=mysqli_query($db, $query_sid) or die (mysqli_error($db));
        $rowone=mysqli_fetch_assoc($execone);
        echo $row['USERTYPE'];
  }
  else{
        echo "Password error";
  }
  if ($row['USERTYPE']=="Admin"){
        header("Location: https://web.njit.edu/~tc324/CS631/Admin.html");
  }
  else if($row["USERTYPE"]=="Reader"){

        //$GLOBAL['grid']=$rowone['ReaderID'];
        echo $rowone['ReaderID'];
        $grid = $rowone['ReaderID'];
        //echo "here ".$grid;
        //setcookie('mycoick','$grid');
        $_SESSION['mysession'] = $grid;
        header("Location: https://web.njit.edu/~yl854/cs631/reader.html");
  } 
  else{
        print("error");
  }

        mysqli_close($db); 

?>