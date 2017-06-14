$('document').ready(function()
{ 
     /* validation */
	 $("#insert-form").validate({
      rules:
	  {
			user_name: {
				
			},
			user_email: {
	            required: true,
	            email: true
            },
	   },
       messages:
	   {
            user_name: "Bitte deinen Namen eigeneben! Mindestens 3 Zeichen...",
            user_email: "Bitte deine Emailadresse eingeben!",
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* submit */
	   function submitForm()
	   {		
			var data = $("#insert-form").serialize();
				
			$.ajax({
				
			type : 'POST',
			url  : 'lib/php/profil_process.php',
			data : data,
			beforeSend: function()
			{	
				$("#error").fadeOut();
				$("#btn-speichern").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; speichern ...');
			},
			success :  function(response)
			   {						
					if(response=="ok"){
									
						$("#btn-speichern").html('<img src="lib/img/btn-ajax-loader.gif" /> &nbsp; speichern ...');
						setTimeout(' window.location.href = "profil.php"; ',1000);
					}
					else{
									
						$("#error").fadeIn(1000, function(){						
							$("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+response+' !</div>');
							$("#btn-login").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; SPEICHERN');
						});
					}
			  }
			});
				return false;
		}
});