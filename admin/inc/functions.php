<?php

function LogAction($username, $parameter, $ip, $time)
{
	global $con;

	$data = $con->prepare('INSERT INTO logs (username, parameter, current_ip, log_time) VALUES(:username, :parameter, :current_ip, :log_time)');
	$data->execute(array(
		':username'   => $username,
		':parameter'  => $parameter,
		':current_ip' => $ip,
		':log_time'   => $time
	));
}


function CheckLoggedIn()
{
	if(!isset($_SESSION['username']) || !isset($_SESSION['password']))
	{
		header('Location: login.php');
		exit();
	}
}

function CheckLoggedOut()
{
	if(isset($_SESSION['username']) && isset($_SESSION['password']))
	{
		header('Location: index.php');
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
				LogAction($_SESSION['username'], "Logged out of the admin panel", $_SERVER['REMOTE_ADDR'], time());

				session_start();
				session_destroy();
				header('Location: login.php');
				exit();
			}
		}
	}
}

function ChangePassword()
{
	if(isset($_POST['changepassword']))
	{
		if(!empty($_POST['oldpassword']) && !empty($_POST['newpassword']) && !empty($_POST['repassword']))
		{
			global $con;

			$username    = $_SESSION['username'];

			$data = $con->prepare('SELECT * FROM users WHERE username = :username');
			$data->execute(array(
				':username' => $username
			));

			$result = $data->fetchAll(PDO::FETCH_ASSOC);

			foreach($result as $row)
			{
				$charset = 'abcdefghijklmnopqrstuvwxyz0123456789';
				$salt    = substr(str_shuffle($charset), 1, 10);

				$oldpassword = sha1(strtoupper($username) . $row['salt'] . ':' . $row['salt'] . strtoupper($_POST['oldpassword']));
				$newpassword = $_POST['newpassword'];
				$repassword  = $_POST['repassword'];
				$password 	 = $row['password'];

				if($oldpassword == $password)
				{
					if($newpassword == $repassword)
					{
						$data = $con->prepare('UPDATE users SET password = :password, salt = :salt WHERE username = :username');
						$data->execute(array(
							':password' => sha1(strtoupper($username) . $salt . ':' . $salt . strtoupper($repassword)),
							':salt'     => $salt,
							':username' => $username
						));

						echo '<span class="green">Successfully changed password!</span>';

						LogAction($_SESSION['username'], "Changed password on account", $_SERVER['REMOTE_ADDR'], time());
					}
					else
					{
						echo '<span class="red">Passwords dont match!</span>';
					}
				}
				else
				{
					echo '<span class="red">Current password is not correct!</span>';
				}
			}

		}
		else
		{
			echo '<span class="red">Fields cant be blank!</span>';
		}
	}
}

function CreateUser()
{
	if(isset($_POST['create']))
	{
		if(!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['repassword']))
		{
			global $con;

			$username     = $_POST['username'];
			$email        = $_POST['email'];
			$password     = $_POST['password'];
			$repassword   = $_POST['repassword'];
			$level        = $_POST['level'];
			$charset      = 'abcdefghijklmnopqrstuvwxyz0123456789';
			$salt         = substr(str_shuffle($charset), 1, 10);
			$ip           = '';
			$registerip   = $_SERVER['REMOTE_ADDR'];
			$registerdate = time();

			$data = $con->prepare('SELECT COUNT(*) FROM users WHERE username = :username');
			$data->execute(array(
				':username' => $username
			));

			if($data->fetchColumn() == 0)
			{
				if(filter_var($email, FILTER_VALIDATE_EMAIL))
				{
					if($repassword == $password)
					{
						$data = $con->prepare('INSERT INTO users (username, email, password, salt, level, ip, register_ip, register_date) VALUES(:username, :email, :password, :salt, :level, :ip, :register_ip, :register_date)');
						$data->execute(array(
							':username'      => $username,
							':email'         => $email,
							':password'      => sha1(strtoupper($username) . $salt . ':' . $salt . strtoupper($password)),
							':salt'          => $salt,
							':level'         => $level,
							':ip'            => $ip,
							':register_ip'   => $registerip,
							':register_date' => $registerdate
						));

						echo '<span class="green">Successfully created user!</span>';

						LogAction($_SESSION['username'], "Created new admin panel user: " . $username . " : email = " . $email . " : level = " . $level, $_SERVER['REMOTE_ADDR'], time());
					}
					else
					{
						echo '<span class="red">Passwords dont match!</span>';
					}
				}
				else
				{
					echo '<span class="red">Email is invalid!</span>';
				}
			}
			else
			{
				echo '<span class="red">Username already taken!</span>';
			}
		}
		else
		{
			echo '<span class="red">Fields cant be blank!</span>';
		}
	}
}

function Permission($page)
{
	global $con;

	$user = $_SESSION['username'];

	$data = $con->prepare('SELECT COUNT(*) FROM users WHERE username = :user');
	$data->execute(array(
		':user' => $user
	));

	if($data->fetchColumn() == 1)
	{
		$user_data = $con->prepare('SELECT * FROM users WHERE username = :user');
		$user_data->execute(array(
			':user' => $user
		));

		$result_user = $user_data->fetchAll(PDO::FETCH_ASSOC);

		foreach($result_user as $user)
		{
			$data = $con->prepare('SELECT * FROM permissions WHERE page_id = :page');
			$data->execute(array(
				':page' => $page
			));

			$result = $data->fetchAll(PDO::FETCH_ASSOC);

			foreach($result as $row)
			{
				if($user['level'] >= $row['permission'])
				{
					
				}
				else
				{
					die('<div class="row">
							<div class="content">
								<div class="content-content column small-12 medium-12 large-12">
									<div class="content-box column small-12 medium-12">
										<div class="error-box-content column small-12">
											You dont have permission!
										</div>
									</div>
								</div>
							</div>
						</div>');
				}
			}
		}
	}
	else
	{
		die('<div class="row">
				<div class="content">
					<div class="content-content column small-12 medium-12 large-12">
						<div class="content-box column small-12 medium-12">
							<div class="error-box-content column small-12">
								You dont have permission!
							</div>
						</div>
					</div>
				</div>
			</div>');
	}
}



function Menu()
{
	global $con;

	$user = $_SESSION['username'];

	$data = $con->prepare('SELECT COUNT(*) FROM users WHERE username = :user');
	$data->execute(array(
		':user' => $user
	));

	if($data->fetchColumn() == 1)
	{
		$user_data = $con->prepare('SELECT * FROM users WHERE username = :user');
		$user_data->execute(array(
			':user' => $user
		));

		$result_user = $user_data->fetchAll(PDO::FETCH_ASSOC);

		foreach($result_user as $user)
		{
			$data = $con->prepare('SELECT * FROM permissions');
			$data->execute();

			$result = $data->fetchAll(PDO::FETCH_ASSOC);

			foreach($result as $row)
			{
				$index     = '';
				$news      = '';
				$faq       = '';
				$media     = '';
				$users     = '';
				$settings  = '';
				$tickets   = '';
				$loot      = '';
				$commands  = '';
				$streamers = '';
				$staff     = '';
				//$gold      = '';
				$accounts  = '';

				switch(strtolower(basename($_SERVER['PHP_SELF'])))
				{
					case '':
						$index = 'current-nav';
					break;

					case 'index.php':
						$index = 'current-nav';
					break;

					case 'news.php':
						$news = 'current-nav';
					break;

					case 'newpost.php':
						$news = 'current-nav';
					break;

					case 'faq.php':
						$faq = 'current-nav';
					break;

					case 'newfaq.php':
						$faq = 'current-nav';
					break;

					case 'media.php':
						$media = 'current-nav';
					break;

					case 'users.php':
						$users = 'current-nav';
					break;

					case 'settings.php':
						$settings = 'current-nav';
					break;

					case 'tickets.php':
						$tickets = 'current-nav';
					break;

					case 'loot.php':
						$loot = 'current-nav';
					break;

					case 'commands.php':
						$commands = 'current-nav';
					break;

					case 'streamers.php':
						$streamers = 'current-nav';
					break;

					case 'newstreamer.php':
						$streamers = 'current-nav';
					break;

					case 'staff.php':
						$staff = 'current-nav';
					break;

					case 'newstaff.php':
						$staff = 'current-nav';
					break;

					/*case 'gold.php':
						$gold = 'current-nav';
					break;*/

					case 'accounts.php':
						$accounts = 'current-nav';
					break;
				}

				if($row['page_id'] == 1)
				{
					if($user['level'] >= $row['permission'])
					{
						echo '<li><a href="index.php" class="' . $index . '"><i class="fa fa-tachometer" aria-hidden="true"></i>Dashboard</a></li>';
					}
				}
				elseif($row['page_id'] == 2)
				{
					if($user['level'] >= $row['permission'])
					{
						echo '<li><a href="news.php" class="' . $news . '"><i class="fa fa-file-text" aria-hidden="true"></i>News</a></li>';
					}
				}
				elseif($row['page_id'] == 3)
				{
					if($user['level'] >= $row['permission'])
					{
						echo '<li><a href="faq.php" class="' . $faq . '"><i class="fa fa-question-circle-o" aria-hidden="true"></i>FAQ</a></li>';
					}
				}
				elseif($row['page_id'] == 4)
				{
					if($user['level'] >= $row['permission'])
					{
						echo '<li><a href="media.php" class="' . $media . '"><i class="fa fa-picture-o" aria-hidden="true"></i>Media</a></li>';
					}
				}
				elseif($row['page_id'] == 5)
				{
					if($user['level'] >= $row['permission'])
					{
						echo '<li><a href="users.php" class="' . $users . '"><i class="fa fa-users" aria-hidden="true"></i>Users</a></li>';
					}
				}
				elseif($row['page_id'] == 6)
				{
					if($user['level'] >= $row['permission'])
					{
						echo '<li><a href="settings.php" class="' . $settings . '"><i class="fa fa-cog" aria-hidden="true"></i>Settings</a></li>';
					}
				}
				elseif($row['page_id'] == 7)
				{
					if($user['level'] >= $row['permission'])
					{
						echo '<li><a href="tickets.php" class="' . $tickets . '"><i class="fa fa-ticket" aria-hidden="true"></i>Tickets</a></li>';
					}
				}
				elseif($row['page_id'] == 8)
				{
					if($user['level'] >= $row['permission'])
					{
						echo '<li><a href="loot.php" class="' . $loot . '"><i class="fa fa-diamond" aria-hidden="true"></i>Loot</a></li>';
					}
				}
				elseif($row['page_id'] == 9)
				{
					if($user['level'] >= $row['permission'])
					{
						echo '<li><a href="commands.php" class="' . $commands . '"><i class="fa fa-flask" aria-hidden="true"></i>Commands</a></li>';
					}
				}
				elseif($row['page_id'] == 10)
				{
					if($user['level'] >= $row['permission'])
					{
						echo '<li><a href="streamers.php" class="' . $streamers . '"><i class="fa fa-twitch" aria-hidden="true"></i>Streamers</a></li>';
					}
				}
				elseif($row['page_id'] == 11)
				{
					if($user['level'] >= $row['permission'])
					{
						echo '<li><a href="staff.php" class="' . $staff . '"><i class="fa fa-university" aria-hidden="true"></i>Staff</a></li>';
					}
				}
				/*elseif($row['page_id'] == 12)
				{
					if($user['level'] >= $row['permission'])
					{
						echo '<li><a href="gold.php" class="' . $gold . '"><i class="fa fa-server" aria-hidden="true"></i>Gold</a></li>';
					}
				}*/
				elseif($row['page_id'] == 13)
				{
					if($user['level'] >= $row['permission'])
					{
						echo '<li><a href="accounts.php" class="' . $accounts . '"><i class="fa fa-server" aria-hidden="true"></i>Accounts</a></li>';
					}
				}
			}
		}
	}
}




function Login()
{
	if(isset($_POST['login']))
	{
		if(!empty($_POST['username']) && !empty($_POST['password']))
		{
			global $con;

			$username   = $_POST['username'];
			$password   = $_POST['password'];
			$captcha    = $_POST['g-recaptcha-response'];
			$secret     = '';
			$current_ip = $_SERVER['REMOTE_ADDR'];

			$data = $con->prepare('SELECT COUNT(*) FROM users WHERE username = :username');
			$data->execute(array(
				':username' => $username
			));

			if($data->fetchColumn() == 1)
			{
				if($captcha)
				{
					$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $captcha . "&remoteip=" . $current_ip);
					$decode   = json_decode($response, true);

					if(intval($decode['success']) == 1)
					{
						$data = $con->prepare('SELECT * FROM users WHERE username = :username');
						$data->execute(array(
							':username' => $username
						));

						$result = $data->fetchAll(PDO::FETCH_ASSOC);

						foreach($result as $row)
						{
							$data = $con->prepare('SELECT COUNT(*) FROM users WHERE username = :username AND password = :password AND salt = :salt');
							$data->execute(array(
								':username'   => $username,
								':password'   => sha1(strtoupper($username) . $row['salt'] . ':' . $row['salt'] . strtoupper($password)),
								':salt'       => $row['salt']
							));

							if($data->fetchColumn() == 1)
							{
								$data = $con->prepare('UPDATE users SET ip = :current_ip WHERE username = :username');
								$data->execute(array(
									':username'   => $username,
									':current_ip' => $current_ip
								));

								$_SESSION['username'] = $username;
								$_SESSION['password'] = $password;

								echo '<span class="green">Success! Logging in..</span>';

								echo '<meta http-equiv="refresh" content="1; url=index.php" />';

								LogAction($username, "Logged into the admin panel", $current_ip, time());
							}
							else
							{
								echo '<span class="red">Wrong username or password!</span>';
							}
						}
					}
					else
					{
						echo '<span class="red">Captcha was incorrect!</span>';
					}
				}
				else
				{
					echo '<span class="red">Captcha is required!</span>';
				}
			}
			else
			{
				echo '<span class="red">Wrong username or password!</span>';
			}
		}
		else
		{
			echo '<span class="red">Fields cant be blank!</span>';
		}
	}
}

function WebsiteInformation($value)
{
	switch($value)
	{
		case 'NAME':
			//Website Name
		break;

		case 'USER':
			$username = '<span class="green">' . ucfirst($_SESSION['username']) . '</span>';
			return $username;
		break;

		case 'EMAIL':
			global $con;

			$username = $_SESSION['username'];

			$data = $con->prepare('SELECT * FROM users WHERE username = :username');
			$data->execute(array(
				':username' => $username
			));

			$result = $data->fetchAll(PDO::FETCH_ASSOC);

			foreach($result as $row)
			{
				return '<span class="green">' . $row['email'] . '</span>';
			}
		break;

		case 'IP':
			global $con;

			$username = $_SESSION['username'];

			$data = $con->prepare('SELECT * FROM users WHERE username = :username');
			$data->execute(array(
				':username' => $username
			));

			$result = $data->fetchAll(PDO::FETCH_ASSOC);

			foreach($result as $row)
			{
				return '<span class="green">' . $row['ip'] . '</span>';
			}
		break;

		case 'LEVEL':
			global $con;

			$username = $_SESSION['username'];

			$rank = array(
				0 => 'No Access',
				1 => '<span class="orange">Game Master</span>',
				2 => '<span class="red">Moderator</span>',
				3 => '<span class="green">Administrator</span>'
			);

			$data = $con->prepare('SELECT * FROM users WHERE username = :username');
			$data->execute(array(
				':username' => $username
			));

			$result = $data->fetchAll(PDO::FETCH_ASSOC);

			foreach($result as $row)
			{
				return  $rank[$row['level']];
			}
		break;
	}
}

function WebStatistics($value)
{
	switch($value)
	{
		case 'UPTIME':
			global $con_realmd;

			$data = $con_realmd->prepare('SELECT * FROM uptime ORDER by id DESC LIMIT 1');
			$data->execute();

			$result = $data->fetchAll(PDO::FETCH_ASSOC);

			function Uptime($time)
			{
				$start   = date('Y-m-d H:i:s', $time);
				$current = date('Y-m-d H:i:s', time());

				$datetime1 = new DateTime($start);
				$datetime2 = new DateTime($current);
				
				$interval  = $datetime1->diff($datetime2);

				return $interval->format('%dd %hh %im %ss');
			}

			foreach($result as $row)
			{
				$time = $row['starttime'];

				return '<span class="green">' . Uptime($time) . '</span>';
			}
		break;

		case 'CHARS':
			global $con_char;

			$data = $con_char->prepare('SELECT COUNT(*) FROM characters');
			$data->execute();

			$result = $data->fetchColumn();

			return '<span class="green">' . $result . '</span>';
		break;

		case 'TICKETS':
			global $con_char;

			$data = $con_char->prepare('SELECT COUNT(*) FROM gm_tickets');
			$data->execute();

			$result = $data->fetchColumn();

			return '<span class="green">' . $result . '</span>';
		break;

		case 'ONLINE':
			global $con_char;

			$data = $con_char->prepare('SELECT COUNT(*) FROM characters WHERE online = 1');
			$data->execute();

			$result = $data->fetchColumn();

			return '<span class="green">' . $result . '</span>';
		break;
	}
}

function SystemInformation($value)
{
	switch($value)
	{
		case 'PHP':
			return '<span class="green">' . phpversion() . '</span>';
		break;

		case 'SERVER':
			$server = explode('(', $_SERVER['SERVER_SOFTWARE']);
			$output = str_replace('/', ' ', $server[0]);
			return '<span class="green">' . $output . '</span>';
		break;

		case 'CMS':
			global $con;

			$data = $con->prepare('SELECT * FROM system');
			$data->execute();

			$result = $data->fetchAll(PDO::FETCH_ASSOC);

			foreach($result as $row)
			{
				return '<span class="green">' . $row['version'] . '</span>';
			}
		break;

		case 'ERRORS':
			return '<span class="green">' . 0 . '</span>';
		break;
	}
}

function UserList()
{
	global $con;

	$data = $con->prepare('SELECT * FROM users ORDER BY level DESC');
	$data->execute();

	echo '<table>
			<th>#</th>
			<th>Username</th>
			<th>Email</th>
			<th>Access</th>
			<th>Current IP</th>
			<th>Register IP</th>
			<th>Register Date</th>
			<th></th>
			<th></th>';

	$rank = array(
		0 => 'No Access',
		1 => '<span class="orange">Game Master</span>',
		2 => '<span class="red">Moderator</span>',
		3 => '<span class="green">Administrator</span>'
	);

	while($result = $data->fetchAll(PDO::FETCH_ASSOC))
	{
		foreach($result as $row)
		{
			echo '<tr>
					<td>' . $row['id'] . '</td>
					<td>' . $row['username'] . '</td>
					<td>' . $row['email'] . '</td>
					<td>' . $rank[$row['level']] . '</td>
					<td>' . $row['ip'] . '</td>
					<td>' . $row['register_ip'] . '</td>
					<td>' . date('H:i:s - d. F, Y', $row['register_date']) . '</td>
					<td><a href="?uedit=' . $row['id'] . '" title="Edit"><i class="fa fa-pencil yellow" aria-hidden="true"></i></a></td>
					<td><a href="?udelete=' . $row['id'] . '" title="Delete" onclick="return confirm(\'Are you sure?\')"><i class="fa fa-trash red" aria-hidden="true"></i></a></td>
				</tr>';
		}
	}

	echo '</table>';
}

function EditUser()
{
	if(isset($_GET['uedit']))
	{
		global $con;

		$id = (int)$_GET['uedit'];

		$data = $con->prepare('SELECT * FROM users WHERE id = :id');
		$data->execute(array(
			':id' => $id
		));

		$result = $data->fetchAll(PDO::FETCH_ASSOC);

		foreach($result as $row)
		{
			if(isset($_POST['edit-user']))
			{
				if(!empty($_POST['email']))
				{
					$email   = $_POST['email'];
					$access  = $_POST['access'];

					$data = $con->prepare('UPDATE users SET email = :email, level = :access WHERE id = :id');
					$data->execute(array(
						':id'     => $id,
						':email'  => $email,
						':access' => $access
					));

					$response = '<span class="green">Updated user!</span>';

					LogAction($_SESSION['username'], "Updated admin panel user: " . $id . " : email = " . $email . " : access = " . $access, $_SERVER['REMOTE_ADDR'], time());
				}
			}

			echo '<div class="content-content column small-12 medium-12 large-12">
					<div class="content-box column small-12 medium-12">
						<div class="content-box-header column small-12">
							Editing user: ' . $row['username'] . '
						</div>

						<div class="content-box-content column small-12">
							<div class="news">
								<form method="POST">
									<div class="news-header column small-12">
										<label>Email Address</label>
										<input type="text" name="email" value="' . $row['email'] . '" />
									</div>

									<div class="news-content column small-12">
									<label>Access</label>
										<select name="access">
											<option value="0">No Access</option>
											<option value="1">Game Master</option>
											<option value="2">Moderator</option>
											<option value="3">Administrator</option>
										</select>
									</div>

									<div class="news-bottom column small-12">
										<input type="submit" class="button small" name="edit-user" value="Edit" />
										<span class="response">' . @$response . '</span>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>';
		}
	}
}

function DeleteUser()
{
	if(isset($_GET['udelete']))
	{
		global $con;

		$id = (int)$_GET['udelete'];

		$data = $con->prepare('SELECT COUNT(*) FROM users WHERE id = :id');
		$data->execute(array(
			':id' => $id
		));

		if($data->fetchColumn() == 1)
		{
			$data = $con->prepare('DELETE FROM users WHERE id = :id');
			$data->execute(array(
				':id' => $id
			));

			echo '<script>location.reload();</script>';

			LogAction($_SESSION['username'], "Deleted admin panel user: " . $id, $_SERVER['REMOTE_ADDR'], time());
		}
	}
}




###################################
#								  #
#			News System 		  #
#                                 #
###################################

function AddNews()
{
	if(isset($_POST['post-news']))
	{
		if(!empty($_POST['title']) && !empty($_POST['summary']) && !empty($_POST['content']))
		{
			global $con;

			$title     = $_POST['title'];
			$author    = $_SESSION['username'];
			$summary   = nl2br($_POST['summary']);
			$content   = nl2br($_POST['content']);
			$banner    = $_POST['post_banner'];
			$post_date = time();
			$ip        = $_SERVER['REMOTE_ADDR'];

			$data = $con->prepare('SELECT COUNT(*) FROM news WHERE post_title = :title AND author = :author AND post_summary = :summary AND post_content = :content');
			$data->execute(array(
				':title'   => $title,
				':author'  => $author,
				':summary' => $summary,
				':content' => $content
			));

			if($data->fetchColumn() == 0)
			{
				$data = $con->prepare('INSERT INTO news (post_title, author, post_summary, post_content, post_banner, post_date, ip_address) VALUES(:title, :author, :summary, :content, :banner, :post_date, :ip)');
				$data->execute(array(
					':title'     => $title,
					':author'    => $author,
					':summary'   => $summary,
					':content'   => $content,
					':banner'   => $banner,
					':post_date' => $post_date,
					':ip'        => $ip
				));

				echo '<span class="green">Successfully posted!</span>';

				LogAction($_SESSION['username'], "Posted news article: " . $title . " : Summary: " . $summary . " : Content: " . $content, $_SERVER['REMOTE_ADDR'], time());
			}
			else
			{
				echo '<span class="red">Duplicate Entry for post!</span>';
			}
		}
		else
		{
			echo '<span class="red">Fields cant be empty!</span>';
		}
	}
}

function ListNews()
{
	global $con;

	$page    = isset($_GET['page']) ? (int)$_GET['page'] : 1;
	$perPage = 10;

	$start = ($page > 1) ? ($page * $perPage) - $perPage : 0;

	$total = $con->query('SELECT COUNT(*) FROM news')->fetchColumn();
	$pages = ceil($total / $perPage);

	$data = $con->prepare('SELECT * FROM news ORDER by id desc LIMIT ' . $start . ', ' . $perPage);
	$data->execute();

	echo '<div class="content-strip column small-12">
			<div class="content-strip-content column small-12">
				<a href="newpost.php" class="small button">Add News</a>
			</div>
		</div>

		<div class="content-content column small-12 medium-12 large-12">
			<div class="content-box column small-12 medium-12">
				<div class="content-box-header column small-12">
					News Articles
				</div>

				<div class="content-box-content column small-12">
					<table>
						<th>#</th>
						<th>Title</th>
						<th>Author</th>
						<th>Date Posted</th>
						<th></th>
						<th></th>';

	while($result = $data->fetchAll(PDO::FETCH_ASSOC))
	{
		foreach($result as $row)
		{
			echo '<tr>
					<td>' . $row['id'] . '</td>
					<td>' . ucfirst($row['post_title']) . '</td>
					<td>' . ucfirst($row['author']) . '</td>
					<td>' . date('H:i:s - d. F, Y', $row['post_date']) . '</td>
					<td><a href="?pedit=' . $row['id'] . '" title="Edit"><i class="fa fa-pencil yellow" aria-hidden="true"></i></a></td>
					<td><a href="?pdelete=' . $row['id'] . '" title="Delete" onclick="return confirm(\'Are you sure?\')"><i class="fa fa-trash red" aria-hidden="true"></i></a></td>
				</tr>';
		}
	}

	echo '			</table>
				</div>
			</div>
		</div>';

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

function EditNews()
{
	if(isset($_GET['pedit']))
	{
		global $con;

		$id = (int)$_GET['pedit'];

		$data = $con->prepare('SELECT * FROM news WHERE id = :id');
		$data->execute(array(
			':id' => $id
		));

		$result = $data->fetchAll(PDO::FETCH_ASSOC);

		foreach($result as $row)
		{
			if(isset($_POST['edit-news']))
			{
				if(!empty($_POST['title']) && !empty($_POST['content']))
				{
					$title   = $_POST['title'];
					$summary = nl2br($_POST['summary']);
					$content = nl2br($_POST['content']);
					$banner  = $_POST['post_banner'];

					$data = $con->prepare('UPDATE news SET post_title = :title, post_summary = :summary, post_content = :content, post_banner = :banner WHERE id = :id');
					$data->execute(array(
						':id'      => $id,
						':title'   => $title,
						':summary' => $summary,
						':content' => $content,
						':banner'  => $banner
					));

					$response = '<span class="green">Updated post!</span>';
					
					echo '<meta http-equiv="refresh" content="1; url=news.php" />';

					LogAction($_SESSION['username'], "Edited news article: " . $title . " : Summary: " . $summary . " : Content: " . $content, $_SERVER['REMOTE_ADDR'], time());
				}
			}

			echo '<div class="content-content column small-12 medium-12 large-12">
					<div class="content-box column small-12 medium-12">
						<div class="content-box-header column small-12">
							Editing post
						</div>

						<div class="content-box-content column small-12">
							<div class="news">
								<form method="POST">
									<div class="news-header column small-12">
										<label>Post title</label>
										<input type="text" name="title" value="' . $row['post_title'] . '" />
									</div>

									<div class="news-content column small-12">
										<label>Summary</label>
										<textarea name="summary" id="textarea" class="small-textarea">' . str_replace("<br />", "", "\n" . $row['post_summary']) . '</textarea>
									</div>

									<div class="news-content column small-12">
										<textarea name="content" id="textarea2" class="normal-textarea">' . str_replace("<br />", "", "\n" . $row['post_content']) . '</textarea>
									</div>

									<div class="news-header column small-12">
										<label>Banner Image (1200x290)</label>
										<input type="text" name="post_banner" value="' . $row['post_banner'] . '" />
									</div>

									<div class="news-bottom column small-12">
										<input type="submit" class="button small" name="edit-news" value="Edit" />
										<span class="response">' . @$response . '</span>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>';
		}
	}
}

function DeleteNews()
{
	if(isset($_GET['pdelete']))
	{
		global $con;

		$id = (int)$_GET['pdelete'];

		$data = $con->prepare('SELECT COUNT(*) FROM news WHERE id = :id');
		$data->execute(array(
			':id' => $id
		));

		if($data->fetchColumn() == 1)
		{
			$data = $con->prepare('DELETE FROM news WHERE id = :id');
			$data->execute(array(
				':id' => $id
			));

			echo '<script>location.reload();</script>';

			LogAction($_SESSION['username'], "Deleted news article: " . $id, $_SERVER['REMOTE_ADDR'], time());
		}
	}
}




###################################
#								  #
#		  Settings System 		  #
#                                 #
###################################


function PagePermissions()
{
	global $con;

	$data = $con->prepare('SELECT * FROM permissions');
	$data->execute();

	echo '<table>
			<th>#</th>
			<th>Page</th>
			<th>Access</th>
			<th></th>';

	$rank = array(
		0 => 'No Access',
		1 => '<span class="orange">Game Master</span>',
		2 => '<span class="red">Moderator</span>',
		3 => '<span class="green">Administrator</span>'
	);

	while($result = $data->fetchAll(PDO::FETCH_ASSOC))
	{
		foreach($result as $row)
		{
			echo '<tr>
					<td>' . $row['page_id'] . '</td>
					<td>' . $row['comment'] . '</td>
					<td>' . $rank[$row['permission']] . '</td>
					<td><a href="?pedit=' . $row['id'] . '" title="Edit"><i class="fa fa-pencil yellow" aria-hidden="true"></i></a></td>
				</tr>';
		}
	}

	echo '</table>';
}

function EditPermissions()
{
	if(isset($_GET['pedit']))
	{
		global $con;

		$id = (int)$_GET['pedit'];

		$data = $con->prepare('SELECT * FROM permissions WHERE id = :id');
		$data->execute(array(
			':id' => $id
		));

		$result = $data->fetchAll(PDO::FETCH_ASSOC);

		foreach($result as $row)
		{
			if(isset($_POST['edit-page']))
			{
				$access  = $_POST['access'];

				$data = $con->prepare('UPDATE permissions SET permission = :access WHERE id = :id');
				$data->execute(array(
					':id'     => $id,
					':access' => $access
				));

				$response = '<span class="green">Updated permission!</span>';

				LogAction($_SESSION['username'], "Changed permission for page: " . $id . " : Access: " . $access, $_SERVER['REMOTE_ADDR'], time());
			}

			echo '<div class="content-content column small-12 medium-12 large-6 left">
					<div class="content-box column small-12 medium-12">
						<div class="content-box-header column small-12">
							Updating permissions for page: <span class="green">' . $row['comment'] . '</span>
						</div>

						<div class="content-box-content column small-12">
							<div class="news">
								<form method="POST">
									<div class="news-content column small-12">
									<label>Access</label>
										<select name="access">
											<option value="1">Game Master</option>
											<option value="2">Moderator</option>
											<option value="3">Administrator</option>
										</select>
									</div>

									<div class="news-bottom column small-12">
										<input type="submit" class="button small" name="edit-page" value="Update" />
										<span class="response">' . @$response . '</span>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>';
		}
	}
}




###################################
#								  #
#		  Commands System 		  #
#                                 #
###################################


function Commands()
{
	global $con_realmd;

	if(isset($_GET['search']))
	{
		if(!empty($_GET['search']))
		{
			$search  = strtolower($_GET['search']);
			$page    = isset($_GET['page']) ? (int)$_GET['page'] : 1;
			$perPage = 20;

			$start = ($page > 1) ? ($page * $perPage) - $perPage : 0;

			$totalq = $con_realmd->prepare('SELECT * FROM logs WHERE type = "8" AND string LIKE ?');
			$totalq->execute(array(
				strtolower("%$search%")
			));

			$total = $totalq->rowCount();


			$pages = ceil($total / $perPage);

			$data = $con_realmd->prepare('SELECT * FROM logs WHERE type = "8" AND string LIKE ? ORDER BY time DESC LIMIT ' . $start . ', ' . $perPage);
			$data->execute(array(
				strtolower("%$search%")
			));

			LogAction($_SESSION['username'], "Searched for username: " . $search, $_SERVER['REMOTE_ADDR'], time());

			function multiexplode ($delimiters,$string)
			{
			    $ready  = str_replace($delimiters, $delimiters[0], $string);
			    $launch = explode($delimiters[0], $ready);
			    return  $launch;
			}

			function GrabAccount($id)
			{
				global $con_realmd;

				$data = $con_realmd->prepare('SELECT * FROM account WHERE id = :id');
				$data->execute(array(
					':id' => $id
				));

				$result = $data->fetchAll(PDO::FETCH_ASSOC);

				foreach($result as $row)
				{
					return ucfirst($row['username']);
				}
			}

			echo '<div class="content-content column small-12 medium-12 large-12">
					<div class="content-box column small-12 medium-12">
						<div class="content-box-header column small-12">
							GM Commands
						</div>

						<div class="content-box-content column small-12">
							<table>
								<th>#</th>
								<th>Account</th>
								<th>Character</th>
								<th>Command</th>
								<th>Coordinates</th>
								<th>MapID</th>
								<th>Target Type</th>
								<th>Target Name</th>
								<th>GUID</th>
								<th>Time</th>';

			while($result = $data->fetchAll(PDO::FETCH_ASSOC))
			{
				foreach($result as $row)
				{
					$string = multiexplode(array(':', '[','(', ')', 'Map', 'Selected'), $row['string']);

					
					$target = $string[13];

					if($string[3] == ' 0')
					{

					}
					else
					{
						echo '<tr>
								<td>' . $row['id'] . '</td>
								<td><span class="green">' . GrabAccount($string[5]) . '</span> (' . str_replace(' ', '', $string[5]) . ')</td>
								<td><span class="orange">' . $string[3] . '</span></td>
								<td>' . $string[1] . '</td>
								<td>X: ' . $string[7] . ':' . $string[8] . ':' . $string[9] . '</td>
								<td>' . $string[11] . '</td>
								<td>' . $string[12] . '</td>
								<td><span class="blue">' . $target . '</span></td>
								<td>' . $string[15] . '</td>
								<td>' . date('H:i:s - d.m.Y', $row['time']) . '</td>
							</tr>';
					}
				}
			}

			echo '			</table>
						</div>
					</div>
				</div>';

			echo '<div class="navigation column small-12"><ul class="nav-menu">';

				echo '<li><a href="?page=1&search=' . $search . '"><<</a></li>';
				
				$min = max($page - 2, 1);
				$max = min($page + 2, $pages);

				for($x = $min; $x <= $max; $x++)
				{
					if(@$page == $x)
					{
						echo '<li><a href="?page=' . $x . '&search=' . $search . '" class="current-nav">' . $x . '</a></li>';
					}
					elseif(@!isset($page))
					{
						echo '<li><a href="?page=' . $x . '&search=' . $search . '" class="current-nav">' . $x . '</a></li>';
					}
					else
					{
						echo '<li><a href="?page=' . $x . '&search=' . $search . '">' . $x . '</a></li>';
					}
				}

				echo '<li><a href="?page=' . $pages . '&search=' . $search . '">>></a></li>';

			echo '</ul></div>';
		}
		else
		{
			$page    = isset($_GET['page']) ? (int)$_GET['page'] : 1;
			$perPage = 20;

			$start = ($page > 1) ? ($page * $perPage) - $perPage : 0;

			$total = $con_realmd->query('SELECT COUNT(*) FROM logs WHERE type = "8"')->fetchColumn();
			$pages = ceil($total / $perPage);

			$data = $con_realmd->prepare('SELECT * FROM logs WHERE type = "8" ORDER BY time DESC LIMIT ' . $start . ', ' . $perPage);
			$data->execute();

			function multiexplode ($delimiters,$string)
			{
			    $ready  = str_replace($delimiters, $delimiters[0], $string);
			    $launch = explode($delimiters[0], $ready);
			    return  $launch;
			}

			function GrabAccount($id)
			{
				global $con_realmd;

				$data = $con_realmd->prepare('SELECT * FROM account WHERE id = :id');
				$data->execute(array(
					':id' => $id
				));

				$result = $data->fetchAll(PDO::FETCH_ASSOC);

				foreach($result as $row)
				{
					return ucfirst($row['username']);
				}
			}

			echo '<div class="content-content column small-12 medium-12 large-12">
					<div class="content-box column small-12 medium-12">
						<div class="content-box-header column small-12">
							GM Commands
						</div>

						<div class="content-box-content column small-12">
							<table>
								<th>#</th>
								<th>Account</th>
								<th>Character</th>
								<th>Command</th>
								<th>Coordinates</th>
								<th>MapID</th>
								<th>Target Type</th>
								<th>Target Name</th>
								<th>GUID</th>
								<th>Time</th>';

			while($result = $data->fetchAll(PDO::FETCH_ASSOC))
			{
				foreach($result as $row)
				{
					$string = multiexplode(array('Command: ', ' [Player: ', ' (Account: ', ') X: ', ' Y: ', ' Z: ', ' Map: ', ' Selected', 'player: ', '(GUID:', ')]'), $row['string']);

					$target = $string[8];
					
					
					echo '<tr>
							<td>' . $row['id'] . '</td>
							<td><span class="green">' . GrabAccount($string[2]) . '</span> (' . $string[3] . ')</td>
							<td><span class="orange">' . $string[3] . '</span></td>
							<td>' . $string[1] . '</td>
							<td>X: ' . $string[4] . ':' . $string[5] . ':' . $string[6] . '</td>
							<td>' . $string[7] . '</td>
							<td>' . $string[8] . '</td>
							<td><span class="blue">' . $target . '</span></td>
							<td>' . $string[9] . '</td>
							<td>' . date('H:i:s - d.m.Y', $row['time']) . '</td>
						</tr>';
				}
			}

			echo '			</table>
						</div>
					</div>
				</div>';

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
	}
	else
	{
		$page    = isset($_GET['page']) ? (int)$_GET['page'] : 1;
		$perPage = 20;

		$start = ($page > 1) ? ($page * $perPage) - $perPage : 0;

		$total = $con_realmd->query('SELECT COUNT(*) FROM logs WHERE type = "8"')->fetchColumn();
		$pages = ceil($total / $perPage);

		$data = $con_realmd->prepare('SELECT * FROM logs WHERE type = "8" ORDER BY time DESC LIMIT ' . $start . ', ' . $perPage);
		$data->execute();

		function multiexplode ($delimiters,$string)
		{
		    $ready  = str_replace($delimiters, $delimiters[0], $string);
		    $launch = explode($delimiters[0], $ready);
		    return  $launch;
		}

		function GrabAccount($id)
		{
			global $con_realmd;

			$data = $con_realmd->prepare('SELECT * FROM account WHERE id = :id');
			$data->execute(array(
				':id' => $id
			));

			$result = $data->fetchAll(PDO::FETCH_ASSOC);

			foreach($result as $row)
			{
				return ucfirst($row['username']);
			}
		}

		echo '<div class="content-content column small-12 medium-12 large-12">
				<div class="content-box column small-12 medium-12">
					<div class="content-box-header column small-12">
						GM Commands
					</div>

					<div class="content-box-content column small-12">
						<table>
							<th>#</th>
							<th>Account</th>
							<th>Character</th>
							<th>Command</th>
							<th>Coordinates</th>
							<th>MapID</th>
							<th>Target Type</th>
							<th>Target Name</th>
							<th>GUID</th>
							<th>Time</th>';

		while($result = $data->fetchAll(PDO::FETCH_ASSOC))
		{
			foreach($result as $row)
			{
				$string = multiexplode(array('Command: ', ' [Player: ', ' (Account: ', ') X: ', ' Y: ', ' Z: ', ' Map: ', ' Selected', 'player: ', '(GUID:', ')]'), $row['string']);

				$target = str_replace(':', '', $string[8]);
				
				
				echo '<tr>
						<td>' . $row['id'] . '</td>
						<td><span class="green">' . GrabAccount($string[3]) . '</span> (' . $string[3] . ')</td>
						<td><span class="orange">' . $string[2] . '</span></td>
						<td>' . $string[1] . '</td>
						<td>X: ' . $string[4] . ':' . $string[5] . ':' . $string[6] . '</td>
						<td>' . $string[7] . '</td>
						<td>' . $string[8] . '</td>
						<td><span class="blue">' . $target . '</span></td>
						<td>' . $string[9] . '</td>
						<td>' . date('H:i:s - d.m.Y', $row['time']) . '</td>
					</tr>';
			}
		}

		echo '			</table>
					</div>
				</div>
			</div>';

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
}





###################################
#								  #
#		  Tickets System 		  #
#                                 #
###################################

function Tickets()
{
	global $con_char;

	if(isset($_GET['view']))
	{
		$ticketID = (int)$_GET['view'];

		$data = $con_char->prepare('SELECT * FROM gm_tickets WHERE ticketId = :view');
		$data->execute(array(
			':view' => $ticketID
		));

		$result = $data->fetchAll(PDO::FETCH_ASSOC);

		foreach($result as $row)
		{
			echo '<div class="content-content column small-12 medium-12 large-12">
					<div class="content-box column small-12 medium-12">
					<div class="content-box-header column small-12">
						Viewing <span class="green">' . $row['name'] . '</span>\'s ticket' . '
					</div>

					<div class="content-box-content column small-12">';

			echo '<div class="ticket-message">' . nl2br($row['message']) . '</div>';
		}

		echo '		</div>
				</div>
			</div>';

		LogAction($_SESSION['username'], "Viewed ticket: " . $ticketID, $_SERVER['REMOTE_ADDR'], time());
	}
	else
	{
		if(isset($_GET['search']))
		{
			$search  = strtolower($_GET['search']);
			$page    = isset($_GET['page']) ? (int)$_GET['page'] : 1;
			$perPage = 20;

			$start = ($page > 1) ? ($page * $perPage) - $perPage : 0;

			$totalq = $con_char->prepare('SELECT * FROM gm_tickets WHERE name LIKE ?');
			$totalq->execute(array(
				strtolower("%$search%")
			));

			$total = $totalq->rowCount();


			$pages = ceil($total / $perPage);

			$data = $con_char->prepare('SELECT * FROM gm_tickets WHERE name LIKE ? ORDER BY createTime DESC LIMIT ' . $start . ', ' . $perPage);
			$data->execute(array(
				strtolower("%$search%")
			));

			LogAction($_SESSION['username'], "Searched for ticket: " . $search, $_SERVER['REMOTE_ADDR'], time());

			function GrabChar($guid)
			{
				global $con_char;

				$data = $con_char->prepare('SELECT * FROM characters WHERE guid = :guid');
				$data->execute(array(
					':guid' => $guid
				));

				$result = $data->fetchAll(PDO::FETCH_ASSOC);

				foreach($result as $row)
				{
					return $row['name'];
				}
			}

			$done = array(
				0 => '<span class="red">No</span>',
				1 => '<span class="green">Yes</span>'
			);

			echo '<div class="content-content column small-12 medium-12 large-12">
					<div class="content-box column small-12 medium-12">
					<div class="content-box-header column small-12">
						Tickets
					</div>

					<div class="content-box-content column small-12">
						<table>
							<th>#</th>
							<th>Character</th>
							<th>Message</th>
							<th>MapID</th>
							<th>Coordinates</th>
							<th>Assigned</th>
							<th>Closed By</th>
							<th>Completed</th>
							<th>Viewed</th>
							<th>Created</th>';

			while($result = $data->fetchAll(PDO::FETCH_ASSOC))
			{
				foreach($result as $row)
				{
					echo '<tr>
							<td>' . $row['ticketId'] . '</td>
							<td><span class="green">' . $row['name'] . '</span></td>
							<td><a href="?view=' . $row['ticketId'] . '">View</a></td>
							<td>' . $row['mapId'] . '</td>
							<td>' . $row['posX'] . ' ' . $row['posY'] . ' ' . $row['posZ'] . '</td>
							<td><span class="orange">' . GrabChar($row['assignedTo']) . '</span></td>
							<td><span class="green">' . GrabChar($row['closedBy']) . '</span></td>
							<td>' . $done[$row['completed']] . '</td>
							<td>' . $done[$row['viewed']] . '</td>
							<td>' . date('H:i:s - d.m.Y', $row['createTime']) . '</td>
						</tr>';
				}
			}

			echo '		</table>
					</div>
				</div>
				</div>';

				echo '<div class="navigation column small-12"><ul class="nav-menu">';

					echo '<li><a href="?page=1&search=' . $search . '"><<</a></li>';
					
					$min = max($page - 2, 1);
					$max = min($page + 2, $pages);

					for($x = $min; $x <= $max; $x++)
					{
						if(@$page == $x)
						{
							echo '<li><a href="?page=' . $x . '&search=' . $search . '" class="current-nav">' . $x . '</a></li>';
						}
						elseif(@!isset($page))
						{
							echo '<li><a href="?page=' . $x . '&search=' . $search . '" class="current-nav">' . $x . '</a></li>';
						}
						else
						{
							echo '<li><a href="?page=' . $x . '&search=' . $search . '">' . $x . '</a></li>';
						}
					}

					echo '<li><a href="?page=' . $pages . '&search=' . $search . '">>></a></li>';

				echo '</ul></div>';
		}
		else
		{
			$page    = isset($_GET['page']) ? (int)$_GET['page'] : 1;
			$perPage = 20;

			$start = ($page > 1) ? ($page * $perPage) - $perPage : 0;

			$total = $con_char->query('SELECT COUNT(*) FROM gm_tickets')->fetchColumn();
			$pages = ceil($total / $perPage);

			$data = $con_char->prepare('SELECT * FROM gm_tickets ORDER BY createTime DESC LIMIT ' . $start . ', ' . $perPage);
			$data->execute();

			function GrabChar($guid)
			{
				global $con_char;

				$data = $con_char->prepare('SELECT * FROM characters WHERE guid = :guid');
				$data->execute(array(
					':guid' => $guid
				));

				$result = $data->fetchAll(PDO::FETCH_ASSOC);

				foreach($result as $row)
				{
					return $row['name'];
				}
			}

			$done = array(
				0 => '<span class="red">No</span>',
				1 => '<span class="green">Yes</span>'
			);

			echo '<div class="content-content column small-12 medium-12 large-12">
					<div class="content-box column small-12 medium-12">
					<div class="content-box-header column small-12">
						Tickets
					</div>

					<div class="content-box-content column small-12">
						<table>
							<th>#</th>
							<th>Character</th>
							<th>Message</th>
							<th>MapID</th>
							<th>Coordinates</th>
							<th>Assigned</th>
							<th>Closed By</th>
							<th>Completed</th>
							<th>Viewed</th>
							<th>Created</th>';

			while($result = $data->fetchAll(PDO::FETCH_ASSOC))
			{
				foreach($result as $row)
				{
					echo '<tr>
							<td>' . $row['ticketId'] . '</td>
							<td><span class="green">' . $row['name'] . '</span></td>
							<td><a href="?view=' . $row['ticketId'] . '">View</a></td>
							<td>' . $row['mapId'] . '</td>
							<td>' . $row['posX'] . ' ' . $row['posY'] . ' ' . $row['posZ'] . '</td>
							<td><span class="orange">' . GrabChar($row['assignedTo']) . '</span></td>
							<td><span class="green">' . GrabChar($row['closedBy']) . '</span></td>
							<td>' . $done[$row['completed']] . '</td>
							<td>' . $done[$row['viewed']] . '</td>
							<td>' . date('H:i:s - d.m.Y', $row['createTime']) . '</td>
						</tr>';
				}
			}

			echo '		</table>
					</div>
				</div>
				</div>';

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
	}
}



function GrabTicketMessage($id)
{
	global $con_char;

	$data = $con_char->prepare('SELECT * FROM gm_tickets WHERE ticketId = :id');
	$data->execute(array(
		':id' => $id
	));

	$result = $data->fetchAll(PDO::FETCH_ASSOC);

	foreach($result as $row)
	{
		return $row['message'];
	}
}



###################################
#								  #
#		  Streamer System 		  #
#                                 #
###################################

function ListStreamers()
{
	global $con;

	$page    = isset($_GET['page']) ? (int)$_GET['page'] : 1;
	$perPage = 10;

	$start = ($page > 1) ? ($page * $perPage) - $perPage : 0;

	$total = $con->query('SELECT COUNT(*) FROM streamers')->fetchColumn();
	$pages = ceil($total / $perPage);

	$data = $con->prepare('SELECT * FROM streamers ORDER by id desc LIMIT ' . $start . ', ' . $perPage);
	$data->execute();

	$enabled = array(
		0 => '<span class="red">Disabled</span>',
		1 => '<span class="green">Enabled</span>'
	);

	echo '<div class="content-strip column small-12">
			<div class="content-strip-content column small-12">
				<a href="newstreamer.php" class="small button">Add Streamer</a>
			</div>
		</div>

		<div class="content-content column small-12 medium-12 large-12">
			<div class="content-box column small-12 medium-12">
				<div class="content-box-header column small-12">
					Streamers
				</div>

				<div class="content-box-content column small-12">
					<table>
						<th>#</th>
						<th>Username</th>
						<th>Status</th>
						<th></th>
						<th></th>';

	while($result = $data->fetchAll(PDO::FETCH_ASSOC))
	{
		foreach($result as $row)
		{
			echo '<tr>
					<td>' . $row['id'] . '</td>
					<td><a href="https://twitch.tv/' . $row['username'] . '">' . ucfirst($row['username']) . '</a></td>
					<td>' . $enabled[$row['status']] . '</td>
					<td><a href="?sedit=' . $row['id'] . '" title="Edit"><i class="fa fa-pencil yellow" aria-hidden="true"></i></a></td>
					<td><a href="?sdelete=' . $row['id'] . '" title="Delete" onclick="return confirm(\'Are you sure?\')"><i class="fa fa-trash red" aria-hidden="true"></i></a></td>
				</tr>';
		}
	}

	echo '			</table>
				</div>
			</div>
		</div>';

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

function EditStreamer()
{
	if(isset($_GET['sedit']))
	{
		global $con;

		$id = (int)$_GET['sedit'];

		$data = $con->prepare('SELECT * FROM streamers WHERE id = :id');
		$data->execute(array(
			':id' => $id
		));

		$result = $data->fetchAll(PDO::FETCH_ASSOC);

		foreach($result as $row)
		{
			if(isset($_POST['edit-streamer']))
			{
				if(!empty($_POST['username']))
				{
					$username = $_POST['username'];
					$status   = $_POST['status'];

					$data = $con->prepare('UPDATE streamers SET username = :username, status = :status WHERE id = :id');
					$data->execute(array(
						':id'       => $id,
						':username' => $username,
						':status'   => $status
					));

					$response = '<span class="green">Updated streamer!</span>';

					LogAction($_SESSION['username'], "Edited streamer: " . $id . " : username = " . $username . " : status = " . $status, $_SERVER['REMOTE_ADDR'], time());
				}
			}

			echo '<div class="content-content column small-12 medium-12 large-12">
					<div class="content-box column small-12 medium-12">
						<div class="content-box-header column small-12">
							Editing streamer <span class="green">' . ucfirst($row['username']) . '</span>
						</div>

						<div class="content-box-content column small-12">
							<div class="news">
								<form method="POST">
									<div class="news-header column small-12">
										<label>Username</label>
										<input type="text" name="username" value="' . $row['username'] . '" />
									</div>

									<div class="news-content column small-12">
										<select name="status">
											<option value="0">Disabled</span>
											<option value="1">Enabled</span>
										</select>
									</div>

									<div class="news-bottom column small-12">
										<input type="submit" class="button small" name="edit-streamer" value="Edit" />
										<span class="response">' . @$response . '</span>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>';
		}
	}
}

function DeleteStreamer()
{
	if(isset($_GET['sdelete']))
	{
		global $con;

		$id = (int)$_GET['sdelete'];

		$data = $con->prepare('SELECT COUNT(*) FROM streamers WHERE id = :id');
		$data->execute(array(
			':id' => $id
		));

		if($data->fetchColumn() == 1)
		{
			$data = $con->prepare('DELETE FROM streamers WHERE id = :id');
			$data->execute(array(
				':id' => $id
			));

			echo '<script>location.reload();</script>';

			LogAction($_SESSION['username'], "Deleted streamer: " . $id, $_SERVER['REMOTE_ADDR'], time());
		}
	}
}

function AddStreamer()
{
	if(isset($_POST['add-streamer']))
	{
		if(!empty($_POST['username']))
		{
			global $con;

			$username = $_POST['username'];
			$status   = $_POST['status'];

			$data = $con->prepare('SELECT COUNT(*) FROM streamers WHERE username = :username');
			$data->execute(array(
				':username' => $username
			));

			if($data->fetchColumn() == 0)
			{
				$data = $con->prepare('INSERT INTO streamers (username, status) VALUES(:username, :status)');
				$data->execute(array(
					':username' => $username,
					':status'   => $status
				));

				echo '<span class="green">Successfully added!</span>';

				LogAction($_SESSION['username'], "Added streamer: " . $username . " : Status = " . $status, $_SERVER['REMOTE_ADDR'], time());
			}
			else
			{
				echo '<span class="red">Duplicate Entry for streamer!</span>';
			}
		}
		else
		{
			echo '<span class="red">Fields cant be empty!</span>';
		}
	}
}



###################################
#								  #
#		  Accounts System 	      #
#                                 #
###################################

function AccountList()
{
	global $con_realmd;

	if(isset($_GET['search']))
	{
		$search = $_GET['search'];

		$page    = isset($_GET['page']) ? (int)$_GET['page'] : 1;
		$perPage = 20;

		$start = ($page > 1) ? ($page * $perPage) - $perPage : 0;

		$total = $con_realmd->prepare('SELECT * FROM account WHERE username LIKE ?');
		$total->execute(array(
			"%$search%"
		));

		LogAction($_SESSION['username'], "Searched for account: " . $search, $_SERVER['REMOTE_ADDR'], time());

		$total = $total->rowCount();

		$pages = ceil($total / $perPage);

		$blacklist = array(
			'agency',
			'bin4ry',
			'remotebaby',
			'digestive97',
			'digestive96',
			'puppeteer',
			'slamo',
			'looten',
			'gabu',
			'inari',
			'kae'
		);

		function GrabRank($id)
		{
			global $con_realmd;

			$data = $con_realmd->prepare('SELECT * FROM account_access WHERE id = :id');
			$data->execute(array(
				':id' => $id
			));

			$result = $data->fetchAll(PDO::FETCH_ASSOC);

			foreach($result as $row)
			{
				return var_dump($row['gmlevel']);
			}
		}

		$data = $con_realmd->prepare('SELECT * FROM account WHERE username LIKE ? LIMIT ' . $start . ', ' . $perPage);
		$data->execute(array(
			"%$search%"
		));

		echo '<div class="content-content column small-12 medium-12 large-12">
				<div class="content-box column small-12 medium-12">
					<div class="content-box-header column small-12">
						Accounts
					</div>

					<div class="content-box-content column small-12">
						<table>
							<th>#</th>
							<th>Username</th>
							<th>Email</th>
							<th>Last IP</th>
							<th>Last Login</th>
							<th>Register Date</th>
							<th>Status</th>
							<th></th>
							<th></th>';

		$access = array(
			0 => 'Normal',
			1 => '<span class="blue">Beta Tester</span>',
			2 => '<span class="orange">Game Master</span>',
			3 => '<span class="red">Moderator</span>',
			4 => '<span class="yellow">Head Moderator</span>',
			5 => '<span class="green">Administrator</span>'
		);

		$status = array(
			0 => '<span class="green">Active</span>',
			1 => '<span class="red">Banned</span>'
		);

		while($result = $data->fetchAll(PDO::FETCH_ASSOC))
		{
			foreach($result as $row)
			{
				if(!in_array(strtolower($row['username']), $blacklist))
				{
					if($row['locked'] == 0)
					{
						$icon = 'fa fa-gavel red';
					}
					else
					{
						$icon = 'fa fa-minus-circle green';
					}

					echo '<tr>
							<td>' . $row['id'] . '</td>
							<td>' . $row['username'] . '</td>
							<td>' . $row['email'] . '</td>
							<td>' . $row['last_ip'] . '</td>
							<td>' . $row['last_login'] . '</td>
							<td>' . $row['joindate'] . '</td>
							<td>' . $status[$row['locked']] . '</td>
							<td><a href="?amodify=' . $row['id'] . '"><i class="' . $icon . '" aria-hidden="true"></i></a></td>
							<td><a href="?arecover=' . $row['id'] . '"><i class="fa fa-key yellow" aria-hidden="true"></i></a></td>
						</tr>';
				}
			}
		}

		echo '			</table>
					</div>
				</div>
			</div>';

		echo '<div class="navigation column small-12"><ul class="nav-menu">';

			echo '<li><a href="?page=1"><<</a></li>';
			
			$min = max($page - 2, 1);
			$max = min($page + 2, $pages);

			for($x = $min; $x <= $max; $x++)
			{
				if(@$page == $x)
				{
					echo '<li><a href="?page=' . $x . '&search=' . $search . '" class="current-nav">' . $x . '</a></li>';
				}
				elseif(@!isset($page))
				{
					echo '<li><a href="?page=' . $x . '&search=' . $search . '" class="current-nav">' . $x . '</a></li>';
				}
				else
				{
					echo '<li><a href="?page=' . $x . '&search=' . $search . '">' . $x . '</a></li>';
				}
			}

			echo '<li><a href="?page=' . $pages . '&search=' . $search . '">>></a></li>';

		echo '</ul></div>';
	}
	else
	{
		$page    = isset($_GET['page']) ? (int)$_GET['page'] : 1;
		$perPage = 20;

		$start = ($page > 1) ? ($page * $perPage) - $perPage : 0;

		$total = $con_realmd->query('SELECT COUNT(*) FROM account')->fetchColumn();
		$pages = ceil($total / $perPage);

		$blacklist = array(
			'agency',
			'bin4ry',
			'remotebaby',
			'digestive97',
			'digestive96',
			'puppeteer',
			'slamo',
			'looten',
			'gabu',
			'inari',
			'kae'
		);

		function GrabRank($id)
		{
			global $con_realmd;

			$data = $con_realmd->prepare('SELECT * FROM account_access WHERE id = :id');
			$data->execute(array(
				':id' => $id
			));

			$result = $data->fetchAll(PDO::FETCH_ASSOC);

			foreach($result as $row)
			{
				return var_dump($row['gmlevel']);
			}
		}

		$data = $con_realmd->prepare('SELECT * FROM account LIMIT ' . $start . ', ' . $perPage);
		$data->execute();

		echo '<div class="content-content column small-12 medium-12 large-12">
				<div class="content-box column small-12 medium-12">
					<div class="content-box-header column small-12">
						Accounts
					</div>

					<div class="content-box-content column small-12">
						<table>
							<th>#</th>
							<th>Username</th>
							<th>Email</th>
							<th>Last IP</th>
							<th>Last Login</th>
							<th>Register Date</th>
							<th>Status</th>
							<th></th>
							<th></th>';

		$access = array(
			0 => 'Normal',
			1 => '<span class="blue">Beta Tester</span>',
			2 => '<span class="orange">Game Master</span>',
			3 => '<span class="red">Moderator</span>',
			4 => '<span class="yellow">Head Moderator</span>',
			5 => '<span class="green">Administrator</span>'
		);

		$status = array(
			0 => '<span class="green">Active</span>',
			1 => '<span class="red">Banned</span>'
		);

		while($result = $data->fetchAll(PDO::FETCH_ASSOC))
		{
			foreach($result as $row)
			{
				if(!in_array(strtolower($row['username']), $blacklist))
				{
					if($row['locked'] == 0)
					{
						$icon = 'fa fa-gavel red';
					}
					else
					{
						$icon = 'fa fa-minus-circle green';
					}

					echo '<tr>
							<td>' . $row['id'] . '</td>
							<td>' . $row['username'] . '</td>
							<td>' . $row['email'] . '</td>
							<td>' . $row['last_ip'] . '</td>
							<td>' . $row['last_login'] . '</td>
							<td>' . $row['joindate'] . '</td>
							<td>' . $status[$row['locked']] . '</td>
							<td><a href="?amodify=' . $row['id'] . '"><i class="' . $icon . '" aria-hidden="true"></i></a></td>
							<td><a href="?arecover=' . $row['id'] . '"><i class="fa fa-key yellow" aria-hidden="true"></i></a></td>
						</tr>';
				}
			}
		}

		echo '			</table>
					</div>
				</div>
			</div>';

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
}

function ForgotPassword()
{
	// Mail recovery function
}

function ModifyAccount()
{
	global $con_realmd;

	if(isset($_GET['amodify']))
	{
		$id = (int)$_GET['amodify'];

		$blacklist = array(
			'agency',
			'bin4ry',
			'remotebaby',
			'digestive97',
			'digestive96',
			'puppeteer',
			'slamo',
			'looten',
			'gabu',
			'inari',
			'kae'
		);

		$data = $con_realmd->prepare('SELECT COUNT(*) FROM account WHERE id = :id');
		$data->execute(array(
			':id' => $id
		));

		if($data->fetchColumn() == 1)
		{
			$data = $con_realmd->prepare('SELECT * FROM account WHERE id = :id');
			$data->execute(array(
				':id' => $id
			));

			LogAction($_SESSION['username'], "Banned account: " . $id, $_SERVER['REMOTE_ADDR'], time());

			// Rewrite function to add account to banlist not using locked.

			/*$result = $data->fetchAll(PDO::FETCH_ASSOC);

			foreach($result as $row)
			{
				if(!in_array(strtolower($row['username']), $blacklist))
				{
					if($row['locked'] == 0)
					{
						$data = $con_realmd->prepare('UPDATE account SET locked = 1 WHERE id = :id');
						$data->execute(array(
							':id' => $id
						));

						echo '<meta http-equiv="refresh" content="0; url=accounts.php">';
					}
					else
					{
						$data = $con_realmd->prepare('UPDATE account SET locked = 0 WHERE id = :id');
						$data->execute(array(
							':id' => $id
						));

						echo '<meta http-equiv="refresh" content="0; url=accounts.php">';
					}
				}
			}*/
		}
	}
}

function ListFAQ()
{
	global $con;

	$data = $con->prepare('SELECT * FROM faq');
	$data->execute();

	$result = $data->fetchAll(PDO::FETCH_ASSOC);

	echo '<table>
			<th>#</th>
			<th>Question</th>
			<th></th>
			<th></th>';

	foreach($result as $row)
	{
		echo '<tr>
				<td>' . $row['id'] . '</td>
				<td>' . $row['question'] . '</td>
				<td style="text-align: right;"><a href="?edit=' . $row['id'] . '" title="Edit"><i class="fa fa-pencil yellow" aria-hidden="true"></i></a></td>
				<td style="text-align: center;"><a href="?delete=' . $row['id'] . '" title="Delete" onclick="return confirm(\'Are you sure?\')"><i class="fa fa-trash red" aria-hidden="true"></i></a></td>
			</tr>';
	}

	echo '</table>';
}

function EditFAQ()
{
	if(isset($_GET['edit']))
	{
		global $con;

		$id = (int)$_GET['edit'];

		$data = $con->prepare('SELECT * FROM faq WHERE id = :id');
		$data->execute(array(
			':id' => $id
		));

		$result = $data->fetchAll(PDO::FETCH_ASSOC);

		foreach($result as $row)
		{
			if(isset($_POST['edit-faq']))
			{
				if(!empty($_POST['question']) && !empty($_POST['answer']))
				{
					$question = $_POST['question'];
					$answer   = $_POST['answer'];

					$data = $con->prepare('UPDATE faq SET question = :question, answer = :answer WHERE id = :id');
					$data->execute(array(
						':id'       => $id,
						':question' => $question,
						':answer'   => $answer
					));

					$response = '<span class="green">Updated question!</span>';
					
					echo '<meta http-equiv="refresh" content="1; url=faq.php" />';

					LogAction($_SESSION['username'], "Edited FAQ: " . $id . " : Question = " . $question . " : Answer = " . $answer, $_SERVER['REMOTE_ADDR'], time());
				}
			}

			echo '<div class="content-content column small-12 medium-12 large-12">
					<div class="content-box column small-12 medium-12">
						<div class="content-box-header column small-12">
							Editing question
						</div>

						<div class="content-box-content column small-12">
							<div class="news">
								<form method="POST">
									<div class="news-header column small-12">
										<label>Question</label>
										<input type="text" name="question" value="' . $row['question'] . '" />
									</div>

									<div class="news-content column small-12">
										<label>Answer</label>
										<textarea name="answer" id="textarea" class="small-textarea">' . $row['answer'] . '</textarea>
									</div>

									<div class="news-bottom column small-12">
										<input type="submit" class="button small" name="edit-faq" value="Edit" />
										<span class="response">' . @$response . '</span>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>';
		}
	}
}

function DeleteFAQ()
{
	if(isset($_GET['delete']))
	{
		global $con;

		$id = (int)$_GET['delete'];

		$data = $con->prepare('SELECT COUNT(*) FROM faq WHERE id = :id');
		$data->execute(array(
			':id' => $id
		));

		if($data->fetchColumn() == 1)
		{
			$data = $con->prepare('DELETE FROM faq WHERE id = :id');
			$data->execute(array(
				':id' => $id
			));

			echo '<script>location.reload();</script>';

			LogAction($_SESSION['username'], "Deleted FAQ: " . $id, $_SERVER['REMOTE_ADDR'], time());
		}
	}
}

function AddFAQ()
{
	if(isset($_POST['add-faq']))
	{
		if(!empty($_POST['question']) && !empty($_POST['answer']))
		{
			global $con;

			$question = $_POST['question'];
			$answer   = $_POST['answer'];

			$data = $con->prepare('SELECT COUNT(*) FROM faq WHERE question = :question');
			$data->execute(array(
				':question' => $question
			));

			if($data->fetchColumn() == 0)
			{
				$data = $con->prepare('INSERT INTO faq (question, answer) VALUES(:question, :answer)');
				$data->execute(array(
					':question' => $question,
					':answer'   => $answer
				));

				echo '<span class="green">Successfully added!</span>';

				LogAction($_SESSION['username'], "Added FAQ: " . $question . " : Answer = " . $answer, $_SERVER['REMOTE_ADDR'], time());
			}
			else
			{
				echo '<span class="red">Duplicate Entry for question!</span>';
			}
		}
		else
		{
			echo '<span class="red">Fields cant be empty!</span>';
		}
	}
}

function ListStaff()
{
	global $con;

	$data = $con->prepare('SELECT * FROM staff ORDER BY rank asc');
	$data->execute();

	echo '<div class="content-strip column small-12">
			<div class="content-strip-content column small-12">
				<a href="newstaff.php" class="small button">Add Staff</a>
			</div>
		</div>

		<div class="content-content column small-12 medium-12 large-12">
			<div class="content-box column small-12 medium-12">
				<div class="content-box-header column small-12">
					Staff Members
				</div>

				<div class="content-box-content column small-12">
					<table>
						<th>Username</th>
						<th>Rank</th>
						<th></th>
						<th></th>';

	function GrabRank($rank)
	{
		global $con;

		$data = $con->prepare('SELECT * FROM ranks WHERE id = :id');
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
		global $con;

		$data = $con->prepare('SELECT * FROM ranks WHERE id = :id');
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
			echo '<tr>
					<td>' . $row['username'] . '</td>
					<td style="color: ' . GrabRankColor($row['rank']) . ';"><b>' . GrabRank($row['rank']) . '</b></td>
					<td style="text-align: right;"><a href="?edit=' . $row['id'] . '" title="Edit"><i class="fa fa-pencil yellow" aria-hidden="true"></i></a></td>
					<td style="text-align: center;"><a href="?delete=' . $row['id'] . '" title="Delete" onclick="return confirm(\'Are you sure?\')"><i class="fa fa-trash red" aria-hidden="true"></i></a></td>
				</tr>';
		}
	}

	echo '			</table>
				</div>
			</div>
		</div>';
}

function AddStaff()
{
	if(isset($_POST['add-staff']))
	{
		if(!empty($_POST['username']))
		{
			global $con;

			$username = $_POST['username'];
			$avatar   = $_POST['avatar'];
			$rank     = $_POST['rank'];

			$data = $con->prepare('SELECT COUNT(*) FROM staff WHERE username = :username');
			$data->execute(array(
				':username' => $username
			));

			if($data->fetchColumn() == 0)
			{
				$data = $con->prepare('INSERT INTO staff (username, avatar, rank) VALUES(:username, :avatar, :rank)');
				$data->execute(array(
					':username' => $username,
					':avatar'   => $avatar,
					':rank'     => $rank
				));

				echo '<span class="green">Successfully added!</span>';

				LogAction($_SESSION['username'], "Added Staff Member: " . $username . " : Avatar = " . $avatar . " : Rank = " . $rank, $_SERVER['REMOTE_ADDR'], time());
			}
			else
			{
				echo '<span class="red">Duplicate Entry for username!</span>';
			}
		}
		else
		{
			echo '<span class="red">Fields cant be empty!</span>';
		}
	}
}

function EditStaff()
{
	if(isset($_GET['edit']))
	{
		global $con;

		$id = (int)$_GET['edit'];

		$data = $con->prepare('SELECT * FROM staff WHERE id = :id');
		$data->execute(array(
			':id' => $id
		));

		$result = $data->fetchAll(PDO::FETCH_ASSOC);

		foreach($result as $row)
		{
			if(isset($_POST['edit-staff']))
			{
				if(!empty($_POST['username']))
				{
					$username = $_POST['username'];
					$avatar   = $_POST['avatar'];
					$rank     = $_POST['rank'];

					$data = $con->prepare('UPDATE staff SET username = :username, avatar = :avatar, rank = :rank WHERE id = :id');
					$data->execute(array(
						':id'       => $id,
						':username' => $username,
						':avatar'   => $avatar,
						':rank'     => $rank
					));

					$response = '<span class="green">Updated staff member!</span>';
					
					echo '<meta http-equiv="refresh" content="1; url=staff.php" />';

					LogAction($_SESSION['username'], "Edited Staff Member: " . $id . " : Username = " . $username . " : Avatar = " . $avatar . " : Rank = " . $rank, $_SERVER['REMOTE_ADDR'], time());
				}
			}

			echo '<div class="content-content column small-12 medium-12 large-12">
					<div class="content-box column small-12 medium-12">
						<div class="content-box-header column small-12">
							Editing staff member
						</div>

						<div class="content-box-content column small-12">
							<div class="news">
								<form method="POST">
									<div class="news-header column small-12">
										<label>Username</label>
										<input type="text" name="username" value="' . $row['username'] . '" />
									</div>

									<div class="news-content column small-12">
										<label>Avatar</label>
										<input type="text" name="avatar" value="' . $row['avatar'] . '" />
									</div>

									<div class="news-content column small-12">
										<label>Rank</label>
										<select name="rank">
											<option value="1">Project Lead</option>
											<option value="2">Web Developer</option>
											<option value="3">Core Developer</option>
											<option value="4">Consigliere</option>
											<option value="5">Junior Developer</option>
											<option value="6">Community Manager</option>
											<option value="7">Head Moderator</option>
											<option value="8">Moderator</option>
											<option value="9">Graphic Artist</option>
											<option value="10">Head Game Master</option>
											<option value="11">Game Master</option>
										</select>
									</div>

									<div class="news-bottom column small-12">
										<input type="submit" class="button small" name="edit-staff" value="Edit" />
										<span class="response">' . @$response . '</span>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>';
		}
	}
}

function DeleteStaff()
{
	if(isset($_GET['delete']))
	{
		global $con;

		$id = (int)$_GET['delete'];

		$data = $con->prepare('SELECT COUNT(*) FROM staff WHERE id = :id');
		$data->execute(array(
			':id' => $id
		));

		if($data->fetchColumn() == 1)
		{
			$data = $con->prepare('DELETE FROM staff WHERE id = :id');
			$data->execute(array(
				':id' => $id
			));

			echo '<script>location.reload();</script>';

			LogAction($_SESSION['username'], "Deleted Staff Member: " . $id, $_SERVER['REMOTE_ADDR'], time());
		}
	}
}








?>