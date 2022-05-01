<?php
if (isset($_POST['submit'])) {
    if (isset($_POST['Name']) && isset($_POST['Price']) &&
        isset($_POST['Description']) && isset($_POST['Availability'])) {
        
        $product_name = $_POST['Name'];
        $product_price = $_POST['Price'];
        $product_description = $_POST['Description'];
        $product_availability = $_POST['Availability'];
		//0
        
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
            $Select = "SELECT Product_Name FROM products WHERE Product_Name = ? LIMIT 1";
            $Insert = "INSERT INTO products(Product_Name, Product_Price, Product_Description, Product_Availability) values(?, ?, ?, ?)";

            $stmt = $conn->prepare($Select);
            $stmt->bind_param("s", $product_name);
            $stmt->execute();
            $stmt->bind_result($resultProduct_name);//
            $stmt->store_result();
            $stmt->fetch();
            $rnum = $stmt->num_rows;

            if ($rnum == 0) {
                $stmt->close();

                $stmt = $conn->prepare($Insert);
                $stmt->bind_param("sdss",$product_name, $product_price, $product_description, $product_availability);
                if ($stmt->execute()) {
                    echo "New record inserted sucessfully.";
                }
                else {
                    echo $stmt->error;
                }
            }
            else {
                echo "There is already a product listing with this name";
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