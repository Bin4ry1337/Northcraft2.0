<?php

include('header.php');

Permission(5);

?>

<div class="row">
	<div class="content">	
		<div class="content-content column small-12 medium-12 large-12">
			<div class="content-box column small-12 medium-12">
				<div class="content-box-header column small-12">
					Create new user
				</div>

				<div class="content-box-content column small-12">
					<div class="news">
						<form method="POST">
							<div class="news-header column small-12">
								<label>Username</label>
								<input type="text" name="username" />
							</div>

							<div class="news-content column small-12">
								<label>Email</label>
								<input type="text" name="email" />
							</div>

							<div class="news-content column small-12">
								<label>Password</label>
								<input type="password" name="password" />
							</div>

							<div class="news-content column small-12">
								<label>Re-Password</label>
								<input type="password" name="repassword" />
							</div>

							<div class="news-content column small-12">
								<label>Access Level</label>
								<select name="level">
									<option value="1">Game Master</option>
									<option value="2">Moderator</option>
									<option value="3">Administrator</option>
								</select>
							</div>

							<div class="news-bottom column small-12">
								<input type="submit" class="button small" name="create" value="Create" />
								<span class="response"><?php CreateUser(); ?></span>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php

include('footer.php');

?>