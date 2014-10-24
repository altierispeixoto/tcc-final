<?php

/*
 *Autor: Altieris Marcelino Peixoto 
 *Data : 08/07/2010 
 *
 */

class ConexaoDB {

    private $host = "localhost";
    private $user = "postgres";
    private $pswd = "sua senha";
    private $dbname;
    private $con;
    private $strCon;

    /**
     * Metodo de conexao com o banco de dados
     * @param $dbame -> nome do banco de dados para a conexao
     */
   public function conexao($dbname) {
       try{
           
        $this->dbname = $dbname;
        $this->strCon = "host=$this->host user=$this->user password=$this->pswd dbname=$this->dbname";
        $this->con = @pg_connect("$this->strCon")
                or die('Nao foi possivel conectar-se ao banco de dados, por favor tente mais tarde!');

       }  catch (Exception $e){
           echo ($e->getMessage());
       }
    }
 
/**
 * Metodo de fechamento da conexao
 */
   public function close() {
        pg_close($this->con);
    }
}
?>