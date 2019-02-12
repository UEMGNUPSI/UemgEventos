<?php 

class bd{
	private $host = 'localhost';

	private $user = 'root';

	private $password = 'fushrodah';

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