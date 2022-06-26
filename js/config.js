function delcupom(id)
	{
		var idcupom = id;
	    var resposta = confirm("Deseja Excluir este Cupom?");
     if (resposta == true) {
		$.ajax({
                method: 'POST',
                timeout: 5000,
                url: 'data/cupom/delcupom.php',
                data: {
					delcupom: 'sim',
					idcupom: idcupom,
                },
                dataType: 'json',

                success: function (data) {
								if (data.status == 'success') {
									alert("Cupom ( " + data.cupom + " ) Deletado!!!");
									window.location.reload();
									
									
									
									
								} else if (data.status == 'error') {
									alert("Erro no Cadastro!");
								
								}
				}
            });
	 }
        
    };	

		 function substituiPonto(el){
    el.value = el.value.replace(",", ".");
}
$('#btncadcupom').click(function() {	 
	 		var	cupomid = document.getElementById('cupomid').value;
	   		var clientecupom = document.getElementById('clientecupom').value;
			var valorcupom = document.getElementById('valorcupom').value;
			var validadecupom = document.getElementById('validadecupom').value;
            $.ajax({
                method: 'POST',
                timeout: 5000,
                url: 'data/cupom/cadcupom.php',
                data: {
                    inserircupom: 'sim',
					cupomid: cupomid,
					clientecupom: clientecupom,
					valorcupom: valorcupom,
					validadecupom: validadecupom,
                },
                dataType: 'json',

                success: function (data) {
								if (data.status == 'success') {
									alert("Cupom ( "+data.cupom+" ) - Cadastrado!");
									window.location.reload();
									
								} else if (data.status == 'error') {
									alert("Erro no Pedido!");
								
								}
				}
            });
        
    });	
	
	
	
function cadastroCupom(){$('#cadastrocupom').modal('show');}
$('#cadastrocupom').on('shown.bs.modal', function () {$('#plataforma').focus()})

function platCupom(plat){
var plat = plat.value;
var x=0;	
if(plat == 2)
	{
	x = Math.floor(Math.random() * 999 + 1);
	x = '#ifood'+x;	
	}
	else if(plat == 1)
		{
		x = Math.floor(Math.random() * 99999 + 1);
		x = '#'+x;	
		}
	else 
		{
			x='';
		}


document.getElementById('cupomid').value = x;	
	
}	
$("document").ready(plataforma());	
function plataforma() {
	var mes = '00';
	$.ajax({
         type: 'POST',
         url: 'data/config/plataforma.php',
         cache: false,
         dataType: 'json',
         timeout: 5000,
		  data: {
                    mes: mes,
													
                },
        
         success: function (data) {
								if (data.status == 'success') {
									$ ('#bodymes').html(data.resposta);
									document.getElementById('selectSpan').value = '00';
																
									
								} else if (data.status == 'error') {
									alert("Sem Lançamentos!");
									
									
								
								}
			   }
		 })
	}	
$('#selectSpan').on('change', function() {
	var mes = this.value;
	$.ajax({
         type: 'POST',
         url: 'data/config/plataforma.php',
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
																
									
								} else if (data.status == 'error') {
									alert("Sem Lançamentos!");
									document.getElementById('selectSpan').value = '00';
									plataforma();
									
								
								}
			   }
		 })
	})	
	
	
function status(id,status,x)
	{
		var id = id;
		var status = status;
		var x = x;
		$.ajax({
                method: 'POST',
                timeout: 5000,
                url: 'data/config/statusconfig.php',
                data: {
					x: x,
                    status: status,
					id: id,

                },
                dataType: 'json',

                success: function (data) {
								if (data.status == 'success') {
									alert("( " + data.resposta + " )")
									window.location.reload();
									
									
									
									
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
									$('#consultapedidoifood').modal('hide');
									$('#consultapedido').modal('show');
									
									
									
								} else if (data.status == 'error') {
									alert("Erro no Cadastro!");
								
								}
				}
            });
        
    };
	function btnPedidoCupom(pedido,cliente)
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
									$ ('#tbodycupom').html(data.resposta);
									$('#consultapedidocupom').modal('show');
									
									
									
								} else if (data.status == 'error') {
									alert("Erro no Cadastro!");
								
								}
				}
            });
        
    };
	function btnIfood(x)
	{
		var x = x;

		$.ajax({
                method: 'POST',
                timeout: 5000,
                url: 'data/pedidos/pedidosifood.php',
                data: {
					x: x,
                    consultapedido: 'sim',

					
					
                },
                dataType: 'json',

                success: function (data) {
								if (data.status == 'success') {
									$ ('#tbodyifood').html(data.resposta);
									$('#consultapedidoifood').modal('show');
									
									
									
								} else if (data.status == 'error') {
									alert("Sem Pedidos no Ifood no momento!");
								
								}
				}
            });
        
    };	
	function escondevalores() {

	$("#vplat").prop('hidden',true);
	$("#vifood").prop('hidden',true);	
	$("#vpag").prop('hidden',true);	
	$("#vcupom").prop('hidden',true);	
			}