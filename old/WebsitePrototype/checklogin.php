<?php
session_start(); 

if (isset($_POST['submit'])) 
{
    if (isset($_POST['Username']) && isset($_POST['Password'])) 
	{
        
        $username = $_POST['Username'];
        $password = $_POST['Password'];
        
        $host = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbName = "coffee shop";
		
		$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
		
		if ($conn->connect_error) 
		{
            die('Could not connect to the database.');
        }
        else
		{
			$sql = "SELECT * FROM accounts WHERE Username='$username' AND Password='$password'";

			$result = mysqli_query($conn, $sql);

			if (mysqli_num_rows($result) === 1) 
			{
				$row = mysqli_fetch_assoc($result);
				if ($row['Username'] === $username && $row['Password'] === $password) 
				{
					$_SESSION['Username'] = $row['Username'];
					$_SESSION['Firstname'] = $row['Firstname'];
					$_SESSION['Account_ID'] = $row['Account_ID'];
					header("Location: http://localhost/websitePrototype/index.html"); //ignore this
					exit();
					
					if($row['Admin'] === "y")//test
					{
						//link to admin page
						header('Location: http://localhost/websitePrototype/AdminPage.html ');
						exit();
					}
					else
					{
						
					}
					echo "Login successful.";
					exit();
				}
            }
			else
			{
				echo "Invalid username or password.";
		        exit();
			}
            //$result = $conn->query("SELECT * FROM accounts WHERE 'Username' = '".$username."' AND 'Password' = '".$password."'");
			//$row = $result->fbsql_fetch_array();//fetch_assoc();
			
			//if($row['Username'] == $username && $row['Password'] == $password)
			//{
			//	echo "Login success".$row['Username'];
			//}
			//else
			//{
			//	echo "Login failed";
			//}
			
            //$conn->close();
        }
		

        //mysql_connect("localhost", "root", "");
		//mysql_select_db("accounts");
		
        //$result = mysql_query("SELECT * FROM accounts WHERE Username = '$username' AND Password = '$password'");
		//				die("failed to connect to database");
        //$row = mysql_fetch_array($result);
		//if($row['Username'] == $username && $row['Password'] == $password)
		//{
		//	echo "Login success".$row['Username'];
		//}
		//else
		//{
		//	echo "Login failed";
		//}
			
        $conn->close();
        
    }
    else 
	{
        echo "All field are required.";
        die();
    }
}
else 
{
    echo "Submit button is not set";
}
?>