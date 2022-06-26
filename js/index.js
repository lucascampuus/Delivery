	function repasseifood()
	{
		$.ajax({
                method: 'POST',
                timeout: 5000,
                url: 'data/pedidos/ifood.php',
                data: {
                    ifood: '1',					
                },
                dataType: 'json',

                success: function (data) {
								if (data.status == 'success') {
									$ ('#bodyrepasseifood').html(data.resposta);
									document.getElementById('datarepasse').value = data.dtini+" > "+data.dtfim;
									$('#repasseifood').modal('show');														
									
								} 
				}
            });
        
    };
	
 function buscarEntreData()
	{
		var dtinicio = document.getElementById("dtinicio").value;
		var dtfim = document.getElementById("dtfim").value;
		$.ajax({
                method: 'POST',
                timeout: 5000,
                url: 'data/rel/relatorioentredata.php',
                data: {
					entredatas: '1',
					dtinicio: dtinicio,
					dtfim: dtfim,
					datapesquisa: '0',
					
                },
                dataType: 'json',

                success: function (data) {
								if (data.status == 'success') {
									$('#bodydata').html(data.resposta);
									document.getElementById('dataRelativa').value = data.data + " > " + data.datafim;
									$('#entradadata').modal('show');
																
									
								} else if (data.status == 'error') {
									alert("Erro no Cadastro!");
								
								}
				}
            });
        
    };	
	$("document").ready(backup());
$("document").ready(mostrarvalores());
$("document").ready(logon())
function atualizarcusto(){	
   
		$.ajax({
                method: 'POST',
                timeout: 5000,
                url: 'data/custo/atualizarcusto.php',
                data: {
					atualizarcusto: 1,

                },
                dataType: 'json',

                success: function (data) {
								if (data.status == 'success') {
								window.location.reload();							
									
								} else if (data.status == 'error') {
									alert("Erro no Cadastro!");
								
								}
				}
            });
}
function backup()
	{
		$.ajax({
                method: 'POST',
                timeout: 5000,
                url: 'data/backup/backup.php',
                data: {
                    backup: '1',
					fazerbackup: '0',
					
                },
                dataType: 'json',

                success: function (data) {
								if (data.backup == '0') {
									$('#fazerbackup').modal('show');														
									
								} 
				}
            });
        
    };
function btnQtdProduto(tipo)
	{
		var tipo = tipo;
		var dtinicio = document.getElementById("dtinicio").value;
		var dtfim = document.getElementById("dtfim").value;
		$.ajax({
                method: 'POST',
                timeout: 5000,
                url: 'data/rel/relqtdproduto.php',
                data: {
                    consultaproduto: 'sim',
					tipo: tipo,	
					dtinicio: dtinicio,
					dtfim: dtfim
                },
                dataType: 'json',

                success: function (data) {
								if (data.status == 'success') {
									document.getElementById('dataQtdproduto').value = data.datainicio + " > " + data.datafim;
									$ ('#tbodyqtdproduto').html(data.resposta);
									$('#entradadata').modal('hide');
									$('#consultaqtdproduto').modal('show');
									
									
									
								} else if (data.status == 'error') {
									alert("Erro no Cadastro!");
								
								}
				}
            });
        
    };	

	function btnPedido(pedido,cliente)
	{
		var pedido = pedido;
		var cliente = cliente;
		$.ajax({
                method: 'POST',
                timeout: 5000,
                url: 'data/pedidos/relpedidos.php',
                data: {
                    consultapedido: 'sim',
					pedido: pedido,
					cliente: cliente,
					
					
                },
                dataType: 'json',

                success: function (data) {
								if (data.status == 'success') {
									$ ('#tbody').html(data.resposta);
									$('#pedidoshoje').modal('hide');
									$('#pedidoscliente').modal('hide');
									$('#consultapedido').modal('show');
									
									
									
								} else if (data.status == 'error') {
									alert("Erro no Cadastro!");
								
								}
				}
            });
        
    };	
	
 $('#btnfazerbackup').click(function() {

            $.ajax({
                method: 'POST',
                timeout: 5000,
                url: 'data/backup/backup.php',
                data: {
					fazerbackup: '1',
					backup: '0',
                },
                dataType: 'json',

                success: function (data) {
								if (data.status == 'success') {
									alert("Backup Atualido até ( " + data.data + " )")	
									$('#fazerbackup').modal('hide');
									atualizarcusto();
								} else if (data.status == 'error') {
									alert("Erro no Pedido!");
								
								}
				}
            });
        
    });	
	
	
$('#selectSpan').on('change', function() {
	var mes = this.value;
	$.ajax({
         type: 'POST',
         url: 'data/rel/relatoriomes.php',
         cache: false,
         dataType: 'json',
         timeout: 5000,
		  data: {
                    mes: mes,
													
                },
        
         success: function (data) {
								if (data.status == 'success') {
									$ ('#bodymes').html(data.resposta);
									document.getElementById('mesRelativo').value = data.mes;
									$('#entradames').modal('show');
																
									
								} else if (data.status == 'error') {
									alert("Sem Lançamentos!");
									
								
								}
			   }
		 })
	})
	
	
	function mostrarvalores() {
    var valormes = document.getElementById("valormes");
	var valorcompras = document.getElementById("valorcompras");
	var valorhoje = document.getElementById("valorhoje");
	var balanco = document.getElementById("valorbalanco");
    valormes.style.display = "block";
	valorcompras.style.display = "block";
	valorhoje.style.display = "block";
	balanco.style.display = "block"; 
	$("#mostrarifood").removeAttr('hidden');
		$("#btnBuscarData").removeAttr('hidden');
		$("#btnBuscarEntreDatas").removeAttr('hidden');
		
		
}
		function escondevalores() {
    var valormes = document.getElementById("valormes");
	var valorcompras = document.getElementById("valorcompras");
	var valorhoje = document.getElementById("valorhoje");
	var balanco = document.getElementById("valorbalanco");
    valormes.style.display = "none";
	valorcompras.style.display = "none";
	valorhoje.style.display = "none";
	balanco.style.display = "none";
	$("#mostrarifood").prop('hidden',true);
			$("#btnBuscarData").prop('hidden',true);	
			$("#btnBuscarEntreDatas").prop('hidden',true);	
			
}
	
 function pedidoshoje()
	{
		$.ajax({
                method: 'POST',
                timeout: 5000,
                url: 'data/rel/relhoje.php',
                data: {
                    pedido: '1',
					compra: '0',
                },
                dataType: 'json',

                success: function (data) {
								if (data.status == 'success') {
									$ ('#bodypedidoshoje').html(data.resposta);
									document.getElementById('caixa').value = 'R$ '+data.caixa;
									document.getElementById('mercadopago').value = 'R$ '+data.mercadopago;
									document.getElementById('ifoodmetodo').value = 'R$ '+data.ifood;
									$('#pedidoshoje').modal('show');
																
									
								} else if (data.status == 'error') {
									alert("Sem Pedidos");
								
								}
				}
            });
        
    };	
 function comprashoje()
	{
		$.ajax({
                method: 'POST',
                timeout: 5000,
                url: 'data/rel/relhoje.php',
                data: {
                    pedido: '0',
					compra: '1',
                },
                dataType: 'json',

                success: function (data) {
								if (data.status == 'success') {
									$ ('#bodycomprashoje').html(data.resposta);
									$('#comprashoje').modal('show');
																
									
								} else if (data.status == 'error') {
									alert("Sem Compras");
								
								}
				}
            });
        
    };	
	
 function buscarData()
	{
		var datapesquisa = document.getElementById("datapesquisa").value;
		$.ajax({
                method: 'POST',
                timeout: 5000,
                url: 'data/rel/relatoriodata.php',
                data: {
                    data: '1',
					datapesquisa: datapesquisa,
					
                },
                dataType: 'json',

                success: function (data) {
								if (data.status == 'success') {
									$ ('#bodydata').html(data.resposta);
									document.getElementById('dataRelativa').value = data.data;
									$('#entradadata').modal('show');
																
									
								} else if (data.status == 'error') {
									alert("Erro no Cadastro!");
								
								}
				}
            });
        
    };

function pedidoscliente(id)
	{
		var idcliente = id;
		$.ajax({
                method: 'POST',
                timeout: 5000,
                url: 'data/rel/relhojecliente.php',
                data: {
                    pedido: '1',
					idcliente: idcliente				
                },
                dataType: 'json',

                success: function (data) {
								if (data.status == 'success') {
									 document.getElementById('nomeclientepedido').value = data.cliente;
									 document.getElementById('valortotal').value = 'Valor Total dos pedidos ( R$'+data.valortotal+' )';
									$ ('#bodypedidoscliente').html(data.resposta);
									$('#pedidoshoje').modal('hide');
									$('#pedidoscliente').modal('show');
																
									
								} else if (data.status == 'error') {
									alert("Sem Pedidos");
								
								}
				}
            });
        
    };
    
	

