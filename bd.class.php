<?php 

class bd{
	//host
	private $host = 'localhost';
	//usuario
	private $user = 'root';
	//senha
	private $password = '';
	//banco de dados
	private $database = 'uemg_eventos';

	public function conecta_mysql(){
		$con = mysqli_connect($this->host, $this->user, $this->password, $this->database);
		mysqli_set_charset($con,"utf8");

		if(mysqli_connect_errno()) {
                echo "Erro ao tentar se conectar com o BD MySQL: " . mysqli_connect_error();
            }
 
            return $con;
	}


}	

?>