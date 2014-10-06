/*
*	APLICAÇÃO
*/
var app =
{
	setBg:function(bgId)
	{
		var bgimg = "bg"+bgId+".jpg";
		var bgstring = "#000 URL(public/img/backgrounds/"+bgimg+") no-repeat center 28px";
		$("body").css("background", bgstring);
	},
	loadCss:function(filename,id)
	{
		var elem = '<link rel="stylesheet" type="text/css" href="public/css/'+filename+'.css" id="'+id+'" media="screen" />';
		$("head").append(elem);
	},
	//Imprensa
	imprensa:
	{
		init:function()
		{
			$("#downloadbt").click(function()
			{
				app.imprensa.validaSenha();
			});
		},
		mostra:function()
		{
			$("#senha").val("Senha");
			$(".lightboxImprensa, .optin-box").fadeIn("fast");
		},
		fecha:function()
		{
			$(".lightboxImprensa, .optin-box").fadeOut("fast");
		},
		validaSenha:function()
		{
			var senha = "xexeostuf"; // Trocar aqui
			var zipfile = "http://www.flaviaxexeo.com.br/gallery/imprensa.zip";
			if($("#senha").val() == senha)
			{
				window.open(zipfile);
			}
			else
			{
				$("#senha").animate({opacity:0},200,"linear",function()
				{
  					$(this).animate({opacity:1},200);
				});
			}
		}
	}
};

/*
*	NAVEGAÇÃO
*/
var nav =
{
	init:function()
	{
		$.address.change(function(event)
		{
			nav.goto(event.value);
		});
	},
	goto:function(eValue)
	{
		var href = eValue.replace("/","");
		if(href == "") href = "home";
		$.post(href+".php",'', function(page)
		{
			_gaq.push(['_trackPageview', href]);
			//alert(page);
			if(href == "agenda")
			{ 
				//var elem = '<link rel="stylesheet" type="text/css" href="public/css/carousel.css" id="cssagenda" media="screen" />';
				app.loadCss("carousel","cssagenda");
				$("#cssvideos").remove();
				$("#csssets").remove();
				//$("head").append(elem);
				// alert($("head").html());
				$(".agenda").slideUp("fast");
			}
			else { $(".agenda").show(); }
			if(href == "galeria-videos")
			{
				app.loadCss("carousel-videos","cssvideos");
				$("#cssagenda").remove();
				$("#csssets").remove();
			}
			if(href == "galeria-sets")
			{ 
				app.loadCss("carousel-sets","csssets");
				$("#cssagenda").remove();
				$("#cssvideos").remove();
				// alert(page);
			}
			setTimeout(function(){
				$(".page_container").html(page);
				nav.menu.init();
			},500);
		});
	},
	menu:
	{
		init:function()
		{
			$(".anav").address();
			$(".menuImprensa").unbind("click");
			$(".menuImprensa").click(function(event)
			{
				event.preventDefault();
				app.imprensa.mostra();
			});
		}
	}
};

/*
*	CONTATO
*/

var contato =
{
	init:function()
	{
		contato.ativaEnvio();
		$("#limpar_form").click(function(){ contato.clear(); });
	},
	ativaEnvio:function()
	{
		$("#enviar_form").unbind("click");
		$("#enviar_form").click(function(event)
		{
			event.preventDefault();
			contato.valida();
		});
	},
	desativaEnvio:function()
	{
		$("#enviar_form").unbind("click");
		$("#enviar_form").click(function(event)
		{
			event.preventDefault();
			void(0);
		});
	},
	valida:function()
	{
		contato.desativaEnvio();
			
		var _nome = $("#nome").val();
		var _email = $("#email").val();
		var _mensagem = $("#mensagem").val();
		var _ddd = $("#ddd").val();
		var _telefone = $("#telefone").val();
		
		var erro = '';
		var first = true;
		// Nome
		if(_nome == "" || _nome == "Nome*")
		{
			if(first) { erro += "Informe corretamente: "; first = false; erro += "nome"}
		}
		// E-mail
		if(uteis.validaEmail(_email) == false)
		{
			if(first) { erro += "Informe corretamente: "; first = false; erro += "e-mail"}
			else { erro += ", e-mail"}
		}
		// Mensagem
		if(_mensagem == "" || _mensagem == "Mensagem*")
		{
			if(first) { erro += "Informe corretamente: "; first = false; erro += "mensagem"}
			else { erro += ", mensagem"}
		}
		
		if(erro != "")
		{
			if(first == false) {erro += "."};
			$(".msg").html(erro).slideDown("fast");
			contato.ativaEnvio();
		}
		else
		{
			$(".msg").html("Enviando, aguarde.").slideDown("fast");
			$.post("envia_contato.php",{nome:_nome,email:_email,mensagem:_mensagem,ddd:_ddd,telefone:_telefone},function(response)
			{
				if(response == "ok")
				{
					contato.clear();
					$(".msg").html("Enviado com sucesso.").fadeIn("fast");
					contato.ativaEnvio();
				}
				else
				{
					$(".msg").html("Erro no envio.");
					contato.ativaEnvio();
				}
			});
		}
	},
	clear:function()
	{
		$("#nome").val('Nome*');
		$("#email").val('E-mail*');
		$("#ddd").val('DDD');
		$("#telefone").val('Telefone');
		$("#mensagem").val('Mensagem*');
		$(".msg").html('').hide();
	}
};

$(document).ready(function()
{
	$('marquee').marquee('agenda-marquee');
	app.imprensa.init();
	nav.init();
});