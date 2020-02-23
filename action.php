<?php

//action.php

include('database_connection.php');

if(isset($_POST["action"]))
{
	if($_POST["action"] == "insert")
	{
		$query = "
		INSERT INTO product (product_name, product_price, product_details, product_img) VALUES ('".$_POST["product_name"]."', '".$_POST["product_price"]."', '".$_POST["product_details"]."', '".$_POST["product_img"]."')
		";
		$statement = $connect->prepare($query);
		$statement->execute();
		echo '<p>Data Inserted...</p>';
	}
	if($_POST["action"] == "fetch_single")
	{
		$query = "
		SELECT * FROM product WHERE id = '".$_POST["id"]."'
		";
		$statement = $connect->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$output['product_name'] = $row['product_name'];
            $output['product_price'] = $row['product_price'];
            $output['product_details'] = $row['product_details'];
            $output['product_img'] = $row['product_img'];
		}
		echo json_encode($output);
	}
	if($_POST["action"] == "update")
	{
		$query = "
		UPDATE product 
		SET product_name = '".$_POST["product_name"]."', 
        product_price = '".$_POST["product_price"]."' ,
        product_details = '".$_POST["product_details"]."', 
        product_img = '".$_POST["product_img"]."'
		WHERE id = '".$_POST["hidden_id"]."'
		";
		$statement = $connect->prepare($query);
		$statement->execute();
		echo '<p>Data Updated</p>';
	}
	if($_POST["action"] == "delete")
	{
		$query = "DELETE FROM product WHERE id = '".$_POST["id"]."'";
		$statement = $connect->prepare($query);
		$statement->execute();
		echo '<p>Data Deleted</p>';
	}
}

?>
