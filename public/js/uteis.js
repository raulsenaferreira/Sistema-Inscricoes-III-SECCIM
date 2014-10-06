var uteis =
{
	// VALIDAÇÃO DE DATA COMPLETA
	validaData:function(dia,mes,ano)
	{
		var erro = "";
		if(dia == '' || mes == '' || ano == '') erro = true;
        // verifica o dia valido para cada mes 
        if ((dia < 01)||(dia < 01 || dia > 30) && (  mes == 04 || mes == 06 || mes == 9 || mes == 11 ) || dia > 31) { 
        	erro = true; 
        }
        // verifica se o mes e valido 
        if (mes < 01 || mes > 12 ) { 
        	erro = true; 
        }
		// verifica se e ano bissexto 
        if (mes == 2 && ( dia < 01 || dia > 29 || ( dia > 28 && (parseInt(ano / 4) != ano / 4)))) { 
            erro = true; 
        }
		if(erro == true){ return false;}
		else { return true;}
	},
	// VALIDAÇÃO DE CPF - retorna true se for válido
	validaCPF:function(cpf)
	{
    	cpf = cpf.toString();
		cpf = cpf.replace(/\./g,'');
		cpf = cpf.replace('-','');
		
		erro = new String;
		if (cpf.length < 11) erro += "Sao necessarios 11 digitos para verificacao do CPF! \n\n";
		var nonNumbers = /\D/;
		if (nonNumbers.test(cpf)) erro += "A verificacao de CPF suporta apenas numeros! \n\n";
		if (cpf == "00000000000" || cpf == "11111111111" || cpf == "22222222222" || cpf == "33333333333" || cpf == "44444444444" || cpf == "55555555555" || cpf == "66666666666" || cpf == "77777777777" || cpf == "88888888888" || cpf == "99999999999")
		{
			erro += "Numero de CPF invalido!"
		}
		var a = [];
		var b = new Number;
		var c = 11;
		for (i=0; i<11; i++){
			a[i] = cpf.charAt(i);
			if (i < 9) b += (a[i] * --c);
		}
		if ((x = b % 11) < 2) { a[9] = 0 } else { a[9] = 11-x }
		b = 0;
		c = 11;
		for (y=0; y<10; y++) b += (a[y] * c--);
		if ((x = b % 11) < 2) { a[10] = 0; } else { a[10] = 11-x; }
		if ((cpf.charAt(9) != a[9]) || (cpf.charAt(10) != a[10])){
			erro +="Digito verificador com problema!";
		}
		if (erro.length > 0){
			return false;
		}
		return true;
	},
	// VALIDAÇÃO DE EMAIL
	validaEmail:function(email)
	{
		if(email == '' || email <6 || email.indexOf('@') == "-1" || email.indexOf('.') == "-1")
		{
			return false;
		}
		else {return true}
	}

};