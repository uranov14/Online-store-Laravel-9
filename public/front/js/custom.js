$(document).ready(function() {
	//$(".loader").show();
	$("#getPrice").change(function() {
			var size = $(this).val();
			var product_id = $(this).attr("product_id");
			//alert(product_id);
			$.ajax({
					headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					type: 'post',
					url: '/get-product-price',
					data: {size: size, product_id: product_id},
					success: function(resp) {
							if (resp['discount'] > 0) {
									//alert(resp['product_price']);
									$(".getAttributePrice").html(`<div class="price">
									<h4>`+resp['final_price']+`&nbsp;<span style="font-size: 1rem">&#x20b4;</span></h4>
							</div>
							<div class="original-price">
									<span>Original Price:</span>
									<span>`+resp['product_price']+`</span>&nbsp;<span style="font-size: .7rem">&#x20b4;</span>
							</div>`);
							} else {
									//alert(resp['final_price']);
									$(".getAttributePrice").html(`<div class="price">
									<h4>`+resp['final_price']+`&nbsp;&#x20b4;</h4>
							</div>`);
							}
					},error: function() {
							alert('Error with product price by change Available Size');
					}
			})
	});

	// Update Cart Items Qty
	$(document).on('click','.updateCartItem',function(){
		if($(this).hasClass('plus-a')){
			// Get Qty
			var quantity = $(this).data('qty');
			// increase the qty by 1
			new_qty = parseInt(quantity) + 1;
			/*alert(new_qty);*/
		}
		if($(this).hasClass('minus-a')){
			// Get Qty
			var quantity = $(this).data('qty');
			// Check Qty is atleast 1
			if(quantity<=1){
				alert("Item quantity must be 1 or greater!");
				return false;
			}
			// increase the qty by 1
			new_qty = parseInt(quantity) - 1;
			/*alert(new_qty);*/
		}
		var cartid = $(this).data('cartid');
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data:{cartid:cartid,qty:new_qty},
			url:'/cart/update',
			type:'post',
			success:function(resp){
				$(".totalCartItems").html(resp.totalCartItems);
				if(resp.status==false){
					alert(resp.message);
				}
				$("#appendCartItems").html(resp.view);
			},error:function(){
				alert("Error");
			}
		});
	});

	// Delete Cart Item
	$(document).on('click','.deleteCartItem',function(){
		var cartid = $(this).data('cartid');
		var result = confirm("Are you sure to delete this Cart Item?");
		if (result) {
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				data:{cartid:cartid},
				url:'/cart/delete',
				type:'post',
				success:function(resp){
					$(".totalCartItems").html(resp.totalCartItems);
					$("#appendCartItems").html(resp.view);
				},error:function(){
					alert("Error");
				}
			});
		}
	}); 

	//Register Form Validation
	$("#registerForm").submit(function() {
		$(".loader").show();
		var formdata = $(this).serialize();
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			url:'/user/register',
			type:'post',
			data:formdata,
			success:function(resp){
				//alert(resp.type);
				if(resp.type == "error") {
					$(".loader").hide();
					$.each(resp.errors, function(i, error) {
						$("#register-"+i).attr('style', 'color:red');
						$("#register-"+i).html(error);
						setTimeout(function() {
							$("#register-"+i).css({'display': 'none'});
						}, 3000);
					});
				} else if(resp.type == "success") {
					$(".loader").hide();
					$("#register-success").attr('style', 'color:green');
					$("#register-success").html(resp.message);
				}
			},error:function(){
				alert("Error with Form Validation");
			}
		});
	});

	//Account Form Validation
	$("#accountForm").submit(function() {
		$(".loader").show();
		var formdata = $(this).serialize();
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			url:'/user/account',
			type:'post',
			data:formdata,
			success:function(resp){
				//alert(resp.type);
				if(resp.type == "error") {
					$(".loader").hide();
					$.each(resp.errors, function(i, error) {
						$("#account-"+i).attr('style', 'color:red');
						$("#account-"+i).html(error);
						setTimeout(function() {
							$("#account-"+i).css({'display': 'none'});
						}, 5000);
					});
				} else if(resp.type == "success") {
					$(".loader").hide();
					$("#account-success").attr('style', 'color:green');
					$("#account-success").html(resp.message);
					setTimeout(function() {
						$("#account-success").css({'display': 'none'});
					}, 5000);
				}
			},error:function(){
				alert("Error with Account Form Validation");
			}
		});
	});

	//Password Form Validation
	$("#passwordForm").submit(function() {
		$(".loader").show();
		var formdata = $(this).serialize();
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			url:'/user/update-password',
			type:'post',
			data:formdata,
			success:function(resp){
				//alert(resp.type);
				if (resp.type == "error") {
					$(".loader").hide();
					$.each(resp.errors, function(i, error) {
						$("#password-"+i).attr('style', 'color:red');
						$("#password-"+i).html(error);
						setTimeout(function() {
							$("#password-"+i).css({'display': 'none'});
						}, 5000);
					});
				} else if (resp.type == "incorrect") {
					$(".loader").hide();
					$("#password-error").attr('style', 'color:red');
					$("#password-error").html(resp.message);
					setTimeout(function() {
						$("#password-error").css({'display': 'none'});
					}, 5000);
				} else if (resp.type == "success") {
					$(".loader").hide();
					$("#password-success").attr('style', 'color:green');
					$("#password-success").html(resp.message);
					setTimeout(function() {
						$("#password-success").css({'display': 'none'});
					}, 5000);
				}
			},error:function(){
				alert("Error with Account Form Validation");
			}
		});
	});

	//Login Form Validation
	$("#loginForm").submit(function() {
		var formdata = $(this).serialize();
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			url:'/user/login',
			type:'post',
			data:formdata,
			success:function(resp){
				//alert(resp.type);
				if(resp.type == "error") {
					$.each(resp.errors, function(i, error) {
						$("#login-"+i).attr('style', 'color:red');
						$("#login-"+i).html(error);
						setTimeout(function() {
							$("#login-"+i).css({'display': 'none'});
						}, 3000);
					});
				} else if(resp.type == "incorrect") {
					$("#login-error").attr('style', 'color:red');
					$("#login-error").html(resp.message);
					setTimeout(function() {
						$("#login-error").css({'display': 'none'});
					}, 5000);
				} else if(resp.type == "inactive") {
					$("#login-error").attr('style', 'color:red');
					$("#login-error").html(resp.message);
					setTimeout(function() {
						$("#login-error").css({'display': 'none'});
					}, 5000);
				} else if(resp.type == "success") {
					$("#users-email").html(resp.email);
					window.location.href = resp.url;
				}
			},error:function(){
				alert("Error with Login Form Validation");
			}
		});
	});

	//Forgot Password
	$("#forgotForm").submit(function() {
		$(".loader").show();
		var formdata = $(this).serialize();
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			url:'/user/forgot-password',
			type:'post',
			data:formdata,
			success:function(resp){
				//alert(resp.type);
				if(resp.type == "error") {
					$(".loader").hide();
					$.each(resp.errors, function(i, error) {
						$("#forgot-"+i).attr('style', 'color:red');
						$("#forgot-"+i).html(error);
						setTimeout(function() {
							$("#forgot-"+i).css({'display': 'none'});
						}, 3000);
					});
				} else if(resp.type == "success") {
					$(".loader").hide();
					$("#forgot-success").attr('style', 'color:green');
					$("#forgot-success").html(resp.message);
				}
			},error:function(){
				alert("Error with Form Forgot Password");
			}
		});
	});
})

function get_filter(class_name) {
	var filter = [];
	$('.'+class_name+':checked').each(function() {
		filter.push($(this).val());
	});

	return filter;
}
