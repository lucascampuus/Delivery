function substituiPonto(el) {
    el.value = el.value.replace(",", ".");
}

function valorbatatacombo(valorcombo) {
    var valorcombo = valorcombo.value;
	var valorbatata = (valorcombo - 11);
	//document.getElementById("valorbatata").value = valorbatata.toFixed(2);
}		
function cadastroCombo()
	{
		$('#cadastrocombo').modal('show'); 
	}
	
function cadastroproduto()
	{
		$('#cadastroproduto').modal('show'); 
	}
function qtdbatata(qtd){	
var qtd = qtd.value;
var	tipo_produto = document.getElementById("tipo_produto").value;
		$.ajax({
                method: 'POST',
                timeout: 5000,
                url: 'data/combos/qtdbatata.php',
                data: {
				qtd: qtd,
			    tipo_produto: tipo_produto

                },
                dataType: 'json',

                success: function (data) {
								if (data.status == 'success') {
								$ ('#formqtdbatata').html(data.resposta);							
								} else if (data.status == 'error') {
									alert("Erro no Cadastro!");
								
								}
				}
            });
	
	
}

$('#combosbtn').click(function() {
	 	var nomecombo = document.getElementById("nomecombo").value;
		var valorcombo = document.getElementById("valorcombo").value;	
		var valorbatata = document.getElementById("valorbatata").value;	
		var qtdbatata = document.getElementById("qtd_batata").value;
	   var dia = document.getElementById("dia").value;
		var nomebatata='';
		var i;
				var limite= qtdbatata-1;
				for(i=0;i<qtdbatata;i++)
					{	

						var	batata= document.getElementById('qtdbatata'+i).value;
						//alert(custo);
						nomebatata+=batata;
						if(i < limite)
							{
						nomebatata+='/';
							}						
					}

            $.ajax({
                method: 'POST',
                timeout: 5000,
                url: 'data/combos/insertcombos.php',
                data: {
                    addcombo: '1',
					nomecombo: nomecombo,
					valorcombo: valorcombo,
					valorbatata: valorbatata,
					qtdbatata: qtdbatata,
					nomebatata: nomebatata,
					dia: dia,
                },
                dataType: 'json',

                success: function (data) {
								if (data.status == 'success') {
									alert("Combo - ( " + data.combo + " ) - Cadastrado!!");
									window.location.reload();
									$('#cadastrocombo').modal('hide');
									
								} else if (data.status == 'error') {
									alert("Erro no Pedido!");
								
								}
				}
            });
        
    });
function statuscombo(id,status)
	{
		var idcombo = id;
		var status = status;
		if(status == 'excluir')
		{
	      	var resposta = confirm("Deseja Excluir este Combo?");
		}
		if(status == 'Ativado' || status == 'Desativado'){var resposta=true;}
 
     if (resposta == true) {
		$.ajax({
                method: 'POST',
                timeout: 5000,
                url: 'data/combos/insertcombos.php',
                data: {
					alterarstatus: '1',
					addcombo: '0',
                    status: status,
					idcombo: idcombo,

                },
                dataType: 'json',

                success: function (data) {
								if (data.status == 'success') {
									alert("Combo ( " + data.resposta + " )")
									window.location.reload();
									
									
									
									
								} else if (data.status == 'error') {
									alert("Erro no Cadastro!");
								
								}
				}
            });
	 }
        
    };
	function escondevalores(){}