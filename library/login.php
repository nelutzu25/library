<?php 
include('header.php');
if(isset($_POST['submit'])){
	$email = $_POST['email'];
	$parola = md5($_POST['parola']);
	
	$foo = new Smart();
	$foo->table = 'useri'; 
	$foo->arr = array('email' => $email,'parola' => $parola);
	$row = reset($foo->select());
	if($email == $row['email'] && $parola == $row['parola']){
		$_SESSION['logat'] = true;
		$_SESSION['username'] = $row['nume'].' '.$row['prenume'];
		$_SESSION['rang'] = $row['rang'];
		$_SESSION['id_utilizator'] = $row['id'];
		header('Location: '.$root.'contul-meu');
	}
}


?>

<div class="span4">
	<p>Trebuie sa te loghezi mai intai!</p>
</div>
<div class="span10">
	<form action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post" enctype="multipart/form-data">
		<div class="row-fluid">
			<div class="span4">
				<label for="email">Email</label>
				<input class="input-xlarge"  name="email" type="email" required placeholder="email"/>				

				<label for="pass">Parola</label>
				<input class="input-xlarge"  name="parola" type="password" required placeholder="parola"/>				
			</div>					
		</div>
		<div class="row-fluid">			
			<div class="span8">
				<div class="form-actions">
					<button class="btn" type="submit" name="submit">Save</button>
				</div>
			</div>
			
		</div>		
	</form>
	<a href="<?echo $root;?>register">E prima data cand folosesti aplicatia? Creaza-ti un cont mai intai!</a>
</div>


<?php include('footer.php');?>