<?php
include '../includes/valida_sessao.inc';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="BR" lang="PT-BR">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <meta http-equiv="pragma" content="no-cache"/>
        <meta HTTP-EQUIV="imagetoolbar" CONTENT="no"/>
        <title>:::: Cadastro de Usu&aacute;rio ::::</title>
        <link type="text/css" href="../css/style.css" rel="stylesheet" />
        <link type="text/css" href="../css/menu.css" rel="stylesheet" />
        <script type="text/javascript" src="../jscripts/jquery/jquery-1.3.2.js"></script>
        <script type="text/javascript" src="../jscripts/menu.js"></script>
        <script type="text/javascript" src="../jscripts/jquery/ui.core.js"></script>
        <script type="text/javascript" src="../jscripts/jquery/ui.tabs.js"></script>
        <script type="text/javascript" src="../jscripts/funcoes.js"></script>
        <script type="text/javascript" src="../jscripts/jquery/ui.draggable.js"></script>
        <script type="text/javascript" src="../jscripts/jquery/ui.resizable.js"></script>
        <script type="text/javascript" src="../jscripts/jquery/ui.dialog.js"></script>
        <script type="text/javascript" src="../jscripts/jquery/jquery.bgiframe.js"></script>
        <link type="text/css" href="../css/jquery/demos.css" rel="stylesheet" />
        <link type="text/css" href="../css/jquery/ui.all.css" rel="stylesheet" />
        <script type="text/javascript">
            $(function() {
                $("#tabs").tabs();
            });
        </script>
        <script type="text/javascript">
            $(document).ready(areaMedica);
         
            //funcao que mostra a area medica para o cadastro de usuarios medicos
            function areaMedica(){
              
                $('.radio').click(
                function(){
                    if($(this).is(':checked') && $(this).val()==2)
                    {
                        $('#area_medica').show();  
                    }
                    else{
                        $('#area_medica').hide();
                    }   
                });
            }
                 
            $(function() {

                var nome = $("#nome"),
                email = $("#email"),
                username = $("#username"),
                senha = $("#senha"),
                allFields = $([]).add(nome).add(email).add(username).add(senha),
                tips = $("#validateTips");

                function updateTips(t,o) {
                    o.next('span').remove();
                    o.after('<span id="error">'+t+'</span>');
                }

                function checkLength(o,n,min,max) {

                    if ( o.val().length > max || o.val().length < min ) {
                        o.addClass('ui-state-error');
                        updateTips("Tamanho do  " + n + " deve ser entre "+min+" e "+max+" caracteres.",o);
                        
                        return false;
                    } else {
                        o.next('span').remove();
                        return true;
                    }
                }

                function checkRegexp(o,regexp,n) {

                    if (!( regexp.test( o.val() ) ) ) {
                        o.addClass('ui-state-error');
                        updateTips(n,o);
                        return false;
                    } else {
                        o.next('span').remove();
                        return true;
                    }
                }
                
                //FUNCAO DE CADASTRO DE USUARIO
                function cadastraUsuario2() {
                    var bValid = true;
                    allFields.removeClass('ui-state-error');

                    bValid = bValid && checkLength(nome,"nome",10,50);
                    bValid = bValid && checkLength(email,"email",6,80);
                    bValid = bValid && checkLength(username,"username",3,15);
                    bValid = bValid && checkLength(senha,"senha",5,16);
                            
                    bValid = bValid && checkRegexp(nome,/^[a-z]([a-z])/i,"O nome deve ser constituido somente de letras.");
                    
                    bValid = bValid && checkRegexp(email,/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i,"Email invalido.");
                    bValid = bValid && checkRegexp(username,/^[a-z]([0-9a-z_])+$/i,"O nome de usuario pode conter letras de a-z, numeros de  0-9, Underlines, e deve iniciar com uma letra.");
                    bValid = bValid && checkRegexp(senha,/^([0-9a-zA-Z])+$/,"O campo de senha tem que ser composto somente de letras e numeros.");

                    if (bValid) {
                        
                        $("#dialog_usuario").dialog({
                            bgiframe: true,
                            modal: true,
                            buttons: {
                                Ok: function() {
                                    $(this).dialog('close');
                                }
                            }
                        });
                        
                        $.post("../app.control/cadastro_usuario.php", {
                            'nome': $('#nome').val(),
                            'email':$('#email').val(),
                            'username':$('#username').val(),
                            'senha':$('#senha').val(),
                            'nv_acess':$(':checked').val(),
                            'area_medica':$('#select_area_medica').val()
                        },
                        function(data) {
                            $("#dialog_usuario p").html(data);
                            $("#dialog_usuario").dialog("open");
                            
                        });

                        return false;
                    }
                    return false;
                    
                }

                $('#btn_upload').click(function() {
                    cadastraUsuario2();
                    return false;
                });
                return false;
            });
            
        </script>
    </head>
    <body oncontextmenu="return false" ondragstart="return false" onselectstart="return false">
        <div id="wrap">
            <div id="header"> <a href="../app.control/logout.php" id="linkexit">Logout<img src="../images/door_open.png" alt="" id="iconexit"></img></a>
                <div id="menux">
                    <?php
                    include '../includes/menu.inc';
                    ?>
                </div>
                <br/>
                <br/>
                <div id="postheader"> <a href="inicio.php" id="linkmap" >Home &gt;&gt;</a> <a id="linkmap" >Cadastro de Usu&aacute;rios &gt;&gt;</a> </div>
            </div>
            <div id="content" style="background-image:none;" > <br/>
                <div id="container">
                    <div id="tabs">
                        <ul>
                            <li><a href="#tabs-1">Cadastro de Usu&aacute;rios</a></li>
                            <p id="validateTips"></p>
                        </ul>
                        <!-- TAB 1 -->
                        <div id="tabs-1">
                            <div class="mudar">
                                <form action="../app.control/cadastro_usuario.php" method="post">

                                    <label id="label1" for="nome">Nome Completo:</label>
                                    <input type="text" maxlength="60" name="nome" id="nome" class=" textfield text ui-widget-content ui-corner-all" style="width: 300px" />
                                    <br/>
                                    <br/>
                                    <label id="label1" for="email">E-mail:</label>
                                    <input type="text" maxlength="60" name="email" id="email" class=" textfield text ui-widget-content ui-corner-all" style="width: 300px"/>
                                    <br/>
                                    <br/>
                                    <label id="label1" for="ussername">Nome de usu&aacute;rio:</label>
                                    <input type="text" maxlength="60" name="username" id="username" class=" textfield text ui-widget-content ui-corner-all" />
                                    <br/>
                                    <br/>
                                    <label id="label1" for="senha" >Senha: </label>
                                    <input type="password" maxlength="60" name="senha" id="senha" class=" textfield text ui-widget-content ui-corner-all"/>
                                    <br/>
                                    <br/>
                                    <label id="label1">N&iacute;vel de acesso:</label>
                                    <input type="radio" class="radio" name="nv_acess" value="1" id="nv_acess">(1)-->Alunos</input>
                                    <input type="radio" class="radio" name="nv_acess" value="2" id="nv_acess">(2)-->M&eacute;dicos</input>
                                    <input type="radio" class="radio" name="nv_acess" value="3" id="nv_acess">(3)-->Administrador</input>
                                    <br/>
                                    <br/>
                                    <div id="area_medica" style="display: none;">
                                        <label id="label1">&Aacute;rea M&eacute;dica :  </label>
                                        <select name = "area_medica" size="1" id="select_area_medica" class="textfield">
                                            <?php
                                            include_once '../app.control/classes/conexao.class.php';
                                            $conexao = new ConexaoDB();
                                            $conexao->conexao("medicina");

                                            $sql = "select id_area_medica,area from area_medica";
                                            $stmt = @pg_query($sql);
                                            $rows = pg_numrows($stmt);

                                            for ($i = 0; $i < $rows; $i++) {
                                                $data = pg_fetch_row($stmt, $i);
                                            ?>
                                                <option  value="<?php echo $data[0] ?>"><?php echo $data[1] ?></option>
                                            <?php
                                            }
                                            $conexao->close();
                                            ?>

                                        </select>
                                    </div>
                                    <!-- dialog -->
                                    <div class="demo" style="display:none">
                                        <div id="dialog_usuario" title="CADASTRO DE USUARIOS">
                                            <p> </p>
                                        </div>
                                    </div>
                                    <!-- FIM DIALOG -->
                                    <br />
                                    <br />
                                    <button type="submit" id="btn_upload" class="ui-corner-all"><img src="../images/user_add.png" align="right" style="vertical-align:middle" alt=""/>Cadastrar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="footer"></div>
            </div>
        </div>
    </body>
</html>