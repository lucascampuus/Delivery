$("document").ready(atualizacombo());
			function atualizacombo()
	{
		
		
		$.ajax({
                method: 'POST',
                timeout: 5000,
                url: 'data/combos/atualizacombo.php',
                data: {
                    atualizacombo: 'sim',
					
					
                },
                dataType: 'json',

                success: function (data) {
								if (data.status == 'success') {																
								} else if (data.status == 'error') {
									alert("Erro no Cadastro!");
								
								}
				}
            });
        
    };
	
	
	
	 function substituiPonto(el){
    el.value = el.value.replace(",", ".");
}
    function cupom()
	{		
	$('#cupom').modal('show');
	}
	  $('#btnCupom').click(function() {
	   var cupom = document.getElementById('codigocupom').value;
		  		
            $.ajax({
                method: 'POST',
                timeout: 5000,
                url: 'data/cupom/insertcupom.php',
                data: {
                    inserircupom: 'sim',
					cupom: cupom,
				
					
                },
                dataType: 'json',

                success: function (data) {
								if (data.status == 'success') {
									alert("Cupom ( "+data.cupom+" ) Inserido!")
									$('#cupom').modal('hide');
									$('#fazerpedido').modal('show');				
																
								} else if (data.status == 'error') {
									alert("Erro no Pedido!");
								
								}
				}
            });
        
    });	
	
	
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
                url: 'data/carrinho/loadcarrinho.php',
                data: {
					carregarcarrinho: 'sim',
					combopromocional: '1',
					idcarrinho: idcarrinho,
					idcombo: idcombo,
					delprodutocarrinho: delprodutocarrinho,
					editprodutocarrinho: editprodutocarrinho,
                },
                dataType: 'json',

                success: function (data) {
								if (data.status == 'success') {
									$ ('#tbody').html(data.resposta);
									document.getElementById('combopromocional'+idcombo).checked = true;
									document.getElementById('combopromocional').value = data.combo;
									//$('#pedido').modal('show');
									
									
									
									
								} else if (data.status == 'error') {
									alert("Erro no Cadastro!");
								
								}
				}
            });

		}
	}	
	
		function cadastroCliente(){
	$('#cadastroCliente').modal('show');}	
	$('#cadastroCliente').on('shown.bs.modal', function (){$('#nome_cliente').focus()})
  
	function pedido(idcliente,nome,apelido,session,valorproduto)
	{
		var idcliente = idcliente;
		$('#idcliente').val(idcliente);
		//$('#nomecliente').val(nome);
		$('#apelido').val(apelido);
		$('#session').val(session);		
		
		
		
	$.ajax({
                method: 'POST',
                timeout: 5000,
                url: 'data/carrinho/insertcarrinho.php',
                data: {
                    inserirfrete: 'sim',
					idcliente: idcliente,
					
					
                },
                dataType: 'json',

                success: function (data) {
								if (data.cupom == '1') {
									$ ('#tcupom').html(data.resposta);
									document.getElementById('codigocupom').value = data.codigo;
									document.getElementById('nomecliente').value = data.cliente;
									cupom();
									
								}
								else if(data.cupom == '0')
									{
								document.getElementById('nomecliente').value = data.cliente;		
								$('#fazerpedido').modal('show');
													
									
								} else if (data.status == 'error') {
									alert("Erro no Cadastro!");
								
								}
				}
            });
        
    };	
	
	
	
	
	
	
 
 $('#btnpedido').click(function() {
	 		var delprodutocarrinho = '';
	 		var idcarrinho = '';
	 		var editprodutocarrinho = '';
	 
	 		var	idcliente = document.getElementById('idcliente').value;
            $.ajax({
                method: 'POST',
                timeout: 5000,
                url: 'data/carrinho/loadcarrinho.php',
                data: {
                    carregarcarrinho: 'sim',
					combopromocional: '',
					idcliente: idcliente,
					delprodutocarrinho: delprodutocarrinho,
					editprodutocarrinho: editprodutocarrinho,
					idcarrinho: idcarrinho,
                },
                dataType: 'json',

                success: function (data) {
								if (data.status == 'success') {
									$('#fazerpedido').modal('hide'); 
									$ ('#tbody').html(data.resposta);
									$('#pedido').modal('show');
									//document.getElementById('valornovo').value = data.valor;
									
								} else if (data.status == 'error') {
									alert("Erro no Pedido!");
								
								}
				}
            });
        
    });
	
	  $('#btnFazerPedido').click(function() {
		  		var	metodopagamento = document.getElementById('metodopagamento').value;
		  		var entregador = document.getElementById('entregador').value;
		  		var valorentrega = document.getElementById('valorentrega').value;
				var	idcliente = document.getElementById('idcliente').value;
		  		var	session = document.getElementById('session').value;
		  		var valortotalpedido = document.getElementById('valornovo').value;
		  		var combopromocional = document.getElementById('combopromocional').value;
		  		var plataforma = document.getElementById('plataforma').value;
				var obs = document.getElementById('obs').value;
		  		
            $.ajax({
                method: 'POST',
                timeout: 5000,
                url: 'data/pedidos/insertpedidos.php',
                data: {
                    inserirpedido: 'sim',
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
									//window.location.replace("pedidos.php?pedido=" + data.pedido + "&cliente=" + data.cliente);
									window.location.reload();
									
																
								} else if (data.status == 'error') {
									alert("Erro no Pedido!");
								
								}
				}
            });
        
    });
	

	
		function esvaziacarrinho()
	{
		
		
		$.ajax({
                method: 'POST',
                timeout: 5000,
                url: 'data/carrinho/insertcarrinho.php',
                data: {
                    esvaziacarrinho: 'sim',
					
					
                },
                dataType: 'json',

                success: function (data) {
								if (data.status == 'success') {																
								} else if (data.status == 'error') {
									alert("Erro no Cadastro!");
								
								}
				}
            });
        
    };
	
	
	
	
	function addcarrinho(id,session,nomeproduto,valorproduto,tipoproduto)
	{
		var idproduto = id;
		var session = session;
		var nomeproduto = nomeproduto;
		var valorproduto = valorproduto;
		var tipoproduto = tipoproduto;
		var idcarrinho = '';
		
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
					idcarrinho: idcarrinho
					
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
	
	function delproduto(id)
	{
		var idcarrinho = id;
		var editprodutocarrinho = '';
		
		$.ajax({
                method: 'POST',
                timeout: 5000,
                url: 'data/carrinho/loadcarrinho.php',
                data: {
					carregacarrinho: 'sim',
                    delprodutocarrinho: '1',
					combopromocional: '',
					editprodutocarrinho: editprodutocarrinho,
					idcarrinho: idcarrinho,					
                },
                dataType: 'json',

                success: function (data) {
								if (data.status == 'success') {
									$ ('#tbody').html(data.resposta);
									$('#pedido').modal('show');
									
									
									
								} else if (data.status == 'error') {
									alert("Erro no Cadastro!");
								
								}
				}
            });
        
    };
	function editproduto(id)
	{
		var idcarrinho = id;
		var valorupg = document.getElementById('valorupg'+id).value;
		var delprodutocarrinho = '';
		$.ajax({
                method: 'POST',
                timeout: 5000,
                url: 'data/carrinho/loadcarrinho.php',
                data: {
					carregacarrinho: 'sim',
                    editprodutocarrinho: '1',
					delprodutocarrinho: delprodutocarrinho,
					combopromocional: '',
					idcarrinho: idcarrinho,
					valorupg: valorupg,
                },
                dataType: 'json',

                success: function (data) {
								if (data.status == 'success') {
									$ ('#tbody').html(data.resposta);
									$('#pedido').modal('show');
									
									
									
									
								} else if (data.status == 'error') {
									alert("Erro no Cadastro!");
								
								}
				}
            });
        
    };
	
	
	
	
				$('#btnCadastrar').click(function() {
       			//var codigoFornecedor = document.getElementsByName('codigo_fornecedor');
				
				var	nomecliente = document.getElementById('nome_cliente').value;
				var apelido = document.getElementById('apelido_cliente').value;
				var	contato = document.getElementById('contato_cliente').value;
				var endereco = document.getElementById('endereco_cliente').value;
				var	bairro = document.getElementById('bairro').value;

            $.ajax({
                method: 'POST',
                timeout: 5000,
                url: 'data/clientes/insertclientes.php',
                data: {
                    inserircliente: 'sim',
					nomecliente: nomecliente,
					apelido: apelido,
					contato: contato,
					endereco: endereco,
                      bairro: bairro,
                  },
                  dataType: 'json',

                  success: function (data) {
                                  if (data.status == 'success') {
                                      
                                      alert("Cliente Cadastrado!");
                                      $('#cadastroCliente').modal('hide');
									  pedido(data.cliente,data.nomecliente,data.apelido,data.session);
                                      document.getElementById('nomecliente').value ="";
                                      document.getElementById('apelido').value="";
                                      document.getElementById('contato').value="";
                                      document.getElementById('endereco').value="";
                                      document.getElementById('bairro').value="";




                                  } else if (data.status == 'error') {
                                      alert("Erro no Cadastro!");

                                  }
                  }
              });
        
    });
	function escondevalores(){}