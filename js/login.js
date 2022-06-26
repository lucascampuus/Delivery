$("document").ready(logon());
$('#loginuser').click(function() {
	 		var	pswd = document.getElementById('pswd').value;
            $.ajax({
                method: 'POST',
                timeout: 5000,
                url: 'data/login/login.php',
                data: {
                    login: '1',
					pswd: pswd,
					logout: '0',
					logon: '1'
                },
                dataType: 'json',

                success: function (data) {
								if (data.status == 'success') {
								window.location.reload();
								
										
									
								} else if (data.status == 'error') {
									$("#pswdmsg").removeAttr('hidden');
									document.getElementById('pswd').value = '';
								
								}
				}
            });
        
    });
	
	 function lengthpswd(){
	 valuelength = document.getElementById('pswd').value
	if (valuelength.length > 3) {
		$("#loginuser").removeAttr('disabled');
	}
	else
	{
		$("#loginuser").prop("disabled", true);
	}
}
	 function logout()
	{
		escondevalores();
		$.ajax({
                method: 'POST',
                timeout: 5000,
                url: 'data/login/login.php',
                data: {
					login: '0',
					pswd: '',
					logout: '1',
					logon: '0'
					
                },
                dataType: 'json',

                success: function (data) {
								if (data.status == 'success') {
								window.location.reload();
																
									
								} else if (data.status == 'error') {
									
								
								}
				}
            });
        
    };
	 function logon()
	{
		$.ajax({
                method: 'POST',
                timeout: 5000,
                url: 'data/login/login.php',
                data: {
					login: '0',
					pswd: '',
					logout: '0',
					logon: '1'
					
                },
                dataType: 'json',

                success: function (data) {
								if (data.status == 'success') {
								
																
									
								} else if (data.status == 'error') {
									$('#login').modal('show');
								
								}
				}
            });
        
    };
	

$('#login').on('shown.bs.modal', function () {
$('#pswd').focus()
})
setTimeout(logout, 30000*10);