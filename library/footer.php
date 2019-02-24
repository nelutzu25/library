		</div>

    </div>
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	<script type="text/javascript" >
	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function (e) {
				$('#preview').attr('src', e.target.result);
			}

			reader.readAsDataURL(input.files[0]);
		}
	}
	</script>

    <script src="<?echo $root;?>js/jquery-ui.custom.min.js"></script>
    <script src="<?echo $root;?>js/javascript.js"></script>
	
	<script type="text/javascript">
		$(document).ready(function(){
			$('#pass').click(function(e){
				var pass = $('[name=parola]').val();
				var pass2 = $('[name=parola2]').val();
				if(pass != pass2){
					alert("Cele 2 parole nu coincid!");
					e.preventDefault();
				}
				else{
					return true;
				}
			});
		});
	</script>

	<div id="dialog-confirm" title="Confirma stergerea" style="display:none;">
		<p>
			<span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>
			Dupa stergere nu mai poate fi recuperat.
		</p>
	</div>

  </body>
</html>