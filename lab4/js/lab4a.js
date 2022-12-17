var RegState = 0;

$(document).ready(function(){
	$.ajax({
		type: 'GET', 
		url: 'php/readRegState.php',
		async: false,
		dataType: 'json',
		encode: true
	}).always(function(data) {
		console.log(data); 
		RegState = parseInt(data);
	});
	if (RegState != 4) {
		window.location.href="index.html";
	}
	$("#logoutBtn").click(function() {
		$.ajax({
			type: 'GET', 
			url: 'php/logout.php',
			async: false,
			dataType: 'json',
			encode: true
		}).always(function(data) {
				console.log(data);
				RegState = parseInt(data.RegState); 
			  if (RegState == 4) {
				$("#logoutMessage").html(data.Message);
				return;
				}
				window.location.href="index.html";
				$("#loginMessage").html(data.Message);
				return;
		});
	})
})
