<?php
include '../includes/valida_sessao.inc';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="BR" lang="PT-BR">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <meta http-equiv="pragma" content="no-cache"/>
        <meta HTTP-EQUIV="imagetoolbar" CONTENT="no"/>
        <title>:::: Ativar / Desativar Imagens  ::::</title>
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
        <script type="text/javascript" src="../jscripts/jquery/ui.datepicker.js"></script>
        <script type="text/javascript" src="../jscripts/jquery/jquery.bgiframe.js"></script>
        <link type="text/css" href="../css/jquery/demos.css" rel="stylesheet" />
        <link type="text/css" href="../css/jquery/ui.all.css" rel="stylesheet" />
        <script type="text/javascript">
            $(function() {
                $("#tabs").tabs();
            });
        </script>
        <script type="text/javascript">
            $(function(){
                $('#patologia').change(function(){
                    if( $(this).val() == "1" )
                    {
                        $('#categoria').show();
                        $('#composicao').show();
                    }
                    else{
                        $('#categoria').hide();
                        $('#composicao').hide();
                    }
                });
            });
        </script>
        <script type="text/javascript">

            $(function() {
                jQuery(function($){
                    $.datepicker.regional['pt-BR'] = {
                        closeText: 'Fechar',
                        prevText: '&#x3c;Anterior',
                        nextText: 'Pr&oacute;ximo&#x3e;',
                        currentText: 'Hoje',
                        monthNames: ['Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho',
                            'Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
                        monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun',
                            'Jul','Ago','Set','Out','Nov','Dez'],
                        dayNames: ['Domingo','Segunda-feira','Ter&ccedil;a-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sabado'],
                        dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
                        dayNamesMin: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
                        dateFormat: 'dd/mm/yy', firstDay: 0,
                        isRTL: false};
                    $.datepicker.setDefaults($.datepicker.regional['pt-BR']);

                });
                $('.datepicker').datepicker({
                    showOn: 'button',
                    buttonImage: '../images/16.png',
                    buttonImageOnly: false,
                    changeMonth: true,
                    changeYear: true

                });
            });
        </script>
        <script type="text/javascript">
            $(document).ready(validaDados);

           
        </script>
    </head>
    <body oncontextmenu="return false" ondragstart="return false" onselectstart="return false">
        <div id="wrap">
            <div id="header"> <a href="../app.control/logout.php" id="linkexit">Logout<img src="../images/door_open.png" alt="" id="iconexit"></img></a>
                <div id="menux">
                    <?php include '../includes/menu.inc'; ?>
                </div>
                <br/>
                <br/>
                <div id="postheader"> <a href="inicio.php" id="linkmap" >Home &gt;&gt;</a> <a id="linkmap" >Ativa&ccedil;&atilde;o/Desativa&ccedil;&atilde;o de Imagens &gt;&gt;</a> </div>
            </div>
            <div id="content" style="background-image: none;" > <br>
                </br>
                <div id="tabs">
                    <ul>
                        <li><a href="#tabs-1">Ativa&ccedil;&atilde;o/Desativa&ccedil;&atilde;o de Imagens</a></li>
                    </ul>
                    <div id="tabs-1">
                        <div class="mudar">
                            <form action="exclui_imagem.php" method="post" >
                                <!-- numero da pagina -->
                                 <input type="hidden" name="pagina" value="1" id="pagina" />

                                 <!-- ativar ou desativar -->
                                <label id="label1" style="width:auto" >Ativar ou Desativar Imagens para Visualiza&ccedil;&atilde;o :</label>
                                <input type="radio" name="ativacao" VALUE="0" class="chekbox">Ativar </input>
                                <input type="radio" name="ativacao" checked="true" value="1" class="chekbox">Desativar </input>
                                <br/>
                                <br/>
                                <br/>
                                <!--id da patologia -->
                                <label class="label1" style="width: auto">Patologia Relacionada :
                                    <select name = "patologia" class="textfield" id="patologia">
                                        <option value="-1" >Selecione</option>
                                        <?php
                                        include_once '../app.control/classes/conexao.class.php';
                                        $conexao = new ConexaoDB();
                                        $conexao->conexao("medicina");

                                        $sql = "select ip.id_patologia,ip.descricao 
                                                from idx_patologia ip ,area_medica am,login_area_medica la
                                                where 
                                                ip.id_area_medica = am.id_area_medica 
                                                and la.id_area_medica = am.id_area_medica 
                                                and la.username = '$username' and
                                                am.status = 1 and ip.status = 1
                                            "; 
                                        $stmt = @pg_query($sql);
                                        $rows = @pg_numrows($stmt);
                                        for ($i = 0; $i < $rows; $i++) {
                                            $data = @pg_fetch_row($stmt, $i);
                                        ?>
                                            <option  value="<?php echo $data[0] ?>"><?php echo $data[1] ?></option>
                                        <?php
                                        }
                                        $conexao->close();
                                        ?>
                                    </select>
                                </label>
                                <label id="categoria" style="display: none;width: auto" class="label1">Categoria :
                                    <select name="categoria" class="textfield" id="cat">
                                        <option value="-1">Selecione</option>
                                        <option value="0">0</option>
                                        <option value="1">I</option>
                                        <option value="2">II</option>
                                        <option value="3">III</option>
                                        <option value="4">IV</option>
                                        <option value="4A">IV-A</option>
                                        <option value="4B">IV-B</option>
                                        <option value="4C">IV-C</option>
                                        <option value="5">V</option>
                                    </select>
                                </label>
                                <label id="composicao" style="display: none;width: auto" class="label1">Composi&ccedil;&atilde;o :
                                    <select name="composicao" class="textfield" id="comp">
                                        <option value="-1">Selecione</option>
                                        <option value="1">I</option>
                                        <option value="2">II</option>
                                        <option value="3">III</option>
                                        <option value="4">IV</option>
                                    </select>
                                </label>
                                <br />
                                <br />
                                <br /><br />
                                <label id="num_imagens" class="label1">N&uacute;mero de Imagens por p&aacute;gina
                                    <select name="num_imagens" id="select_num_imagens">
                                        <option value="10" >10</option>
                                        <option value="20" >20</option>
                                        <option value="30" >30</option>
                                        <option value="40" >40</option>
                                        <option value="50" >50</option>
                                    </select>
                                </label>
                                <br/>
                                <br/>
                                <br />
                                <fieldset style="border:#808080 dashed 1px;width: 500px;" class="ui-corner-all">
                                    <legend style="border: #808080 dashed 1px;" class="ui-corner-all">Selecionar periodo de upload para busca de imagens</legend>
                                 <br />
                                    <label id="label1" for="dt_inicio">Data Inicial:</label>
                                    <input type="text" class="datepicker  textfield text ui-widget-content ui-corner-all" name="dt_inicio" id="dt_inicio"></input>
                                    <br />
                                    <br />
                                    <label id="label1" for="dt_fim">Data Final:</label>
                                    <input type="text" class="datepicker  textfield text ui-widget-content ui-corner-all" name="dt_fim" id="dt_fim"></input>
                                </fieldset>
                                <br />
                                <br />
                                <br />
                                <button type="submit" id="btn_upload" class=" ui-corner-all" >Selecionar Imagens</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
              <!-- dialog -->
              <div class="demo" style="display:none">
                <div id="dialog_visualizador" title="ATENCAO !">
                  <p> </p>
                </div>
              </div>
              <!-- FIM DIALOG -->
        </div>
    </body>
</html>