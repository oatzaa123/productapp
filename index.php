<html>  
    <head>  
        <title>หน้าจัดการสินค้า</title>  
		<link rel="stylesheet" href="jquery-ui.css">
        <link rel="stylesheet" href="bootstrap.min.css" />
		<script src="jquery.min.js"></script>  
		<script src="jquery-ui.js"></script>
    </head>  
    <body>  
        <div class="container">
			<br />
			
			<h1 align="center">หน้าจัดการสินค้า</a></h1><br />
			<br />
			<div align="right" style="margin-bottom:5px;">
			<button type="button" name="add" id="add" class="btn btn-success btn-xs">Add</button>
			</div>
			<div class="table-responsive" id="user_data">
				
			</div>
			<br />
		</div>
		
		<div id="user_dialog" title="Add Data">
			<form method="post" id="user_form">
				<div class="form-group">
					<label>Enter Product name</label>
					<input type="text" name="product_name" id="product_name" class="form-control" />
					<span id="error_product_name" class="text-danger"></span>
				</div>
				<div class="form-group">
					<label>Enter Product name</label>
					<input type="text" name="product_price" id="product_price" class="form-control" />
					<span id="error_product_price" class="text-danger"></span>
        </div>
        <div class="form-group">
					<label>Enter Product details</label>
					<input type="text" name="product_details" id="product_details" class="form-control" />
					<span id="error_product_details" class="text-danger"></span>
        </div>
        <div class="form-group">
					<label>Select Product img</label>
					<input type="text" name="product_img" id="product_img" class="form-control" />
					<span id="error_product_image"></span>
				</div>
				<div class="form-group">
					<input type="hidden" name="action" id="action" value="insert" />
					<input type="hidden" name="hidden_id" id="hidden_id" />
					<input type="submit" name="form_action" id="form_action" class="btn btn-info" value="Insert" />
				</div>
			</form>
		</div>
		
		<div id="action_alert" title="Action">
			
		</div>
		
		<div id="delete_confirmation" title="Confirmation">
		<p>Are you sure you want to Delete this data?</p>
		</div>
		
    </body>  
</html>  




<script>  
$(document).ready(function(){  

	load_data();
    
	function load_data()
	{
		$.ajax({
			url:"fetch.php",
			method:"POST",
			success:function(data)
			{
				$('#user_data').html(data);
			}
		});
	}
	
	$("#user_dialog").dialog({
		autoOpen:false,
		width:400
	});
	
	$('#add').click(function(){
		$('#user_dialog').attr('title', 'Add Data');
		$('#action').val('insert');
		$('#form_action').val('Insert');
		$('#user_form')[0].reset();
		$('#form_action').attr('disabled', false);
		$("#user_dialog").dialog('open');
	});
	
	$('#user_form').on('submit', function(event){
		event.preventDefault();
		var error_product_name = '';
    	var error_product_price = '';
    	var error_product_details = '';
    	var error_product_img = '';
		if($('#product_name').val() == '')
		{
			error_product_name = 'Product name is required';
			$('#error_product_name').text(error_product_name);
			$('#product_name').css('border-color', '#cc0000');
		}
		else
		{
			error_product_name = '';
			$('#error_product_name').text(error_product_name);
			$('#product_name').css('border-color', '');
		}
		if($('#product_price').val() == '')
		{
			error_product_price = 'Product price is required';
			$('#error_product_price').text(error_product_price);
			$('#product_price').css('border-color', '#cc0000');
		}
		else
		{
			error_product_price = '';
			$('#error_product_price').text(error_product_price);
			$('#product_price').css('border-color', '');
    	}
    	if($('#product_details').val() == '')
		{
			error_product_details = 'Product details is required';
			$('#error_product_details').text(error_product_details);
			$('#product_details').css('border-color', '#cc0000');
		}
		else
		{
			error_product_details = '';
			$('#error_product_details').text(error_product_details);
			$('#product_details').css('border-color', '');
		}
		if($('#product_img').val() == '')
		{
			error_product_img = 'Product img is required';
			$('#error_product_img').text(error_product_img);
			$('#product_img').css('border-color', '#cc0000');
		}
		else
		{
			error_product_img = '';
			$('#error_product_img').text(error_product_img);
			$('#product_img').css('border-color', '');
    	}
		
		if(error_product_name != '' || error_product_price != '' || error_product_details != '' || error_product_img != '')
		{
			return false;
		}
		else
		{
			$('#form_action').attr('disabled', 'disabled', 'disabled', 'disabled');
			var form_data = $(this).serialize();
			$.ajax({
				url:"action.php",
				method:"POST",
				data:form_data,
				success:function(data)
				{
					$('#user_dialog').dialog('close');
					$('#action_alert').html(data);
					$('#action_alert').dialog('open');
					load_data();
					$('#form_action').attr('disabled', false);
				}
			});
		}
		
	});
	
	$('#action_alert').dialog({
		autoOpen:false
	});
	
	$(document).on('click', '.edit', function(){
		var id = $(this).attr('id');
		var action = 'fetch_single';
		$.ajax({
			url:"action.php",
			method:"POST",
			data:{id:id, action:action},
			dataType:"json",
			success:function(data)
			{
				$('#product_name').val(data.product_name);
        		$('#product_price').val(data.product_price);
				$('#product_details').val(data.product_details);
				$('#product_img').val(data.product_img);
				$('#user_dialog').attr('title', 'Edit Data');
				$('#action').val('update');
				$('#hidden_id').val(id);
				$('#form_action').val('Update');
				$('#user_dialog').dialog('open');
			}
		});
	});
	
	$('#delete_confirmation').dialog({
		autoOpen:false,
		modal: true,
		buttons:{
			Ok : function(){
				var id = $(this).data('id');
				var action = 'delete';
				$.ajax({
					url:"action.php",
					method:"POST",
					data:{id:id, action:action},
					success:function(data)
					{
						$('#delete_confirmation').dialog('close');
						$('#action_alert').html(data);
						$('#action_alert').dialog('open');
						load_data();
					}
				});
			},
			Cancel : function(){
				$(this).dialog('close');
			}
		}	
	});
	
	$(document).on('click', '.delete', function(){
		var id = $(this).attr("id");
		$('#delete_confirmation').data('id', id).dialog('open');
	});
	
});  
</script>