<?php

include('../inc/settings.php');

try
{
	$con_characters = new PDO('mysql:host=' . $config['HOST_CHARS'] . ';dbname=' . $config['DB_CHARS'] . ';charset=' . $config['CHARSET'], $config['USER_CHARS'], $config['PASS_CHARS']);
}
catch(PDOException $e)
{
	die($e->getMessage());
}

if(!empty($_POST['searchVal']))
{
	global $con_characters;

	$name = ucfirst(strtolower($_POST['searchVal']));

	$page    = isset($_GET['page']) ? (int)$_GET['page'] : 1;
	$perPage = 10;
	$limit   = 100;

	$start = ($page > 1) ? ($page * $perPage) - $perPage : 0;

	$data = $con_characters->prepare('SELECT * FROM characters WHERE name LIKE ? ORDER BY name ASC LIMIT ' . $start . ', ' . $perPage);
	$data->execute(array(
		"%$name%"
	));

	$data2 = $con_characters->prepare('SELECT * FROM characters WHERE name LIKE ?');
	$data2->execute(array(
		"%$name%"
	));

	$rows = $data2->rowCount();
	
	$totalq = $con_characters->prepare('SELECT * FROM characters WHERE name LIKE ?');
	$totalq->execute(array(
		"%$name%"
	));

	$total = $totalq->rowCount();

	$pages = ceil($total / $perPage);
	
	$race = array(
		1  => array(
				0 => 'img/icons/race/human-male.png',
				1 => 'img/icons/race/human-female.png'
		),
		2  => array(
				0 => 'img/icons/race/orc-male.png',
				1 => 'img/icons/race/orc-female.png'
		),
		3  => array(
				0 => 'img/icons/race/dwarf-male.png',
				1 => 'img/icons/race/dwarf-female.png'
		),
		4  => array(
				0 => 'img/icons/race/nightelf-male.png',
				1 => 'img/icons/race/nightelf-female.png'
		),
		5  => array(
				0 => 'img/icons/race/undead-male.png',
				1 => 'img/icons/race/undead-female.png'
		),
		6  => array(
				0 => 'img/icons/race/tauren-male.png',
				1 => 'img/icons/race/tauren-female.png'
		),
		7  => array(
				0 => 'img/icons/race/gnome-male.png',
				1 => 'img/icons/race/gnome-female.png'
		),
		8  => array(
				0 => 'img/icons/race/troll-male.png',
				1 => 'img/icons/race/troll-female.png'
		),
		10 => array(
				0 => 'img/icons/race/bloodelf-male.png',
				1 => 'img/icons/race/bloodelf-female.png'
		),
		11 => array(
				0 => 'img/icons/race/draenei-male.png',
				1 => 'img/icons/race/draenei-female.png'
		)
	);

	$class = array(
		1  => 'img/icons/class/warrior.png',
		2  => 'img/icons/class/paladin.png',
		3  => 'img/icons/class/hunter.png',
		4  => 'img/icons/class/rogue.png',
		5  => 'img/icons/class/priest.png',
		6  => 'img/icons/class/deathknight.png',
		7  => 'img/icons/class/shaman.png',
		8  => 'img/icons/class/mage.png',
		9  => 'img/icons/class/warlock.png',
		11 => 'img/icons/class/druid.png'
	);

	$classColor = array(
		1  => 'warrior',
		2  => 'paladin',
		3  => 'hunter',
		4  => 'rogue',
		5  => 'priest',
		6  => 'deathknight',
		7  => 'shaman',
		8  => 'mage',
		9  => 'warlock',
		11 => 'druid'
	);

	$faction = array(
		1  => '<img src="img/icons/faction/alliance.png" width="23" title="Alliance">',
		2  => '<img src="img/icons/faction/horde.png" width="23" title="Horde">',
		3  => '<img src="img/icons/faction/alliance.png" width="23" title="Alliance">',
		4  => '<img src="img/icons/faction/alliance.png" width="23" title="Alliance">',
		5  => '<img src="img/icons/faction/horde.png" width="23" title="Horde">',
		6  => '<img src="img/icons/faction/horde.png" width="23" title="Horde">',
		7  => '<img src="img/icons/faction/alliance.png" width="23" title="Alliance">',
		8  => '<img src="img/icons/faction/horde.png" width="23" title="Horde">',
		10 => '<img src="img/icons/faction/horde.png" width="23" title="Horde">',
		11 => '<img src="img/icons/faction/alliance.png" width="23" title="Alliance">'
	);

	function GrabGuild($value)
	{
		global $con_characters;

		$data = $con_characters->prepare('SELECT * FROM guild_member WHERE guid = :id');
		$data->execute(array(
			':id' => $value
		));

		$result = $data->fetchAll(PDO::FETCH_ASSOC);

		foreach($result as $row)
		{
			$data = $con_characters->prepare('SELECT * FROM guild WHERE guildid = :guildid');
			$data->execute(array(
				':guildid' => $row['guildid']
			));

			$result = $data->fetchAll(PDO::FETCH_ASSOC);

			foreach($result as $row)
			{
				return $row['name'];
			}
		}
	}

	echo '<div class="armory-box-output column small-12">
			<div class="tab">
				Characters (' . $rows . ')
			</div>

			<div class="result">
				<table>
					<th>Name</th>
					<th>Guild</th>
					<th>Class</th>
					<th>Race</th>
					<th>Level</th>';

	while($result = $data->fetchAll(PDO::FETCH_ASSOC))
	{
		foreach($result as $search)
		{
			if(!empty(GrabGuild($search['guid'])))
			{
				$guild = '<span class="green">< ' . GrabGuild($search['guid']) . ' ></span>';
			}
			else
			{
				$guild = '';
			}

			echo '<tr>
					<td><a href="?character=' . $search['name'] . '"><span class="' . $classColor[$search['class']] . '">' . $search['name'] . '</span></a></td>
					<td>' . $guild . '</td>
					<td><img src="' . $class[$search['class']] . '" width="24"></td>
					<td><img src="' . $race[$search['race']][$search['gender']] . '" width="24"></td>
					<td><span class="orange">Level</span> ' . $search['level'] . '</td>
				</tr>';
		}
	}

	echo '</table>
				</div>
			</div>
		</div>';

	echo '<div class="navigation-armory column small-12"><ul class="nav-menu">';

		echo '<li><a href="?character=' . $name . '&page=1"><<</a></li>';
		
		$min = max($page - 2, 1);
		$max = min($page + 2, $pages);

		for($x = $min; $x <= $max; $x++)
		{
			if(@$page == $x)
			{
				echo '<li><a href="?character=' . $name . '&page=' . $x . '" class="current-nav">' . $x . '</a></li>';
			}
			elseif(@!isset($page))
			{
				echo '<li><a href="?character=' . $name . '&page=' . $x . '" class="current-nav">' . $x . '</a></li>';
			}
			else
			{
				echo '<li><a href="?character=' . $name . '&page=' . $x . '">' . $x . '</a></li>';
			}
		}

		echo '<li><a href="?character=' . $name . '&page=' . $pages . '">>></a></li>';

	echo '</ul></div>';
}


?>