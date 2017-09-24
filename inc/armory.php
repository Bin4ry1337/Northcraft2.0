<?php

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

function Armory()
{
	if(isset($_GET['page']))
	{
		global $con_characters;

		$name = ucfirst($_GET['character']);

		$page    = isset($_GET['page']) ? (int)$_GET['page'] : 1;
		$perPage = 10;

		$start = ($page > 1) ? ($page * $perPage) - $perPage : 0;

		$data = $con_characters->prepare('SELECT * FROM characters WHERE name LIKE ? LIMIT ' . $start . ', ' . $perPage);
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
	else
	{
		if(isset($_GET['character']))
		{
			function GrabItemQuality($id)
			{
				global $con_world;

				$data = $con_world->prepare('SELECT * FROM item_template WHERE entry = :id');
				$data->execute(array(
					':id' => $id
				));

				$result = $data->fetchAll(PDO::FETCH_ASSOC);

				foreach($result as $row)
				{
					return $row['Quality'];
				}
			}

			$Quality = array(
				0 => '#888',
				1 => '#CCC',
				2 => '#1eff00',
				3 => '#0070ff',
				4 => '#a335ee',
				5 => '#ff8000',
				6 => '#e6cc80',
				7 => '#e6cc80'
			);

			global $con_characters;

			$name = ucfirst(strtolower($_GET['character']));

			$data = $con_characters->prepare('SELECT COUNT(*) FROM characters WHERE name = :name');
			$data->execute(array(
				':name' => $name
			));

			if($data->fetchColumn() == 1)
			{
				$data = $con_characters->prepare('SELECT * FROM characters WHERE name = :name');
				$data->execute(array(
					':name' => $name
				));

				$result = $data->fetchAll(PDO::FETCH_ASSOC);

				foreach($result as $row)
				{
					$items = explode(' ', $row['equipmentCache']);

					$equipment = array(
						'HEAD'     => $items[0],
						'NECK'     => $items[2],
						'SHOULDER' => $items[4],
						'SHIRT'    => $items[6],
						'CHEST'    => $items[8],
						'WAIST'    => $items[10],
						'LEGS'     => $items[12],
						'FEET'     => $items[14],
						'WRIST'    => $items[16],
						'HANDS'    => $items[18],
						'RING1'    => $items[20],
						'RING2'    => $items[22],
						'TRINKET1' => $items[24],
						'TRINKET2' => $items[26],
						'CLOAK'    => $items[28],
						'MAINHAND' => $items[30],
						'OFFHAND'  => $items[32],
						'RANGED'   => $items[34],
						'TABARD'   => $items[36]
					);

					$race = array(
						1  => 'Human',
						2  => 'Orc',
						3  => 'Dwarf',
						4  => 'Night Elf',
						5  => 'Undead',
						6  => 'Tauren',
						7  => 'Gnome',
						8  => 'Troll',
						10 => 'Blood Elf',
						11 => 'Draenei'
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

					if(!empty(GrabGuild($row['guid'])))
					{
						$guild = '<span class="green">< ' . GrabGuild($row['guid']) . ' ></span>';
					}
					else
					{
						$guild = '';
					}

					function Enchantments($guid, $slot)
					{
						global $con_characters;

						$ench = $con_characters->prepare('SELECT * FROM item_instance WHERE owner_guid = :guid AND itemEntry = :item');
						$ench->execute(array(
							':guid' => $guid,
							':item' => $slot
						));

						$result = $ench->fetchAll(PDO::FETCH_ASSOC);

						foreach($result as $enchant)
						{
							$attachment = explode(" ", $enchant['enchantments']);

							$attach = array(
								'ENCHANT'    => $attachment[0],
								'GEM1'       => $attachment[6],
								'GEM2'       => $attachment[9],
								'GEM3'       => $attachment[12],
								'ENCHANT2'   => $attachment[18]
							);

							if($attach['ENCHANT'] == 1)
							{
								$enchant = $attach['ENCHANT'];
							}
							elseif($attach['ENCHANT'] == 0)
							{
								$enchant = '';
							}
							else
							{
								$enchant = $attach['ENCHANT'];
							}

							return 'ench=' . $enchant . ';gems=' . $attach['GEM1'] . ':' . $attach['GEM2'] . ':' . $attach['GEM3'];
						}
					}

					function GrabItemName($id)
					{
						global $con_world;

						$data = $con_world->prepare('SELECT * FROM item_template WHERE entry = :id');
						$data->execute(array(
							':id' => $id
						));

						$result = $data->fetchAll(PDO::FETCH_ASSOC);

						foreach($result as $row)
						{
							return $row['name'];
						}
					}

					function GrabItemLevel($id)
					{
						global $con_world;

						$data = $con_world->prepare('SELECT * FROM item_template WHERE entry = :id');
						$data->execute(array(
							':id' => $id
						));

						$result = $data->fetchAll(PDO::FETCH_ASSOC);

						foreach($result as $row)
						{
							return $row['ItemLevel'];
						}
					}

					function Enchantment($guid, $slot)
					{
						global $con_characters;

						$ench = $con_characters->prepare('SELECT * FROM item_instance WHERE owner_guid = :guid AND itemEntry = :item');
						$ench->execute(array(
							':guid' => $guid,
							':item' => $slot
						));

						$result = $ench->fetchAll(PDO::FETCH_ASSOC);

						foreach($result as $enchant)
						{
							$attachment = explode(" ", $enchant['enchantments']);

							$attach = array(
								'ENCHANT'    => $attachment[0],
								'GEM1'       => $attachment[6],
								'GEM2'       => $attachment[9],
								'GEM3'       => $attachment[12],
								'ENCHANT2'   => $attachment[18]
							);

							if($attach['ENCHANT'] == 1)
							{
								$enchant = $attach['ENCHANT'];
							}
							elseif($attach['ENCHANT'] == 0)
							{
								$enchant = '';
							}
							else
							{
								$enchant = $attach['ENCHANT'];
							}

							return $enchant;
						}
					}

					function GrabEnchantSpell($id)
					{
						global $con_web;

						$data = $con_web->prepare('SELECT * FROM spell WHERE field110 = :id');
						$data->execute(array(
							':id' => $id
						));

						$result = $data->fetchAll(PDO::FETCH_ASSOC);

						foreach($result as $row)
						{
							return $row['id'];
						}

					}

					function GrabEnchantName($id)
					{
						global $con_web;

						$data = $con_web->prepare('SELECT * FROM spell WHERE field110 = :id');
						$data->execute(array(
							':id' => $id
						));

						$result = $data->fetchAll(PDO::FETCH_ASSOC);

						foreach($result as $row)
						{
							return $row['field136'];
						}

					}

					function GrabCharStats($id, $column)
					{
						global $con_characters;

						$data = $con_characters->prepare('SELECT * FROM character_stats WHERE guid = :id');
						$data->execute(array(
							':id' => $id
						));

						$result = $data->fetchAll(PDO::FETCH_ASSOC);

						foreach($result as $row)
						{
							return $row[$column];
						}
					}

					function GrabCharSkill($id, $skill)
					{
						global $con_characters;

						$data = $con_characters->prepare('SELECT * FROM character_skills WHERE guid = :id AND skill = :skill');
						$data->execute(array(
							':id'    => $id,
							':skill' => $skill
						));

						$result = $data->fetchAll(PDO::FETCH_ASSOC);

						foreach($result as $row)
						{
							return $row['value'];
						}
					}

					$raceAvatar = array(
						1  => array(
								0 => 'img/icons/avatars/human-male.png',
								1 => 'img/icons/avatars/human-female.png'
						),
						2  => array(
								0 => 'img/icons/avatars/orc-male.png',
								1 => 'img/icons/avatars/orc-female.png'
						),
						3  => array(
								0 => 'img/icons/avatars/dwarf-male.png',
								1 => 'img/icons/avatars/dwarf-female.png'
						),
						4  => array(
								0 => 'img/icons/avatars/nightelf-male.png',
								1 => 'img/icons/avatars/nightelf-female.png'
						),
						5  => array(
								0 => 'img/icons/avatars/undead-male.png',
								1 => 'img/icons/avatars/undead-female.png'
						),
						6  => array(
								0 => 'img/icons/avatars/tauren-male.png',
								1 => 'img/icons/avatars/tauren-female.png'
						),
						7  => array(
								0 => 'img/icons/avatars/gnome-male.png',
								1 => 'img/icons/avatars/gnome-female.png'
						),
						8  => array(
								0 => 'img/icons/avatars/troll-male.png',
								1 => 'img/icons/avatars/troll-female.png'
						),
						10 => array(
								0 => 'img/icons/avatars/bloodelf-male.png',
								1 => 'img/icons/avatars/bloodelf-female.png'
						),
						11 => array(
								0 => 'img/icons/avatars/draenei-male.png',
								1 => 'img/icons/avatars/draenei-female.png'
						)
					);
					
					echo '<div class="character-info-box column small-12">
							<div class="character-avatar column show-for-large large-1">
								<img src="' . $raceAvatar[$row['race']][$row['gender']] . '" width="70">
							</div>

							<div class="character-info column small-12 medium-12 large-11">
								<div class="character-name">
									<span class="' . $classColor[$row['class']] . '">' . $row['name'] . '</span>
								</div>

								<div class="character-guild">
									' . $guild . '
								</div>
							</div>

							<div class="character-info2 column small-12 medium-12 large-11">
								<div class="character-level">
									<span class="orange">Level</span> ' . $row['level'] . ' -
								</div>

								<div class="character-race">
									' . $race[$row['race']] . '
								</div>

								<div class="character-class">
									<span class="' . $classColor[$row['class']] . '">' . ucfirst($classColor[$row['class']]) . '</span>
								</div>
							</div>
						</div>
						' . /*'
						<div class="character-box column small-12 medium-12">
							<div class="character-items column medium-12 large-5 show-for-large">
								<div class="character-items-box-left">
									<div class="item-left head" style="border-color: ' . @$Quality[GrabItemQuality($equipment['HEAD'])] . ';">
										<a href="http://db.rising-gods.de/?item=' . @$equipment['HEAD'] . '" rel="' . Enchantments($row['guid'], $equipment['HEAD']) . '"></a>
									</div>

									<div class="item-left neck" style="border-color: ' . @$Quality[GrabItemQuality($equipment['NECK'])] . ';">
										<a href="https://db.rising-gods.de/?item=' . @$equipment['NECK'] . '" rel="' . Enchantments($row['guid'], $equipment['NECK']) . '"></a>
									</div>

									<div class="item-left shoulder" style="border-color: ' . @$Quality[GrabItemQuality($equipment['SHOULDER'])] . ';">
										<a href="https://db.rising-gods.de/?item=' . @$equipment['SHOULDER'] . '" rel="' . Enchantments($row['guid'], $equipment['SHOULDER']) . '"></a>
									</div>

									<div class="item-left cloak" style="border-color: ' . @$Quality[GrabItemQuality($equipment['CLOAK'])] . ';">
										<a href="https://db.rising-gods.de/?item=' . @$equipment['CLOAK'] . '" rel="' . Enchantments($row['guid'], $equipment['CLOAK']) . '"></a>
									</div>

									<div class="item-left chest" style="border-color: ' . @$Quality[GrabItemQuality($equipment['CHEST'])] . ';">
										<a href="https://db.rising-gods.de/?item=' . @$equipment['CHEST'] . '" rel="' . Enchantments($row['guid'], $equipment['CHEST']) . '"></a>
									</div>

									<div class="item-left shirt" style="border-color: ' . @$Quality[GrabItemQuality($equipment['SHIRT'])] . ';">
										<a href="https://db.rising-gods.de/?item=' . @$equipment['SHIRT'] . '"></a>
									</div>

									<div class="item-left tabard" style="border-color: ' . @$Quality[GrabItemQuality($equipment['TABARD'])] . ';">
										<a href="https://db.rising-gods.de/?item=' . @$equipment['TABARD'] . '"></a>
									</div>

									<div class="item-left wrist" style="border-color: ' . @$Quality[GrabItemQuality($equipment['WRIST'])] . ';">
										<a href="https://db.rising-gods.de/?item=' . @$equipment['WRIST'] . '" rel="' . Enchantments($row['guid'], $equipment['WRIST']) . '"></a>
									</div>
								</div>

								<div class="character-items-box-mid">
									<div class="character-stats column small-12">
										<div class="stats-splitter column small-12">
											Base Stats
										</div>

										<div class="stats-content column small-12">
											<div class="stats-text column small-6">
												Strength
											</div>

											<div class="stats-value column small-6">
												' . GrabCharStats($row['guid'], 'strength') . '
											</div>

											<div class="stats-text column small-6">
												Agility
											</div>

											<div class="stats-value column small-6">
												' . GrabCharStats($row['guid'], 'agility') . '
											</div>

											<div class="stats-text column small-6">
												Stamina
											</div>

											<div class="stats-value column small-6">
												' . GrabCharStats($row['guid'], 'stamina') . '
											</div>

											<div class="stats-text column small-6">
												Intellect
											</div>

											<div class="stats-value column small-6">
												' . GrabCharStats($row['guid'], 'intellect') . '
											</div>

											<div class="stats-text column small-6">
												Spirit
											</div>

											<div class="stats-value column small-6">
												' . GrabCharStats($row['guid'], 'spirit') . '
											</div>
										</div>
									</div>

									<div class="character-stats column small-12">
										<div class="stats-splitter column small-12">
											Defenses
										</div>

										<div class="stats-content column small-12">
											<div class="stats-text column small-6">
												Armor
											</div>

											<div class="stats-value column small-6">
												' . GrabCharStats($row['guid'], 'armor') . '
											</div>

											<div class="stats-text column small-6">
												Defense
											</div>

											<div class="stats-value column small-6">
												' . GrabCharSkill($row['guid'], 95) . '
											</div>

											<div class="stats-text column small-6">
												Dodge
											</div>

											<div class="stats-value column small-6">
												' . number_format(GrabCharStats($row['guid'], 'dodgePct'), 2, '.', '') . '%
											</div>

											<div class="stats-text column small-6">
												Parry
											</div>

											<div class="stats-value column small-6">
												' . number_format(GrabCharStats($row['guid'], 'parryPct'), 2, '.', '') . '%
											</div>

											<div class="stats-text column small-6">
												Block
											</div>

											<div class="stats-value column small-6">
												' . number_format(GrabCharStats($row['guid'], 'blockPct'), 2, '.', '') . '%
											</div>

											<div class="stats-text column small-6">
												Resilience
											</div>

											<div class="stats-value column small-6">
												' . GrabCharStats($row['guid'], 'resilience') . '
											</div>
										</div>
									</div>

									<div class="character-stats2 column small-12">
										<div class="stats-splitter column small-12">
											Combat
										</div>

										<div class="character-stat-melee">
											<div class="stats-content column small-12">
												<div class="stats-text column small-6">
													Attack Power
												</div>

												<div class="stats-value column small-6">
													' . GrabCharStats($row['guid'], 'attackPower') . '
												</div>

												<div class="stats-text column small-6">
													Ranged Power
												</div>

												<div class="stats-value column small-6">
													' . GrabCharStats($row['guid'], 'rangedAttackPower') . '
												</div>

												<div class="stats-text column small-6">
													Spell Power
												</div>

												<div class="stats-value column small-6">
													' . GrabCharStats($row['guid'], 'spellPower') . '
												</div>

												<div class="stats-text column small-6">
													Melee Crit
												</div>

												<div class="stats-value column small-6">
													' . number_format(GrabCharStats($row['guid'], 'critPct'), 2, '.', '') . '%
												</div>

												<div class="stats-text column small-6">
													Ranged Crit
												</div>

												<div class="stats-value column small-6">
													' . number_format(GrabCharStats($row['guid'], 'rangedCritPct'), 2, '.', '') . '%
												</div>

												<div class="stats-text column small-6">
													Spell Crit
												</div>

												<div class="stats-value column small-6">
													' . number_format(GrabCharStats($row['guid'], 'spellCritPct'), 2, '.', '') . '%
												</div>
											</div>
										</div>
									</div>
								</div>

								<div class="character-items-box-right">
									<div class="item-right hands" style="border-color: ' . @$Quality[GrabItemQuality($equipment['HANDS'])] . ';">
										<a href="https://db.rising-gods.de/?item=' . @$equipment['HANDS'] . '" rel="' . Enchantments($row['guid'], $equipment['HANDS']) . '"></a>
									</div>

									<div class="item-right waist" style="border-color: ' . @$Quality[GrabItemQuality($equipment['WAIST'])] . ';">
										<a href="https://db.rising-gods.de/?item=' . @$equipment['WAIST'] . '" rel="' . Enchantments($row['guid'], $equipment['WAIST']) . '"></a>
									</div>

									<div class="item-right legs" style="border-color: ' . @$Quality[GrabItemQuality($equipment['LEGS'])] . ';">
										<a href="https://db.rising-gods.de/?item=' . @$equipment['LEGS'] . '" rel="' . Enchantments($row['guid'], $equipment['LEGS']) . '"></a>
									</div>

									<div class="item-right feet" style="border-color: ' . @$Quality[GrabItemQuality($equipment['FEET'])] . ';">
										<a href="https://db.rising-gods.de/?item=' . @$equipment['FEET'] . '" rel="' . Enchantments($row['guid'], $equipment['FEET']) . '"></a>
									</div>

									<div class="item-right ring" style="border-color: ' . @$Quality[GrabItemQuality($equipment['RING1'])] . ';">
										<a href="https://db.rising-gods.de/?item=' . @$equipment['RING1'] . '" rel="' . Enchantments($row['guid'], $equipment['RING1']) . '"></a>
									</div>

									<div class="item-right ring" style="border-color: ' . @$Quality[GrabItemQuality($equipment['RING2'])] . ';">
										<a href="https://db.rising-gods.de/?item=' . @$equipment['RING2'] . '" rel="' . Enchantments($row['guid'], $equipment['RING2']) . '"></a>
									</div>

									<div class="item-right trinket" style="border-color: ' . @$Quality[GrabItemQuality($equipment['TRINKET1'])] . ';">
										<a href="https://db.rising-gods.de/?item=' . @$equipment['TRINKET1'] . '" rel="' . Enchantments($row['guid'], $equipment['TRINKET1']) . '"></a>
									</div>

									<div class="item-right trinket" style="border-color: ' . @$Quality[GrabItemQuality($equipment['TRINKET2'])] . ';">
										<a href="https://db.rising-gods.de/?item=' . @$equipment['TRINKET2'] . '" rel="' . Enchantments($row['guid'], $equipment['TRINKET2']) . '"></a>
									</div>
								</div>

								<div class="character-items-box-bottom">
									<div class="item-bottom mainhand" style="border-color: ' . @$Quality[GrabItemQuality($equipment['MAINHAND'])] . ';">
										<a href="https://db.rising-gods.de/?item=' . @$equipment['MAINHAND'] . '" rel="' . Enchantments($row['guid'], $equipment['MAINHAND']) . '"></a>
									</div>

									<div class="item-bottom offhand" style="border-color: ' . @$Quality[GrabItemQuality($equipment['OFFHAND'])] . ';">
										<a href="https://db.rising-gods.de/?item=' . @$equipment['OFFHAND'] . '" rel="' . Enchantments($row['guid'], $equipment['OFFHAND']) . '"></a>
									</div>
									
									<div class="item-bottom ranged" style="border-color: ' . @$Quality[GrabItemQuality($equipment['RANGED'])] . ';">
										<a href="https://db.rising-gods.de/?item=' . @$equipment['RANGED'] . '" rel="' . Enchantments($row['guid'], $equipment['RANGED']) . '"></a>
									</div>
								</div>
							</div>


							*/ '
							<div class="character-box column small-12 medium-12">
								<div class="character-items column small-12">
									<table>
										<th>Item Name</th>
										<th>ilvl</th>
										<th>Gems</th>
										<th>Enchants</th>

										<tr>
											<td><a href="https://db.rising-gods.de/?item=' . @$equipment['HEAD'] . '" style="color: ' . @$Quality[GrabItemQuality($equipment['HEAD'])] . ';">' . GrabItemName($equipment['HEAD']) . '</a></td>
											<td>' . GrabItemLevel($equipment['HEAD']) . '</td>
											<td></td>
											<td><a href="https://db.rising-gods.de/spell=' . GrabEnchantSpell(Enchantment($row['guid'], $equipment['HEAD'])) . '">' . GrabEnchantName(Enchantment($row['guid'], $equipment['HEAD'])) . '</a></td>
										</tr>
										<tr>
											<td><a href="https://db.rising-gods.de/?item=' . @$equipment['NECK'] . '" style="color: ' . @$Quality[GrabItemQuality($equipment['NECK'])] . ';">' . GrabItemName($equipment['NECK']) . '</a></td>
											<td>' . GrabItemLevel($equipment['NECK']) . '</td>
											<td></td>
											<td><a href="https://db.rising-gods.de/spell=' . GrabEnchantSpell(Enchantment($row['guid'], $equipment['NECK'])) . '">' . GrabEnchantName(Enchantment($row['guid'], $equipment['NECK'])) . '</a></td>
										</tr>
										<tr>
											<td><a href="https://db.rising-gods.de/?item=' . @$equipment['SHOULDER'] . '" style="color: ' . @$Quality[GrabItemQuality($equipment['SHOULDER'])] . ';">' . GrabItemName($equipment['SHOULDER']) . '</a></td>
											<td>' . GrabItemLevel($equipment['SHOULDER']) . '</td>
											<td></td>
											<td><a href="https://db.rising-gods.de/spell=' . GrabEnchantSpell(Enchantment($row['guid'], $equipment['SHOULDER'])) . '">' . GrabEnchantName(Enchantment($row['guid'], $equipment['SHOULDER'])) . '</a></td>
										</tr>
										<tr>
											<td><a href="https://db.rising-gods.de/?item=' . @$equipment['CLOAK'] . '" style="color: ' . @$Quality[GrabItemQuality($equipment['CLOAK'])] . ';">' . GrabItemName($equipment['CLOAK']) . '</a></td>
											<td>' . GrabItemLevel($equipment['CLOAK']) . '</td>
											<td></td>
											<td><a href="https://db.rising-gods.de/spell=' . GrabEnchantSpell(Enchantment($row['guid'], $equipment['CLOAK'])) . '">' . GrabEnchantName(Enchantment($row['guid'], $equipment['CLOAK'])) . '</a></td>
										</tr>
										<tr>
											<td><a href="https://db.rising-gods.de/?item=' . @$equipment['CHEST'] . '" style="color: ' . @$Quality[GrabItemQuality($equipment['CHEST'])] . ';">' . GrabItemName($equipment['CHEST']) . '</a></td>
											<td>' . GrabItemLevel($equipment['CHEST']) . '</td>
											<td></td>
											<td><a href="https://db.rising-gods.de/spell=' . GrabEnchantSpell(Enchantment($row['guid'], $equipment['CHEST'])) . '">' . GrabEnchantName(Enchantment($row['guid'], $equipment['CHEST'])) . '</a></td>
										</tr>
										<tr>
											<td><a href="https://db.rising-gods.de/?item=' . @$equipment['SHIRT'] . '" style="color: ' . @$Quality[GrabItemQuality($equipment['SHIRT'])] . ';">' . GrabItemName($equipment['SHIRT']) . '</a></td>
											<td>' . GrabItemLevel($equipment['SHIRT']) . '</td>
											<td></td>
											<td><a href="https://db.rising-gods.de/spell=' . GrabEnchantSpell(Enchantment($row['guid'], $equipment['SHIRT'])) . '">' . GrabEnchantName(Enchantment($row['guid'], $equipment['SHIRT'])) . '</a></td>
										</tr>
										<tr>
											<td><a href="https://db.rising-gods.de/?item=' . @$equipment['TABARD'] . '" style="color: ' . @$Quality[GrabItemQuality($equipment['TABARD'])] . ';">' . GrabItemName($equipment['TABARD']) . '</a></td>
											<td>' . GrabItemLevel($equipment['TABARD']) . '</td>
											<td></td>
											<td><a href="https://db.rising-gods.de/spell=' . GrabEnchantSpell(Enchantment($row['guid'], $equipment['TABARD'])) . '">' . GrabEnchantName(Enchantment($row['guid'], $equipment['TABARD'])) . '</a></td>
										</tr>
										<tr>
											<td><a href="https://db.rising-gods.de/?item=' . @$equipment['WRIST'] . '" style="color: ' . @$Quality[GrabItemQuality($equipment['WRIST'])] . ';">' . GrabItemName($equipment['WRIST']) . '</a></td>
											<td>' . GrabItemLevel($equipment['WRIST']) . '</td>
											<td></td>
											<td><a href="https://db.rising-gods.de/spell=' . GrabEnchantSpell(Enchantment($row['guid'], $equipment['WRIST'])) . '">' . GrabEnchantName(Enchantment($row['guid'], $equipment['WRIST'])) . '</a></td>
										</tr>
										<tr>
											<td><a href="https://db.rising-gods.de/?item=' . @$equipment['HANDS'] . '" style="color: ' . @$Quality[GrabItemQuality($equipment['HANDS'])] . ';">' . GrabItemName($equipment['HANDS']) . '</a></td>
											<td>' . GrabItemLevel($equipment['HANDS']) . '</td>
											<td></td>
											<td><a href="https://db.rising-gods.de/spell=' . GrabEnchantSpell(Enchantment($row['guid'], $equipment['HANDS'])) . '">' . GrabEnchantName(Enchantment($row['guid'], $equipment['HANDS'])) . '</a></td>
										</tr>
										<tr>
											<td><a href="https://db.rising-gods.de/?item=' . @$equipment['WAIST'] . '" style="color: ' . @$Quality[GrabItemQuality($equipment['WAIST'])] . ';">' . GrabItemName($equipment['WAIST']) . '</a></td>
											<td>' . GrabItemLevel($equipment['WAIST']) . '</td>
											<td></td>
											<td><a href="https://db.rising-gods.de/spell=' . GrabEnchantSpell(Enchantment($row['guid'], $equipment['WAIST'])) . '">' . GrabEnchantName(Enchantment($row['guid'], $equipment['WAIST'])) . '</a></td>
										</tr>
										<tr>
											<td><a href="https://db.rising-gods.de/?item=' . @$equipment['LEGS'] . '" style="color: ' . @$Quality[GrabItemQuality($equipment['LEGS'])] . ';">' . GrabItemName($equipment['LEGS']) . '</a></td>
											<td>' . GrabItemLevel($equipment['LEGS']) . '</td>
											<td></td>
											<td><a href="https://db.rising-gods.de/spell=' . GrabEnchantSpell(Enchantment($row['guid'], $equipment['LEGS'])) . '">' . GrabEnchantName(Enchantment($row['guid'], $equipment['LEGS'])) . '</a></td>
										</tr>
										<tr>
											<td><a href="https://db.rising-gods.de/?item=' . @$equipment['FEET'] . '" style="color: ' . @$Quality[GrabItemQuality($equipment['FEET'])] . ';">' . GrabItemName($equipment['FEET']) . '</a></td>
											<td>' . GrabItemLevel($equipment['FEET']) . '</td>
											<td></td>
											<td><a href="https://db.rising-gods.de/spell=' . GrabEnchantSpell(Enchantment($row['guid'], $equipment['FEET'])) . '">' . GrabEnchantName(Enchantment($row['guid'], $equipment['FEET'])) . '</a></td>
										</tr>
										<tr>
											<td><a href="https://db.rising-gods.de/?item=' . @$equipment['RING1'] . '" style="color: ' . @$Quality[GrabItemQuality($equipment['RING1'])] . ';">' . GrabItemName($equipment['RING1']) . '</a></td>
											<td>' . GrabItemLevel($equipment['RING1']) . '</td>
											<td></td>
											<td><a href="https://db.rising-gods.de/spell=' . GrabEnchantSpell(Enchantment($row['guid'], $equipment['RING1'])) . '">' . GrabEnchantName(Enchantment($row['guid'], $equipment['RING1'])) . '</a></td>
										</tr>
										<tr>
											<td><a href="https://db.rising-gods.de/?item=' . @$equipment['RING2'] . '" style="color: ' . @$Quality[GrabItemQuality($equipment['RING2'])] . ';">' . GrabItemName($equipment['RING2']) . '</a></td>
											<td>' . GrabItemLevel($equipment['RING2']) . '</td>
											<td></td>
											<td><a href="https://db.rising-gods.de/spell=' . GrabEnchantSpell(Enchantment($row['guid'], $equipment['RING2'])) . '">' . GrabEnchantName(Enchantment($row['guid'], $equipment['RING2'])) . '</a></td>
										</tr>
										<tr>
											<td><a href="https://db.rising-gods.de/?item=' . @$equipment['TRINKET1'] . '" style="color: ' . @$Quality[GrabItemQuality($equipment['TRINKET1'])] . ';">' . GrabItemName($equipment['TRINKET1']) . '</a></td>
											<td>' . GrabItemLevel($equipment['TRINKET1']) . '</td>
											<td></td>
											<td><a href="https://db.rising-gods.de/spell=' . GrabEnchantSpell(Enchantment($row['guid'], $equipment['TRINKET1'])) . '">' . GrabEnchantName(Enchantment($row['guid'], $equipment['TRINKET1'])) . '</a></td>
										</tr>
										<tr>
											<td><a href="https://db.rising-gods.de/?item=' . @$equipment['TRINKET2'] . '" style="color: ' . @$Quality[GrabItemQuality($equipment['TRINKET2'])] . ';">' . GrabItemName($equipment['TRINKET2']) . '</a></td>
											<td>' . GrabItemLevel($equipment['TRINKET2']) . '</td>
											<td></td>
											<td><a href="https://db.rising-gods.de/spell=' . GrabEnchantSpell(Enchantment($row['guid'], $equipment['TRINKET2'])) . '">' . GrabEnchantName(Enchantment($row['guid'], $equipment['TRINKET2'])) . '</a></td>
										</tr>
										<tr>
											<td><a href="https://db.rising-gods.de/?item=' . @$equipment['MAINHAND'] . '" style="color: ' . @$Quality[GrabItemQuality($equipment['MAINHAND'])] . ';">' . GrabItemName($equipment['MAINHAND']) . '</a></td>
											<td>' . GrabItemLevel($equipment['MAINHAND']) . '</td>
											<td></td>
											<td><a href="https://db.rising-gods.de/spell=' . GrabEnchantSpell(Enchantment($row['guid'], $equipment['MAINHAND'])) . '">' . GrabEnchantName(Enchantment($row['guid'], $equipment['MAINHAND'])) . '</a></td>
										</tr>
										<tr>
											<td><a href="https://db.rising-gods.de/?item=' . @$equipment['OFFHAND'] . '" style="color: ' . @$Quality[GrabItemQuality($equipment['OFFHAND'])] . ';">' . GrabItemName($equipment['OFFHAND']) . '</a></td>
											<td>' . GrabItemLevel($equipment['OFFHAND']) . '</td>
											<td></td>
											<td><a href="https://db.rising-gods.de/spell=' . GrabEnchantSpell(Enchantment($row['guid'], $equipment['OFFHAND'])) . '">' . GrabEnchantName(Enchantment($row['guid'], $equipment['OFFHAND'])) . '</a></td>
										</tr>
										<tr>
											<td><a href="https://db.rising-gods.de/?item=' . @$equipment['RANGED'] . '" style="color: ' . @$Quality[GrabItemQuality($equipment['RANGED'])] . ';">' . GrabItemName($equipment['RANGED']) . '</a></td>
											<td>' . GrabItemLevel($equipment['RANGED']) . '</td>
											<td></td>
											<td><a href="https://db.rising-gods.de/spell=' . GrabEnchantSpell(Enchantment($row['guid'], $equipment['RANGED'])) . '">' . GrabEnchantName(Enchantment($row['guid'], $equipment['RANGED'])) . '</a></td>
										</tr>
									</table>
								</div>
							</div>
							

							<div class="character-items column small-12">
								<table class="char-stats-table">
									<th>Stat</th>
									<th>Value</th>
									
									<tr>
										<td>Strength</td>
										<td><span class="orange">' . GrabCharStats($row['guid'], 'strength') . '</span></td>
									</tr>

									<tr>
										<td>Agility</td>
										<td><span class="orange">' . GrabCharStats($row['guid'], 'agility') . '</span></td>
									</tr>

									<tr>
										<td>Stamina</td>
										<td><span class="orange">' . GrabCharStats($row['guid'], 'stamina') . '</span></td>
									</tr>

									<tr>
										<td>Intellect</td>
										<td><span class="orange">' . GrabCharStats($row['guid'], 'intellect') . '</span></td>
									</tr>

									<tr>
										<td>Spirit</td>
										<td><span class="orange">' . GrabCharStats($row['guid'], 'spirit') . '</span></td>
									</tr>

									<tr>
										<td>Armor</td>
										<td><span class="orange">' . GrabCharStats($row['guid'], 'armor') . '</span></td>
									</tr>

									<tr>
										<td>Defense</td>
										<td><span class="orange">' . GrabCharSkill($row['guid'], 95) . '</span></td>
									</tr>

									<tr>
										<td>Dodge</td>
										<td><span class="orange">' . number_format(GrabCharStats($row['guid'], 'dodgePct'), 2, '.', '') . '%</span></td>
									</tr>

									<tr>
										<td>Parry</td>
										<td><span class="orange">' . number_format(GrabCharStats($row['guid'], 'parryPct'), 2, '.', '') . '%</span></td>
									</tr>

									<tr>
										<td>Block</td>
										<td><span class="orange">' . number_format(GrabCharStats($row['guid'], 'blockPct'), 2, '.', '') . '%</span></td>
									</tr>

									<tr>
										<td>Resilience</td>
										<td><span class="orange">' . GrabCharStats($row['guid'], 'resilience') . '</span></td>
									</tr>

									<tr>
										<td>Attack Power</td>
										<td><span class="orange">' . GrabCharStats($row['guid'], 'attackPower') . '</span></td>
									</tr>

									<tr>
										<td>Ranged Power</td>
										<td><span class="orange">' . GrabCharStats($row['guid'], 'rangedAttackPower') . '</span></td>
									</tr>

									<tr>
										<td>Spell Power</td>
										<td><span class="orange">' . GrabCharStats($row['guid'], 'spellPower') . '</span></td>
									</tr>

									<tr>
										<td>Melee Crit</td>
										<td><span class="orange">' . number_format(GrabCharStats($row['guid'], 'critPct'), 2, '.', '') . '%</span></td>
									</tr>

									<tr>
										<td>Ranged Crit</td>
										<td><span class="orange">' . number_format(GrabCharStats($row['guid'], 'rangedCritPct'), 2, '.', '') . '%</span></td>
									</tr>

									<tr>
										<td>Spell Crit</td>
										<td><span class="orange">' . number_format(GrabCharStats($row['guid'], 'spellCritPct'), 2, '.', '') . '%</span></td>
									</tr>
								</table>
							</div>
							'/*
							<div class="character-items column medium-12 large-7">
								<div class="character-professions">
									<div class="char-header">
										Professions
									</div>

									<div class="char-content">
										<div class="prof-label column small-12">
											<label>Primary Professions</label><span class="red">Coming soon!</span>
										</div>

										<!--<div class="char-box column small-12 medium-6">
											<div class="char-content-box column small-12 medium-6">
												<div class="char-icon">
													<img src="img/icons/professions/enchanting.jpg" width="30">
												</div>

												<div class="char-prof">
													Enchanting
												</div>

												<div class="prof-level">
													450 / 450
												</div>
											</div>

										<div class="char-box column small-12 medium-6">
											<div class="char-content-box-none column small-12 medium-6">
												<div class="char-icon">
													<i class="fa fa-ban" aria-hidden="true"></i>
												</div>

												<div class="char-prof">
													No Profession
												</div>

												<div class="prof-level">
													
												</div>
											</div>
										</div>

										<div class="char-box column small-12 medium-6">
											<div class="char-content-box column small-12 medium-6">
												<div class="char-icon">
													<img src="img/icons/professions/mining.jpg" width="30">
												</div>

												<div class="char-prof">
													Mining
												</div>

												<div class="prof-level">
													120 / 450
												</div>
											</div>
										</div>

										<div class="prof-label2 column small-12">
											<label>Secondary Professions</label>
										</div>

										<div class="char-box column small-12 medium-6">
											<div class="char-content-box column small-12 medium-6">
												<div class="char-icon">
													<img src="img/icons/professions/firstaid.jpg" width="30">
												</div>

												<div class="char-prof">
													First Aid
												</div>

												<div class="prof-level">
													320 / 450
												</div>
											</div>
										</div>

										<div class="char-box column small-12 medium-6">
											<div class="char-content-box column small-12 medium-6">
												<div class="char-icon">
													<img src="img/icons/professions/fishing.jpg" width="30">
												</div>

												<div class="char-prof">
													Fishing
												</div>

												<div class="prof-level">
													450 / 450
												</div>
											</div>
										</div>

										<div class="char-box column small-12 medium-6">
											<div class="char-content-box column small-12 medium-6">
												<div class="char-icon">
													<img src="img/icons/professions/cooking.jpg" width="30">
												</div>

												<div class="char-prof">
													Cooking
												</div>

												<div class="prof-level">
													75 / 450
												</div>
											</div>
										</div>

										<div class="char-box column small-12 medium-6">
											<div class="char-content-box column small-12 medium-6">
												<div class="char-icon">
													<img src="img/icons/professions/riding.jpg" width="30">
												</div>

												<div class="char-prof">
													Riding
												</div>

												<div class="prof-level">
													150 / 150
												</div>
											</div>
										</div>-->
									</div>
								</div>
							</div>

							<div class="activity column small-12 medium-12 large-7">
								<div class="activity-box column small-12">
									<div class="activity-header column small-12">
										Recent Activity
									</div>

									<div class="activity-content column small-12">
										<div class="activity-label">
											<label>Recent Loot</label> <span class="red">Coming soon!</span>
										</div>

										<!--<div class="activity-label">
											<div class="activity-line column small-12">
												Obtained <span class="epic">[Skullflame Shield]</span> <span class="activity-date">20.12.2016</span>
											</div>

											<div class="activity-line column small-12">
												Obtained <span class="epic">[Blade of the Unrequited]</span> <span class="activity-date">20.12.2016</span>
											</div>

											<div class="activity-line column small-12">
												Obtained <span class="uncommon">[Darkmist Wizard Hat]</span> <span class="activity-date">20.12.2016</span>
											</div>

											<div class="activity-line column small-12">
												Obtained <span class="rare">[Jaina\'s Firestarter]</span> <span class="activity-date">20.12.2016</span>
											</div>
										</div>-->
									</div>
								</div>
							</div>
						</div>*/
						;
				}
			}
			else
			{
				echo '<span class="red">Character not found!</span>';
			}
		}
	}
}




























?>