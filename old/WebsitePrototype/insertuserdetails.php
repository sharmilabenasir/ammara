<?php
session_start();//

if (isset($_POST['submit'])) {
    if (isset($_POST['Username']) && isset($_POST['Password']) &&
        isset($_POST['Gender']) && isset($_POST['Email']) &&
        isset($_POST['Firstname']) && isset($_POST['Lastname'])) {
        
        $username = $_POST['Username'];
        $password = $_POST['Password'];
        $gender = $_POST['Gender'];
        $email = $_POST['Email'];
        $firstname = $_POST['Firstname'];
        $lastname = $_POST['Lastname'];

        $host = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbName = "coffee shop";

        $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

        if ($conn->connect_error) {
            die('Could not connect to the database.');
        }
        else {
            $Select = "SELECT Email FROM accounts WHERE Email = ? LIMIT 1";
            $Insert = "INSERT INTO accounts(Username, Password, Gender, Email, Firstname, Lastname) values(?, ?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($Select);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($resultEmail);
            $stmt->store_result();
            $stmt->fetch();
            $rnum = $stmt->num_rows;

            if ($rnum == 0) {
                $stmt->close();

                $stmt = $conn->prepare($Insert);
                $stmt->bind_param("ssssss",$username, $password, $gender, $email, $firstname, $lastname);
                if ($stmt->execute()) 
				{
					header('Location: http://localhost/websitePrototype/index.html ');
					exit();
                    echo "New account created.";
                }
                else {
                    echo $stmt->error;
                }
            }
            else {
                echo "Sorry this email is already in use, please use register using another email.";
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