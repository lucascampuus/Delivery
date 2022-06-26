function selectmaterial(x)
{
if(x=='peso')
{
	$("#vp1").removeAttr('hidden');
	$("#vp2").removeAttr('hidden');
	$("#vp5").removeAttr('hidden');
	$("#vp3").prop("hidden", true);
	$("#vp4").prop("hidden", true);
	$("#vp6").prop("hidden", true);
}
else
{
	$("#vp3").removeAttr('hidden');
	$("#vp4").removeAttr('hidden');
	$("#vp6").removeAttr('hidden');
	$("#vp1").prop("hidden", true);
	$("#vp2").prop("hidden", true);
	$("#vp5").prop("hidden", true);
}
}
function substituiPonto(el) {
    el.value = el.value.replace(",", ".");
	valorunidadepeso(el);
}
function substituiPonto3(el) {
    el.value = el.value.replace(",", ".");
}
function valorunidadepeso(el) {
	var valorpesound = document.getElementById('valorpesound').value;
	var valor =  el.value / valorpesound;
	document.getElementById('qtdpesound').value = valor.toFixed(3);   
}

function substituiPonto2(el) {
    el.value = el.value.replace(",", ".");
	valorpesound(el);
}
function valorpesound() {
	var qtdpesound2 = document.getElementById('qtdpesound2').value;
	var valorpesound2 = document.getElementById('valorpesound2').value;
	var valor =  valorpesound2 * qtdpesound2;
	document.getElementById('valorcompra2').value = valor.toFixed(2);   
}

function fornecedor(idmaterial)
	{
		var idmaterial = idmaterial.value;
		$.ajax({
                method: 'POST',
                timeout: 5000,
                url: 'data/compras/qtdfornecedor.php',
                data: {
					idmaterial: idmaterial,
					qtdfornecedor: 0,
					consultamaterial: 1,

                },
                dataType: 'json',

                success: function (data) {
								if (data.status == 'success') {
									$("#form_produtos").removeAttr('hidden');
									$ ('#bodymateriais').html(data.resposta);
									document.getElementById('desc').value = data.material;
									selectmaterial(data.material);
									
									
									
									
									
								} else if (data.status == 'error') {
									$("#form_produtos").prop('hidden',true);
								
								}
				}
            });
        
    };	
	
	function qtdfornecedor(qtd){	
var qtd = qtd.value;
		$.ajax({
                method: 'POST',
                timeout: 5000,
                url: 'data/compras/qtdfornecedor.php',
                data: {
				qtd: qtd,
				qtdfornecedor: 1,
				consultamaterial: 0,	

                },
                dataType: 'json',

                success: function (data) {
								if (data.status == 'success') {
								$ ('#formqtdfornecedor').html(data.resposta);							
								} else if (data.status == 'error') {
									alert("Erro no Cadastro!");
								
								}
				}
            });
	
	
}
	
	
	
	function addcompras(){
	$('#cadastrocompras').modal('show');}
	$('#cadastrocompras').on('shown.bs.modal', function () {
	$('#material').focus()
})
	function addfornecedor(){
	$('#cadastrofornecedor').modal('show');}
	function addmaterial(){
	$('#cadastromaterial').modal('show');}
	
	
	
$('#btnCompras').click(function() {	
				var	radio1 = document.getElementById('desc').value;
				if(radio1=='peso')
				{					
				var	material = document.getElementById('material').value;
				var valorcompra = document.getElementById('valorcompra').value;
				var datacompra = document.getElementById('datacompra').value;
				var undpeso = document.getElementById('qtdpesound').value;
				var valorundpeso = document.getElementById('valorpesound').value;
				var fornecedor = document.getElementById('fornecedor').value;
				}
				else
				{
			    var	material = document.getElementById('material').value;
				var valorcompra = document.getElementById('valorcompra2').value;
				var datacompra = document.getElementById('datacompra').value;
				var undpeso = document.getElementById('qtdpesound2').value;
				var valorundpeso = document.getElementById('valorpesound2').value;
				var fornecedor = document.getElementById('fornecedor').value;
				}

            $.ajax({
                method: 'POST',
                timeout: 5000,
                url: 'data/compras/insertcompras.php',
                data: {
                    inserircompra: 'sim',
					material: material,
					fornecedor: fornecedor,
					valorcompra: valorcompra,
					datacompra: datacompra,
					undpeso: undpeso,
					valorundpeso: valorundpeso,
                },
                dataType: 'json',

                success: function (data) {
								if (data.status == 'success') {
									window.location.reload();
								} else if (data.status == 'error') {
									alert("Erro no Cadastro!");	}
				}
            });
        });
$('#btnCadastroMaterial').click(function() {		
				var	nomematerial = document.getElementById('nome_material').value;
				var tipomaterial = document.getElementById('tipo_material').value;
				var desc = document.getElementById('desc_material').value;
				var qtdfornecedor = document.getElementById("qtd_fornecedor").value;
				var nomefornecedor='';
				var i;
				var limite= qtdfornecedor-1;
				for(i=0;i<qtdfornecedor;i++)
					{	

						var	fornecedor= document.getElementById('qtdfornecedor'+i).value;
						//alert(custo);
						nomefornecedor+=fornecedor;
						if(i < limite)
							{
						nomefornecedor+='/';
							}						
					}	

            $.ajax({
                method: 'POST',
                timeout: 5000,
                url: 'data/compras/insertmaterial.php',
                data: {
                    inserirmaterial: 'sim',
					nomematerial: nomematerial,
					tipomaterial: tipomaterial,
					desc: desc,
					nomefornecedor: nomefornecedor,
                },
                dataType: 'json',

                success: function (data) {
								if (data.status == 'success') {
									$('#cadastromaterial').modal('hide');
									document.getElementById('nome_material').value = '';
									document.getElementById('tipo_material').value = '';
									document.getElementById('desc_material').value = '';
									alert("Material - ( " + data.material + " ) - Cadastrado!!");
									window.location.reload();
								} else if (data.status == 'error') {
									alert("Erro no Cadastro!");	}
				}
            });
        });	
$('#btnCadastroFornecedor').click(function() {		
				var	nomefornecedor = document.getElementById('nome_fornecedor').value;
				var contato = document.getElementById('contato_fornecedor').value;

            $.ajax({
                method: 'POST',
                timeout: 5000,
                url: 'data/compras/insertfornecedor.php',
                data: {
                    inserirfornecedor: 'sim',
					nomefornecedor: nomefornecedor,
					contato: contato,
                },
                dataType: 'json',

                success: function (data) {
								if (data.status == 'success') {
									window.location.reload();
									$('#cadastrofornecedor').modal('hide');
									document.getElementById('nome_fornecedor').value = '';
									document.getElementById('contato_fornecedor').value = '';
									
									
								} else if (data.status == 'error') {
									alert("Erro no Cadastro!");	}
				}
            });
        });
		function escondevalores(){}