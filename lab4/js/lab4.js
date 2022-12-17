
var RegState = 0;

$(document).ready(function() {
	$.ajax({
		type: 'GET', 
		url: 'php/readRegState.php',
		async: false,
		dataType: "text",
		encode: false
	}).always(function(data) {
		console.log(data); 
		RegState = parseInt(data);
	});
	// alert("readRegState return("+RegState+")");
	if (RegState <= 0) {
		$("#loginForm").show();
		$("#registerForm").hide();
		$("#setPasswordForm").hide();
		$("#resetPasswordForm").hide();
		$("#authenticationForm").hide();
		$("#authenticationForm2").hide();
	}
	if (RegState == 1) {
		$("#loginForm").hide();
		$("#registerForm").show();
		$("#setPasswordForm").hide();
		$("#resetPasswordForm").hide();
		$("#authenticationForm").show();
		$("#authenticationForm2").hide();
	}
	if (RegState == 2) {
		$("#loginForm").hide();
		$("#registerForm").hide();
		$("#setPasswordForm").show();
		$("#resetPasswordForm").hide();
		$("#authenticationForm").hide();
		$("#authenticationForm2").hide();
	}
	if (RegState == 3) {
		$("#loginForm").hide();
		$("#registerForm").hide();
		$("#setPasswordForm").hide();
		$("#resetPasswordForm").show();
		$("#authenticationForm").hide();
		$("#authenticationForm2").show();
	}
	if (RegState == 4) {
		window.location.href="protected.html";
		console.log("Welcome to RegState 4");
	}
	$("#registerViewBtn").click(function(){
		$.ajax({
			type: "GET", 
			url: "php/register0.php",
			async: false,
			dataType: "text",
			encode: false
		}).always(function(data) {
			console.log(data); 
			RegState = parseInt(data);
		});
		$("#loginForm").hide();
		$("#registerForm").show();
		$("#setPasswordForm").hide();
		$("#resetPasswordForm").hide();
		$("#authenticationForm").show();
		$("#authenticationForm2").hide();
	})
	$("#forgetViewBtn").click(function(){
		$.ajax({
			type: "GET", 
			url: "php/forget0.php",
			async: false,
			dataType: "text",
			encode: false
		}).always(function(data) {
			console.log(data); 
			RegState = parseInt(data);
		});
		$("#loginForm").hide();
		$("#registerForm").hide();
		$("#setPasswordForm").hide();
		$("#resetPasswordForm").show();
		$("#authenticationForm").hide();
		$("#authenticationForm2").show();
	})
	$("#registerBtn").click(function(e) {
		event.preventDefault(e);
		var formData = {
		  'FirstName' : $('input[name=FirstName]').val(),
		  'LastName' : $('input[name=LastName]').val(),
		  'Email': $('input[name=Email]').val()
		};
		$.ajax({
			type: 'GET', 
			url: 'php/register.php',
			async: true,
			data: formData,
			dataType: 'json',   
			encode: true		
		}).always(function(data) {	
			console.log(data); 
			RegState = parseInt(data.RegState);
			$("#loginForm").hide();
			$("#registerForm").show();
			$("#setPasswordForm").hide();
			$("#resetPasswordForm").hide();
			$("#authenticationForm").show();
			$("#authenticationForm2").hide();	
			$("#registerMessage").html(data.Message);
		});
	})
 	$("#authBtn1").click(function(e){
		event.preventDefault(e);
		var formData = {
		  'ACode' : $('input[name=Acode]').val()
		};
		$.ajax({
		  type: 'POST', 
		  url: 'php/authenticate.php',
		  async: true,
		  data: formData,
		  dataType: 'json',   
		  encode: true		
		}).always(function(data) {	
			console.log(data); 
			RegState = parseInt(data.RegState);
			if (RegState == 2) {
				$("#loginForm").hide();
				$("#registerForm").hide();
				$("#setPasswordForm").show();
				$("#resetPasswordForm").hide();
				$("#authenticationForm").hide();
				$("#authenticationForm2").hide();	
				$("#setPasswordMessage").html(data.Message);
			} else {
				$("#loginForm").hide();
				$("#registerForm").show();
				$("#setPasswordForm").hide();
				$("#resetPasswordForm").hide();
				$("#authenticationForm").show();
				$("#authenticationForm2").hide();
				$("#registerMessage").html(data.Message);	  
			}
			return;
		});		
	})
	
	$("#setPasswordBtn").click(function(e) {
		event.preventDefault(e);
		var formData = {
			'password1' : $('input[name=password1]').val(),
			'password2' : $('input[name=password2]').val()
		};
		$.ajax({
			type: 'POST', 
			url: 'php/setPassword.php',
			async: true,
			data: formData,
			dataType: 'json',   
			encode: true		
		}).always(function(data) {	
			console.log(data); 
			RegState = parseInt(data.RegState);
			if (RegState == 0) { // Success
				$("#loginForm").show();
				$("#registerForm").hide();
				$("#setPasswordForm").hide();
				$("#resetPasswordForm").hide();
				$("#authenticationForm").hide();
				$("#authenticationForm2").hide();
				$("#loginMessage").html(data.Message);
				return;
			} // Errors
			$("#loginForm").hide();
			$("#registerForm").hide();
			$("#setPasswordForm").show();
			$("#resetPasswordForm").hide();
			$("#authenticationForm").hide();
			$("#authenticationForm2").hide();		
			$("#setPasswordMessage").html(data.Message);
			return;
		});
	})
	
	$("#authBtn2").click(function(e){
		event.preventDefault(e);
		var formData = {
			'ACode' : $('input[name=Acode2]').val()
		};
		$.ajax({
			type: 'POST', 
			url: 'php/authenticate.php',
			async: true,
			data: formData,
			dataType: 'json',
			encode: true
		}).always(function(data) {
			console.log(data); 
			RegState = parseInt(data.RegState);
			if (RegState == 2) {
				$("#loginForm").hide();
				$("#registerForm").hide();
				$("#setPasswordForm").show();
				$("#resetPasswordForm").hide();
				$("#authenticationForm").hide();
				$("#authenticationForm2").hide();	
				$("#setPasswordMessage").html(data.Message);
			} else {
				$("#loginForm").hide();
				$("#registerForm").hide();
				$("#setPasswordForm").hide();
				$("#resetPasswordForm").show();
				$("#authenticationForm").hide();
				$("#authenticationForm2").show();
				$("#resetPasswordMessage").html(data.Message);
			}
		});
	})
	
 	$("#loginBtn").click(function(e) { 
		event.preventDefault(e);
		var formData = {
			'Email' : $('input[name=loginEmail]').val(),
			'Password' : $('input[name=loginPassword]').val(),
			'RememberMe' : $('input[name=RememberMe]').is(':checked')? 'remember-me' : ''
		};
		
		$.ajax({
			type: 'POST', 
			url: 'php/login.php',
			async: true,
			data: formData,
			dataType: 'json',
			encode: true
		}).always(function(data) {
			console.log(data); 
			RegState = parseInt(data.RegState);
			alert("RegState=["+RegState+"]");
			if ((RegState <= 0) || (isNaN(RegState))) {
				$("#loginForm").show();
				$("#registerForm").hide();
				$("#setPasswordForm").hide();
				$("#resetPasswordForm").hide();
				$("#authenticationForm").hide();
				$("#authenticationForm2").hide();
				$("#loginMessage").html(data.Message);
				return;
			}
			window.location.href="protected.html";
			return;
		});
	})
	$("#resetPasswordBtn").click(function(e) {
		event.preventDefault(e);
		var formData = {
			'resetEmailPassword' : $('input[name=resetEmailPassword]').val()
		};
		$.ajax({
			type: 'GET', 
			url: 'php/resetEmailPassword.php',
			async: true,
			data: formData,
			dataType: 'json',
			encode: true
		}).always(function(data) {
			console.log(data); 
			RegState = parseInt(data.RegState);
			$("#loginForm").hide();
			$("#registerForm").hide();
			$("#setPasswordForm").hide();
			$("#resetPasswordForm").show();
			$("#authenticationForm").hide();
			$("#authenticationForm2").show();
			$("#resetPasswordMessage").html(data.Message);
		});
	})
	$("#back").click(function(){
		$.ajax({
			type: 'GET', 
			url: 'php/back.php',
			async: false,
			dataType: "json",
			encode: true
		}).always(function(data) {
			console.log(data); 
			RegState = parseInt(data);
		});
		window.location.href="index.html";
	})
	$(".home").click(function(){
		$.ajax({
			type: 'GET', 
			url: 'php/back.php',
			async: false,
			dataType: "json",   
			encode: true	
		}).always(function(data) {	
			console.log(data); 
			RegState = parseInt(data);
		});
		window.location.href="index.html";
	})
});
