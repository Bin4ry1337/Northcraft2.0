<?php

include('header.php');

Permission(3);

?>

<div class="row">
	<div class="content">
		<div class="content-content column small-12 medium-12 large-12">
			<div class="content-box column small-12 medium-12">
				<div class="content-box-header column small-12">
					Add a new question
				</div>

				<div class="content-box-content column small-12">
					<div class="news">
						<form method="POST">
							<div class="news-header column small-12">
								<label>Question</label>
								<input type="text" name="question" />
							</div>

							<div class="news-content column small-12">
								<label>Answer</label>
								<textarea name="answer" style="min-height: 100px;"></textarea>
							</div>

							<div class="news-bottom column small-12">
								<input type="submit" class="button small" name="add-faq" value="Submit" />
								<span class="response"><?php AddFAQ(); ?></span>
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