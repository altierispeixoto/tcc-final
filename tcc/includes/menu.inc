<!-- MENU -->

<div id="menu">
    <ul class="menu">
        <li><a href="#" class="parent"><span>SISTEMA</span></a>
            <div>
                <ul>
                    <li><a href="formpassword.php"><span>Trocar Senha</span></a></li>
                    <li><a href="../app.control/logout.php"><span>Logout</span></a></li>
                </ul>
            </div>
        </li>
        <li> <a href="#" class="parent"><span>IMAGENS M&Eacute;DICAS</span></a>
            <div>
                <ul>
                    <?php
                    //so medicos podem realizar upload de images ou ativar/desativar imagens
                    if($_SESSION["nv_acess"]==2){
                    ?>
                    <li><a href="upload.php" ><span>Upload de Imagens M&eacute;dicas</span></a> </li>
                    <li><a href="visualizador_exclusao.php" ><span>Ativar / Desativar Imagens M&eacute;dicas</span></a> </li>
                     <?php
                    }
                    ?>
                    <li><a href="visualizador.php" ><span>Visualizador de Imagens M&eacute;dicas</span></a> </li>
                    
                </ul>
            </div>
        </li>
        <?php
        #se o usuario e administrador entao ele pode cadastrar usuario e desativar-los
        if($_SESSION["nv_acess"] == 3){
        ?>
        <li> <a href="#" class="parent"><span>ADMINISTRATIVO</span></a>
            <div>
                <ul>
                    <li><a href="#" class="parent"><span>Usu&aacute;rios</span></a>
                        <div>
                            <ul>
                                <li><a href="tabela_usuarios.php"><span>Tabela de Usu&aacute;rios</span></a></li>
                                <li><a href="cadastro_usuario.php" ><span>Cadastrar Novo Usu&aacute;rio</span></a> </li>

                            </ul>
                        </div>
                    </li>
                    <li><a href="#" class="parent"><span>Areas Medicas</span></a>
                    <div>
                            <ul>
                                <li><a href="tabela_subareas.php"><span>Tabela de Areas Medicas e Sub Areas</span></a></li>
                            </ul>
                        </div>
                    
                    </li>
                    <li><a href="administrativo.php" ><span>Relat&oacute;rios</span></a> </li>
                </ul>
            </div>
        </li>
        <?php
        }
        ?>

        <?php
        if($_SESSION["nv_acess"] == 2 ||$_SESSION["nv_acess"] == 3 ){
        ?>
        <li class="last"><a href="#"><span>CADASTROS</span></a>
            <div>
                <ul>
                    <?php
                    if($_SESSION["nv_acess"] == 3){
                    ?>
                    <li><a href="cadastro_area_medica.php" ><span>Areas M&eacute;dicas</span></a> </li>
                    <?php
                    }
                    ?>
                    <?php
                    if($_SESSION["nv_acess"] ==  2){
                    ?>
                    <li><a href="cadastro_patologia.php" ><span>Patologias</span></a> </li>
                    <li><a href="cadastro_sub_area_medica.php" ><span>Sub&aacute;reas M&eacute;dicas</span></a> </li>
               <?php
                    }
                    ?>
                </ul>
            </div>
        </li>

        <?php
        }
        ?>

    </ul>
</div>
<div ><a href="http://apycom.com/"></a></div>
<!-- FINAL DO MENU -->