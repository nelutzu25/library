<?php 
include('header.php');
if(isset($_POST['submit'])){
	$foo = new Smart();
	$foo->table = 'useri';
	$array = array(
		'nume' => $_POST['nume'],
		'prenume' => $_POST['prenume'],
		'email' => $_POST['email'],
		'telefon' => $_POST['telefon'],
		'parola' => md5($_POST['parola']),
		'rang' => 0
	);
		
	$foo->arr = $array;
	echo $foo->insert();
	header('Location: '.$root.'login');
}
?>

<div class="span4">
	<p>Inregistreaza-te</p>
</div>
<div class="span10">
	<form id="myForm" action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post" enctype="multipart/form-data">
		<div class="row-fluid">
			<div class="span4">
				<label for="nume">Nume</label>
				<input class="input-xlarge" name="nume" type="text" required placeholder="nume"/>

				<label for="prenume">Prenume</label>
				<input class="input-xlarge" name="prenume" type="text" required placeholder="prenume"/>				
				
				<label for="email">Email</label>
				<input class="input-xlarge"  name="email" type="email" required placeholder="email"/>				

				<label for="telefon">Telefon</label>
				<input class="input-xlarge"  name="telefon" type="number" required placeholder="telefon"/>				
				
				<label for="pass">Parola</label>
				<input class="input-xlarge"  name="parola" type="password" required placeholder="parola"/>

				<label for="pass">Confirma Parola</label>
				<input class="input-xlarge"  name="parola2" type="password" required placeholder="confirma parola"/>					
			</div>					
		</div>
		<div class="row-fluid">			
			<div class="span8">
				<div class="form-actions">
					<button id="pass" class="btn" type="submit" name="submit">Save</button>
				</div>
			</div>
			
		</div>		
	</form>
</div>


<?php include('footer.php');?>