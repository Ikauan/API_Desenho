<?php
class Operacao{
    private $con;
    function __construct()
    {
        require_once dirname(__FILE__). './Conexao.php';
        $bd = new Conexao();
        $this->con = $bd->connect();
    }

    function createDesenho($campo_2,$campo_3){
        $stmt = $this->con->prepare("INSERT INTO desenho_tb(nomedesenho,imgdesenho) VALUES (?,?)");
        $stmt->bind_param("ss",$campo_2,$campo_3);
        if($stmt->execute())
            return true;
        return var_dump($stmt);
    }
    function getDesenho(){
        $stmt = $this->con->prepare("Select * from desenho_tb");
        $stmt -> execute();
        $stmt -> bind_result($uid,$nomedesenho,$imgdesenho);

        $dicas = array();

        while($stmt->fetch()){
            $dica = array();
            $dica['uid']= $uid;
            $dica['nomedesenho']=$nomedesenho;
            $dica['imgdesenho']=$imgdesenho;
            array_push($dicas,$dica);
        }
        return $dicas;
    }
    function updateDesenho($campo_1,$campo_2,$campo_3){
        $stmt = $this->con->prepare("update desenho_tb set nomedesenho = ? ,imgdesenho= ? where uid=?");
        $stmt->bind_param("sssi",$campo_2,$campo_3,$campo_1);
        if($stmt->execute())
        return true;
        return false;
    }

    function deleteDesenho($campo_1){
        $stmt = $this->con->prepare("delete from desenho_tb where uid = ?");
        $stmt->bind_param("i",$campo_1);
        if($stmt-> execute())
        return true;
        return false;
    }
}
