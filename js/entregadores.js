function addentregador()
	{
		$('#entregadores').modal('show');
	}
	
	
function entregador(identregador,statusentrega)
	{	
		var identregador = identregador;
		var statusentrega = statusentrega;
		$.ajax({
                method: 'POST',
                timeout: 5000,
                url: 'data/entregadores/entregas.php',
                data: {
					identregador: identregador,
					statusentrega: statusentrega,
					pagarboy: '0',
					
                },
                dataType: 'json',

                success: function (data) {
								if (data.status == 'success') {
									$ ('#bodymotoboy').html(data.resposta);
									if(data.qtd > 0)
									{
									$('#entregas').modal('show');
									}
									else
										{
											alert("Sem Entregas");
										}
																									
								} else if (data.status == 'error') {
									alert("Erro no Cadastro!");
								
								}
				}
            });
        
    };
	
	
	
	
	
function pagarboy(identregador)
	{	
		var pagarboy = identregador;
		$.ajax({
                method: 'POST',
                timeout: 5000,
                url: 'data/entregadores/entregas.php',
                data: {
					identregador: pagarboy,
					pagarboy: pagarboy,
					statusentrega: '',
					
                },
                dataType: 'json',

                success: function (data) {
								if (data.status == 'success') {
									$ ('#bodymotoboy').html(data.resposta);
									if(data.valor != 'false'){
									alert("Valor Pago R$" + data.valor);
									window.location.reload();}
									$('#entregadores').modal('hide');
																									
								} else if (data.status == 'error') {
									alert("Erro no Cadastro!");
								
								}
				}
            });
        
    };
$('#entregadorbtn').click(function() {
	 	var nomeentregador = document.getElementById("nomeentregador").value;

            $.ajax({
                method: 'POST',
                timeout: 5000,
                url: 'data/entregadores/insertentregador.php',
                data: {
                    addentregador: '1',
					nomeentregador: nomeentregador,
                },
                dataType: 'json',

                success: function (data) {
								if (data.status == 'success') {
									alert("Entregador - ( " + data.entregador + " ) - Cadastrado!!");
									window.location.reload();
									$('#cadastroentregador').modal('hide');
									
								} else if (data.status == 'error') {
									alert("Erro no Pedido!");
								
								}
				}
            });
        
    });
function statusentregador(id,status)
	{
		var identregador = id;
		var status = status;
		$.ajax({
                method: 'POST',
                timeout: 5000,
                url: 'data/entregadores/insertentregador.php',
                data: {
					alterarstatus: '1',
					addentregador: '0',
                    status: status,
					identregador: identregador,

                },
                dataType: 'json',

                success: function (data) {
								if (data.status == 'success') {
									alert("Entregador ( " + data.resposta + " )")
									window.location.reload();
									
									
									
									
								} else if (data.status == 'error') {
									alert("Erro no Cadastro!");
								
								}
				}
            });
        
    };
	function escondevalores(){}	