function substituiPonto(el) {
    el.value = el.value.replace(",", ".");
}	
function cadastroproduto()
	{
		$('#cadastroproduto').modal('show'); 
	}
function statusproduto(id,status)
	{
		var idproduto = id;
		var status = status;
		$.ajax({
                method: 'POST',
                timeout: 5000,
                url: 'data/produtos/insertproduto.php',
                data: {
					alterarstatus: '1',
					addproduto: '0',
                    status: status,
					idproduto: idproduto,

                },
                dataType: 'json',

                success: function (data) {
								if (data.status == 'success') {
									alert("Produto ( " + data.resposta + " )")
									window.location.reload();
									
									
									
									
								} else if (data.status == 'error') {
									alert("Erro no Cadastro!");
								
								}
				}
            });
        
    };		
function qtdcusto(qtd){	
var qtd = qtd.value;
	if(qtd > 0)
		{
		$.ajax({
                method: 'POST',
                timeout: 5000,
                url: 'data/produtos/qtdcusto.php',
                data: {
					qtd: qtd,

                },
                dataType: 'json',

                success: function (data) {
								if (data.status == 'success') {
								$ ('#formcusto').html(data.resposta);
								} else if (data.status == 'error') {
									alert("Erro no Cadastro!");
								
								}
				}
            });
	
		}
}
function eqtdcusto(qtd){	
var qtd = qtd.value;
	if(qtd > 0)
		{
		$.ajax({
                method: 'POST',
                timeout: 5000,
                url: 'data/produtos/eqtdcusto.php',
                data: {
					qtd: qtd,

                },
                dataType: 'json',

                success: function (data) {
								if (data.status == 'success') {
								$ ('#eformcusto').html(data.resposta);	
								} else if (data.status == 'error') {
									alert("Erro no Cadastro!");
								
								}
				}
            });
	
		}
}	
	
function editarproduto(idproduto)
  {
	var idproduto = idproduto;
	$('#editarproduto').modal('show');
	  //alert(idproduto);
	  $.ajax({
                method: 'POST',
                timeout: 5000,
                url: 'data/produtos/mostrarproduto.php',
                data: {
					mostrar: '1',
					editarprodutos: '0',
					idproduto: idproduto

                },
                dataType: 'json',

                success: function (data) {
								if (data.status == 'success') {
									document.getElementById('enome_produto').value = data.nome_produto;
									document.getElementById('etipo_produto').value = data.tipo_produto;
									document.getElementById('evalor_produto').value = data.valor_produto;
									document.getElementById('eidproduto').value = data.id_produto;
															
								} else if (data.status == 'error') {
									alert("Erro no Cadastro!");
								
								}
				}
            });
  }
	
	
	$('#btnCadastrarProduto').click(function() {
				var	nome_produto = document.getElementById('nome_produto').value;
				var	tipo_produto = document.getElementById('tipo_produto').value;
				var valor_produto = document.getElementById('valor_produto').value;
				var	qtdcusto = document.getElementById('qtd_custo').value;
				
				var nomecusto='';
				var limite= qtdcusto-1;
				for(i=0;i<qtdcusto;i++)
					{	

						var	custo= document.getElementById('custo_idcusto'+i).value;
						//alert(custo);
						nomecusto+=custo;
						if(i < limite)
							{
						nomecusto+='/';
							}						
					}

            $.ajax({
                method: 'POST',
                timeout: 5000,
                url: 'data/produtos/insertproduto.php',
                data: {
                    nome_produto: nome_produto,
					tipo_produto: tipo_produto,
					valor_produto: valor_produto,
					nomecusto: nomecusto,
					addproduto: '1',
					alterarstatus: '0',

                },
                dataType: 'json',

                success: function (data) {
								if (data.status == 'success') {
									alert("Produto ( " + data.produto + " ) - Cadastrado!");
									$('#editarprodutos').modal('hide'); 
									window.location.reload();
									
									
								} else if (data.status == 'error') {
									alert("Erro no Cadastro!");
								
								}
				}
            });
        
    });
	$('#btnEditarProduto').click(function() {
				var	nome_produto = document.getElementById('enome_produto').value;
				var	tipo_produto = document.getElementById('etipo_produto').value;
				var valor_produto = document.getElementById('evalor_produto').value;
				var	eqtdcusto = document.getElementById('eqtd_custo').value;
		        var	idproduto = document.getElementById('eidproduto').value;
		        
				
				var nomecusto='';
				var limite= eqtdcusto-1;
				for(i=0;i<eqtdcusto;i++)
					{	

						var	custo= document.getElementById('ecusto_idcusto'+i).value;
						//alert(custo);
						nomecusto+=custo;
						if(i < limite)
							{
						nomecusto+='/';
							}						
					}

            $.ajax({
                method: 'POST',
                timeout: 5000,
                url: 'data/produtos/editarproduto.php',
                data: {
					idproduto: idproduto,
                    nome_produto: nome_produto,
					tipo_produto: tipo_produto,
					valor_produto: valor_produto,
					nomecusto: nomecusto,
					editarprodutos: '1',
					mostrar: '0'

                },
                dataType: 'json',

                success: function (data) {
								if (data.status == 'success') {
									alert("Produto ( " + data.produto + " ) - Atualizado!");
									$('#editarproduto').modal('hide'); 
									//window.location.reload();
									
									
								} else if (data.status == 'error') {
									alert("Erro Ao Editar Cadastro!");
								
								}
				}
            });
        
    });	
	function escondevalores(){}