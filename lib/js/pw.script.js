$('document').ready(function()
{ 
     /* validation */
	 $("#pw-form").validate({
      rules:
	  {
	  		password: {
				required: true,
				minlength: 5
			},
			confirm_password: {
				required: true,
				minlength: 5,
				equalTo: "#password"
			},


	   },
       messages:
	   {
            password: {
				required: "Bitte ein Passwort eingeben",
				minlength: "Dein Passwort muss mindestens 5 Zeichen lang sein!"
			},
			confirm_password: {
				required: "Bitte ein Passwort eingeben",
				minlength: "Dein Passwort muss mindestens 5 Zeichen lang sein!",
				equalTo: "Das Passwort stimmt nicht mit dem ersten überein!"
			},


       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* submit */
	   function submitForm()
	   {		
			var data = $("#pw-form").serialize();
				
			$.ajax({
				
			type : 'POST',
			url  : 'lib/php/passwort_process.php',
			data : data,
			beforeSend: function()
			{	
				$("#error").fadeOut();
				$("#btn-pwspeichern").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; speichern ...');
			},
			success :  function(response)
			   {						
					if(response=="ok"){
									
						$("#btn-pwspeichern").html('<img src="lib/img/btn-ajax-loader.gif" /> &nbsp; speichern ...');
						setTimeout(' window.location.href = "profil.php"; ',1000);
					}
					else{
									
						$("#error").fadeIn(1000, function(){						
							$("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+response+' !</div>');
							$("#btn-pwspeichern").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; SPEICHERN');
						});
					}
			  }
			});
				return false;
		}
});