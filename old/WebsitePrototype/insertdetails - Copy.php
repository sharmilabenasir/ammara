<?php
//error_reporting(E_ALL);//
//ini_set('display_errors', 1);//

if (isset($_POST['submit'])) {
    if (isset($_POST['Username']) && isset($_POST['Password']) && isset($_POST['Email']) &&
        isset($_POST['Firstname']) && isset($_POST['Lastname'])) {
        
		$email_address = $_POST['Email'];
        $user_name = $_POST['Username'];
        $password = $_POST['Password'];
        $first_name = $_POST['Firstname'];
        $last_name = $_POST['Lastname'];
        
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
            $Select = "SELECT Email_Address FROM 'user accounts' WHERE Email_Address = ? LIMIT 1";
            $Insert = "INSERT INTO 'user accounts'(Email_address, Username, Password, Firstname, Lastname) values(?, ?, ?, ?, ?)";
			
			//if($stmt = $conn->prepare($Select)) { // assuming $mysqli is the connection
			//	$query->bind_param('s', $email_address);//
			//	$query->execute();//
			//	$stmt->bind_result($resultEmail_address);//
			//	$stmt->store_result();//
			//	$stmt->fetch();//
			//	$rnum = $stmt->num_rows;//
			//	// any additional code you need would go here.
			//} 
			//else 
			//{
			//	$error = $conn->errno . ' ' . $conn->error;
			//	echo $error; // 1054 Unknown column 'foo' in 'field list'
			//}
			
            $stmt = $conn->prepare($Select);
            $stmt->bind_param('s', $email_address);
            $stmt->execute();
            $stmt->bind_result($email_address);//was resultemailaddress
            $stmt->store_result();
            $stmt->fetch();
            $rnum = $stmt->num_rows;

            if ($rnum == 0) {
                $stmt->close();

                $stmt = $conn->prepare($Insert);
                $stmt->bind_param("sssss", $email_address, $user_name, $password, $first_name, $last_name);
                if ($stmt->execute()) {
                    echo "New account created.";
                }
                else {
                    echo $stmt->error;
                }
            }
            else {
                echo "Sorry this email is already in use, please select another email to create an account";
            }
            $stmt->close();
            $conn->close();
        }
    }
    else {
        echo "All field are required.";
        die();
    }
}
else {
    echo "Submit button is not set";
}
?>