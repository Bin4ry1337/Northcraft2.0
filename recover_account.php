<?php


include('inc/config.php');


function RecoverAccount()
{
	global $con_realmd;
	global $con_characters;

	if(isset($_POST['recover']))
	{
		$account = $_POST['account'];
		$char1   = $_POST['char1'];
		$level1  = $_POST['level1'];
		$gender1 = $_POST['gender1'];
		$race1   = $_POST['race1'];
		$class1  = $_POST['class1'];

		$data = $con_realmd->prepare('SELECT COUNT(*) FROM account WHERE username = :username');
		$data->execute(array(
			':username' => $account
		));

		if($data->fetchColumn() == 1)
		{
			$data = $con_realmd->prepare('SELECT * FROM account WHERE username = :username');
			$data->execute(array(
				':username' => $account
			));

			$result = $data->fetchAll(PDO::FETCH_ASSOC);

			foreach($result as $row)
			{
				$accid = $row['id'];
			}

			$data = $con_characters->prepare('SELECT COUNT(*) FROM characters WHERE account > 14058 AND account < 16001 AND name = :name AND level = :level AND gender = :gender AND race = :race AND class = :class');
			$data->execute(array(
				':name'   => ucfirst(strtolower($char1)),
				':level'  => $level1,
				':gender' => $gender1,
				':race'   => $race1,
				':class'  => $class1
			));

			if($data->fetchColumn() == 1)
			{
				$data = $con_characters->prepare('UPDATE characters SET account = :accid WHERE name = :name');
				$data->execute(array(
					':accid' => $accid,
					':name'  => ucfirst(strtolower($char1)),
				));

				echo 'Character has been added to your account!';
			}
			else
			{
				echo 'Character not found!';
			}
		}
		else
		{
			echo 'Account was not found!';
		}
	}
}


?>
<html>
<head>

</head>
<body>
<p>
	<font color="#F00">Make sure you register a new account on our front page to recover your old characters to your NEW account.</font>
</p>
<form method="POST">
	<label>New Account Name</label>
	<input type="text" name="account" />
	<br>
	<br>
	<label>Character Name</label>
	<input type="text" name="char1" />
	<label>Level</label>
	<input type="number" name="level1" min="1" max="80" value="70" />
	<select name="gender1">
		<option>Gender</option>
		<option value="0">Male</option>
		<option value="1">Female</option>
	</select>
	<select name="race1">
		<option>Race</option>
		<option value="1">Human</option>
		<option value="2">Orc</option>
		<option value="3">Dwarf</option>
		<option value="4">Night Elf</option>
		<option value="5">Undead</option>
		<option value="6">Tauren</option>
		<option value="7">Gnome</option>
		<option value="8">Troll</option>
		<option value="10">Blood Elf</option>
		<option value="11">Draenei</option>
	</select>
	<select name="class1">
		<option>Class</option>
		<option value="1">Warrior</option>
		<option value="2">Paladin</option>
		<option value="3">Hunter</option>
		<option value="4">Rogue</option>
		<option value="5">Priest</option>
		<option value="6">Deathknight</option>
		<option value="7">Shaman</option>
		<option value="8">Mage</option>
		<option value="9">Warlock</option>
		<option value="11">Druid</option>
	</select>
	<br>
	<br>
	<input type="submit" name="recover" value="Recover" />
	<br>
	<?php RecoverAccount(); ?>
</form>

</body>
</html>