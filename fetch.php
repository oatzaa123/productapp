<?php

//fetch.php

include("database_connection.php");

$query = "SELECT * FROM product";
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$total_row = $statement->rowCount();
$output = '
<table class="table table-striped table-bordered">
	<tr>
		<th>Product Name</th>
        <th>Product Price</th>
        <th>Product Details</th>
        <th>Product Img</th>
		<th>Edit</th>
		<th>Delete</th>
	</tr>
';
if($total_row > 0)
{
	foreach($result as $row)
	{
		$output .= '
		<tr>
			<td width="40%">'.$row["product_name"].'</td>
            <td width="40%">'.$row["product_price"].'</td>
            <td width="40%">'.$row["product_details"].'</td>
            <td><img src="img/'.$row["product_img"].'" height="60" width="75" class="img-thumbnail" /></td>
            
			<td width="10%">
				<button type="button" name="edit" class="btn btn-primary btn-xs edit" id="'.$row["id"].'">Edit</button>
			</td>
			<td width="10%">
				<button type="button" name="delete" class="btn btn-danger btn-xs delete" id="'.$row["id"].'">Delete</button>
			</td>
		</tr>
		';
	}
}
else
{
	$output .= '
	<tr>
		<td colspan="4" align="center">Data not found</td>
	</tr>
	';
}
$output .= '</table>';
echo $output;
?>