// FUNÇÃO PARA TRATAR OS ERROS DE DIGITAÇÃO DE LETRAS, NÚMEROS E CARACTÉRES ESPECIAIS NOS CAMPOS (NOME, TELEFONE E CELULAR)
function validarNumero(caracter, blockType, campo){
    if(window.event){ // TRATAMENTO PARA VERIFICAR POR QUAL NAVEGADOR ESTÁ VINDO
        var  letra=caracter.charCode;
    }else{
        // TRANSFORMA EM ASCII, CASO A ENTRADA DE DADOS FOR PELO Internet Explore
        var  letra=caracter.which; // TRANSFORMA EM ASCII, CASO A ENTRADA DE DADOS FOR PELO Firefox ou Google Chrome
    }
    // BLOQUEIO DE NÚMEROS
    if(blockType=="number"){
        if(letra>=48 && letra<=57){ // BLOQUEIO DE NÚMEROS DE 0 - 9
            return false;
        }
        // BLOQUEIO DE CARACTÉRES
    }else if (blockType=="caracter"){
        if(letra<48 || letra>57){
            /* ATIVAR ALGUMAS TECLAS NECESSÁRIAS
            traço"-": 45, espaço: 32, backspace:8 */
            if(letra!=45 && letra !=32 && letra!=8){
                document.getElementById(campo);
                return false;
            }
        }else{
            document.getElementById(campo);
        }
    }
}