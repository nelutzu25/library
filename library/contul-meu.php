<?php include('header.php');
echo '<div class="span10">';
	$foo = new Smart();
	$foo->table = 'useri';
	if(isset($_POST['submit'])){ // add/edit			
		$array = array(
			'id' => $_POST['id'],
			'nume' => $_POST['nume'],
			'prenume' => $_POST['prenume'],
			'adresa' => $_POST['adresa'],
			'email' => $_POST['email'],
			'telefon' => $_POST['telefon']
		);
		$parola = $_POST['parola'];
		if($parola != '')
			$array['parola'] = md5($parola);
		$id = $_POST['id'];
		$foo->arr = $array;
		$foo->where = "WHERE id = '$id'";
		echo $foo->edit();
		
		require_once('includes/class.upload.php');
		$boo = new Upload($_FILES['poza']);
		if ($boo->uploaded) {
		  // save uploaded image with a new name,
		  $boo->file_auto_rename = false;
		  $boo->file_overwrite = true;
		  $boo->file_new_name_body = $id;
		  $boo->image_resize = true;
		  $boo->image_x = 200;
		  //$boo->image_ratio_y = true;
		  $boo->image_y = 200;
		  $boo->Process('uploads/');
		  if ($boo->processed) {
			$boo->Clean();
		  } else {
			echo 'error : ' . $boo->error;
		  }
		}
	}
	$result = mysql_query("SELECT * FROM useri WHERE id='$id' LIMIT 1");
	$cont = mysql_fetch_array($result); 	
?>
<form id="myForm" action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post" enctype="multipart/form-data">
	<div class="row-fluid">
		<div class="span4">
			<input  value="<?php echo $cont['id'];?>" name="id" type="hidden" />				
		
			<label for="nume">Nume</label>
			<input class="input-xlarge" value="<?php echo $cont['nume'];?>" name="nume" type="text" required placeholder="nume"/>				
			
			<label for="prenume">Prenume</label>
			<input class="input-xlarge" value="<?php echo $cont['prenume'];?>" name="prenume" type="text" required placeholder="prenume"/>				

			<label for="email">Email</label>
			<input class="input-xlarge" value="<?php echo $cont['email'];?>" name="email" type="email" required placeholder="email"/>				

			<label for="telefon">Telefon</label>
			<input class="input-xlarge" value="<?php echo $cont['telefon'];?>" name="telefon" type="number" required placeholder="telefon"/>				
		
			<label for="adresa">Adresa</label>
			<textarea class="input-xlarge" name="adresa"><?php echo $cont['adresa'];?></textarea>
			
			<label for="pass">Parola noua</label>
			<input class="input-xlarge"  name="parola" type="password" placeholder="parola"/>

			<label for="pass">Confirma Parola</label>
			<input class="input-xlarge"  name="parola2" type="password"  placeholder="confirma parola"/>
			
			<label for="poza">Alege o poza!(daca vrei sa o inlocuiesti alege alta poza)</label>
			<input name="poza" type='file' onchange="readURL(this);" />
			<img width="200px" height="200px" id="preview" src="../uploads/<?php echo getFile('uploads/',$cont['id']);?>" alt="your image" />
				
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
<?php 
echo '</div>';

include('footer.php');
?>