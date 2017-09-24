<?php

function Uptime($realm)
{
	global $con_realmd;

	$data = $con_realmd->prepare('SELECT * FROM uptime WHERE realmid = :realm ORDER by id DESC LIMIT 1');
	$data->execute(array(
		':realm' => $realm
	));

	$result = $data->fetchAll(PDO::FETCH_ASSOC);

	foreach($result as $row)
	{
		$time = $row['starttime'];

		$start   = date('Y-m-d H:i:s', $time);
		$current = date('Y-m-d H:i:s', time());

		$datetime1 = new DateTime($start);
		$datetime2 = new DateTime($current);
		
		$interval  = $datetime1->diff($datetime2);

		return '<span class="red">Under Maintenance</span>'; //$interval->format('%dd %hh %im %ss');
	}
}

function FactionBalance($realmid, $faction)
{
	if($realmid == 1)
	{
		global $con_characters;

		// Grab Alliance
		$data = $con_characters->query('SELECT COUNT(*) FROM characters WHERE online = 1 AND race IN(1,3,4,7,11)')->fetchColumn();
		$countally = $data;

		// Grab Horde
		$data = $con_characters->query('SELECT COUNT(*) FROM characters WHERE online = 1 AND race IN(2,5,6,8,10)')->fetchColumn();
		$counthorde = $data;

		if($faction == 0)
		{
			if($countally == 0 || $counthorde == 0)
			{
				// Grab Alliance
				$data = $con_characters->query('SELECT COUNT(*) FROM characters WHERE race IN(1,3,4,7,11)')->fetchColumn();
				$countally2 = $data;

				// Grab Horde
				$data = $con_characters->query('SELECT COUNT(*) FROM characters WHERE race IN(2,5,6,8,10)')->fetchColumn();
				$counthorde2 = $data;

				return ceil($countally2 / ($counthorde2 + $countally2) * 100);
			}
			else
			{
				$result = ceil($countally / ($counthorde + $countally) * 100);
				return $result;
			}
		}
		else
		{
			if($counthorde == 0 || $countally == 0)
			{
				// Grab Alliance
				$data = $con_characters->query('SELECT COUNT(*) FROM characters WHERE race IN(1,3,4,7,11)')->fetchColumn();
				$countally2 = $data;

				// Grab Horde
				$data = $con_characters->query('SELECT COUNT(*) FROM characters WHERE race IN(2,5,6,8,10)')->fetchColumn();
				$counthorde2 = $data;

				
				return floor($counthorde2 / ($counthorde2 + $countally2) * 100);
			}
			else
			{
				$result2 = floor($counthorde / ($counthorde + $countally) * 100);
				return $result2;
			}
		}
	}
	else
	{
		
	}
}

function Realm($value)
{
	global $con_realmd;
	global $con_characters;

	$h    = "2";
	$hm   = $h * 60; 
	$ms   = $hm * 60;
	$time = gmdate('H:i:s', time()+($ms));

	switch ($value) {
		case 0:
			if(@fsockopen('149.202.215.214', 8085, $errno, $errstr, 1))
			{
				$online = '<span class="green">Online</span>';
			}
			else
			{
				$online = '<span class="red">Offline</span>';
			}

			$data =	$con_characters->prepare('SELECT COUNT(*) FROM characters WHERE online = 1');
			$data->execute();

			$result = $data->fetchColumn();

			$population = $result;

			$data = $con_realmd->prepare('SELECT * FROM realmlist WHERE id = 1');
			$data->execute();

			$result = $data->fetchAll(PDO::FETCH_ASSOC);

			if($online == '<span class="green">Online</span>')
			{
				$uptime = Uptime(1);
			}
			else
			{
				$uptime = '';
			}

			foreach($result as $row)
			{
				echo '<div class="realm-box column small-12">
						<div class="realm-box-banner column small-12">
							<div class="realm-title column small-12">
								' . ucfirst($row['name']) . '
							</div>
						</div>

						<div class="realm-box-content column small-12">
							<div class="realm-box-strip2 column small-12">
								<div class="balance">
									<div class="balance-ally" style="width: ' . FactionBalance(1, 0) .'%;">
										' . FactionBalance(1, 0) .'%
									</div>

									<div class="balance-horde" style="width: ' . FactionBalance(1, 1) .'%;">
										' . FactionBalance(1, 1) .'%
									</div>
								</div>
							</div>

							<div class="realm-box-strip column small-12">
								Status: ' . $online . '
							</div>

							<div class="realm-box-strip column small-12">
								Population: <span class="green">' . $population . '</span>
							</div>

							<div class="realm-box-strip column small-12">
								Server Time: <span class="green">' . $time . '</span>
							</div>

							<div class="realm-box-strip column small-12">
								Uptime: <span class="green">' . $uptime . '</span>
							</div>
						</div>
					</div>';
			}
			break;

			case 1:
				if(@fsockopen('149.202.215.214', 8085, $errno, $errstr, 1))
				{
					$online = '<span class="green">Online</span>';
				}
				else
				{
					$online = '<span class="red">Offline</span>';
				}

				$data =	$con_characters->prepare('SELECT COUNT(*) FROM characters WHERE online = 1');
				$data->execute();

				$result = $data->fetchColumn();

				$population = $result;

				$data = $con_realmd->prepare('SELECT * FROM realmlist WHERE id = 1');
				$data->execute();

				$result = $data->fetchAll(PDO::FETCH_ASSOC);

				if($online == '<span class="green">Online</span>')
				{
					$uptime = Uptime(1);
				}
				else
				{
					$uptime = '';
				}

				foreach($result as $row)
				{
					echo '<div class="realm-box2 column small-12">
							<div class="realm-box-content column small-12">
								<div class="realm-box-strip2 column small-12">
									<div class="balance">
										<div class="balance-ally" style="width: ' . FactionBalance(1, 0) .'%;">
											' . FactionBalance(1, 0) .'%
										</div>

										<div class="balance-horde" style="width: ' . FactionBalance(1, 1) .'%;">
											' . FactionBalance(1, 1) .'%
										</div>
									</div>
								</div>

								<div class="realm-box-strip column small-12">
									Status: ' . $online . '
								</div>

								<div class="realm-box-strip column small-12">
									Population: <span class="green">' . $population . '</span>
								</div>

								<div class="realm-box-strip column small-12">
									Server Time: <span class="green">' . $time . '</span>
								</div>

								<div class="realm-box-strip column small-12">
									Uptime: <span class="green">' . $uptime . '</span>
								</div>
							</div>
						</div>';
				}
			break;
	}
}

function BBCodeParser($input)
{
	$bbcode = array( 
        '@\n@',
		'~\[b\](.*?)\[/b\]~s',
		'~\[i\](.*?)\[/i\]~s',
		'~\[u\](.*?)\[/u\]~s',
		'~\[quote\](.*?)\[/quote\]~s', 
        '/\[size\=(.+?)\](.+?)\[\/size\]/is',  
        '/\[font\=(.+?)\](.+?)\[\/font\]/is', 
        '/\[center\](.+?)\[\/center\]/is', 
        '/\[right\](.+?)\[\/right\]/is', 
        '/\[left\](.+?)\[\/left\]/is',
		'~\[color=(.*?)\](.*?)\[/color\]~s',
		'~\[url\]((?:ftp|https?)://.*?)\[/url\]~s',
		'~\[img\](https?://.*?\.(?:jpg|jpeg|gif|png|bmp))\[/img\]~s',
        '/\[email\](.+?)\[\/email\]/is',
		'~\[video\](.*?)\[/video\]~s',
		'#\[url](.+)\[/url]#Usi',
		'#\[url=(.+)](.+)\[/url\]#Usi',
		'/\[(\/?)list=1\]/i',
		'/\[\*\](.*?)(\n|\r\n?)/i',
		'/\[(\/?)list\]/i',
		'/\[(\/?)li\]/i'
	);

	$html = array(
		'<br />',
		'<b>$1</b>',
		'<i>$1</i>',
		'<span style="text-decoration:underline;">$1</span>',
		'<pre>$1</'.'pre>',
		'<font size=\"$1\">$2</font>', 
        '<span style=\"font-family: $1\">$2</span>', 
        '<div style=\"text-align:center;\">$1</div>', 
        '<div style=\"text-align:right;\">$1</div>', 
        '<div style=\"text-align:left;\">$1</div>',
		'<span style="color:$1;">$2</span>',
		'<a href="$1">$1</a>',
		'<img src="$1">',
        '<a href=\"mailto:$1\" target=\"_blank\">$1</a>',
        '<iframe width="800" height="480" src="https://www.youtube.com/embed/$1" frameborder="0"></iframe>',
        '<a rel="nofollow" target="_blank" href="$1">$1</a>',
		'<a rel="nofollow" target="_blank" href="$1">$2</a>',
		'<$1ol>',
		'<li>$1</li>',
		'<$1ol>',
		'<$1li>'
	);


	$parse = preg_replace($bbcode, $html, $input);

	return($parse);
}

function GrabNews()
{
	global $con_web;

	$page    = isset($_GET['page']) ? (int)$_GET['page'] : 1;
	$perPage = 4;

	$start = ($page > 1) ? ($page * $perPage) - $perPage : 0;

	$total = $con_web->query('SELECT COUNT(*) FROM news')->fetchColumn();
	$pages = ceil($total / $perPage);

	$data = $con_web->prepare('SELECT * FROM news ORDER BY id DESC LIMIT ' . $start . ', ' . $perPage);
	$data->execute();

	while($result = $data->fetchAll(PDO::FETCH_ASSOC))
	{
		foreach($result as $row)
		{
			if(!empty($row['post_banner']))
			{
				$banner = '<div class="content-img">
							<img src="' . $row['post_banner'] . '">
						</div>';
			}
			else
			{
				$banner = '';
			}

			echo '<div class="content-box column small-12">
					' . $banner . '

					<div class="content-header">
						<div class="content-title">
							' . $row['post_title'] . '
						</div>

						<div class="content-date">
							' . date('d. F, Y', $row['post_date']) . '
						</div>
					</div>
					
					<div class="content-text">
						' . BBCodeParser($row['post_summary']) . '
					</div>

					<div class="content-button">
						<a href="view.php?post_id=' . $row['id'] . '" class="small button">Read more</a>
					</div>
				</div>';
		}
	}

	echo '<div class="navigation column small-12"><ul class="nav-menu">';

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



function ViewNews()
{
	global $con_web;

	if(isset($_GET['post_id']))
	{
		if(!empty($_GET['post_id']))
		{
			$id = (int)$_GET['post_id'];

			$data = $con_web->prepare('SELECT COUNT(*) FROM news WHERE id = :post_id');
			$data->execute(array(
				':post_id' => $id
			));

			if($data->fetchColumn() == 1)
			{
				$data = $con_web->prepare('SELECT * FROM news WHERE id = :post_id');
				$data->execute(array(
					':post_id' => $id
				));

				$result = $data->fetchAll(PDO::FETCH_ASSOC);

				foreach($result as $row)
				{
					if(!empty($row['post_banner']))
					{
						$banner = '<div class="news-banner">
									<img src="' . $row['post_banner'] . '">
								</div>';
					}
					else
					{
						$banner = '';
					}

					echo '<div class="news-box column small-12">
							
							' . $banner . '

							<div class="news-header">
								<div class="news-header-title">
									' . $row['post_title'] . '
								</div>

								<div class="news-header-date">
									' . date('d. F, Y', $row['post_date']) . '
								</div>
							</div>

							<div class="news-content">
								<div class="news-content-text">
									<span class="" style="color: rgba(241, 196, 15, 0.8);">' . BBCodeParser($row['post_summary']) . '</span>
									<br>
									' . BBCodeParser($row['post_content']) . '
								</div>
							</div>
						</div>';
				}
			}
			else
			{
				header('Location: 404.php');
			}
		}
		else
		{
			header('Location: 404.php');
		}
	}
	else
	{
		header('Location: 404.php');
	}
}



function ContactUs()
{
	if(isset($_POST['send']))
	{
		if(!empty($_POST['yourname']) && !empty($_POST['youremail']) && !empty($_POST['subject']) && !empty($_POST['message']))
		{
			global $con_web;

			$name    = $_POST['yourname'];
			$email   = $_POST['youremail'];
			$subject = $_POST['subject'];
			$message = nl2br($_POST['message']);
			$created = time();
			$ip      = $_SERVER['REMOTE_ADDR'];
			$captcha = $_POST['g-recaptcha-response'];
			$secret  = '6LfUyQ4UAAAAAEzidq99y83ijRrRIOTQkVOfve5p';

			if(filter_var($email, FILTER_VALIDATE_EMAIL))
			{
				if(isset($captcha))
				{
					$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $captcha . "&remoteip=" . $ip);
					$decode   = json_decode($response, true);

					if(intval($decode['success']) == 1)
					{
						$data = $con_web->prepare('INSERT INTO support (name, email, subject, message, created, ip) VALUES(:name, :email, :subject, :message, :created, :ip)');
						$data->execute(array(
							':name'    => $name,
							':email'   => $email,
							':subject' => $subject,
							':message' => $message,
							':created' => $created,
							':ip'      => $ip
						));

						echo '<div class="callout success">Thank you for your message, we will get back to you soon!</div>';
					}
					else
					{
						echo '<div class="callout bg-red white">Captcha was incorrect!</div>';
					}
				}
				else
				{
					echo '<div class="callout bg-red white">Captcha is required!</div>';
				}
			}
			else
			{
				echo '<div class="callout bg-red white">Email is not a valid email!</div>';
			}
		}
		else
		{
			echo '<div class="callout bg-red white">All fields are required!</div>';
		}
	}
}



function Register()
{
	if(isset($_POST['register']))
	{
		if(!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['re-password']))
		{
			global $con_realmd;

			$username    = $_POST['username'];
			$email       = $_POST['email'];
			$password    = $_POST['password'];
			$re_password = $_POST['re-password'];
			$lastip      = $_SERVER['REMOTE_ADDR'];
			$time        = time();
			$date        = date('Y-m-d H:i:s', $time);
			$expansion   = 2;
			$captcha     = $_POST['g-recaptcha-response'];
			$secret      = '';
			//$checkbox   = $_POST['tos'];

			if(strlen($username) && strlen($password) && strlen($re_password) < 17)
			{
				if(strlen($email) < 255)
				{
					/*if(isset($checkbox))
					{*/
						if(ctype_alnum($username))
						{
							if(ctype_alnum($password) && ctype_alnum($re_password))
							{
								if($captcha)
								{
									$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $captcha . "&remoteip=" . $lastip);
									$decode   = json_decode($response, true);

									if(intval($decode['success']) == 1)
									{
										if($re_password == $password)
										{
											$data = $con_realmd->prepare('SELECT COUNT(*) FROM account WHERE username = :username OR email = :email');
											$data->execute(array(
												':username' => $username,
												':email'    => $email
											));

											if($data->fetchColumn() == 0)
											{
												if(filter_var($email, FILTER_VALIDATE_EMAIL))
												{
													if(filter_var($email, FILTER_SANITIZE_EMAIL))
													{
														$data = $con_realmd->prepare('INSERT INTO account (username, sha_pass_hash, email, last_ip, joindate, last_login, expansion) VALUES(:username, :password, :email, :last_ip, :joindate, CURRENT_TIMESTAMP, :expansion)');
														$data->execute(array(
															':username'  => $username,
															':password'  => sha1(strtoupper($username) . ":" . strtoupper($password)),
															':email'     => $email,
															':last_ip'   => $lastip,
															':joindate'  => $date,
															':expansion' => $expansion
														));

														echo '<div class="callout success">Successfully registered!</div>
															<div class="callout warning">set realmlist logon.northcraft.org</div>';
													}
													else
													{
														echo '<div class="callout bg-red white">Email contains malicious characters!</div>';
													}
												}
												else
												{
													echo '<div class="callout bg-red white">Email is not a valid email!</div>';
												}
											}
											else
											{
												echo '<div class="callout bg-red white">Username or Email already taken!</div>';
											}
										}
										else
										{
											echo '<div class="callout bg-red white">Passwords doesn\'t match!</div>';
										}
									}
									else
									{
										echo '<div class="callout bg-red white">Captcha is wrong!</div>';
									}
								}
								else
								{
									echo '<div class="callout bg-red white">Please fill in the captcha!</div>';
								}
							}
							else
							{
								echo '<div class="callout bg-red white">Password contains malicious characters!</div>';
							}
						}
						else
						{
							echo '<div class="callout bg-red white">Username contains malicious characters!</div>';
						}
					/*}
					else
					{
						echo '<div class="callout warning">Please accept our Terms of Service and Privacy Policy!</div>';
					}*/
				}
				else
				{
					echo '<div class="callout bg-red white">Email address is too long!</div>';
				}
			}
			else
			{
				echo '<div class="callout bg-red white">Username or password is too long!</div>';
			}
		}
		else
		{
			echo '<div class="callout bg-red white">All fields are required!</div>';
		}
	}
}

function CheckLoggedIn()
{
	if(!isset($_SESSION['username']))
	{
		echo '<script>window.location.replace("login.php");</script>';
		exit();
	}
}

function CheckLoggedOut()
{
	if(isset($_SESSION['username']))
	{
		echo '<script>window.location.replace("usercp.php");</script>';
		exit();
	}
}

function Logout()
{
	if(isset($_GET['logout']))
	{
		if(!empty($_GET['logout']))
		{
			$logout = (int)$_GET['logout'];

			if($logout == '1')
			{
				session_destroy();
				header('Location: login.php');
				exit();
			}
		}
	}
}

function Login()
{
	global $con_realmd;

	if(isset($_POST['login']))
	{
		if(!empty($_POST['username']) && !empty($_POST['password']))
		{
			$username = $_POST['username'];
			$password = $_POST['password'];
			$lastip   = $_SERVER['REMOTE_ADDR'];
			$captcha  = $_POST['g-recaptcha-response'];
			$secret   = '-';
			
			if($captcha)
			{
				$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $captcha . "&remoteip=" . $lastip);
				$decode   = json_decode($response, true);

				if(intval($decode['success']) == 1)
				{
					$data = $con_realmd->prepare('SELECT COUNT(*) FROM account WHERE username = :username AND sha_pass_hash = :password');
					$data->execute(array(
						':username' => $username,
						':password' => sha1(strtoupper($username) . ':' . strtoupper($password))
					));

					if($data->fetchColumn() == 1)
					{
						$_SESSION['username'] = $username;

						echo '<div class="callout success">Success! Redirecting...</div>';

						echo '<script>
								setTimeout(function () {
								   window.location.href = "usercp.php";
								}, 2000);
							</script>';
					}
					else
					{
						echo '<div class="callout bg-red white">Username or password was wrong!</div>';
					}
				}
				else
				{
					echo '<div class="callout bg-red white">Captcha is wrong!</div>';
				}
			}
			else
			{
				echo '<div class="callout bg-red white">Please fill in captcha!</div>';
			}
		}
		else
		{
			echo '<div class="callout bg-red white">Please fill in all fields!</div>';
		}
	}
}

function GrabCharacters()
{
	global $con_realmd;
	global $con_characters;

	$username = $_SESSION['username'];

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

	$data = $con_realmd->prepare('SELECT * FROM account WHERE username = :username');
	$data->execute(array(
		':username' => $username
	));

	$result = $data->fetchAll(PDO::FETCH_ASSOC);

	foreach($result as $row)
	{
		$data = $con_characters->prepare('SELECT * FROM characters WHERE account = :id');
		$data->execute(array(
			':id' => $row['id']
		));

		while($result = $data->fetchAll(PDO::FETCH_ASSOC))
		{
			foreach($result as $row)
			{
				if(!empty(GrabGuild($row['guid'])))
				{
					$guild = '<span class="green">< ' . GrabGuild($row['guid']) . ' ></span>';
				}
				else
				{
					$guild = '&nbsp;';
				}

				echo '<div class="char-box column small-12">
						<div class="char-box-item column small-2">
							<a href="armory.php?character=' . $row['name'] . '"><span class="' . $classColor[$row['class']] . '">' . $row['name'] . '</span></a>
						</div>

						<div class="char-box-item column small-2">
							' . $guild . '
						</div>

						<div class="char-box-item column small-2">
							' . $faction[$row['race']] . '
						</div>

						<div class="char-box-item column small-2">
							<img src="' . $race[$row['race']][$row['gender']] . '" width="23" height="23">
						</div>

						<div class="char-box-item column small-2">
							<img src="' . $class[$row['class']] . '" width="23" height="23">
						</div>

						<div class="char-box-item column small-2">
							<span class="orange">Level</span> ' . $row['level'] . '
						</div>
					</div>';
			}
		}
	}
}

function ChangePassword()
{
	if(isset($_POST['change']))
	{
		if(!empty($_POST['oldpassword']) && !empty($_POST['newpassword']) && !empty($_POST['repassword']))
		{
			global $con_realmd;

			$username    = $_SESSION['username'];
			$oldpassword = $_POST['oldpassword'];
			$newpassword = $_POST['newpassword'];
			$repassword  = $_POST['repassword'];

			if(strlen($oldpassword) && strlen($newpassword) && strlen($repassword) < 17)
			{
				$data = $con_realmd->prepare('SELECT COUNT(*) FROM account WHERE username = :username AND sha_pass_hash = :password');
				$data->execute(array(
					':username' => $username,
					':password' => sha1(strtoupper($username) . ":" . strtoupper($oldpassword))
				));

				if($data->fetchColumn() == 1)
				{
					if(ctype_alnum($repassword) && ctype_alnum($newpassword))
					{
						if($repassword == $newpassword)
						{
							$data = $con_realmd->prepare('UPDATE account SET sha_pass_hash = :password, sessionkey = "", v = "", s = "" WHERE username = :username');
							$data->execute(array(
								':username'    => $username,
								//':oldpassword' => sha1(strtoupper($username) . ":" . strtoupper($oldpassword)),
								':password'    => sha1(strtoupper($username) . ":" . strtoupper($repassword))
							));

							if($data)
							{
								echo '<div class="callout success">Password has been changed!</div>';
							}
							else
							{
								echo '<div class="callout bg-red white">Something went wrong!</div>';
							}
						}
						else
						{
							echo '<div class="callout bg-red white">New passwords dont match!</div>';
						}
					}
					else
					{
						echo '<div class="callout bg-red white">Password contains malicious characters!</div>';
					}
				}
				else
				{
					echo '<div class="callout bg-red white">Old password is not correct!</div>';
				}
			}
			else
			{
				echo '<div class="callout bg-red white">Password is too long!</div>';
			}
		}
		else
		{
			echo '<div class="callout bg-red white">Fields cant be blank!</div>';
		}
	}
}

function GrabAccountData($value)
{
	global $con_realmd;

	$username = $_SESSION['username'];

	if(isset($username))
	{
		$data = $con_realmd->prepare('SELECT * FROM account WHERE username = :username');
		$data->execute(array(
			':username' => $username
		));

		$result = $data->fetchAll(PDO::FETCH_ASSOC);

		foreach($result as $row)
		{
			echo ucfirst($row[$value]);
		}
	}
}

function GrabAccountStatus()
{
	global $con_realmd;

	$username = $_SESSION['username'];

	if(isset($username))
	{
		$data = $con_realmd->prepare('SELECT * FROM account WHERE username = :username');
		$data->execute(array(
			':username' => $username
		));

		$result = $data->fetchAll(PDO::FETCH_ASSOC);

		foreach($result as $row)
		{
			$data = $con_realmd->prepare('SELECT COUNT(*) FROM account_banned WHERE id = :id AND active = 1');
			$data->execute(array(
				':id' => $row['id']
			));

			if($data->fetchColumn() == 1)
			{
				echo '<span class="red">Banned</span>';
			}
			else
			{
				echo '<span class="green">Active</span>';
			}
		}
	}
}

function ShowFAQ()
{
	global $con_web;

	$data = $con_web->prepare('SELECT * FROM faq');
	$data->execute();

	$result = $data->fetchAll(PDO::FETCH_ASSOC);

	foreach($result as $row)
	{
		echo '<div id="faq-box" class="faq-box column small-12">
				<div class="faq-box-question column small-12">
					' . $row['question'] . '
				</div>

				<div id="faq-answer" class="faq-box-answer column small-12">
					' . $row['answer'] . '
				</div>
			</div>';
	}
}

function ShowStaff()
{
	global $con_web;

	$data = $con_web->prepare('SELECT * FROM staff ORDER BY rank asc');
	$data->execute();

	function GrabRank($rank)
	{
		global $con_web;

		$data = $con_web->prepare('SELECT * FROM ranks WHERE id = :id');
		$data->execute(array(
			':id' => $rank
		));

		$result = $data->fetchAll(PDO::FETCH_ASSOC);

		foreach($result as $row)
		{
			return $row['name'];
		}
	}

	function GrabRankColor($rank)
	{
		global $con_web;

		$data = $con_web->prepare('SELECT * FROM ranks WHERE id = :id');
		$data->execute(array(
			':id' => $rank
		));

		$result = $data->fetchAll(PDO::FETCH_ASSOC);

		foreach($result as $row)
		{
			return $row['color'];
		}
	}

	while($result = $data->fetchAll(PDO::FETCH_ASSOC))
	{
		foreach($result as $row)
		{
			if($row['avatar'] == '0')
			{
				$avatar = 'img/staff/default.jpg';
			}
			else
			{
				$avatar = $row['avatar'];
			}
			echo '<div class="staff column small-12 medium-3 large-2 float-left">
					<div class="staff-box column small-12">
						<div class="staff-box-header column small-12" style="background-color: ' . GrabRankColor($row['rank']) . ';">
							' . GrabRank($row['rank']) . '
						</div>

						<div class="staff-box-image">
							<img src="' . $avatar . '">
						</div>

						<div class="staff-box-content column small-12">
							' . $row['username'] . '
						</div>
					</div>
				</div>';
		}
	}
}

function RecoverPassword()
{
	global $con_web;
	global $con_realmd;

	if(isset($_POST['recover']))
	{
		if(!empty($_POST['email']))
		{
			$email = $_POST['email'];

			if(filter_var($email, FILTER_VALIDATE_EMAIL))
			{
				$captcha  = $_POST['g-recaptcha-response'];
				$secret   = '';
				$lastip   = $_SERVER['REMOTE_ADDR'];
				
				if($captcha)
				{
					$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $captcha . "&remoteip=" . $lastip);
					$decode   = json_decode($response, true);

					if(intval($decode['success']) == 1)
					{

						$data = $con_realmd->prepare('SELECT COUNT(*) FROM account WHERE email = :email');
						$data->execute(array(
							':email' => $email
						));

						if($data->fetchColumn() == 1)
						{
							function GrabUsername($email)
							{
								global $con_realmd;

								$data = $con_realmd->prepare('SELECT * FROM account WHERE email = :email');
								$data->execute(array(
									':email' => $email
								));

								$result = $data->fetchAll(PDO::FETCH_ASSOC);

								foreach($result as $row)
								{
									return $row['username'];
								}
							}

							$time   = time();
							$code   = sha1(substr(str_shuffle('1234567890ABCDEFabcdef'), 0, 20));
							$active = 1;
							$ip     = $_SERVER['REMOTE_ADDR'];

							$data = $con_web->prepare('INSERT INTO recover_emails (email, code, ip_address, received_date, active) VALUES(:email, :code, :ip, :time, :active)');
							$data->execute(array(
								':email'  => $email,
								':code'   => $code,
								':ip'     => $ip,
								':time'   => $time,
								':active' => $active
							));

							echo '<div class="callout success">An Email has been sent!</div>';

							$headers  = "From: support@northcraft.org\r\n";
							$headers .= "Reply-To: support@northcraft.org\r\n";
							$headers .= "CC: support@northcraft.org\r\n";
							$headers .= "MIME-Version: 1.0\r\n";
							$headers .= "Content-Type: text/html; charset=iso-8859-1\r\n";

							mail($email, 'Northcraft Password Reset', 'Hello ' . GrabUsername($email) . ', <br> Go here to reset your password: <a href="https://northcraft.org/reset_password.php?email=' . $email . '&code=' . $code . '">https://northcraft.org/reset_password.php?email=' . $email . '&code=' . $code . '</a>', $headers); // Change to PHPMailer Later
						}
						else
						{
							echo '<div class="callout success">An Email has been sent!</div>';
						}
					}
					else
					{
						echo '<div class="callout bg-red white">Captcha is wrong!</div>';
					}
				}
				else
				{
					echo '<div class="callout bg-red white">Please fill in captcha!</div>';
				}
			}
			else
			{
				echo '<div class="callout bg-red white">Please fill in a valid email!</div>';
			}
		}
		else
		{
			echo '<div class="callout bg-red white">Please fill in a email!</div>';
		}
	}
}

function ResetPassword()
{
	global $con_web;
	global $con_realmd;

	if(isset($_GET['email']) && isset($_GET['code']))
	{
		$email = $_GET['email'];
		$code  = $_GET['code'];

		$data = $con_web->prepare('SELECT COUNT(*) FROM recover_emails WHERE email = :email AND code = :code AND active = 1');
		$data->execute(array(
			':email' => $email,
			':code'  => $code
		));

		if($data->fetchColumn() == 1)
		{
			if(isset($_POST['password']) && isset($_POST['repassword']))
			{
				if(!empty($_POST['password']) || !empty($_POST['repassword']))
				{
					if(strlen($_POST['password']) && strlen($_POST['repassword']) < 17)
					{
						$password   = $_POST['password'];
						$repassword = $_POST['repassword'];

						if(ctype_alnum($password) && ctype_alnum($repassword))
						{
							$data = $con_realmd->prepare('SELECT * FROM account WHERE email = :email');
							$data->execute(array(
								':email' => $email
							));

							$result = $data->fetchAll(PDO::FETCH_ASSOC);

							foreach($result as $row)
							{
								$username = $row['username'];
							}

							if($password == $repassword)
							{
								$data = $con_realmd->prepare('UPDATE account SET sha_pass_hash = :password, sessionkey = "", v = "", s = "" WHERE email = :email');
								$data->execute(array(
									':email'    => $email,
									':password' => sha1(strtoupper($username) . ':' . strtoupper($password))
								));

								$data = $con_web->prepare('UPDATE recover_emails SET active = 0 WHERE email = :email AND code = :code');
								$data->execute(array(
									':email' => $email,
									':code'  => $code
								));

								echo '<div class="callout success">Password has been changed!</div>';
							}
							else
							{
								echo '<div class="callout bg-red white">Passwords dont match password!</div>';
							}
						}
						else
						{
							echo '<div class="callout bg-red white">Password contains malicious characters!</div>';
						}
					}
					else
					{
						echo '<div class="callout bg-red white">Password is too long!</div>';
					}
				}	
				else
				{
					echo '<div class="callout bg-red white">Please fill all fields!</div>';
				}
			}
		}
		else
		{
			echo '<script>window.location.replace("https://northcraft.org");</script>';
		}
	}
	else
	{
		echo '<script>window.location.replace("https://northcraft.org");</script>';
	}
}

function RedeemCode()
{
	global $con_web;
	global $con_characters;

	if(isset($_POST['redeem']))
	{
		if(!empty($_POST['code']) && !empty($_POST['character']))
		{
			$code      = $_POST['code'];
			$character = $_POST['character'];
			$ip        = $_SERVER['REMOTE_ADDR'];
			$captcha   = $_POST['g-recaptcha-response'];
			$secret    = '';
			$time      = time();

			if(isset($captcha))
			{
				$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $captcha . "&remoteip=" . $ip);
				$decode   = json_decode($response, true);

				if(intval($decode['success']) == 1)
				{
					$data = $con_web->prepare('SELECT COUNT(*) FROM reward_system WHERE code = :code AND active = 1');
					$data->execute(array(
						':code' => $code
					));

					if($data->fetchColumn() == 1)
					{
						$data = $con_characters->prepare('SELECT COUNT(*) FROM characters WHERE name = :name');
						$data->execute(array(
							':name' => ucfirst(strtolower($character))
						));

						if($data->fetchColumn() == 1)
						{
							$data = $con_characters->prepare('SELECT * FROM characters WHERE name = :name');
							$data->execute(array(
								':name' => ucfirst(strtolower($character))
							));

							$result = $data->fetchAll(PDO::FETCH_ASSOC);

							foreach($result as $row)
							{
								$id = $row['guid'];
							}

							$data = $con_web->prepare('SELECT * FROM reward_system WHERE code = :code AND active = 1');
							$data->execute(array(
								':code' => $code
							));

							$result = $data->fetchAll(PDO::FETCH_ASSOC);

							foreach($result as $row2)
							{
								$reward = $row2['reward'];
							}

							$send_time   = time();
							$expire_time = strtotime('+30 day', $send_time);
							$mail_id     = substr(str_shuffle('123456789'), 0, 9);
							$instance_id = substr(str_shuffle('123456789'), 0, 9);

							$data = $con_characters->prepare('INSERT INTO mail (id, messageType, stationery, mailTemplateId, sender, receiver, subject, body, has_items, expire_time, deliver_time, money, cod, checked) 
								VALUES(:mail_id, 0, 61, 0, 0, :id, "Here is your Reward", "Thank you for supporting our server, we really appreciate your support. 

									Regards, 
									Northcraft STAFF", 1, :expire, :deliver, 0, 0, 0)');
							$data->execute(array(
								':mail_id'  => $mail_id,
								':id'       => $id,
								':expire'   => $expire_time,
								':deliver'  => $send_time
							));

							$data = $con_characters->prepare('INSERT INTO item_instance (guid, itemEntry, owner_guid, creatorGuid, giftCreatorGuid, count, duration, charges, flags, enchantments, randomPropertyId, durability, playedTime, text) 
								VALUES(:instance_id, :reward, :id, 0, 0, 1, 0, "1 0 0 0 0 ", 0, "0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ", 0, 0, 0, "")');
							$data->execute(array(
								':instance_id' => $instance_id,
								':reward'      => $reward,
								':id'          => $id
							));

							$data = $con_characters->prepare('INSERT INTO mail_items (mail_id, item_guid, receiver) VALUES(:mail_id, :item_guid, :receiver)');
							$data->execute(array(
								':mail_id'   => $mail_id,
								':item_guid' => $instance_id,
								':receiver'  => $id
							));

							$data = $con_web->prepare('UPDATE reward_system SET active = 0, redeemed_on = :character, ip_used = :ip, time_used = :time WHERE code = :code');
							$data->execute(array(
								':code'      => $code,
								':character' => ucfirst(strtolower($character)),
								':ip'        => $ip,
								':time'      => $time
							));

							echo '<div class="callout success">Code has been redeemed!</div>';
						}
						else
						{
							echo '<div class="callout bg-red white">Character was not found!</div>';
						}
					}
					else
					{
						echo '<div class="callout bg-red white">Code was not found in our database!</div>';
					}
				}
				else
				{
					echo '<div class="callout bg-red white">Wrong captcha!</div>';
				}
			}
			else
			{
				echo '<div class="callout bg-red white">Please fill in the captcha!</div>';
			}
		}
		else
		{
			echo '<div class="callout bg-red white">Please fill in all fields!</div>';
		}
	}
}

function HallsOfFame()
{
	global $con_characters;

	function GrabPlayer($guid)
	{
		global $con_characters;

		$data = $con_characters->prepare('SELECT * FROM characters WHERE guid = :guid');
		$data->execute(array(
			':guid' => $guid
		));

		$result = $data->fetchAll(PDO::FETCH_ASSOC);

		foreach($result as $row)
		{
			return $row['name'];
		}
	}

	$ach = array(
		// Level 80
		457 => array(
			0 => 'Realm First! Level 80',
			1 => 'First person on the realm to achieve level 80.',
			2 => '< Name > The Supreme',
			3 => 'img/achievement/achievement_level_80.jpg'
		),



		// Primary Professions
		1415 => array(
			0 => 'Realm First! Grand Master Alchemist',
			1 => 'First person on the realm to achieve 450 skill in alchemy.',
			2 => 'Grand Master Alchemist < Name >',
			3 => 'img/achievement/achievement_alchemy.jpg'
		),

		1414 => array(
			0 => 'Realm First! Grand Master Blacksmith',
			1 => 'First person on the realm to achieve 450 skill in blacksmithing.',
			2 => 'Grand Master Blacksmith < Name >',
			3 => 'img/achievement/achievement_blacksmithing.jpg'
		),

		1417 => array(
			0 => 'Realm First! Grand Master Enchanter',
			1 => 'First person on the realm to achieve 450 skill in enchanting.',
			2 => 'Grand Master Enchanter < Name >',
			3 => 'img/achievement/achievement_enchanting.jpg'
		),

		1418 => array(
			0 => 'Realm First! Grand Master Engineer',
			1 => 'First person on the realm to achieve 450 skill in engineering.',
			2 => 'Grand Master Engineer < Name >',
			3 => 'img/achievement/achievement_engineering.jpg'
		),

		1421 => array(
			0 => 'Realm First! Grand Master Herbalist',
			1 => 'First person on the realm to achieve 450 skill in herbalism.',
			2 => 'Grand Master Herbalist < Name >',
			3 => 'img/achievement/achievement_herbalism.jpg'
		),

		1423 => array(
			0 => 'Realm First! Grand Master Jewelcrafter',
			1 => 'First person on the realm to achieve 450 skill in jewelcrafting.',
			2 => 'Grand Master Jewelcrafter < Name >',
			3 => 'img/achievement/achievement_jewelcrafting.jpg'
		),

		1424 => array(
			0 => 'Realm First! Grand Master Leatherworker',
			1 => 'First person on the realm to achieve 450 skill in leatherworking.',
			2 => 'Grand Master Leatherworker < Name >',
			3 => 'img/achievement/achievement_leatherworking.jpg'
		),

		1425 => array(
			0 => 'Realm First! Grand Master Miner',
			1 => 'First person on the realm to achieve 450 skill in mining.',
			2 => 'Grand Master Miner < Name >',
			3 => 'img/achievement/achievement_mining.jpg'
		),

		1422 => array(
			0 => 'Realm First! Grand Master Scribe',
			1 => 'First person on the realm to achieve 450 skill in inscription.',
			2 => 'Grand Master Scribe < Name >',
			3 => 'img/achievement/achievement_inscription.jpg'
		),

		1426 => array(
			0 => 'Realm First! Grand Master Skinner',
			1 => 'First person on the realm to achieve 450 skill in skinning.',
			2 => 'Grand Master Skinner < Name >',
			3 => 'img/achievement/achievement_skinning.jpg'
		),

		1427 => array(
			0 => 'Realm First! Grand Master Tailor',
			1 => 'First person on the realm to achieve 450 skill in tailoring.',
			2 => 'Grand Master Tailor < Name >',
			3 => 'img/achievement/achievement_tailoring.jpg'
		),



		// Secondary Professions
		1420 => array(
			0 => 'Realm First! Grand Master Angler',
			1 => 'First person on the realm to achieve 450 skill in fishing.',
			2 => 'Grand Master Angler < Name >',
			3 => 'img/achievement/achievement_fishing.jpg'
		),

		1416 => array(
			0 => 'Realm First! Cooking Grand Master',
			1 => 'First person on the realm to achieve 450 skill in cooking.',
			2 => 'Iron Chef < Name >',
			3 => 'img/achievement/achievement_cooking.jpg'
		),

		1419 => array(
			0 => 'Realm First! First Aid Grand Master',
			1 => 'First person on the realm to achieve 450 skill in first aid.',
			2 => 'Doctor < Name >',
			3 => 'img/achievement/achievement_firstaid.jpg'
		),



		// Classes
		461 => array(
			0 => 'Realm First! Level 80 Death Knight',
			1 => 'First death knight on the realm to achieve level 80.',
			2 => '< Name > Of the Ebon Blade',
			3 => 'img/achievement/achievement_deathknight.jpg'
		),

		466 => array(
			0 => 'Realm First! Level 80 Druid',
			1 => 'First druid on the realm to achieve level 80.',
			2 => 'Arch Druid < Name >',
			3 => 'img/achievement/achievement_druid.jpg'
		),

		462 => array(
			0 => 'Realm First! Level 80 Hunter',
			1 => 'First hunter on the realm to achieve level 80.',
			2 => 'Stalker < Name >',
			3 => 'img/achievement/achievement_hunter.jpg'
		),

		460 => array(
			0 => 'Realm First! Level 80 Mage',
			1 => 'First mage on the realm to achieve level 80.',
			2 => 'Archmage < Name >',
			3 => 'img/achievement/achievement_mage.jpg'
		),

		465 => array(
			0 => 'Realm First! Level 80 Paladin',
			1 => 'First paladin on the realm to achieve level 80.',
			2 => 'Crusader < Name >',
			3 => 'img/achievement/achievement_paladin.jpg'
		),

		464 => array(
			0 => 'Realm First! Level 80 Priest',
			1 => 'First priest on the realm to achieve level 80.',
			2 => 'Prophet < Name >',
			3 => 'img/achievement/achievement_priest.jpg'
		),

		458 => array(
			0 => 'Realm First! Level 80 Rogue',
			1 => 'First rogue on the realm to achieve level 80.',
			2 => 'Assassin < Name >',
			3 => 'img/achievement/achievement_rogue.jpg'
		),

		467 => array(
			0 => 'Realm First! Level 80 Shaman',
			1 => 'First shaman on the realm to achieve level 80.',
			2 => '< Name > Of the Ten Storms',
			3 => 'img/achievement/achievement_shaman.jpg'
		),

		463 => array(
			0 => 'Realm First! Level 80 Warlock',
			1 => 'First warlock on the realm to achieve level 80.',
			2 => '< Name > The Malefic',
			3 => 'img/achievement/achievement_warlock.jpg'
		),

		459 => array(
			0 => 'Realm First! Level 80 Warrior',
			1 => 'First warrior on the realm to achieve level 80.',
			2 => 'Warbringer < Name >',
			3 => 'img/achievement/achievement_warrior.jpg'
		),



		// Races
		1405 => array(
			0 => 'Realm First! Level 80 Blood Elf',
			1 => 'First blood elf on the realm to achieve level 80.',
			2 => '< Name > Of Quel\'thalas',
			3 => 'img/achievement/achievement_bloodelf.jpg'
		),

		1406 => array(
			0 => 'Realm First! Level 80 Draenei',
			1 => 'First draenei on the realm to achieve level 80.',
			2 => '< Name > Of Argus',
			3 => 'img/achievement/achievement_draenei.jpg'
		),

		1407 => array(
			0 => 'Realm First! Level 80 Dwarf',
			1 => 'First dwarf on the realm to achieve level 80.',
			2 => '< Name > Of Khaz Modan',
			3 => 'img/achievement/achievement_dwarf.jpg'
		),

		1413 => array(
			0 => 'Realm First! Level 80 Forsaken',
			1 => 'First forsaken on the realm to achieve level 80.',
			2 => '< Name > The Forsaken',
			3 => 'img/achievement/achievement_undead.jpg'
		),

		1404 => array(
			0 => 'Realm First! Level 80 Gnome',
			1 => 'First gnome on the realm to achieve level 80.',
			2 => '< Name > Of Gnomeregan',
			3 => 'img/achievement/achievement_gnome.jpg'
		),

		1408 => array(
			0 => 'Realm First! Level 80 Human',
			1 => 'First human on the realm to achieve level 80.',
			2 => '< Name > The Lion Hearted',
			3 => 'img/achievement/achievement_human.jpg'
		),

		1409 => array(
			0 => 'Realm First! Level 80 Night Elf',
			1 => 'First night elf on the realm to achieve level 80.',
			2 => '< Name > Champion of Elune',
			3 => 'img/achievement/achievement_nightelf.jpg'
		),

		1410 => array(
			0 => 'Realm First! Level 80 Orc',
			1 => 'First orc on the realm to achieve level 80.',
			2 => '< Name > Hero of Orgrimmar',
			3 => 'img/achievement/achievement_orc.jpg'
		),

		1411 => array(
			0 => 'Realm First! Level 80 Tauren',
			1 => 'First tauren on the realm to achieve level 80.',
			2 => '< Name > Plainsrunner',
			3 => 'img/achievement/achievement_tauren.jpg'
		),

		1412 => array(
			0 => 'Realm First! Level 80 Troll',
			1 => 'First troll on the realm to achieve level 80.',
			2 => '< Name > Of the Darkspear',
			3 => 'img/achievement/achievement_troll.jpg'
		),



		// Reputation
		1463 => array(
			0 => 'Realm First! Northrend Vanguard',
			1 => 'First player on the realm to gain exalted reputation with the Argent Crusade, Wyrmrest Accord, Kirin Tor and Knights of the Ebon Blade.',
			2 => '',
			3 => 'img/achievement/'
		),



		// Raids
		1402 => array(
			0 => 'Realm First! Conqueror of Naxxramas',
			1 => 'Participated in the realm first defeat of Kel\'Thuzad in Naxxramas in 25-player mode.',
			2 => '',
			3 => 'img/achievement/'
		),

		1400 => array(
			0 => 'Realm First! Magic Seeker',
			1 => 'Participated in the realm first defeat of Malygos in 25-player mode.',
			2 => '',
			3 => 'img/achievement/'
		),

		456  => array(
			0 => 'Realm First! Obsidian Slayer',
			1 => 'Participated in the realm first defeat of Sartharion the Onyx Guardian in 25-player mode.',
			2 => '',
			3 => 'img/achievement/'
		),

		3259 => array(
			0 => 'Realm First! Celestial Defender',
			1 => 'Participated in the realm first defeat of Algalon the Observer in 25-player mode.',
			2 => '',
			3 => 'img/achievement/'
		),

		3117 => array(
			0 => 'Realm First! Death\'s Demise',
			1 => 'Participated in the realm first defeat of Yogg-Saron without the assistance of any Keepers in 25-player mode.',
			2 => '',
			3 => 'img/achievement/'
		),

		4078 => array(
			0 => 'Realm First! Grand Crusader',
			1 => 'Participated in the realm first conquest of the Trial of the Grand Crusader with 50 attempts remaining in 25-player mode.',
			2 => '',
			3 => 'img/achievement/'
		),

		4576 => array(
			0 => 'Realm First! Fall of the Lich King',
			1 => 'Participated in the realm first defeat of the Lich King in 25-player heroic mode.',
			2 => '',
			3 => 'img/achievement/'
		)
	);

	$data = $con_characters->prepare('SELECT * FROM character_achievement WHERE achievement IN(457, 1415, 1414, 1417, 1418, 1421, 1423, 1424, 1425, 1422, 1426, 1427, 1420, 1416, 1419, 461, 466, 462, 460, 465, 464, 458, 467, 463, 459, 1405, 1406, 1407, 1413, 1404, 1408, 1409, 1410, 1411, 1412) ORDER BY achievement ASC');
	$data->execute();

	while($result = $data->fetchAll(PDO::FETCH_ASSOC))
	{
		foreach($result as $row)
		{
			echo '<div class="ach-image column medium-12 show-for-medium">
					<img src="img/achievement/achievement_base.png">

					<div class="ach-icon">
						<img src="' . $ach[$row['achievement']][3] . '" width="49">
					</div>

					<div class="ach-title">
						' . GrabPlayer($row['guid']) . ' ' . $ach[$row['achievement']][0] . '
					</div>

					<div class="ach-description">
						' . $ach[$row['achievement']][1] . '
					</div>

					<div class="ach-reward">
						Title Reward: ' . $ach[$row['achievement']][2] . '
					</div>
				</div>';
		}
	}
}

function GrabShopItems($type)
{
	global $con_web;

	$data = $con_web->prepare('SELECT * FROM shop WHERE product_type = :type');
	$data->execute(array(
		':type' => $type
	));

	$result = $data->fetchAll(PDO::FETCH_ASSOC);

	foreach($result as $row)
	{
		echo '<tr>
				<td><a href="https://db.rising-gods.de/?item=' . $row['entry'] . '"></a></td>
				<td>€' . $row['price'] . '</td>
				<td class="item-right"><a href="gateway/checkout.php?type=SHOP&product_id=' . $row['product_id'] . '" class="small button">BUY</a></td>
			</tr>';
	}
}

function LoggingSystem()
{
	global $con_web;

	$ip      = $_SERVER['REMOTE_ADDR'];
	$agent   = $_SERVER['HTTP_USER_AGENT'];
	$time    = time();

	$data = $con_web->prepare('INSERT INTO logging_system (ip, agent, time) VALUES(:ip, :agent, :time)');
	$data->execute(array(
		':ip'    => $ip,
		':agent' => $agent,
		':time'  => $time
	));
}

function Blacklist()
{
	global $con_web;

	$ip = $_SERVER['REMOTE_ADDR'];

	$data = $con_web->prepare('SELECT COUNT(*) FROM blacklist WHERE ip = :ip');
	$data->execute(array(
		':ip' => $ip
	));

	if($data->fetchColumn() == 1)
	{
		header('Location: https://www.youtube.com/watch?v=mj-v6zCnEaw');
	}
}

?>