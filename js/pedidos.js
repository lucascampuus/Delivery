
	 function substituiPonto(el){
    el.value = el.value.replace(",", ".");
}
function pedidohide()
{
$('#fazerpedido').modal('hide');
var delprodutocarrinho = '';
	 		var idcarrinho = '';
	 		var editprodutocarrinho = ''; 
			var pedido = document.getElementById('sessionpedido').value;
            $.ajax({
                method: 'POST',
                timeout: 5000,
                url: 'data/carrinho/eloadcarrinho.php',
                data: {
                    carregarcarrinho: 'sim',
					combopromocional: '',
					pedido: pedido,
					delprodutocarrinho: delprodutocarrinho,
					editprodutocarrinho: editprodutocarrinho,
					idcarrinho: idcarrinho,
                },
                dataType: 'json',

                success: function (data) {
								if (data.status == 'success') {
									document.getElementById('sessionpedido').value = data.pedido;
									document.getElementById('nomecliente').value = data.cliente;
									document.getElementById('idclientepedido').value = data.cliente;
									$ ('#tbodypedido').html(data.resposta);
									$('#pedido').modal('show');
									
									
									
								} else if (data.status == 'error') {
									alert("Erro no Pedido!");
								
								}
				}
            });
        
};
function cancelarPedido(id)
	{
		var pedido = id;
	    var resposta = confirm("Deseja Cancelar este Pedido?");
     if (resposta == true) {
		$.ajax({
                method: 'POST',
                timeout: 5000,
                url: 'data/pedidos/cancelarpedido.php',
                data: {
					cancelarpedido: 'sim',
					pedido: pedido,
                },
                dataType: 'json',

                success: function (data) {
								if (data.status == 'success') {
									alert("Pedido ( " + data.pedido + " ) Cancelado!!!");
									window.location.reload();
									
									
									
									
								} else if (data.status == 'error') {
									alert("Erro no Cadastro!");
								
								}
				}
            });
	 }
        
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
									$('#consultapedido').modal('show');
									
									
									
								} else if (data.status == 'error') {
									alert("Erro no Cadastro!");
								
								}
				}
            });
        
    };
	$("document").ready(buttonvalid());
	function buttonvalid() {
    var buttonshow = document.getElementById("btnFazerPedido");
    var entregador  = document.getElementById("entregador");
    var metodopagamento = document.getElementById("metodopagamento");
	var plataforma = document.getElementById("plataforma");
    
    
  if(entregador && metodopagamento){
     if(entregador.value  != "Não Selecionado" && metodopagamento.value != "Não Selecionado" && plataforma.value != "Não Selecionado"){
           $("#btnFazerPedido").removeAttr('disabled');
     }
	  else if(entregador.value  == "Não Selecionado" || metodopagamento.value == "Não Selecionado" || plataforma.value == "Não Selecionado"){
           $("#btnFazerPedido").prop("disabled", true);
     }
   }
}
	
	function myfunction(obj){
    if (obj.checked)
    {
		var idcombo = obj.value;
		var delprodutocarrinho = '';
	 	var idcarrinho = '';
	 	var editprodutocarrinho = '';
		$.ajax({
                method: 'POST',
                timeout: 5000,
                url: 'data/carrinho/eloadcarrinho.php',
                data: {
					carregarcarrinho: 'sim',
					combopromocional: '1',
					idcombo: idcombo,
					idcarrinho: idcarrinho,
					delprodutocarrinho: delprodutocarrinho,
					editprodutocarrinho: editprodutocarrinho,
                },
                dataType: 'json',

                success: function (data) {
								if (data.status == 'success') {
									$ ('#tbody').html(data.resposta);
									document.getElementById('combopromocional'+idcombo).checked = true;
									document.getElementById('combopromocional').value = data.combo;
									$('#pedido').modal('show');
									
									
									
									
								} else if (data.status == 'error') {
									alert("Erro no Cadastro!");
								
								}
				}
            });

		}
	}	
	 function editarPedido(pedido) {
	 		var delprodutocarrinho = '';
	 		var idcarrinho = '';
	 		var editprodutocarrinho = ''; 
			var pedido = pedido;
            $.ajax({
                method: 'POST',
                timeout: 5000,
                url: 'data/carrinho/eloadcarrinho.php',
                data: {
                    carregarcarrinho: 'sim',
					combopromocional: '',
					pedido: pedido,
					delprodutocarrinho: delprodutocarrinho,
					editprodutocarrinho: editprodutocarrinho,
					idcarrinho: idcarrinho,
                },
                dataType: 'json',

                success: function (data) {
								if (data.status == 'success') {
									document.getElementById('sessionpedido').value = data.pedido;
									document.getElementById('idclientepedido').value = data.cliente;
									document.getElementById('nomecliente').value = data.nomecliente;									
									document.getElementById('idclientepedido').value = data.cliente;
									$('#fazerpedido').modal('hide'); 
									$ ('#tbodypedido').html(data.resposta);
									$('#pedido').modal('show');
									
									
									
								} else if (data.status == 'error') {
									alert("Erro no Pedido!");
								
								}
				}
            });
        
    };
	
	  $('#btnFazerPedido').click(function() {
		  		var	metodopagamento = document.getElementById('metodopagamento').value;
		  		var entregador = document.getElementById('entregador').value;
		  		var valorentrega = document.getElementById('valorentrega').value;
				var	idcliente = document.getElementById('idclientepedido').value;
		  		var	session = document.getElementById('sessionpedido').value;
		  		var valortotalpedido = document.getElementById('valornovo').value;
		  		var combopromocional = document.getElementById('combopromocional').value;
		  		var plataforma = document.getElementById('plataforma').value;
				var obs = document.getElementById('obs').value;
		  		
            $.ajax({
                method: 'POST',
                timeout: 5000,
                url: 'data/pedidos/editarpedido.php',
                data: {
                    editarpedido: 'sim',
					idcliente: idcliente,
					session: session,
					valortotalpedido: valortotalpedido,
					metodopagamento: metodopagamento,
					combopromocional: combopromocional,	
					entregador: entregador,
					valorentrega: valorentrega,
					plataforma: plataforma,
					obs: obs,
					
                },
                dataType: 'json',

                success: function (data) {
								if (data.status == 'success') {
									$('#pedido').modal('hide');
									if(data.repetido == 1)
										{
											alert("Pedido Já Inserido");
										}
									if(data.cupom != '0')
										{
											alert("Cliente Tem Cupom de ( "+data.cupom+" ) - Disponivel!")
										}
									window.location.replace("pedidos.php?pedido=" + data.pedido + "&cliente=" + data.cliente);
									
																
								} else if (data.status == 'error') {
									alert("Erro no Pedido!");
								
								}
				}
            });
        
    });
	function addcarrinho(id,nomeproduto,valorproduto,tipoproduto)
	{
		var idproduto = id;
		var session = session;
		var nomeproduto = nomeproduto;
		var valorproduto = valorproduto;
		var tipoproduto = tipoproduto;
		var session = document.getElementById('sessionpedido').value;
		
		$.ajax({
                method: 'POST',
                timeout: 5000,
                url: 'data/carrinho/insertcarrinho.php',
                data: {
                    inserircarrinho: 'sim',
					idproduto: idproduto,
					session: session,
					nomeproduto: nomeproduto,
					valorproduto: valorproduto,
					tipoproduto: tipoproduto,
					
                },
                dataType: 'json',

                success: function (data) {
								if (data.status == 'success') {
									alert(data.produto + "  Adicionado");
									
									
									
								} else if (data.status == 'error') {
									alert("Erro no Cadastro!");
								
								}
				}
            });
        
    };	
	
	function delproduto(id,pedido)
	{
		var idcarrinho = id;
		var pedido = pedido;
		var editprodutocarrinho = '';
		
		$.ajax({
                method: 'POST',
                timeout: 5000,
                url: 'data/carrinho/eloadcarrinho.php',
                data: {
					carregacarrinho: 'sim',
                    delprodutocarrinho: '1',
					combopromocional: '',
					pedido: pedido,
					editprodutocarrinho: editprodutocarrinho,
					idcarrinho: idcarrinho,					
                },
                dataType: 'json',

                success: function (data) {
								if (data.status == 'success') {
									$ ('#tbodypedido').html(data.resposta);
									$('#pedido').modal('show');
									
									
									
								} else if (data.status == 'error') {
									alert("Erro no Cadastro!");
								
								}
				}
            });
        
    };
	function editproduto(id,pedido)
	{
		var idcarrinho = id;
		var pedido = pedido;
		var valorupg = document.getElementById('valorupg'+id).value;
		var delprodutocarrinho = '';
		$.ajax({
                method: 'POST',
                timeout: 5000,
                url: 'data/carrinho/eloadcarrinho.php',
                data: {
					carregacarrinho: 'sim',
                    editprodutocarrinho: '1',
					delprodutocarrinho: delprodutocarrinho,
					combopromocional: '',
					idcarrinho: idcarrinho,
					valorupg: valorupg,
					pedido: pedido,
                },
                dataType: 'json',

                success: function (data) {
								if (data.status == 'success') {
									$ ('#tbodypedido').html(data.resposta);
									$('#pedido').modal('show');
									
									
									
									
								} else if (data.status == 'error') {
									alert("Erro no Cadastro!");
								
								}
				}
            });
        
    };
	function escondevalores(){}