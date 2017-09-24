<?php

function GrabArenaHighscore()
{
	global $con_web;
	global $con_characters;

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
		1  => '<img src="img/icons/faction/alliance.png" width="22" title="Alliance">',
		2  => '<img src="img/icons/faction/horde.png" width="22" title="Horde">',
		3  => '<img src="img/icons/faction/alliance.png" width="22" title="Alliance">',
		4  => '<img src="img/icons/faction/alliance.png" width="22" title="Alliance">',
		5  => '<img src="img/icons/faction/horde.png" width="22" title="Horde">',
		6  => '<img src="img/icons/faction/horde.png" width="22" title="Horde">',
		7  => '<img src="img/icons/faction/alliance.png" width="22" title="Alliance">',
		8  => '<img src="img/icons/faction/horde.png" width="22" title="Horde">',
		10 => '<img src="img/icons/faction/horde.png" width="22" title="Horde">',
		11 => '<img src="img/icons/faction/alliance.png" width="22" title="Alliance">'
	);

	function GrabCaptain($guid)
	{
		global $con_characters;

		$data = $con_characters->prepare('SELECT * FROM characters WHERE guid = :guid');
		$data->execute(array(
			':guid' => $guid
		));

		$result = $data->fetchAll(PDO::FETCH_ASSOC);		

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

		foreach($result as $row)
		{
			return '<a href="armory.php?character=' . $row['name'] . '"><span class="' . $classColor[$row['class']] . '">' . $row['name'] . '</span></a>';
		}
	}

	function GrabFaction($guid)
	{
		global $con_characters;

		$data = $con_characters->prepare('SELECT * FROM characters WHERE guid = :guid');
		$data->execute(array(
			':guid' => $guid
		));

		$result = $data->fetchAll(PDO::FETCH_ASSOC);

		foreach($result as $row)
		{
			return $row['race'];
		}
	}

	function GrabPlayerMMR($guid)
	{
		global $con_characters;

		$data = $con_characters->prepare('SELECT * FROM character_arena_stats WHERE guid = :guid');
		$data->execute(array(
			':guid' => $guid
		));

		$result = $data->fetchAll(PDO::FETCH_ASSOC);

		foreach($result as $row)
		{
			return $row['matchMakerRating'];
		}
	}

	function GrabPlayerInfo($column, $guid)
	{
		global $con_characters;

		$data = $con_characters->prepare('SELECT * FROM characters WHERE guid = :guid');
		$data->execute(array(
			':guid'   => $guid
		));

		$result = $data->fetchAll(PDO::FETCH_ASSOC);

		foreach($result as $row)
		{
			return $row[$column];
		}
	}

	function GrabTeamCaptain($guid)
	{
		global $con_characters;

		$data = $con_characters->prepare('SELECT COUNT(*) FROM arena_team WHERE captainGuid = :guid');
		$data->execute(array(
			':guid' => $guid
		));

		if($data->fetchColumn() == 1)
		{
			return ' <img src="img/icons/arena/captain.png" title="Captain">';
		}
		else
		{
			return false;
		}
	}

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
				return '< ' . $row['name'] . ' >';
			}
		}
	}

	if(isset($_GET['team']))
	{
		$id = (int)$_GET['team'];

		$data = $con_characters->prepare('SELECT COUNT(*) FROM arena_team WHERE arenaTeamId = :id');
		$data->execute(array(
			':id' => $id
		));

		if($data->fetchColumn() == 1)
		{
			$data = $con_characters->prepare('SELECT * FROM arena_team WHERE arenaTeamId = :id');
			$data->execute(array(
				':id' => $id
			));

			$result = $data->fetchAll(PDO::FETCH_ASSOC);

			echo '<div class="box column small-12">';

			foreach($result as $row)
			{
				$weekLoss   = $row['weekGames']-$row['weekWins'];
				$seasonLoss = $row['seasonGames']-$row['seasonWins'];

				echo '<div class="arena-header column small-12">
							' . $row['name'] . '
							<br>
							<span class="arena-subtext grey">Alliance ' . $row['type'] . 'v' . $row['type'] . ' Team</span>
						</div>

						<div class="arena-content column small-12">
							<table class="arena-table">
								<th>Statistics</th>
								<th>Games</th>
								<th>Wins</th>
								<th>Loss</th>
								<th>Team Rating</th>

								<tr>
									<td>Weekly</td>
									<td><span class="blue">' . $row['weekGames'] . '</span></td>
									<td><span class="green">' . $row['weekWins'] . '</span></td>
									<td><span class="red">' . $weekLoss . '</span></td>
									<td>' . $row['rating'] . '</td>
								</tr>
								<tr>
									<td>Season</td>
									<td><span class="blue">' . $row['seasonGames'] . '</span></td>
									<td><span class="green">' . $row['seasonWins'] . '</span></td>
									<td><span class="red">' . $seasonLoss . '</span></td>
									<td>' . $row['rating'] . '</td>
								</tr>
							</table>

							<br>';
			}

			$data = $con_characters->prepare('SELECT * FROM arena_team_member WHERE arenaTeamId = :id');
			$data->execute(array(
				':id' => $id
			));

			$result = $data-> fetchAll(PDO::FETCH_ASSOC);
			
			echo '<table class="arena-table">
					<th>Name</th>
					<th>Guild</th>
					<th>Race</th>
					<th>Class</th>
					<th>Faction</th>
					<th>Wins</th>
					<th>Games</th>
					<th>P-Rating</th>
					<th>MMR</th>';

			foreach($result as $row)
			{
				echo '<tr>
						<td><a href="armory.php?character=' . GrabPlayerInfo('name', $row['guid']) . '"><span class="' . $classColor[GrabPlayerInfo('class', $row['guid'])] . '">' . GrabPlayerInfo('name', $row['guid']) . '</span>' . GrabTeamCaptain($row['guid']) . '</a></td>
						<td><span class="green">' . GrabGuild($row['guid']) . '</span></td>
						<td><img src="' . $race[GrabPlayerInfo('race', $row['guid'])][GrabPlayerInfo('gender', $row['guid'])] . '" width="22"></td>
						<td><img src="' . $class[GrabPlayerInfo('class', $row['guid'])] . '" width="22"></td>
						<td>' . $faction[GrabPlayerInfo('race', $row['guid'])] . '</td>
						<td><span class="green">' . $row['seasonWins'] . '</span></td>
						<td><span class="blue">' . $row['seasonGames'] . '</span></td>
						<td>' . $row['personalRating'] . '</td>
						<td>' . GrabPlayerMMR($row['guid']) . '</td>
					</tr>';
			}

			echo '</table>
				</div>
			</div>';
		}
		else
		{
			echo '<script>
					setTimeout(function () {
					   window.location.href = "arenaladder.php";
					}, 0);
				</script>';
		}
	}
	else
	{
		if(isset($_GET['type']))
		{
			$id = (int)$_GET['type'];

			if($id == 3)
			{
				$page    = isset($_GET['page']) ? (int)$_GET['page'] : 1;
				$perPage = 15;

				$start = ($page > 1) ? ($page * $perPage) - $perPage : 0;

				$total = $con_characters->query('SELECT COUNT(*) FROM arena_team')->fetchColumn();
				$pages = ceil($total / $perPage);

				$rank = $start;

				$data = $con_characters->prepare('SELECT * FROM arena_team WHERE type = 3 ORDER BY rating DESC LIMIT ' . $start . ', ' . $perPage);
				$data->execute();

				echo '<div class="box column small-12 medium-12">
							<div class="content-tabs column small-12">
								<div class="content-tab column small-12 medium-3">
									<label><span class="orange">Arena Type</span></label>
									<a href="arenaladder.php" class="ladder-button">2v2</a>
									<a href="?type=3" class="ladder-button current">3v3</a>
									<a href="?type=5" class="ladder-button">5v5</a>
								</div>
							</div>
							<div class="box-content column small-12">
								<div class="pvp-box">
									<div class="pvp-box-header">
										Arena Ladder
									</div>

									<div class="pvp-box-content">
										<table>
											<th>#</th>
											<th>Arena Team</th>
											<th>Captain</th>
											<th>Faction</th>
											<th>Team Rating</th>
											<th>Season Games</th>
											<th>Season Wins</th>
											<th>Season Loses</th>';

				while($result = $data->fetchAll(PDO::FETCH_ASSOC))
				{
					foreach($result as $row)
					{
						$rank++;

						$loses = $row['seasonGames'] -  $row['seasonWins'];

						echo '<tr>
								<td>' . $rank . '</td>
								<td><span class="white"><a href="?team=' . $row['arenaTeamId'] . '">' . $row['name'] . '</a></span></td>
								<td>' . GrabCaptain($row['captainGuid']) . '</td>
								<td>' . $faction[GrabFaction($row['captainGuid'])] . '</td>
								<td>' . $row['rating'] . '</td>
								<td><span class="blue">' . $row['seasonGames'] . '</span></td>
								<td><span class="green">' . $row['seasonWins'] . '</span></td>
								<td><span class="red">' . $loses . '</span></td>
							</tr>';
					}
				}

				echo '				</table>
								</div>
							</div>
						</div>
					</div>';

				echo '<div class="navigation2 column small-12"><ul class="nav-menu">';

					echo '<li><a href="?page=1"><<</a></li>';
					
					$min = max($page - 2, 1);
					$max = min($page + 2, $pages);

					for($x = $min; $x <= $max; $x++)
					{
						if(@$page == $x)
						{
							echo '<li><a href="?page=' . $x . '" class="current-nav">' . $x . '</a></li>';
						}
						elseif(@!isset($page))
						{
							echo '<li><a href="?page=' . $x . '" class="current-nav">' . $x . '</a></li>';
						}
						else
						{
							echo '<li><a href="?page=' . $x . '">' . $x . '</a></li>';
						}
					}

					echo '<li><a href="?page=' . $pages . '">>></a></li>';

				echo '</ul></div>';
			}
			elseif($id == 5)
			{
				$page    = isset($_GET['page']) ? (int)$_GET['page'] : 1;
				$perPage = 15;

				$start = ($page > 1) ? ($page * $perPage) - $perPage : 0;

				$total = $con_characters->query('SELECT COUNT(*) FROM arena_team')->fetchColumn();
				$pages = ceil($total / $perPage);

				$rank = $start;

				$data = $con_characters->prepare('SELECT * FROM arena_team WHERE type = 5 ORDER BY rating DESC LIMIT ' . $start . ', ' . $perPage);
				$data->execute();

				echo '<div class="box column small-12 medium-12">
							<div class="content-tabs column small-12">
								<div class="content-tab column small-12 medium-3">
									<label><span class="orange">Arena Type</span></label>
									<a href="arenaladder.php" class="ladder-button">2v2</a>
									<a href="?type=3" class="ladder-button">3v3</a>
									<a href="?type=5" class="ladder-button current">5v5</a>
								</div>
							</div>
							<div class="box-content column small-12">
								<div class="pvp-box">
									<div class="pvp-box-header">
										Arena Ladder
									</div>

									<div class="pvp-box-content">
										<table>
											<th>#</th>
											<th>Arena Team</th>
											<th>Captain</th>
											<th>Faction</th>
											<th>Team Rating</th>
											<th>Season Games</th>
											<th>Season Wins</th>
											<th>Season Loses</th>';

				while($result = $data->fetchAll(PDO::FETCH_ASSOC))
				{
					foreach($result as $row)
					{
						$rank++;

						$loses = $row['seasonGames'] -  $row['seasonWins'];

						echo '<tr>
								<td>' . $rank . '</td>
								<td><span class="white"><a href="?team=' . $row['arenaTeamId'] . '">' . $row['name'] . '</a></span></td>
								<td>' . GrabCaptain($row['captainGuid']) . '</td>
								<td>' . $faction[GrabFaction($row['captainGuid'])] . '</td>
								<td>' . $row['rating'] . '</td>
								<td><span class="blue">' . $row['seasonGames'] . '</span></td>
								<td><span class="green">' . $row['seasonWins'] . '</span></td>
								<td><span class="red">' . $loses . '</span></td>
							</tr>';
					}
				}

				echo '				</table>
								</div>
							</div>
						</div>
					</div>';

				echo '<div class="navigation2 column small-12"><ul class="nav-menu">';

					echo '<li><a href="?page=1"><<</a></li>';
					
					$min = max($page - 2, 1);
					$max = min($page + 2, $pages);

					for($x = $min; $x <= $max; $x++)
					{
						if(@$page == $x)
						{
							echo '<li><a href="?page=' . $x . '" class="current-nav">' . $x . '</a></li>';
						}
						elseif(@!isset($page))
						{
							echo '<li><a href="?page=' . $x . '" class="current-nav">' . $x . '</a></li>';
						}
						else
						{
							echo '<li><a href="?page=' . $x . '">' . $x . '</a></li>';
						}
					}

					echo '<li><a href="?page=' . $pages . '">>></a></li>';

				echo '</ul></div>';
			}
			else
			{
				echo '<script>
					setTimeout(function () {
					   window.location.href = "arenaladder.php";
					}, 0);
				</script>';
			}
		}
		else
		{
			$page    = isset($_GET['page']) ? (int)$_GET['page'] : 1;
			$perPage = 15;

			$start = ($page > 1) ? ($page * $perPage) - $perPage : 0;

			$total = $con_characters->query('SELECT COUNT(*) FROM arena_team')->fetchColumn();
			$pages = ceil($total / $perPage);

			$rank = $start;

			$data = $con_characters->prepare('SELECT * FROM arena_team WHERE type = 2 ORDER BY rating DESC LIMIT ' . $start . ', ' . $perPage);
			$data->execute();

			echo '<div class="box column small-12 medium-12">
						<div class="content-tabs column small-12">
							<div class="content-tab column small-12 medium-3">
								<label><span class="orange">Arena Type</span></label>
								<a href="arenaladder.php" class="ladder-button current">2v2</a>
								<a href="?type=3" class="ladder-button">3v3</a>
								<a href="?type=5" class="ladder-button">5v5</a>
							</div>
						</div>
						<div class="box-content column small-12">
							<div class="pvp-box">
								<div class="pvp-box-header">
									Arena Ladder
								</div>

								<div class="pvp-box-content">
									<table>
										<th>#</th>
										<th>Arena Team</th>
										<th>Captain</th>
										<th>Faction</th>
										<th>Team Rating</th>
										<th>Season Games</th>
										<th>Season Wins</th>
										<th>Season Loses</th>';

			while($result = $data->fetchAll(PDO::FETCH_ASSOC))
			{
				foreach($result as $row)
				{
					$rank++;

					$loses = $row['seasonGames'] -  $row['seasonWins'];

					echo '<tr>
							<td>' . $rank . '</td>
							<td><span class="white"><a href="?team=' . $row['arenaTeamId'] . '">' . $row['name'] . '</a></span></td>
							<td>' . GrabCaptain($row['captainGuid']) . '</td>
							<td>' . $faction[GrabFaction($row['captainGuid'])] . '</td>
							<td>' . $row['rating'] . '</td>
							<td><span class="blue">' . $row['seasonGames'] . '</span></td>
							<td><span class="green">' . $row['seasonWins'] . '</span></td>
							<td><span class="red">' . $loses . '</span></td>
						</tr>';
				}
			}

			echo '				</table>
							</div>
						</div>
					</div>
				</div>';

			echo '<div class="navigation2 column small-12"><ul class="nav-menu">';

				echo '<li><a href="?page=1"><<</a></li>';
				
				$min = max($page - 2, 1);
				$max = min($page + 2, $pages);

				for($x = $min; $x <= $max; $x++)
				{
					if(@$page == $x)
					{
						echo '<li><a href="?page=' . $x . '" class="current-nav">' . $x . '</a></li>';
					}
					elseif(@!isset($page))
					{
						echo '<li><a href="?page=' . $x . '" class="current-nav">' . $x . '</a></li>';
					}
					else
					{
						echo '<li><a href="?page=' . $x . '">' . $x . '</a></li>';
					}
				}

				echo '<li><a href="?page=' . $pages . '">>></a></li>';

			echo '</ul></div>';
		}
	}
}

function GrabPvPHighscore()
{
	global $con_web;
	global $con_characters;

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

	if(isset($_GET['character']))
	{
		
	}

	if(isset($_GET['class']))
	{
		switch ($_GET['class'])
		{
			case 'warrior':
				$page    = isset($_GET['page']) ? (int)$_GET['page'] : 1;
				$perPage = 15;

				$start = ($page > 1) ? ($page * $perPage) - $perPage : 0;

				$total = $con_characters->query('SELECT COUNT(*) FROM characters WHERE class = 1')->fetchColumn();
				$pages = ceil($total / $perPage);

				$data = $con_characters->prepare('SELECT * FROM characters WHERE class = 1 ORDER BY totalKills DESC LIMIT ' . $start . ', ' . $perPage);
				$data->execute();

				$rank = $start;

				echo '<div class="box column small-12 medium-12">
						<div class="content-tabs column small-12">
							<div class="content-tab column small-12 medium-3">
								<label><span class="orange">Filter by Class</span></label>
								<a href="?class=warrior" class="current-selected"><img src="img/icons/class/warrior.png" width="26"></a>
								<a href="?class=paladin"><img src="img/icons/class/paladin.png" width="26"></a>
								<a href="?class=hunter"><img src="img/icons/class/hunter.png" width="26"></a>
								<a href="?class=rogue"><img src="img/icons/class/rogue.png" width="26"></a>
								<a href="?class=priest"><img src="img/icons/class/priest.png" width="26"></a>
								<a href="?class=deathknight"><img src="img/icons/class/deathknight.png" width="26"></a>
								<a href="?class=shaman"><img src="img/icons/class/shaman.png" width="26"></a>
								<a href="?class=mage"><img src="img/icons/class/mage.png" width="26"></a>
								<a href="?class=warlock"><img src="img/icons/class/warlock.png" width="26"></a>
								<a href="?class=druid"><img src="img/icons/class/druid.png" width="26"></a>
							</div>

							<div class="content-tab column small-12 medium-8 left">
								<label><span class="orange">Filter by Faction</span></label>
								<a href="?faction=alliance"><img src="img/icons/faction/alliance.jpg" width="26"></a>
								<a href="?faction=horde"><img src="img/icons/faction/horde.jpg" width="26"></a>
							</div>
						</div>

						<div class="box-content column small-12">
							<div class="pvp-box">
								<div class="pvp-box-header">
									PvP Ladder
								</div>

								<div class="pvp-box-content">
									<table>
										<th>#</th>
										<th>Character</th>
										<th>Race</th>
										<th>Class</th>
										<th>Level</th>
										<th>Honor Points</th>
										<th>Honor Kills</th>';

				while($result = $data->fetchAll(PDO::FETCH_ASSOC))
				{
					foreach($result as $row)
					{
						if(!empty($row['name']))
						{
							$rank++;

							echo '<tr>
									<td>' . $rank . '</td>
									<td><a href="armory.php?character=' . $row['name'] . '"><span class="' . $classColor[$row['class']] . '">' . $row['name'] . '</a></td>
									<td><img src="' . $race[$row['race']][$row['gender']] . '" width="22"></td>
									<td><img src="' . $class[$row['class']] . '" width="22"></td>
									<td><span class="orange">Level</span> ' . $row['level'] . '</td>
									<td>' . $row['totalHonorPoints'] . '</td>
									<td>' . $row['totalKills'] . '</td>
								</tr>';
						}
					}
				}

				echo '					</table>
									</div>
								</div>
							</div>
						</div>';

				echo '<div class="navigation2 column small-12"><ul class="nav-menu">';

					echo '<li><a href="?class=warrior&page=1"><<</a></li>';
					
					$min = max($page - 2, 1);
					$max = min($page + 2, $pages);

					for($x = $min; $x <= $max; $x++)
					{
						if(@$page == $x)
						{
							echo '<li><a href="?class=warrior&page=' . $x . '" class="current-nav">' . $x . '</a></li>';
						}
						elseif(@!isset($page))
						{
							echo '<li><a href="?class=warrior&page=' . $x . '" class="current-nav">' . $x . '</a></li>';
						}
						else
						{
							echo '<li><a href="?class=warrior&page=' . $x . '">' . $x . '</a></li>';
						}
					}

					echo '<li><a href="?class=warrior&page=' . $pages . '">>></a></li>';

				echo '</ul></div>';
				break;

			case 'paladin':
				$page    = isset($_GET['page']) ? (int)$_GET['page'] : 1;
				$perPage = 15;

				$start = ($page > 1) ? ($page * $perPage) - $perPage : 0;

				$total = $con_characters->query('SELECT COUNT(*) FROM characters WHERE class = 2')->fetchColumn();
				$pages = ceil($total / $perPage);

				$data = $con_characters->prepare('SELECT * FROM characters WHERE class = 2 ORDER BY totalKills DESC LIMIT ' . $start . ', ' . $perPage);
				$data->execute();

				$rank = $start;

				echo '<div class="box column small-12 medium-12">
						<div class="content-tabs column small-12">
							<div class="content-tab column small-12 medium-3">
								<label><span class="orange">Filter by Class</span></label>
								<a href="?class=warrior"><img src="img/icons/class/warrior.png" width="26"></a>
								<a href="?class=paladin" class="current-selected"><img src="img/icons/class/paladin.png" width="26"></a>
								<a href="?class=hunter"><img src="img/icons/class/hunter.png" width="26"></a>
								<a href="?class=rogue"><img src="img/icons/class/rogue.png" width="26"></a>
								<a href="?class=priest"><img src="img/icons/class/priest.png" width="26"></a>
								<a href="?class=deathknight"><img src="img/icons/class/deathknight.png" width="26"></a>
								<a href="?class=shaman"><img src="img/icons/class/shaman.png" width="26"></a>
								<a href="?class=mage"><img src="img/icons/class/mage.png" width="26"></a>
								<a href="?class=warlock"><img src="img/icons/class/warlock.png" width="26"></a>
								<a href="?class=druid"><img src="img/icons/class/druid.png" width="26"></a>
							</div>

							<div class="content-tab column small-12 medium-8 left">
								<label><span class="orange">Filter by Faction</span></label>
								<a href="?faction=alliance"><img src="img/icons/faction/alliance.jpg" width="26"></a>
								<a href="?faction=horde"><img src="img/icons/faction/horde.jpg" width="26"></a>
							</div>
						</div>

						<div class="box-content column small-12">
							<div class="pvp-box">
								<div class="pvp-box-header">
									PvP Ladder
								</div>

								<div class="pvp-box-content">
									<table>
										<th>#</th>
										<th>Character</th>
										<th>Race</th>
										<th>Class</th>
										<th>Level</th>
										<th>Honor Points</th>
										<th>Honor Kills</th>';

				while($result = $data->fetchAll(PDO::FETCH_ASSOC))
				{
					foreach($result as $row)
					{
						if(!empty($row['name']))
						{
							$rank++;

							echo '<tr>
									<td>' . $rank . '</td>
									<td><a href="armory.php?character=' . $row['name'] . '"><span class="' . $classColor[$row['class']] . '">' . $row['name'] . '</a></td>
									<td><img src="' . $race[$row['race']][$row['gender']] . '" width="22"></td>
									<td><img src="' . $class[$row['class']] . '" width="22"></td>
									<td><span class="orange">Level</span> ' . $row['level'] . '</td>
									<td>' . $row['totalHonorPoints'] . '</td>
									<td>' . $row['totalKills'] . '</td>
								</tr>';
						}
					}
				}

				echo '					</table>
									</div>
								</div>
							</div>
						</div>';

				echo '<div class="navigation2 column small-12"><ul class="nav-menu">';

					echo '<li><a href="?class=paladin&page=1"><<</a></li>';
					
					$min = max($page - 2, 1);
					$max = min($page + 2, $pages);

					for($x = $min; $x <= $max; $x++)
					{
						if(@$page == $x)
						{
							echo '<li><a href="?class=paladin&page=' . $x . '" class="current-nav">' . $x . '</a></li>';
						}
						elseif(@!isset($page))
						{
							echo '<li><a href="?class=paladin&page=' . $x . '" class="current-nav">' . $x . '</a></li>';
						}
						else
						{
							echo '<li><a href="?class=paladin&page=' . $x . '">' . $x . '</a></li>';
						}
					}

					echo '<li><a href="?class=paladin&page=' . $pages . '">>></a></li>';

				echo '</ul></div>';
				break;

			case 'hunter':
				$page    = isset($_GET['page']) ? (int)$_GET['page'] : 1;
				$perPage = 15;

				$start = ($page > 1) ? ($page * $perPage) - $perPage : 0;

				$total = $con_characters->query('SELECT COUNT(*) FROM characters WHERE class = 3')->fetchColumn();
				$pages = ceil($total / $perPage);

				$data = $con_characters->prepare('SELECT * FROM characters WHERE class = 3 ORDER BY totalKills DESC LIMIT ' . $start . ', ' . $perPage);
				$data->execute();

				$rank = $start;

				echo '<div class="box column small-12 medium-12">
						<div class="content-tabs column small-12">
							<div class="content-tab column small-12 medium-3">
								<label><span class="orange">Filter by Class</span></label>
								<a href="?class=warrior"><img src="img/icons/class/warrior.png" width="26"></a>
								<a href="?class=paladin"><img src="img/icons/class/paladin.png" width="26"></a>
								<a href="?class=hunter" class="current-selected"><img src="img/icons/class/hunter.png" width="26"></a>
								<a href="?class=rogue"><img src="img/icons/class/rogue.png" width="26"></a>
								<a href="?class=priest"><img src="img/icons/class/priest.png" width="26"></a>
								<a href="?class=deathknight"><img src="img/icons/class/deathknight.png" width="26"></a>
								<a href="?class=shaman"><img src="img/icons/class/shaman.png" width="26"></a>
								<a href="?class=mage"><img src="img/icons/class/mage.png" width="26"></a>
								<a href="?class=warlock"><img src="img/icons/class/warlock.png" width="26"></a>
								<a href="?class=druid"><img src="img/icons/class/druid.png" width="26"></a>
							</div>

							<div class="content-tab column small-12 medium-8 left">
								<label><span class="orange">Filter by Faction</span></label>
								<a href="?faction=alliance"><img src="img/icons/faction/alliance.jpg" width="26"></a>
								<a href="?faction=horde"><img src="img/icons/faction/horde.jpg" width="26"></a>
							</div>
						</div>

						<div class="box-content column small-12">
							<div class="pvp-box">
								<div class="pvp-box-header">
									PvP Ladder
								</div>

								<div class="pvp-box-content">
									<table>
										<th>#</th>
										<th>Character</th>
										<th>Race</th>
										<th>Class</th>
										<th>Level</th>
										<th>Honor Points</th>
										<th>Honor Kills</th>';

				while($result = $data->fetchAll(PDO::FETCH_ASSOC))
				{
					foreach($result as $row)
					{
						if(!empty($row['name']))
						{
							$rank++;

							echo '<tr>
									<td>' . $rank . '</td>
									<td><a href="armory.php?character=' . $row['name'] . '"><span class="' . $classColor[$row['class']] . '">' . $row['name'] . '</a></td>
									<td><img src="' . $race[$row['race']][$row['gender']] . '" width="22"></td>
									<td><img src="' . $class[$row['class']] . '" width="22"></td>
									<td><span class="orange">Level</span> ' . $row['level'] . '</td>
									<td>' . $row['totalHonorPoints'] . '</td>
									<td>' . $row['totalKills'] . '</td>
								</tr>';
						}
					}
				}

				echo '					</table>
									</div>
								</div>
							</div>
						</div>';

				echo '<div class="navigation2 column small-12"><ul class="nav-menu">';

					echo '<li><a href="?class=hunter&page=1"><<</a></li>';
					
					$min = max($page - 2, 1);
					$max = min($page + 2, $pages);

					for($x = $min; $x <= $max; $x++)
					{
						if(@$page == $x)
						{
							echo '<li><a href="?class=hunter&page=' . $x . '" class="current-nav">' . $x . '</a></li>';
						}
						elseif(@!isset($page))
						{
							echo '<li><a href="?class=hunter&page=' . $x . '" class="current-nav">' . $x . '</a></li>';
						}
						else
						{
							echo '<li><a href="?class=hunter&page=' . $x . '">' . $x . '</a></li>';
						}
					}

					echo '<li><a href="?class=hunter&page=' . $pages . '">>></a></li>';

				echo '</ul></div>';
				break;

			case 'rogue':
				$page    = isset($_GET['page']) ? (int)$_GET['page'] : 1;
				$perPage = 15;

				$start = ($page > 1) ? ($page * $perPage) - $perPage : 0;

				$total = $con_characters->query('SELECT COUNT(*) FROM characters WHERE class = 4')->fetchColumn();
				$pages = ceil($total / $perPage);

				$data = $con_characters->prepare('SELECT * FROM characters WHERE class = 4 ORDER BY totalKills DESC LIMIT ' . $start . ', ' . $perPage);
				$data->execute();

				$rank = $start;

				echo '<div class="box column small-12 medium-12">
						<div class="content-tabs column small-12">
							<div class="content-tab column small-12 medium-3">
								<label><span class="orange">Filter by Class</span></label>
								<a href="?class=warrior"><img src="img/icons/class/warrior.png" width="26"></a>
								<a href="?class=paladin"><img src="img/icons/class/paladin.png" width="26"></a>
								<a href="?class=hunter"><img src="img/icons/class/hunter.png" width="26"></a>
								<a href="?class=rogue" class="current-selected"><img src="img/icons/class/rogue.png" width="26"></a>
								<a href="?class=priest"><img src="img/icons/class/priest.png" width="26"></a>
								<a href="?class=deathknight"><img src="img/icons/class/deathknight.png" width="26"></a>
								<a href="?class=shaman"><img src="img/icons/class/shaman.png" width="26"></a>
								<a href="?class=mage"><img src="img/icons/class/mage.png" width="26"></a>
								<a href="?class=warlock"><img src="img/icons/class/warlock.png" width="26"></a>
								<a href="?class=druid"><img src="img/icons/class/druid.png" width="26"></a>
							</div>

							<div class="content-tab column small-12 medium-8 left">
								<label><span class="orange">Filter by Faction</span></label>
								<a href="?faction=alliance"><img src="img/icons/faction/alliance.jpg" width="26"></a>
								<a href="?faction=horde"><img src="img/icons/faction/horde.jpg" width="26"></a>
							</div>
						</div>

						<div class="box-content column small-12">
							<div class="pvp-box">
								<div class="pvp-box-header">
									PvP Ladder
								</div>

								<div class="pvp-box-content">
									<table>
										<th>#</th>
										<th>Character</th>
										<th>Race</th>
										<th>Class</th>
										<th>Level</th>
										<th>Honor Points</th>
										<th>Honor Kills</th>';

				while($result = $data->fetchAll(PDO::FETCH_ASSOC))
				{
					foreach($result as $row)
					{
						if(!empty($row['name']))
						{
							$rank++;

							echo '<tr>
									<td>' . $rank . '</td>
									<td><a href="armory.php?character=' . $row['name'] . '"><span class="' . $classColor[$row['class']] . '">' . $row['name'] . '</a></td>
									<td><img src="' . $race[$row['race']][$row['gender']] . '" width="22"></td>
									<td><img src="' . $class[$row['class']] . '" width="22"></td>
									<td><span class="orange">Level</span> ' . $row['level'] . '</td>
									<td>' . $row['totalHonorPoints'] . '</td>
									<td>' . $row['totalKills'] . '</td>
								</tr>';
						}
					}
				}

				echo '					</table>
									</div>
								</div>
							</div>
						</div>';

				echo '<div class="navigation2 column small-12"><ul class="nav-menu">';

					echo '<li><a href="?class=rogue&page=1"><<</a></li>';
					
					$min = max($page - 2, 1);
					$max = min($page + 2, $pages);

					for($x = $min; $x <= $max; $x++)
					{
						if(@$page == $x)
						{
							echo '<li><a href="?class=rogue&page=' . $x . '" class="current-nav">' . $x . '</a></li>';
						}
						elseif(@!isset($page))
						{
							echo '<li><a href="?class=rogue&page=' . $x . '" class="current-nav">' . $x . '</a></li>';
						}
						else
						{
							echo '<li><a href="?class=rogue&page=' . $x . '">' . $x . '</a></li>';
						}
					}

					echo '<li><a href="?class=rogue&page=' . $pages . '">>></a></li>';

				echo '</ul></div>';
				break;

			case 'priest':
				$page    = isset($_GET['page']) ? (int)$_GET['page'] : 1;
				$perPage = 15;

				$start = ($page > 1) ? ($page * $perPage) - $perPage : 0;

				$total = $con_characters->query('SELECT COUNT(*) FROM characters WHERE class = 5')->fetchColumn();
				$pages = ceil($total / $perPage);

				$data = $con_characters->prepare('SELECT * FROM characters WHERE class = 5 ORDER BY totalKills DESC LIMIT ' . $start . ', ' . $perPage);
				$data->execute();

				$rank = $start;

				echo '<div class="box column small-12 medium-12">
						<div class="content-tabs column small-12">
							<div class="content-tab column small-12 medium-3">
								<label><span class="orange">Filter by Class</span></label>
								<a href="?class=warrior"><img src="img/icons/class/warrior.png" width="26"></a>
								<a href="?class=paladin"><img src="img/icons/class/paladin.png" width="26"></a>
								<a href="?class=hunter"><img src="img/icons/class/hunter.png" width="26"></a>
								<a href="?class=rogue"><img src="img/icons/class/rogue.png" width="26"></a>
								<a href="?class=priest" class="current-selected"><img src="img/icons/class/priest.png" width="26"></a>
								<a href="?class=deathknight"><img src="img/icons/class/deathknight.png" width="26"></a>
								<a href="?class=shaman"><img src="img/icons/class/shaman.png" width="26"></a>
								<a href="?class=mage"><img src="img/icons/class/mage.png" width="26"></a>
								<a href="?class=warlock"><img src="img/icons/class/warlock.png" width="26"></a>
								<a href="?class=druid"><img src="img/icons/class/druid.png" width="26"></a>
							</div>

							<div class="content-tab column small-12 medium-8 left">
								<label><span class="orange">Filter by Faction</span></label>
								<a href="?faction=alliance"><img src="img/icons/faction/alliance.jpg" width="26"></a>
								<a href="?faction=horde"><img src="img/icons/faction/horde.jpg" width="26"></a>
							</div>
						</div>

						<div class="box-content column small-12">
							<div class="pvp-box">
								<div class="pvp-box-header">
									PvP Ladder
								</div>

								<div class="pvp-box-content">
									<table>
										<th>#</th>
										<th>Character</th>
										<th>Race</th>
										<th>Class</th>
										<th>Level</th>
										<th>Honor Points</th>
										<th>Honor Kills</th>';

				while($result = $data->fetchAll(PDO::FETCH_ASSOC))
				{
					foreach($result as $row)
					{
						if(!empty($row['name']))
						{
							$rank++;

							echo '<tr>
									<td>' . $rank . '</td>
									<td><a href="armory.php?character=' . $row['name'] . '"><span class="' . $classColor[$row['class']] . '">' . $row['name'] . '</a></td>
									<td><img src="' . $race[$row['race']][$row['gender']] . '" width="22"></td>
									<td><img src="' . $class[$row['class']] . '" width="22"></td>
									<td><span class="orange">Level</span> ' . $row['level'] . '</td>
									<td>' . $row['totalHonorPoints'] . '</td>
									<td>' . $row['totalKills'] . '</td>
								</tr>';
						}
					}
				}

				echo '					</table>
									</div>
								</div>
							</div>
						</div>';

				echo '<div class="navigation2 column small-12"><ul class="nav-menu">';

					echo '<li><a href="?class=priest&page=1"><<</a></li>';
					
					$min = max($page - 2, 1);
					$max = min($page + 2, $pages);

					for($x = $min; $x <= $max; $x++)
					{
						if(@$page == $x)
						{
							echo '<li><a href="?class=priest&page=' . $x . '" class="current-nav">' . $x . '</a></li>';
						}
						elseif(@!isset($page))
						{
							echo '<li><a href="?class=priest&page=' . $x . '" class="current-nav">' . $x . '</a></li>';
						}
						else
						{
							echo '<li><a href="?class=priest&page=' . $x . '">' . $x . '</a></li>';
						}
					}

					echo '<li><a href="?class=priest&page=' . $pages . '">>></a></li>';

				echo '</ul></div>';
				break;

			case 'deathknight':
				$page    = isset($_GET['page']) ? (int)$_GET['page'] : 1;
				$perPage = 15;

				$start = ($page > 1) ? ($page * $perPage) - $perPage : 0;

				$total = $con_characters->query('SELECT COUNT(*) FROM characters WHERE class = 6')->fetchColumn();
				$pages = ceil($total / $perPage);

				$data = $con_characters->prepare('SELECT * FROM characters WHERE class = 6 ORDER BY totalKills DESC LIMIT ' . $start . ', ' . $perPage);
				$data->execute();

				$rank = $start;

				echo '<div class="box column small-12 medium-12">
						<div class="content-tabs column small-12">
							<div class="content-tab column small-12 medium-3">
								<label><span class="orange">Filter by Class</span></label>
								<a href="?class=warrior"><img src="img/icons/class/warrior.png" width="26"></a>
								<a href="?class=paladin"><img src="img/icons/class/paladin.png" width="26"></a>
								<a href="?class=hunter"><img src="img/icons/class/hunter.png" width="26"></a>
								<a href="?class=rogue"><img src="img/icons/class/rogue.png" width="26"></a>
								<a href="?class=priest"><img src="img/icons/class/priest.png" width="26"></a>
								<a href="?class=deathknight" class="current-selected"><img src="img/icons/class/deathknight.png" width="26"></a>
								<a href="?class=shaman"><img src="img/icons/class/shaman.png" width="26"></a>
								<a href="?class=mage"><img src="img/icons/class/mage.png" width="26"></a>
								<a href="?class=warlock"><img src="img/icons/class/warlock.png" width="26"></a>
								<a href="?class=druid"><img src="img/icons/class/druid.png" width="26"></a>
							</div>

							<div class="content-tab column small-12 medium-8 left">
								<label><span class="orange">Filter by Faction</span></label>
								<a href="?faction=alliance"><img src="img/icons/faction/alliance.jpg" width="26"></a>
								<a href="?faction=horde"><img src="img/icons/faction/horde.jpg" width="26"></a>
							</div>
						</div>

						<div class="box-content column small-12">
							<div class="pvp-box">
								<div class="pvp-box-header">
									PvP Ladder
								</div>

								<div class="pvp-box-content">
									<table>
										<th>#</th>
										<th>Character</th>
										<th>Race</th>
										<th>Class</th>
										<th>Level</th>
										<th>Honor Points</th>
										<th>Honor Kills</th>';

				while($result = $data->fetchAll(PDO::FETCH_ASSOC))
				{
					foreach($result as $row)
					{
						if(!empty($row['name']))
						{
							$rank++;

							echo '<tr>
									<td>' . $rank . '</td>
									<td><a href="armory.php?character=' . $row['name'] . '"><span class="' . $classColor[$row['class']] . '">' . $row['name'] . '</a></td>
									<td><img src="' . $race[$row['race']][$row['gender']] . '" width="22"></td>
									<td><img src="' . $class[$row['class']] . '" width="22"></td>
									<td><span class="orange">Level</span> ' . $row['level'] . '</td>
									<td>' . $row['totalHonorPoints'] . '</td>
									<td>' . $row['totalKills'] . '</td>
								</tr>';
						}
					}
				}

				echo '					</table>
									</div>
								</div>
							</div>
						</div>';

				echo '<div class="navigation2 column small-12"><ul class="nav-menu">';

					echo '<li><a href="?class=deathknight&page=1"><<</a></li>';
					
					$min = max($page - 2, 1);
					$max = min($page + 2, $pages);

					for($x = $min; $x <= $max; $x++)
					{
						if(@$page == $x)
						{
							echo '<li><a href="?class=deathknight&page=' . $x . '" class="current-nav">' . $x . '</a></li>';
						}
						elseif(@!isset($page))
						{
							echo '<li><a href="?class=deathknight&page=' . $x . '" class="current-nav">' . $x . '</a></li>';
						}
						else
						{
							echo '<li><a href="?class=deathknight&page=' . $x . '">' . $x . '</a></li>';
						}
					}

					echo '<li><a href="?class=deathknight&page=' . $pages . '">>></a></li>';

				echo '</ul></div>';
				break;

			case 'shaman':
				$page    = isset($_GET['page']) ? (int)$_GET['page'] : 1;
				$perPage = 15;

				$start = ($page > 1) ? ($page * $perPage) - $perPage : 0;

				$total = $con_characters->query('SELECT COUNT(*) FROM characters WHERE class = 7')->fetchColumn();
				$pages = ceil($total / $perPage);

				$data = $con_characters->prepare('SELECT * FROM characters WHERE class = 7 ORDER BY totalKills DESC LIMIT ' . $start . ', ' . $perPage);
				$data->execute();

				$rank = $start;

				echo '<div class="box column small-12 medium-12">
						<div class="content-tabs column small-12">
							<div class="content-tab column small-12 medium-3">
								<label><span class="orange">Filter by Class</span></label>
								<a href="?class=warrior"><img src="img/icons/class/warrior.png" width="26"></a>
								<a href="?class=paladin"><img src="img/icons/class/paladin.png" width="26"></a>
								<a href="?class=hunter"><img src="img/icons/class/hunter.png" width="26"></a>
								<a href="?class=rogue"><img src="img/icons/class/rogue.png" width="26"></a>
								<a href="?class=priest"><img src="img/icons/class/priest.png" width="26"></a>
								<a href="?class=deathknight"><img src="img/icons/class/deathknight.png" width="26"></a>
								<a href="?class=shaman" class="current-selected"><img src="img/icons/class/shaman.png" width="26"></a>
								<a href="?class=mage"><img src="img/icons/class/mage.png" width="26"></a>
								<a href="?class=warlock"><img src="img/icons/class/warlock.png" width="26"></a>
								<a href="?class=druid"><img src="img/icons/class/druid.png" width="26"></a>
							</div>

							<div class="content-tab column small-12 medium-8 left">
								<label><span class="orange">Filter by Faction</span></label>
								<a href="?faction=alliance"><img src="img/icons/faction/alliance.jpg" width="26"></a>
								<a href="?faction=horde"><img src="img/icons/faction/horde.jpg" width="26"></a>
							</div>
						</div>

						<div class="box-content column small-12">
							<div class="pvp-box">
								<div class="pvp-box-header">
									PvP Ladder
								</div>

								<div class="pvp-box-content">
									<table>
										<th>#</th>
										<th>Character</th>
										<th>Race</th>
										<th>Class</th>
										<th>Level</th>
										<th>Honor Points</th>
										<th>Honor Kills</th>';

				while($result = $data->fetchAll(PDO::FETCH_ASSOC))
				{
					foreach($result as $row)
					{
						if(!empty($row['name']))
						{
							$rank++;

							echo '<tr>
									<td>' . $rank . '</td>
									<td><a href="armory.php?character=' . $row['name'] . '"><span class="' . $classColor[$row['class']] . '">' . $row['name'] . '</a></td>
									<td><img src="' . $race[$row['race']][$row['gender']] . '" width="22"></td>
									<td><img src="' . $class[$row['class']] . '" width="22"></td>
									<td><span class="orange">Level</span> ' . $row['level'] . '</td>
									<td>' . $row['totalHonorPoints'] . '</td>
									<td>' . $row['totalKills'] . '</td>
								</tr>';
						}
					}
				}

				echo '					</table>
									</div>
								</div>
							</div>
						</div>';

				echo '<div class="navigation2 column small-12"><ul class="nav-menu">';

					echo '<li><a href="?class=shaman&page=1"><<</a></li>';
					
					$min = max($page - 2, 1);
					$max = min($page + 2, $pages);

					for($x = $min; $x <= $max; $x++)
					{
						if(@$page == $x)
						{
							echo '<li><a href="?class=shaman&page=' . $x . '" class="current-nav">' . $x . '</a></li>';
						}
						elseif(@!isset($page))
						{
							echo '<li><a href="?class=shaman&page=' . $x . '" class="current-nav">' . $x . '</a></li>';
						}
						else
						{
							echo '<li><a href="?class=shaman&page=' . $x . '">' . $x . '</a></li>';
						}
					}

					echo '<li><a href="?class=shaman&page=' . $pages . '">>></a></li>';

				echo '</ul></div>';
				break;

			case 'mage':
				$page    = isset($_GET['page']) ? (int)$_GET['page'] : 1;
				$perPage = 15;

				$start = ($page > 1) ? ($page * $perPage) - $perPage : 0;

				$total = $con_characters->query('SELECT COUNT(*) FROM characters WHERE class = 8')->fetchColumn();
				$pages = ceil($total / $perPage);

				$data = $con_characters->prepare('SELECT * FROM characters WHERE class = 8 ORDER BY totalKills DESC LIMIT ' . $start . ', ' . $perPage);
				$data->execute();

				$rank = $start;

				echo '<div class="box column small-12 medium-12">
						<div class="content-tabs column small-12">
							<div class="content-tab column small-12 medium-3">
								<label><span class="orange">Filter by Class</span></label>
								<a href="?class=warrior"><img src="img/icons/class/warrior.png" width="26"></a>
								<a href="?class=paladin"><img src="img/icons/class/paladin.png" width="26"></a>
								<a href="?class=hunter"><img src="img/icons/class/hunter.png" width="26"></a>
								<a href="?class=rogue"><img src="img/icons/class/rogue.png" width="26"></a>
								<a href="?class=priest"><img src="img/icons/class/priest.png" width="26"></a>
								<a href="?class=deathknight"><img src="img/icons/class/deathknight.png" width="26"></a>
								<a href="?class=shaman"><img src="img/icons/class/shaman.png" width="26"></a>
								<a href="?class=mage" class="current-selected"><img src="img/icons/class/mage.png" width="26"></a>
								<a href="?class=warlock"><img src="img/icons/class/warlock.png" width="26"></a>
								<a href="?class=druid"><img src="img/icons/class/druid.png" width="26"></a>
							</div>

							<div class="content-tab column small-12 medium-8 left">
								<label><span class="orange">Filter by Faction</span></label>
								<a href="?faction=alliance"><img src="img/icons/faction/alliance.jpg" width="26"></a>
								<a href="?faction=horde"><img src="img/icons/faction/horde.jpg" width="26"></a>
							</div>
						</div>

						<div class="box-content column small-12">
							<div class="pvp-box">
								<div class="pvp-box-header">
									PvP Ladder
								</div>

								<div class="pvp-box-content">
									<table>
										<th>#</th>
										<th>Character</th>
										<th>Race</th>
										<th>Class</th>
										<th>Level</th>
										<th>Honor Points</th>
										<th>Honor Kills</th>';

				while($result = $data->fetchAll(PDO::FETCH_ASSOC))
				{
					foreach($result as $row)
					{
						if(!empty($row['name']))
						{
							$rank++;

							echo '<tr>
									<td>' . $rank . '</td>
									<td><a href="armory.php?character=' . $row['name'] . '"><span class="' . $classColor[$row['class']] . '">' . $row['name'] . '</a></td>
									<td><img src="' . $race[$row['race']][$row['gender']] . '" width="22"></td>
									<td><img src="' . $class[$row['class']] . '" width="22"></td>
									<td><span class="orange">Level</span> ' . $row['level'] . '</td>
									<td>' . $row['totalHonorPoints'] . '</td>
									<td>' . $row['totalKills'] . '</td>
								</tr>';
						}
					}
				}

				echo '					</table>
									</div>
								</div>
							</div>
						</div>';

				echo '<div class="navigation2 column small-12"><ul class="nav-menu">';

					echo '<li><a href="?class=mage&page=1"><<</a></li>';
					
					$min = max($page - 2, 1);
					$max = min($page + 2, $pages);

					for($x = $min; $x <= $max; $x++)
					{
						if(@$page == $x)
						{
							echo '<li><a href="?class=mage&page=' . $x . '" class="current-nav">' . $x . '</a></li>';
						}
						elseif(@!isset($page))
						{
							echo '<li><a href="?class=mage&page=' . $x . '" class="current-nav">' . $x . '</a></li>';
						}
						else
						{
							echo '<li><a href="?class=mage&page=' . $x . '">' . $x . '</a></li>';
						}
					}

					echo '<li><a href="?class=mage&page=' . $pages . '">>></a></li>';

				echo '</ul></div>';
				break;

			case 'warlock':
				$page    = isset($_GET['page']) ? (int)$_GET['page'] : 1;
				$perPage = 15;

				$start = ($page > 1) ? ($page * $perPage) - $perPage : 0;

				$total = $con_characters->query('SELECT COUNT(*) FROM characters WHERE class = 9')->fetchColumn();
				$pages = ceil($total / $perPage);

				$data = $con_characters->prepare('SELECT * FROM characters WHERE class = 9 ORDER BY totalKills DESC LIMIT ' . $start . ', ' . $perPage);
				$data->execute();

				$rank = $start;

				echo '<div class="box column small-12 medium-12">
						<div class="content-tabs column small-12">
							<div class="content-tab column small-12 medium-3">
								<label><span class="orange">Filter by Class</span></label>
								<a href="?class=warrior"><img src="img/icons/class/warrior.png" width="26"></a>
								<a href="?class=paladin"><img src="img/icons/class/paladin.png" width="26"></a>
								<a href="?class=hunter"><img src="img/icons/class/hunter.png" width="26"></a>
								<a href="?class=rogue"><img src="img/icons/class/rogue.png" width="26"></a>
								<a href="?class=priest"><img src="img/icons/class/priest.png" width="26"></a>
								<a href="?class=deathknight"><img src="img/icons/class/deathknight.png" width="26"></a>
								<a href="?class=shaman"><img src="img/icons/class/shaman.png" width="26"></a>
								<a href="?class=mage"><img src="img/icons/class/mage.png" width="26"></a>
								<a href="?class=warlock" class="current-selected"><img src="img/icons/class/warlock.png" width="26"></a>
								<a href="?class=druid"><img src="img/icons/class/druid.png" width="26"></a>
							</div>

							<div class="content-tab column small-12 medium-8 left">
								<label><span class="orange">Filter by Faction</span></label>
								<a href="?faction=alliance"><img src="img/icons/faction/alliance.jpg" width="26"></a>
								<a href="?faction=horde"><img src="img/icons/faction/horde.jpg" width="26"></a>
							</div>
						</div>

						<div class="box-content column small-12">
							<div class="pvp-box">
								<div class="pvp-box-header">
									PvP Ladder
								</div>

								<div class="pvp-box-content">
									<table>
										<th>#</th>
										<th>Character</th>
										<th>Race</th>
										<th>Class</th>
										<th>Level</th>
										<th>Honor Points</th>
										<th>Honor Kills</th>';

				while($result = $data->fetchAll(PDO::FETCH_ASSOC))
				{
					foreach($result as $row)
					{
						if(!empty($row['name']))
						{
							$rank++;

							echo '<tr>
									<td>' . $rank . '</td>
									<td><a href="armory.php?character=' . $row['name'] . '"><span class="' . $classColor[$row['class']] . '">' . $row['name'] . '</a></td>
									<td><img src="' . $race[$row['race']][$row['gender']] . '" width="22"></td>
									<td><img src="' . $class[$row['class']] . '" width="22"></td>
									<td><span class="orange">Level</span> ' . $row['level'] . '</td>
									<td>' . $row['totalHonorPoints'] . '</td>
									<td>' . $row['totalKills'] . '</td>
								</tr>';
						}
					}
				}

				echo '					</table>
									</div>
								</div>
							</div>
						</div>';

				echo '<div class="navigation2 column small-12"><ul class="nav-menu">';

					echo '<li><a href="?class=warlock&page=1"><<</a></li>';
					
					$min = max($page - 2, 1);
					$max = min($page + 2, $pages);

					for($x = $min; $x <= $max; $x++)
					{
						if(@$page == $x)
						{
							echo '<li><a href="?class=warlock&page=' . $x . '" class="current-nav">' . $x . '</a></li>';
						}
						elseif(@!isset($page))
						{
							echo '<li><a href="?class=warlock&page=' . $x . '" class="current-nav">' . $x . '</a></li>';
						}
						else
						{
							echo '<li><a href="?class=warlock&page=' . $x . '">' . $x . '</a></li>';
						}
					}

					echo '<li><a href="?class=warlock&page=' . $pages . '">>></a></li>';

				echo '</ul></div>';
				break;

			case 'druid':
				$page    = isset($_GET['page']) ? (int)$_GET['page'] : 1;
				$perPage = 15;

				$start = ($page > 1) ? ($page * $perPage) - $perPage : 0;

				$total = $con_characters->query('SELECT COUNT(*) FROM characters WHERE class = 11')->fetchColumn();
				$pages = ceil($total / $perPage);

				$data = $con_characters->prepare('SELECT * FROM characters WHERE class = 11 ORDER BY totalKills DESC LIMIT ' . $start . ', ' . $perPage);
				$data->execute();

				$rank = $start;

				echo '<div class="box column small-12 medium-12">
						<div class="content-tabs column small-12">
							<div class="content-tab column small-12 medium-3">
								<label><span class="orange">Filter by Class</span></label>
								<a href="?class=warrior"><img src="img/icons/class/warrior.png" width="26"></a>
								<a href="?class=paladin"><img src="img/icons/class/paladin.png" width="26"></a>
								<a href="?class=hunter"><img src="img/icons/class/hunter.png" width="26"></a>
								<a href="?class=rogue"><img src="img/icons/class/rogue.png" width="26"></a>
								<a href="?class=priest"><img src="img/icons/class/priest.png" width="26"></a>
								<a href="?class=deathknight"><img src="img/icons/class/deathknight.png" width="26"></a>
								<a href="?class=shaman"><img src="img/icons/class/shaman.png" width="26"></a>
								<a href="?class=mage"><img src="img/icons/class/mage.png" width="26"></a>
								<a href="?class=warlock"><img src="img/icons/class/warlock.png" width="26"></a>
								<a href="?class=druid" class="current-selected"><img src="img/icons/class/druid.png" width="26"></a>
							</div>

							<div class="content-tab column small-12 medium-8 left">
								<label><span class="orange">Filter by Faction</span></label>
								<a href="?faction=alliance"><img src="img/icons/faction/alliance.jpg" width="26"></a>
								<a href="?faction=horde"><img src="img/icons/faction/horde.jpg" width="26"></a>
							</div>
						</div>

						<div class="box-content column small-12">
							<div class="pvp-box">
								<div class="pvp-box-header">
									PvP Ladder
								</div>

								<div class="pvp-box-content">
									<table>
										<th>#</th>
										<th>Character</th>
										<th>Race</th>
										<th>Class</th>
										<th>Level</th>
										<th>Honor Points</th>
										<th>Honor Kills</th>';

				while($result = $data->fetchAll(PDO::FETCH_ASSOC))
				{
					foreach($result as $row)
					{
						if(!empty($row['name']))
						{
							$rank++;

							echo '<tr>
									<td>' . $rank . '</td>
									<td><a href="armory.php?character=' . $row['name'] . '"><span class="' . $classColor[$row['class']] . '">' . $row['name'] . '</a></td>
									<td><img src="' . $race[$row['race']][$row['gender']] . '" width="22"></td>
									<td><img src="' . $class[$row['class']] . '" width="22"></td>
									<td><span class="orange">Level</span> ' . $row['level'] . '</td>
									<td>' . $row['totalHonorPoints'] . '</td>
									<td>' . $row['totalKills'] . '</td>
								</tr>';
						}
					}
				}

				echo '					</table>
									</div>
								</div>
							</div>
						</div>';

				echo '<div class="navigation2 column small-12"><ul class="nav-menu">';

					echo '<li><a href="?class=druid&page=1"><<</a></li>';
					
					$min = max($page - 2, 1);
					$max = min($page + 2, $pages);

					for($x = $min; $x <= $max; $x++)
					{
						if(@$page == $x)
						{
							echo '<li><a href="?class=druid&page=' . $x . '" class="current-nav">' . $x . '</a></li>';
						}
						elseif(@!isset($page))
						{
							echo '<li><a href="?class=druid&page=' . $x . '" class="current-nav">' . $x . '</a></li>';
						}
						else
						{
							echo '<li><a href="?class=druid&page=' . $x . '">' . $x . '</a></li>';
						}
					}

					echo '<li><a href="?class=druid&page=' . $pages . '">>></a></li>';

				echo '</ul></div>';
				break;

				default:
					header('Location: pvpladder.php');
					break;
		}

	}
	elseif(isset($_GET['faction']))
	{
		switch($_GET['faction'])
		{
			case 'alliance':
				$page    = isset($_GET['page']) ? (int)$_GET['page'] : 1;
				$perPage = 15;

				$start = ($page > 1) ? ($page * $perPage) - $perPage : 0;

				$total = $con_characters->query('SELECT COUNT(*) FROM characters WHERE race in (1,3,4,7,11)')->fetchColumn();
				$pages = ceil($total / $perPage);

				$data = $con_characters->prepare('SELECT * FROM characters WHERE race in (1,3,4,7,11) ORDER BY totalKills DESC LIMIT ' . $start . ', ' . $perPage);
				$data->execute();

				$rank = $start;

				echo '<div class="box column small-12 medium-12">
						<div class="content-tabs column small-12">
							<div class="content-tab column small-12 medium-3">
								<label><span class="orange">Filter by Class</span></label>
								<a href="?class=warrior"><img src="img/icons/class/warrior.png" width="26"></a>
								<a href="?class=paladin"><img src="img/icons/class/paladin.png" width="26"></a>
								<a href="?class=hunter"><img src="img/icons/class/hunter.png" width="26"></a>
								<a href="?class=rogue"><img src="img/icons/class/rogue.png" width="26"></a>
								<a href="?class=priest"><img src="img/icons/class/priest.png" width="26"></a>
								<a href="?class=deathknight"><img src="img/icons/class/deathknight.png" width="26"></a>
								<a href="?class=shaman"><img src="img/icons/class/shaman.png" width="26"></a>
								<a href="?class=mage"><img src="img/icons/class/mage.png" width="26"></a>
								<a href="?class=warlock"><img src="img/icons/class/warlock.png" width="26"></a>
								<a href="?class=druid"><img src="img/icons/class/druid.png" width="26"></a>
							</div>

							<div class="content-tab column small-12 medium-8 left">
								<label><span class="orange">Filter by Faction</span></label>
								<a href="?faction=alliance" class="current-selected"><img src="img/icons/faction/alliance.jpg" width="26"></a>
								<a href="?faction=horde"><img src="img/icons/faction/horde.jpg" width="26"></a>
							</div>
						</div>

						<div class="box-content column small-12">
							<div class="pvp-box">
								<div class="pvp-box-header">
									PvP Ladder
								</div>

								<div class="pvp-box-content">
									<table>
										<th>#</th>
										<th>Character</th>
										<th>Race</th>
										<th>Class</th>
										<th>Level</th>
										<th>Honor Points</th>
										<th>Honor Kills</th>';

				while($result = $data->fetchAll(PDO::FETCH_ASSOC))
				{
					foreach($result as $row)
					{
						if(!empty($row['name']))
						{
							$rank++;

							echo '<tr>
									<td>' . $rank . '</td>
									<td><a href="armory.php?character=' . $row['name'] . '"><span class="' . $classColor[$row['class']] . '">' . $row['name'] . '</a></td>
									<td><img src="' . $race[$row['race']][$row['gender']] . '" width="22"></td>
									<td><img src="' . $class[$row['class']] . '" width="22"></td>
									<td><span class="orange">Level</span> ' . $row['level'] . '</td>
									<td>' . $row['totalHonorPoints'] . '</td>
									<td>' . $row['totalKills'] . '</td>
								</tr>';
						}
					}
				}

				echo '					</table>
									</div>
								</div>
							</div>
						</div>';

				echo '<div class="navigation2 column small-12"><ul class="nav-menu">';

					echo '<li><a href="?faction=alliance&page=1"><<</a></li>';
					
					$min = max($page - 2, 1);
					$max = min($page + 2, $pages);

					for($x = $min; $x <= $max; $x++)
					{
						if(@$page == $x)
						{
							echo '<li><a href="?faction=alliance&page=' . $x . '" class="current-nav">' . $x . '</a></li>';
						}
						elseif(@!isset($page))
						{
							echo '<li><a href="?faction=alliance&page=' . $x . '" class="current-nav">' . $x . '</a></li>';
						}
						else
						{
							echo '<li><a href="?faction=alliance&page=' . $x . '">' . $x . '</a></li>';
						}
					}

					echo '<li><a href="?faction=alliance&page=' . $pages . '">>></a></li>';

				echo '</ul></div>';
				break;

			case 'horde':
				$page    = isset($_GET['page']) ? (int)$_GET['page'] : 1;
				$perPage = 15;

				$start = ($page > 1) ? ($page * $perPage) - $perPage : 0;

				$total = $con_characters->query('SELECT COUNT(*) FROM characters WHERE race in (2,5,6,8,10)')->fetchColumn();
				$pages = ceil($total / $perPage);

				$data = $con_characters->prepare('SELECT * FROM characters WHERE race in (2,5,6,8,10) ORDER BY totalKills DESC LIMIT ' . $start . ', ' . $perPage);
				$data->execute();

				$rank = $start;

				echo '<div class="box column small-12 medium-12">
						<div class="content-tabs column small-12">
							<div class="content-tab column small-12 medium-3">
								<label><span class="orange">Filter by Class</span></label>
								<a href="?class=warrior"><img src="img/icons/class/warrior.png" width="26"></a>
								<a href="?class=paladin"><img src="img/icons/class/paladin.png" width="26"></a>
								<a href="?class=hunter"><img src="img/icons/class/hunter.png" width="26"></a>
								<a href="?class=rogue"><img src="img/icons/class/rogue.png" width="26"></a>
								<a href="?class=priest"><img src="img/icons/class/priest.png" width="26"></a>
								<a href="?class=deathknight"><img src="img/icons/class/deathknight.png" width="26"></a>
								<a href="?class=shaman"><img src="img/icons/class/shaman.png" width="26"></a>
								<a href="?class=mage"><img src="img/icons/class/mage.png" width="26"></a>
								<a href="?class=warlock"><img src="img/icons/class/warlock.png" width="26"></a>
								<a href="?class=druid"><img src="img/icons/class/druid.png" width="26"></a>
							</div>

							<div class="content-tab column small-12 medium-8 left">
								<label><span class="orange">Filter by Faction</span></label>
								<a href="?faction=alliance"><img src="img/icons/faction/alliance.jpg" width="26"></a>
								<a href="?faction=horde" class="current-selected"><img src="img/icons/faction/horde.jpg" width="26"></a>
							</div>
						</div>

						<div class="box-content column small-12">
							<div class="pvp-box">
								<div class="pvp-box-header">
									PvP Ladder
								</div>

								<div class="pvp-box-content">
									<table>
										<th>#</th>
										<th>Character</th>
										<th>Race</th>
										<th>Class</th>
										<th>Level</th>
										<th>Honor Points</th>
										<th>Honor Kills</th>';

				while($result = $data->fetchAll(PDO::FETCH_ASSOC))
				{
					foreach($result as $row)
					{
						if(!empty($row['name']))
						{
							$rank++;

							echo '<tr>
									<td>' . $rank . '</td>
									<td><a href="armory.php?character=' . $row['name'] . '"><span class="' . $classColor[$row['class']] . '">' . $row['name'] . '</a></td>
									<td><img src="' . $race[$row['race']][$row['gender']] . '" width="22"></td>
									<td><img src="' . $class[$row['class']] . '" width="22"></td>
									<td><span class="orange">Level</span> ' . $row['level'] . '</td>
									<td>' . $row['totalHonorPoints'] . '</td>
									<td>' . $row['totalKills'] . '</td>
								</tr>';
						}
					}
				}

				echo '					</table>
									</div>
								</div>
							</div>
						</div>';

				echo '<div class="navigation2 column small-12"><ul class="nav-menu">';

					echo '<li><a href="?faction=horde&page=1"><<</a></li>';
					
					$min = max($page - 2, 1);
					$max = min($page + 2, $pages);

					for($x = $min; $x <= $max; $x++)
					{
						if(@$page == $x)
						{
							echo '<li><a href="?faction=horde&page=' . $x . '" class="current-nav">' . $x . '</a></li>';
						}
						elseif(@!isset($page))
						{
							echo '<li><a href="?faction=horde&page=' . $x . '" class="current-nav">' . $x . '</a></li>';
						}
						else
						{
							echo '<li><a href="?faction=horde&page=' . $x . '">' . $x . '</a></li>';
						}
					}

					echo '<li><a href="?faction=horde&page=' . $pages . '">>></a></li>';

				echo '</ul></div>';
				break;

			default:
				header('Location: pvpladder.php');
				break;
		}
	}
	else
	{
		$page    = isset($_GET['page']) ? (int)$_GET['page'] : 1;
		$perPage = 15;

		$start = ($page > 1) ? ($page * $perPage) - $perPage : 0;

		$total = $con_characters->query('SELECT COUNT(*) FROM characters')->fetchColumn();
		$pages = ceil($total / $perPage);

		$data = $con_characters->prepare('SELECT * FROM characters ORDER BY totalKills DESC LIMIT ' . $start . ', ' . $perPage);
		$data->execute();

		$rank = $start;

		echo '<div class="box column small-12 medium-12">
				<div class="content-tabs column small-12">
					<div class="content-tab column small-12 medium-3">
						<label><span class="orange">Filter by Class</span></label>
						<a href="?class=warrior"><img src="img/icons/class/warrior.png" width="26"></a>
						<a href="?class=paladin"><img src="img/icons/class/paladin.png" width="26"></a>
						<a href="?class=hunter"><img src="img/icons/class/hunter.png" width="26"></a>
						<a href="?class=rogue"><img src="img/icons/class/rogue.png" width="26"></a>
						<a href="?class=priest"><img src="img/icons/class/priest.png" width="26"></a>
						<a href="?class=deathknight"><img src="img/icons/class/deathknight.png" width="26"></a>
						<a href="?class=shaman"><img src="img/icons/class/shaman.png" width="26"></a>
						<a href="?class=mage"><img src="img/icons/class/mage.png" width="26"></a>
						<a href="?class=warlock"><img src="img/icons/class/warlock.png" width="26"></a>
						<a href="?class=druid"><img src="img/icons/class/druid.png" width="26"></a>
					</div>

					<div class="content-tab column small-12 medium-8 left">
						<label><span class="orange">Filter by Faction</span></label>
						<a href="?faction=alliance"><img src="img/icons/faction/alliance.jpg" width="26"></a>
						<a href="?faction=horde"><img src="img/icons/faction/horde.jpg" width="26"></a>
					</div>
				</div>

				<div class="content-search column small-12">
					<!--<form method="GET">
						<label><span class="orange">Search</span></label>
						<input type="text" name="search" placeholder="Character.." />
					</form>-->
				</div>

				<div class="box-content column small-12">
					<div class="pvp-box">
						<div class="pvp-box-header">
							PvP Ladder
						</div>

						<div class="pvp-box-content">
							<table>
								<th>#</th>
								<th>Character</th>
								<th>Race</th>
								<th>Class</th>
								<th>Level</th>
								<th>Honor Points</th>
								<th>Honor Kills</th>';

		while($result = $data->fetchAll(PDO::FETCH_ASSOC))
		{
			foreach($result as $row)
			{
				if(!empty($row['name']))
				{
					$rank++;

					echo '<tr>
							<td>' . $rank . '</td>
							<td><a href="armory.php?character=' . $row['name'] . '"><span class="' . $classColor[$row['class']] . '">' . $row['name'] . '</a></td>
							<td><img src="' . $race[$row['race']][$row['gender']] . '" width="22"></td>
							<td><img src="' . $class[$row['class']] . '" width="22"></td>
							<td><span class="orange">Level</span> ' . $row['level'] . '</td>
							<td>' . $row['totalHonorPoints'] . '</td>
							<td>' . $row['totalKills'] . '</td>
						</tr>';
				}
			}
		}

		echo '					</table>
							</div>
						</div>
					</div>
				</div>';

		echo '<div class="navigation2 column small-12"><ul class="nav-menu">';

			echo '<li><a href="?page=1"><<</a></li>';
			
			$min = max($page - 2, 1);
			$max = min($page + 2, $pages);

			for($x = $min; $x <= $max; $x++)
			{
				if(@$page == $x)
				{
					echo '<li><a href="?page=' . $x . '" class="current-nav">' . $x . '</a></li>';
				}
				elseif(@!isset($page))
				{
					echo '<li><a href="?page=' . $x . '" class="current-nav">' . $x . '</a></li>';
				}
				else
				{
					echo '<li><a href="?page=' . $x . '">' . $x . '</a></li>';
				}
			}

			echo '<li><a href="?page=' . $pages . '">>></a></li>';

		echo '</ul></div>';
	}
}


























?>