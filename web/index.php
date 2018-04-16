<?php
	try{
		$hostname = "ec2-174-129-41-64.compute-1.amazonaws.com";
    	$dbname = "d3gqbgksnbl117";
    	$username = "hvjraezogmchof";
   		$pw = "bfbc91096e12adbe3d5976921e26f5758ed98a360641f9910dac05e56827178f";
    	$pdo = new PDO ("pgsql:host=$hostname;dbname=$dbname","$username","$pw");
	}catch (PDOException $e){
		echo "Failed to get DB handle: " . $e->getMessage() . "\n";
    	exit;
	}

	if(isset($_POST['tarea'])){
		$query = $pdo->prepare("INSERT INTO tasklist (task) VALUES ('".$_POST['tarea']."')");
		$query->execute();

		echo "<form method='post' action='index.php'>
		      <label>Create New Task</label>
		      <input type='text' name='tarea'>
		      <input type='submit' value='Enviar'>
		      </form>
		      ";
	}else{
		echo "<form method='post' action='index.php'>
		      <label>Create New Task</label>
		      <input type='text' name='tarea'>
		      <input type='submit' value='Enviar'>
		      </form>
		      ";

	}

?>


<html>
	<head>
		<style>
			table {border: 1px solid black;}
		</style>
	</head>
	<body>
		<table>
			<thead>
				<th>ID</th>
				<th>Task</th>
				<th>Done</th>
			</thead>
			<tr></tr>
			<?php

				$query = $pdo->prepare("select * FROM tasklist");
				$query->execute();

				//anem agafant les fileres d'amb una amb una
				$row = $query->fetch();
				while ( $row ) {
				echo "<td>". $row['id']. "</td>";
				echo "<td>". $row['task']."</td>";
				echo "<td><input type='checkbox' id=".$row['id']." onfocus='checkear(event)'></td>";
				echo "<tr></tr>";
				$row = $query->fetch();
				}

			?>
		</table>


		<script>
			function checkear(event){
				var obj = event.currentTarget;
				if(obj.checked != true){
					obj.checked = true;
					obj.disabled = true;
				}
			}

		</script>
	</body>
</html>
