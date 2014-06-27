<div>
	<form action="" method="POST">
		<fieldset>
			<legend>Parametros de Conexion</legend>
			
			<select name="driver">
				<option value="mysqli">mysql</option>
				<option value="postgres">postgres</option>
			</select>
			
			<label for="user">Usuario</label>
			<input type="text" name="user" />
			
			<label for="key">Clave</label>
			<input type="text" name="key" />
			
			<label for="server">Servidor</label>
			<input type="text" name="server" value="localhost" />
			
			<label for="database">Base de datos</label>
			<input type="text" name="database" />
			
			<input type="submit" value="Enviar" />
			
		</fieldset>
	</form>
</div>
<?php
	if ( isset($_POST["user"]) )
	{
		$config_db = '<?php
			$config_db["driver"] = "'.$_POST["driver"].'";
			$config_db["user"] = "'.$_POST["user"].'";
			$config_db["password"] = "'.$_POST["key"].'";
			$config_db["server"] = "'.$_POST["server"].'";		
			$config_db["database"] = "'.$_POST["database"].'";	
		?>';
		
		system("echo $config_db > siga.conf");
		
	}
?>
