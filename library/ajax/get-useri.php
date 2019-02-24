<?
session_start();
require_once('../includes/functions.php'); 
//print_r($_GET);

//PAGE NUMBER, RESULTS PER PAGE, AND OFFSET OF THE RESULTS
if($_GET["page"]){
    $pagenum = $_GET["page"]; 
}
if($_GET["size"]){
	$rowsperpage = $_GET["size"]; //MAXIMUM RESULTS PER PAGE
}
$where = '';
if($_GET["filter"]){
	$where = ' WHERE ';
	if(isset($_GET["filter"][0])){
		$id = $_GET["filter"][0];
		$where .= " id = $id ";
	}
	if(isset($_GET["filter"][1])){
		$nume = $_GET["filter"][1];
		$where .= " nume LIKE '%$nume%' ";
	}
	if(isset($_GET["filter"][2])){
		$prenume = $_GET["filter"][2];
		$where .= " prenume LIKE '%$prenume%' ";
	}
	if(isset($_GET["filter"][3])){
		$r = array_search($_GET["filter"][3],$rang);
		$where .= " rang = $r ";
	}
	if(isset($_GET["filter"][5])){
		$email = $_GET["filter"][5];
		$where .= " email LIKE '%$email%' ";
	}
}

$order = '';
if($_GET["column"]){
	$order = ' ORDER BY ';
	if(isset($_GET["column"][0])){
		$id = $_GET["column"][0];
		if($id == 1)
			$order .= " id ASC ";
		if($id == 0)
			$order .= " id DESC ";
	}
	if(isset($_GET["column"][1])){
		$nume = $_GET["column"][1];
		if($nume == 1)
			$order .= " nume ASC ";
		if($nume == 0)
			$order .= " nume DESC ";
	}
	if(isset($_GET["column"][2])){
		$prenume = $_GET["column"][2];
		if($nume == 1)
			$order .= " prenume ASC ";
		if($nume == 0)
			$order .= " prenume DESC ";
	}
	if(isset($_GET["column"][3])){
		$r = $_GET["column"][3];
		if($r == 1)
			$order .= " rang ASC ";
		if($r == 0)
			$order .= " rang DESC ";
	}
	if(isset($_GET["column"][5])){
		$email = $_GET["column"][5];
		if($email == 1)
			$order .= " email ASC ";
		if($email == 0)
			$order .= " email DESC ";
	}
}

$offset = $pagenum  * $rowsperpage; //WHERE THE RESULTS START FROM

$sql = "SELECT * FROM useri 
		$where $order
		LIMIT $offset,$rowsperpage"; 
$sqlall = "SELECT * FROM useri $where";
//echo $sql;
//echo $sqlall;

$q = mysql_query($sql);
$page_nums = mysql_num_rows($q); //NUMBER OF RESULTS FOR THE PAGE
$total_q = mysql_query($sqlall); //FOR THE ALL RESULTS
$total_nums = mysql_num_rows($total_q); //TOTAL NUMBER OF RESULTS

$array_rows = array();
$result = mysql_query($sql);
while($row = mysql_fetch_array($result)){
 $row1 = array("ID"=> $row['id'],
		"Nume"=> $row['nume'],
		"Prenume"=> $row['prenume'],
		"Rang"=> $rang[$row['rang']],
		"Poza"=> '<img width="50px" height="50px" src="'.$root.'uploads/'.getFile("uploads/",$row['id']).'" alt="poza" />',
		"Email"=> $row['email'],
		"Edit"=> '<a class="btn" href="../useri/edit&id='.$row['id'].'">Editeaza</a>',
		"Sterge"=> '<a class="btn confirm sterge" data-load="../useri/list&stergeid='.$row['id'].'">Sterge</a>') ;
 array_push($array_rows,$row1);
}

$newdata = array(
	'total_rows'=>$total_nums, 
	'headers' => array("ID", "Nume", "Prenume" , "Rang", "Poza", "Email", "Edit", "Sterge"), 
	'rows'=>$array_rows
);

echo json_encode($newdata);
?>