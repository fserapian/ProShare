<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="container">
	<!-- flash message -->
	<?php flash('message'); ?>
	<div class="card">
		<div class="card-content" id="top-tile">
			<div class="row squeeze">
				<div class="col m6">
					<p>Vous cherchez une catégorie particulière ?</p>
				</div>
				<div class="col m6">
					<a class='dropdown-trigger btn green lighten-2' href='#' data-target='dropdown1'>Choisissez une catégorie</a>
					<ul id='dropdown1' class='dropdown-content lighten-2'>
						<li><a href="0">Toutes les catégories</a></li>
						<?php foreach ($data['categories'] as $categorie) : ?>
							<li><a href="<?php echo $categorie->id; ?>"><?php echo $categorie->name; ?></a></li>
						<?php endforeach; ?>
					</ul>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- posts in view -->
	<?php if (!empty($data['posts'])) : ?>
		<?php foreach ($data['posts'] as $post) : ?>
			<div class="card hoverable" id="post-card" onclick="loadShowPage('<?php echo URLROOT . '/posts/show/' . $post->postId; ?>');">
				<div class="card-content">
					<div class="row">
						<div class="col m6">

							<span class="card-title"><strong><?php echo $post->title; ?></strong>
								<div class="chip">

									<?php if ($post->userImage) : ?>
										<img src="<?php echo URLROOT; ?>/img/<?php echo $post->userImage; ?>" alt="">
									<?php endif; ?>

									<?php echo $post->first_name . ' ' . $post->last_name; ?>
								</div>
								<p><small class="light">Cat&eacute;gorie: <?php echo $post->categorie ?></small></p>
							</span>

							<!-- truncated body -->
							<p class="truncate"><?php echo $post->body; ?></p>
						</div>
						<div class="col m6 right-align">

							<div class="rating">
								<?php if ($post->avgNote == null) : ?>
									<?php for ($i = 0; $i < 5; $i++) : ?>
										<i class="grade material-icons">star_border</i>
									<?php endfor; ?>
									<br><small class="light">Aucune note pour le moment</small>
									<?php else :
												$averageNote = $post->avgNote;
												for ($i = 0; $i < 5; $i++) {
													if ($averageNote >= 1) : ?>
											<i class="material-icons">star</i>
										<?php $averageNote = $averageNote - 1;
														elseif ($averageNote < 1 && $averageNote > 0) : ?>
											<i class="material-icons">star_half</i>
										<?php $averageNote = 0;
														else : ?>
											<i class="material-icons">star_border</i>
										<?php endif;
													}
													if ($post->nbrComments == 1) : ?>
										<br><small class="light">Basé sur 1 commentaire.</small>
									<?php else : ?>
										<br><small class="light">Basé sur <?php echo $post->nbrComments; ?> commentaires.</small>
									<?php endif; ?>
								<?php endif; ?>
								<br><small class="light"><?php echo $post->postDate; ?></small>
							</div>

						</div>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	<?php else : ?>
		<div class="card hoverable" id="post-card">
			<div class="card-content" id="top-tile">
				<div class="row">
					<p>Aucun résultat correspondant à ces critères n'a été trouvé;.</p>
				</div>
			</div>
		</div>
	<?php endif; ?>
</div>

<!-- fixed floating add button -->
<div class="fixed-action-btn">
	<a href="<?php echo URLROOT . '/posts/add'; ?>" class="btn-floating btn-large waves-effect waves-light red">
		<i class="material-icons">add</i>
	</a>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>