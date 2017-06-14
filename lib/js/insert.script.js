
$('document').ready(function(){ 

     /* validation */
	 $("#insert-form").validate({
      rules:
	  {
			wert1: {
			required: true,
			},
			wert2: {
			required: true,
			},
			wert2: {
			required: true,
			},
	   },
       messages:
	   {
            wert1: "Bitte aller Werte eingeben!",
            wert2: "Bitte aller Werte eingeben!",
            wert3: "Bitte aller Werte eingeben!",
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* insert submit */
	   function submitForm()
	   {		
			var data = $("#insert-form").serialize();
				
			$.ajax({
				
			type : 'POST',
			url  : 'lib/php/insert_process.php',
			data : data,
			beforeSend: function()
			{	
				$("#error").fadeOut();
				$("#btn-login").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; sending ...');
			},
			success :  function(response)
			{						
				if(response=="ok"){
					$("#btn-login").html('<img src="lib/img/btn-ajax-loader.gif" /> &nbsp; Daten speichern ...');
					setTimeout(' window.location.href = "insert.php"; ',4000);
				}
				else{
					$("#error").fadeIn(1000, function(){						
						$("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+response+' !</div>');
						$("#btn-login").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Sign In');
					});
				}
			}
			});
			return false;
		}
	   /* insert submit */
});