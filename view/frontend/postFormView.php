<?php $title='Ajouter un article'; ?>

<?php ob_start(); ?>

<div class="container content form_page">
	<div class="row">
		<div class="col-12 col-md-8 offset-md-2">
			<h2>Ajouter un article</h2>
			<form method="post" action="index.php?action=addPost">
				<div class="form-group">
					<label for="title">Titre de l'article</label>
					<input type="text" class="form-control" name="title" id="title" autofocus required />
				</div>

				<div class="form-group">
					<label for="category">Catégorie</label>
					<select name="category" id="category" class="custom-select">
						<option selected>Choisir une catégorie</option>
						<?php 
						foreach ($categories as $category)
						{
						?>
							<option value="<?= $category['id'] ?>"><?= $category['title'] ?></option>
						<?php
						}
						?>
					</select>
				</div>
				<div class="form-group">
					<label for="true_value">L'article est : </label>
					<select name="true_value" id="true_value" class="custom-select">
						<option selected>Choisir</option>
						<option value="1">Vrai</option>
						<option value="0">Faux</option>
					</select>
				</div>
				<div class="form-group">
					<label for="content">Contenu de l'article</label>
					<textarea name="content" id="content" class="form-control" cols="40" rows="5" maxlength="255" aria-describedby="content_maxlength" required ></textarea>
					<small id="content_maxlength" class="text-muted">
						Limité à 255 caractères
					</small>
				</div>
				<button class="btn btn-primary" type="submit">Enregistrer l'article</button>
			</form>
		</div>
	</div>
</div>

<?php $content=ob_get_clean(); ?>

<?php require('template.php'); ?>