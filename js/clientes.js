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
									$('#pedidoscliente').modal('show');
																
									
								} else if (data.status == 'error') {
									alert("Sem Pedidos");
								
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
									$('#pedidoscliente').modal('hide');
									$('#consultapedido').modal('show');
									
									
									
								} else if (data.status == 'error') {
									alert("Erro no Cadastro!");
								
								}
				}
            });
        
    };
	
function editarCliente(idcliente, nome, apelido, contato, endereco, bairro)
  {
	$('#edit_id').val(idcliente);
	$('#edit_nome').val(nome);
	$('#edit_apelido').val(apelido);
	$('#edit_contato').val(contato);
	$('#edit_endereco').val(endereco);
	$('select#edit_bairro').val(bairro);
	$('#editarCliente').modal('show');      	  
  }
	
	
	$('#btnEditarCliente').click(function() {
				var	idcliente = document.getElementById('edit_id').value;
				var	nome = document.getElementById('edit_nome').value;
				var apelido = document.getElementById('edit_apelido').value;
				var	contato = document.getElementById('edit_contato').value;
				var endereco = document.getElementById('edit_endereco').value;
				var	bairro = document.getElementById('edit_bairro').value;

            $.ajax({
                method: 'POST',
                timeout: 5000,
                url: 'data/clientes/insertclientes.php',
                data: {
                    editarcliente: '1',
					idcliente: idcliente,
					nome: nome,
					apelido: apelido,
					contato: contato,
					endereco: endereco,
					bairro: bairro,
                },
                dataType: 'json',

                success: function (data) {
								if (data.status == 'success') {
									alert("Cliente ( " + data.cliente + " ) - Editado!");
									$('#editarCliente').modal('hide'); 
									window.location.reload();
									
									
								} else if (data.status == 'error') {
									alert("Erro no Cadastro!");
								
								}
				}
            });
        
    });
	function escondevalores(){}