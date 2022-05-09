function userAvailability(){

	
	$.ajax({
		type:"POST",
		url:"ajax/userCheck.php",
		cache:false,
		data:{
			type:1,
			username:$("#username").val(),
		},
		success:function(data){
			$("#user-availability-status").html(data);

		}
	});
}
function emailAvailability(){

	
	$.ajax({
		type:"POST",
		url:"ajax/emailCheck.php",
		cache:false,
		data:{
			type:1,
			email:$("#email").val(),
		},
		success:function(data){
			$("#email-availability-status").html(data);

		}
	});
}