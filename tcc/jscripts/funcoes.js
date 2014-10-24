/*
 * Autor : Altieris Marcelino Peixoto
 * Data : 10/07/2010 16:46
 * 
 */

//FUNCAO DE VALIDACAO DO LOGIN

function validaLogin(){
		
    var username = $('#user').val();
    var password = $('#password').val();
			
    if(username != "" && password != ""){
        return true;
    }
    if(username == "" && password == ""){
        $('#alert_user').show().html('Preencha o campo de usuario');
        $('#alert_user_pas').show().html('Preencha o campo de senha');
        return false;
    }
    if(username != ""){
                
        $('#alert_user').hide();
    }
    if(password != ""){
        $('#alert_user_pas').hide();
    }
    if(username == ""){
        $('#alert_user').show().html('Preencha o campo de usuario');
        return false;
    }
    if(password == ""){
        $('#alert_user_pas').show().html('Preencha o campo de senha');
        return false;
			
    }
    return true;
}
//-----------------------------------------------------------------------------------------------------------------------------

//FUNCAO PARA CADASTRO DE AREA MEDICA

function cadastraAreaMedica(){
    var area_medica = $('#area_medica').val();
	
    $("#dialog_area_medica").dialog({
        bgiframe: true,
        modal: true,
        buttons: {
            Ok: function() {
                $(this).dialog('close');
            }
        }
    });
 
    $.post("../app.control/cadastro_area_medica.php", {
        'area_medica': area_medica
    }, function(data) {
	
        $("#dialog_area_medica p").html(data);
        $("#dialog_area_medica").dialog("open");
    });
		
    return false;
}

//FUNCAO DE CADASTRO DE SUB AREA MEDICA

function cadastraSubArea(){
	
    var id_area_medica = $('#select_area_medica').val();
    var sub_area_medica = $('#sub_area_medica').val();
	 
    $("#dialog_sub_area").dialog({
        bgiframe: true,
        modal: true,
        buttons: {
            Ok: function() {
                $(this).dialog('close');
            }
        }
    });
 
    $.post("../app.control/cadastro_sub_area_medica.php", {
        'sub_area': sub_area_medica,
        'id_area_medica':id_area_medica
    }, function(data) {
        $("#dialog_sub_area p").html(data);
        $("#dialog_sub_area").dialog("open");
    });
  
    return false;
}

//FUNCAO DE CADASTRO DE PATOLOGIAS

function cadastraPatologia(){
	
    var id_subarea_medica = $('#select_subarea').val();
    var patologia = $('#patologia').val();
	 
    $("#dialog_patologia").dialog({
        bgiframe: true,
        modal: true,
        buttons: {
            Ok: function() {
                $(this).dialog('close');
            }
        }
    });
 
    $.post("../app.control/cadastro_patologia.php", {
        'patologia': patologia,
        'id_subarea':id_subarea_medica,
        'id_area_medica':1
    }, function(data) {
        $("#dialog_patologia p").html(data);
        $("#dialog_patologia").dialog("open");
    });
  
    return false;
}

//FUNCAO DE TROCA DE SENHA
function trocaSenha(){
    $("#dialog_troca_senha p").empty();
        
    var username = $("#username").val();
    var senha = $("#senha").val();
    var nova_senha =$('#nova_senha').val();
    var nova_senha2 =$("#nova_senha2").val();


 
    $("#dialog_troca_senha").dialog({
        bgiframe: true,
        modal: true,
        buttons: {
            Ok: function() {
                $(this).dialog('close');
            }
        }
    });
    
    $('#btn_tr_senha').click(function(){
    
        $.post("../app.control/altera_senha.php", {
            'username':username,
            'senha':senha,
            'nova_senha':nova_senha,
            'nova_senha2':nova_senha2
        }, function(data) {
            
            $("#dialog_troca_senha p").html(data);
            $("#dialog_troca_senha").dialog("open");
        });
 
        return false;
    });
    return false;
}


//abre textarea diagnostico
function abreTextareaDiagnostico(){
    $('#diagnostico').show('slow');
    $(this).attr({
        src: "../images/menos.png"
    });
     
}

//fecha textarea diagnostico
function fechaTextareaDiagnostico(){
    $('#diagnostico').hide('slow');
    $(this).attr({
        src: "../images/mais.png"
    });

}

//abre textarea observacoes
function abreTextareaObs(){
    $('#obs').show('slow');
    $(this).attr({
        src: "../images/menos.png"
    });

}

// fecha textarea observacoes
function fechaTextareaObs(){
    $('#obs').hide('slow');
    $(this).attr({
        src: "../images/mais.png"
    });
}

function desativaUsuario(){

    $('.btn_upload').click(
   
        function(){
            var userstatus = "status"+this.id;
            //se usuario ativo
            if($(this).text()== "Desativar"){
                $("#usuario").dialog({
                    bgiframe: true,
                    modal: true,
                    buttons: {
                        Ok: function() {
                            $(this).dialog('close');
                        }
                    }
                });
                $.post("../app.control/desativa_usuario.php", {
                    'username':this.id
                }, function(data) {
                    $("#usuario p").html(data);
                    $("#usuario").dialog("open");
                     
                });
                $(this).css('color','green').text("Ativar");
                $('#'+userstatus).css('color','red').text("Inativo");
            }
            // se usuario inativo  entao
            else{
                $("#usuario").dialog({
                    bgiframe: true,
                    modal: true,
                    buttons: {
                        Ok: function() {
                            $(this).dialog('close');
                        }
                    }
                });
                $.post("../app.control/ativa_usuario.php", {
                    'username':this.id
                }, function(data) {
                    $("#usuario p").html(data);
                    $("#usuario").dialog("open");
                    
                });
                $(this).css('color','#666').text("Desativar");
                $('#'+userstatus).css('color','green').text("Ativo");
            }

        });
    return false;
}


function ativa_textareas(){

    $('#patologia').removeAttr('disabled');
    $('#diag').removeAttr('disabled');
    $('#comp').removeAttr('disabled');
    $('#cat').removeAttr('disabled');
    $('#diag').focus();
    $('#obser').removeAttr('disabled');
    $(this).text('Enviar dados Alterados');
}

function enviaDadosAlterados(){
    
    $("#dialog_imagem p").empty();
    var id=$('#idimagem').val();
    var diagnostico = $('#diag').val();
    var observacao = $('#obser').val();
    var patologia = $('#patologia').val();
    var composicao = $('#comp').val();
    var categoria = $('#cat').val();

    if(patologia != -1){

        if(patologia == 1){ // se patologia igual a 1 entao imagem e Bi-Rads
            //testar para ver se os dados de entrada sao validos
       
            if(categoria == -1 || categoria == '' || composicao == -1 || composicao == ''){
           
                $("#dialog_imagem").dialog({
                    bgiframe: true,
                    modal: true,
                    buttons: {
                        Ok: function() {
                            $(this).dialog('close');
                        }
                    }
                });
                $("#dialog_imagem p").text('Por favor preencha os dados de categoria e composicao da imagem corretamente.');
                $("#dialog_imagem").dialog("open");
                return false;
            }
        }
        else{ //senao entao a imagem nao e Bi-Rads portanto nao tem categoria e nao tem composicao
            categoria = '';
            composicao = '';
        }
        if($('#edit').text('Enviar dados Alterados')){

            $('#cat').attr('disabled','disabled');
            $('#comp').attr('disabled','disabled');
            $('#diag').attr('disabled','disabled');
            $('#obser').attr('disabled','disabled');
            $('#patologia').attr('disabled','disabled');
            $(this).text('Editar dados da imagem');
   
            $("#dialog_imagem").dialog({
                bgiframe: true,
                modal: true,
                buttons: {
                    Ok: function() {
                        $(this).dialog('close');
                    }
                }
            });
   
            //metodo para atualizar o diagnostico, observacoes e patologia da imagem
            $.post("../app.control/atualiza_imagem.php", {
                'id_imagem': id,
                'id_patologia':patologia,
                'composicao':composicao,
                'categoria':categoria,
                'diagnostico':diagnostico,
                'observacao':observacao
            }, function(data) {
        
                $("#dialog_imagem p").html(data);
                $("#dialog_imagem").dialog("open");
            });
            return false;
        }
        return false;
    }
    //se nao selecionou a patologia
    else{
        $("#dialog_imagem").dialog({
            bgiframe: true,
            modal: true,
            buttons: {
                Ok: function() {
                    $(this).dialog('close');
                }
            }
        });
        $("#dialog_imagem p").text('Por favor selecione a patologia relacionada com a imagem!');
        $("#dialog_imagem").dialog("open");
    }
    return false;
}

function validaDados(){
    
    var patologia;
    var categoria;
    var composicao;
    var dt_inicio;
    var dt_fim;

    $('#btn_upload').click(function(){

        patologia = $('#patologia').val();
        categoria = $('#cat').val();
        composicao = $('#comp').val();
        dt_inicio = $('#dt_inicio').val();
        dt_fim = $('#dt_fim').val();

  
        //data de inicio <= data de fim
       
        if(patologia != -1){

            if(dt_inicio > dt_fim){

                $("#dialog_visualizador").dialog({
                    bgiframe: true,
                    modal: true,
                    buttons: {
                        Ok: function() {
                            $(this).dialog('close');
                        }
                    }
                });
                $("#dialog_visualizador p").text('O campo de data de inicio deve possuir uma data anterior a data final.');
                $("#dialog_visualizador").dialog("open");
                return false;

            }
            else if($('#dt_inicio').val() == 0 || $('#dt_fim').val()== 0){

                $("#dialog_visualizador").dialog({
                    bgiframe: true,
                    modal: true,
                    buttons: {
                        Ok: function() {
                            $(this).dialog('close');
                        }
                    }
                });
                $("#dialog_visualizador p").text('Por favor,preencha os campos de data de inicio e data de final corretamente.');
                $("#dialog_visualizador").dialog("open");
                return false;
            }
            //TODO : verificar se o digitado e uma data
            else{

                if(patologia == 1){
                    if(composicao == -1 || composicao == '' || categoria == -1 || categoria ==''){
                    
                        $("#dialog_visualizador").dialog({
                            bgiframe: true,
                            modal: true,
                            buttons: {
                                Ok: function() {
                                    $(this).dialog('close');
                                }
                            }
                        });
                        $("#dialog_visualizador p").text('Por favor preencha os dados de categoria e composicao da imagem corretamente.');
                        $("#dialog_visualizador").dialog("open");
                        return false;
                    }
                    else{
                        return true;
                    }
                }

                return true;
            }
        }
        else{
            $("#dialog_visualizador").dialog({
                bgiframe: true,
                modal: true,
                buttons: {
                    Ok: function() {
                        $(this).dialog('close');
                    }
                }
            });
            $("#dialog_visualizador p").text('Por favor selecione a patologia corretamente.');
            $("#dialog_visualizador").dialog("open");
            return false;
        }
    });
    return true;
}