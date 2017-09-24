<?php

function GrabStreams()
{
	if(isset($_GET['stream']))
	{
		$api      = 'https://api.twitch.tv/kraken/streams/';
		$channel  = stripslashes($_GET['stream']);
		$key      = '1dc3glny88pq4i6n5b62c3p2trpx32';

		$ch = curl_init();

		curl_setopt_array($ch, array(
		    CURLOPT_HTTPHEADER => array(
		       'Client-ID: ' . $key
		    ),
		    CURLOPT_RETURNTRANSFER => true,
		    CURLOPT_URL => $api . $channel
		));

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		 
		$response = curl_exec($ch);
		curl_close($ch);

		$decode = json_decode($response, true);

		echo '<div class="stream-box column small-12 medium-12 large-8">
				<div class="stream-content-box column small-12">
					<div class="twitch-video-window">
						<iframe
					        src="http://player.twitch.tv/?channel=' . $channel . '"
					        height="100%"
					        width="100%"
					        frameborder="0"
					        scrolling="no"
					        allowfullscreen="true">
					    </iframe>
					</div>
				</div>
			</div>

			<div class="stream-box column small-12 medium-12 large-4">
				<div class="stream-content-box column small-12">
					<div class="twitch-chat-window">
						<iframe frameborder="0"
					        scrolling="no"
					        id="chat_embed"
					        src="http://www.twitch.tv/' . $channel . '/chat"
					        height="100%"
					        width="100%">
						</iframe>
					</div>
				</div>
			</div>';
	}
	else
	{
		global $con_web;

		$error     = '';
		$error2    = '';
		$streams   = 0;

		$data = $con_web->prepare('SELECT COUNT(*) FROM streamers WHERE status = 1');
		$data->execute();

		if($data->fetchColumn() > 0)
		{
			$data = $con_web->prepare('SELECT * FROM streamers WHERE status = 1');
			$data->execute();

			$result = $data->fetchAll(PDO::FETCH_ASSOC);

			foreach($result as $row)
			{
				$channel = $row['username'];
				$api     = 'https://api.twitch.tv/kraken/streams/';
				$key     = '1dc3glny88pq4i6n5b62c3p2trpx32';

				$ch = curl_init();

				curl_setopt_array($ch, array(
				    CURLOPT_HTTPHEADER => array(
				       'Client-ID: ' . $key
				    ),
				    CURLOPT_RETURNTRANSFER => true,
				    CURLOPT_URL => $api . $channel
				));

				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				 
				$response = curl_exec($ch);
				curl_close($ch);

				$decode = json_decode($response, true);

				if(!empty($decode['stream']['preview']['large']))
				{
					$streams++;

					echo '<a href="?stream=' . $decode['stream']['channel']['display_name'] . '">
							<div class="stream-box column small-12 medium-6 large-4 left">
								<div class="stream-content-box">
									<img src="' . $decode['stream']['preview']['large'] . '">

									<div class="stream-status">
										' . $decode['stream']['channel']['status'] . '
									</div>
									
									<div class="stream-channel">
										' . $decode['stream']['channel']['display_name'] . '
									</div>

									<div class="stream-viewers">
										<i class="fa fa-user" aria-hidden="true"></i> ' . $decode['stream']['viewers'] . '
									</div>
								</div>
							</div>
						</a>';
				}

				if($streams < 1)
				{
					$error2 = '<div class="stream-box column small-12">
								<div class="callout bg-red white">
									No streams found at the moment!
								</div>
							</div>';
				}
			}
		}
		else
		{
			$error = '<div class="stream-box column small-12">
						<div class="callout bg-red white">
							No streams found at the moment!
						</div>
					</div>';

			echo $error;
		}

		echo $error2;
	}
}


?>