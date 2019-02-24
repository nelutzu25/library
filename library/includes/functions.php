<?php
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ERROR);
require_once('db-connect.php');
/*
************************
*	start smart class  *	 
*	select			   *	 
*	insert			   *	 
*	delete			   *	 
*	edit 			   *	 
************************
*/
class Smart{
	public $arr = array(); //tip array
	public $table; // tabela
	public $where; // unde
	private $e = 'id';
	public $order = 'ORDER BY id'; //ordine la selectie daca e cazul

	//pentru stergere
	public $id; //id de sters
	public $desters = array(); // tabela=>row
	
	public function __construct(){
    } 
	
	//insert in db
	public function insert(){
		$rows = array();
		$values = array();
		foreach($this->arr as $key=>$val){
			$rows[] = $key;
			$values[] = $val;
		}
		$row = '('.implode(',',$rows).')';
		$val = '(\''.implode('\',\'',$values).'\')';
		$result = mysql_query("INSERT INTO ".$this->table ." $row VALUES $val");
		if(!$result){
			return '<div class="alert"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>ATENTIE!</strong> '.mysql_error().'</div>';
		}
		else return '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>S-a inserat cu succes</div>'; 
	}
	//editeaza in db
	public function edit(){
		$rows = array();
		foreach($this->arr as $key=>$val){
			$rows[] = $key."='$val'";
		}
		$row = implode(',',$rows);
		$result = mysql_query("UPDATE ".$this->table ." SET $row ".$this->where);
		if(!$result){
			return '<div class="alert"><button type="button" class="close" data-dismiss="alert alert-block alert-error ">&times;</button><strong>ATENTIE!</strong> '.mysql_error().'</div>';
		}
		else return '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>S-a editat cu succes</div>'; 
	
	}
	//sterge in db
	public function delete(){
		$var = $this->desters;
		if(count($var) > 0){
			foreach($var as $k=>$v){//parcurgem vectorul ramas, si stergem ce se potriveste
				$result = mysql_query("DELETE FROM $k WHERE $v='".$this->id ."'");
			}
			return '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>S-a sters cu succes</div>';
		}
	}
	//selecteaza din db
	public function select(){
		$wh = '';
		$rows = array();
		$wa = array();
		$i = 0;
		if(count($this->arr)>0){
			foreach($this->arr as $k=>$v){
				$wa[] = "$k='$v' ";
			}
			if(count($wa)>0)
				$wh = "WHERE ".implode(' AND ',$wa);
		}
		$result = mysql_query("SELECT * FROM ".$this->table ." $wh ".$this->order);
		while($row = mysql_fetch_array($result)){
			$rows[$row[$this->e]] = $row;
		}
		unset($this->arr);
		return  $rows;
	}
}
/*
************************
*	end smart class    *	 
************************
*/


function getFile($folder,$filename = '',$ext = '.*'){
	$i = 0;
	$files = array();
	$poze = array();
	$file = null;
	//$dir = $_SERVER['DOCUMENT_ROOT'].$folder;
	//$files = glob($dir.$filename.$ext);
	$files = glob($folder.$filename.$ext);
	if(count($files)>0)
	usort($files, create_function('$a,$b', 'return filemtime($a)>filemtime($b);'));
	if(is_array($files)){
		foreach($files as $file){
			$file = basename($file).PHP_EOL;
			$file = preg_replace("/[^a-zA-Z0-9\/_.|+-]/", '', $file);
			break;
		}
		return $file;
	}
	return $file;
}



$root = 'http://'.$_SERVER['SERVER_NAME'].'/';$root = 'http://localhost:8080/biblioteca/'; 

$rang[0] = 'Abonat';
$rang[1] = 'Bibliotecar';
$rang[2] = 'Administrator';

$status_imprumut[0] = 'nou';
$status_imprumut[1] = 'acceptat';
$status_imprumut[2] = 'respins';
$status_imprumut[3] = 'anulat';

$result = mysql_query("SELECT * FROM useri ");
while($row = mysql_fetch_array($result)){
	$lista_useri[$row['id']] = $row['nume'].' '.$row['prenume'];	if($row['rang'] == 0)
		$lista_abonati[$row['id']] = $row['nume'].' '.$row['prenume'];
}
$result = mysql_query("SELECT * FROM autori ");
while($row = mysql_fetch_array($result)){
	$lista_autori[$row['id']] = $row['prenume'].' '.$row['nume'];
}

$result = mysql_query("SELECT * FROM carti ");
while($row = mysql_fetch_array($result)){
	$lista_carti[$row['id']] = $row['titlu'];
	$lista_autor_carte[$row['id']] = $lista_autori[$row['id_autor']];
}
?>