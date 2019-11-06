<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="container">
	<?php flash('message'); ?>
	<!-- update and delete buttons -->
	<?php if (isset($_SESSION['user_id']) && ($data['post']->userId === $_SESSION['user_id']  || $_SESSION['level'] == 3)) : ?>
		<form action="<?php echo URLROOT; ?>/posts/delete/<?php echo $data['post']->postId; ?>" method="post">
			<button class="btn-delete btn red right waves-effect waves-light">Supprimer</button>
		</form>
		<a href="<?php echo URLROOT; ?>/posts/edit/<?php echo $data['post']->postId; ?>" class="btn-edit btn black right waves-effect waves-light">Modifier</a>
	<?php endif; ?>
	<!-- back button -->
	<a href="<?php echo URLROOT; ?>/posts" class="btn white black-text"><i class="material-icons left">arrow_back</i>Retour</a>

	<!-- Title -->
	<h3>
		<strong><?php echo $data['post']->title; ?></strong>
	</h3>
	<strong> Catégorie: <?php echo $data['post']->categorie; ?></strong>
	<p>

		<!-- lesser header -->
		<small>Créé par <strong><?php echo $data['post']->first_name . ' ' . $data['post']->last_name; ?></strong> le <?php echo ($data['post']->postDate) ?></small>

		<!-- likes and dislikes -->
		<span id="numdown" class="right"><?php echo $data['dislikesCount']; ?></span>
		<i id="tdown" class="material-icons right reaction" onclick="react(-1, <?php echo $data['post']->postId; ?>)">thumb_down</i>
		<span id="numup" class="right"><?php echo $data['likesCount']; ?></span>
		<i id="tup" class="material-icons right reaction" onclick="react(1, <?php echo $data['post']->postId; ?>)">thumb_up</i>
	</p>
	<hr>
	<!-- content -->
	<div id="showcontent">
		<p><?php echo $data['post']->content; ?></p>
	</div>

	<!-- comment textbox -->
	<form action="<?php echo URLROOT; ?>/posts/show/<?php echo $data['post']->postId ?>" method="post">
		<?php if (!isset($_SESSION['user_id'])) : ?>
			­<p><a href='<?php echo URLROOT; ?>/users/login'>Connectez-vous</a> pour commenter sur ce projet.</p>
		<?php elseif ($data['post']->userId !== $_SESSION['user_id']) : ?>
			<div class="row">
				<div class="input-field col s10">
					<textarea name="content" id="comment" class="<?php echo !empty($data['comment_err']) ? 'invalid' : ''; ?> materialize-textarea"></textarea>
					<label for="comment">Votre commentaire...</label>
					<span class="helper-text" data-error="<?php echo $data['comment_err']; ?>"></span>
				</div>
				<div class="col s2" style="padding-top: 14px">
					<select name="note" id="note">
						<option value="0">note</option>
						<?php for ($i = 1; $i <= 5; $i++) : ?>
							<option value="<?php echo $i ?>"><?php echo $i ?></option>
						<?php endfor; ?>
					</select>
				</div>
			</div>

			<div class="input-field">
				<input type="submit" value="Commenter" class="btn-small black">
			</div>
		<?php endif; ?>
	</form>
	<h5>Commentaires</h5>
	<?php if ((!isset($_SESSION['user_id']) && count($data['comments']) == 0)  || (count($data['comments']) == 0  && ($data['post']->userId !== $_SESSION['user_id']))) : ?>
		<p class="light"><br> Il n'y a pas encore de commentaires sur ce projet. Soyez le premier à laisser <?php echo $data['post']->first_name ?> savoir ce que vous en pensez !</p>
	<?php elseif (count($data['comments']) == 0  && ($data['post']->userId === $_SESSION['user_id'])) : ?>
		<p class="light">Il n'y a pas encore de commentaires sur votre projet. </p>
	<?php else : ?>
		<!-- comments -->
		<?php foreach ($data['comments'] as $comment) : ?>
			<div class="card" id="post-card">
				<div class="card-content">
					<div class="row">
						<div class="col m9">
							<span class="card-title">
								<div class="chip">
									<?php echo $comment->fname . ' ' . $comment->lname; ?>
								</div>
								<small class="light timeago"><?php echo $comment->dateComment ?> </small>
							</span>
							<p><?php echo $comment->content ?></p><br>
						</div>
						<div class="col m3 right-align">
							<div class="rating">
								<?php $note = $comment->note; ?>
								<?php for ($i = 0; $i < 5; $i++) : ?>
									<?php if ($note >= 1) : ?>
										<div class="material-icons">star</div>
										<?php $note = $note - 1; ?>
									<?php else : ?>
										<div class="material-icons">star_border</div>
									<?php endif; ?>
								<?php endfor; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	<?php endif; ?>

</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>