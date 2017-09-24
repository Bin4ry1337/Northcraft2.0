<?php

include('header.php');

Permission(2);

?>

<div class="row">
	<div class="content">
		<div class="content-content column small-12 medium-12 large-12">
			<div class="content-box column small-12 medium-12">
				<div class="content-box-header column small-12">
					Create a new post
				</div>

				<div class="content-box-content column small-12">
					<div class="news">
						<form method="POST">
							<div class="news-header column small-12">
								<label>Post title</label>
								<input type="text" name="title" />
							</div>

							<div class="news-content column small-12">
								<label>Summary</label>
								<textarea name="summary" id="textarea" class="small-textarea"></textarea>
							</div>

							<div class="news-content column small-12">
								<textarea name="content" id="textarea2" class="normal-textarea"></textarea>
							</div>

							<div class="news-header column small-12">
								<label>Banner Image (1200x290)</label>
								<input type="text" name="post_banner" />
							</div>

							<div class="news-bottom column small-12">
								<input type="submit" class="button small" name="post-news" value="Post" />
								<span class="response"><?php AddNews(); ?></span>
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