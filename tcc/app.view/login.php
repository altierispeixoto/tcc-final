<?php
header("Content-Type: text/html; charset=iso-8859-1");
// Faz o controle de cache.
header("Cache-Control: no-cache, must-revalidate");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="pragma" content="no-cache"/>
        <meta HTTP-EQUIV="imagetoolbar" CONTENT="no"/>
        <title>::Login::</title>
        <link href="../css/login.css" type="text/css" rel="stylesheet" />
        <script type="text/javascript" src="../jscripts/jquery/jquery-1.3.2.js" ></script>
        <script type="text/javascript" src="../jscripts/funcoes.js"></script>
        <script type="text/javascript">
            //<![CDATA[
            $(document).ready(iniciaEventos);
            function iniciaEventos(){
                $('button').click(validaLogin);
            }
            //]]>
        </script>
    </head>
    <body oncontextmenu="return false" ondragstart="return false" onselectstart="return false">
        <div id="wrap">
            <div id="div_form_Login">
                <ul>
                    <form name="login" method="post" action="../app.control/entrar.php" >
                        <p id="titulo">Area restrita, efetue o login!</p>
                        <table border="0" cellspacing="1" cellpadding="2">
                            <tr>
                                <td>Usuario:</td>
                                <td> <input type="text" name="username" id="user"  />
                                    <td><p id="alert_user"></p></td></td>
                            </tr>
                            <tr>
                                <td>Senha:</td>
                                <td><input  type="password" name="password" id="password"/><td><p id="alert_user_pas"></p></td></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td><button style="text-align: center; width: 80px;" type="submit"id="btn_entrar">Entrar</button></td>
                            </tr>
                        </table>
                    </form>
                </ul>
            </div>
        </div>
    </body>
</html>