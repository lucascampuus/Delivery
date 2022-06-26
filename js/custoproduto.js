function substituiPonto(el) {
    el.value = el.value.replace(",", ".");
}
function customaterial(qtd) {
    var valormedio = document.getElementById("valormedio_material").value;
	var customedio = (valormedio * qtd.value);
	document.getElementById("custo_material").value = customedio.toFixed(2);
}	
	
function cadastrocusto()
	{
		$('#cadastrocusto').modal('show'); 
	}
	
function material(idmaterial){	
var idmaterial = idmaterial.value;
		$.ajax({
                method: 'POST',
                timeout: 5000,
                url: 'data/custo/insertcustoproduto.php',
                data: {
					idmaterial: idmaterial,
					consultamaterial: '1',
					addcusto: '0',
					alterarstatus: '0',

                },
                dataType: 'json',

                success: function (data) {
								if (data.status == 'success') {
									$("#form_tipo_material").removeAttr('hidden');
									$("#form_valormedio_material").removeAttr('hidden');
									$("#form_qtd_material").removeAttr('hidden');
									$("#form_custo_material").removeAttr('hidden');
									document.getElementById("valormedio_material").value = data.valormedio;
									document.getElementById("tipo_material").value = data.desc;
									
									
									
									
									
								} else if (data.status == 'error') {
									alert("Erro no Cadastro!");
								
								}
				}
            });
	
	
}
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
								alert("Custo Atualizado com Sucesso!!! ");
								window.location.reload();	
									
									
									
									
									
								} else if (data.status == 'error') {
									alert("Erro no Cadastro!");
								
								}
				}
            });
	
	
}

$('#custosbtn').click(function() {
		var material = document.getElementById("material_idmaterial").value;	
		var qtdmaterial = document.getElementById("qtd_material").value;	
		var customaterial = document.getElementById("custo_material").value;
		var tipomaterial = document.getElementById("tipo_material").value;
		var nomecusto = document.getElementById("nome_custo").value;	
            $.ajax({
                method: 'POST',
                timeout: 5000,
                url: 'data/custo/insertcustoproduto.php',
                data: {
                    addcusto: '1',
					material: material,
					qtdmaterial: qtdmaterial,
					customaterial: customaterial,
					tipomaterial: tipomaterial,
					consultamaterial: '0',
					alterarstatus: '0',
					nomecusto: nomecusto,
                },
                dataType: 'json',

                success: function (data) {
								if (data.status == 'success') {
									alert("Custo Cadastrado!!");
									window.location.reload();
									$('#cadastrocusto').modal('hide');
									
								} else if (data.status == 'error') {
									alert("Erro no Pedido!");
								
								}
				}
            });
        
    });
function statuscusto(id,status)
	{
		var idcusto = id;
		var status = status;
		$.ajax({
                method: 'POST',
                timeout: 5000,
                url: 'data/custo/insertcustoproduto.php',
                data: {
					alterarstatus: '1',
					addcusto: '0',
                    status: status,
					idcusto: idcusto,

                },
                dataType: 'json',

                success: function (data) {
								if (data.status == 'success') {
									alert("custo ( " + data.resposta + " )")
									window.location.reload();
									
									
									
									
								} else if (data.status == 'error') {
									alert("Erro no Cadastro!");
								
								}
				}
            });
        
    };
	function escondevalores(){}	