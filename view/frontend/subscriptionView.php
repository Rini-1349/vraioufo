<?php $title='Inscription'; ?>

<?php ob_start(); ?>

<div class="container content">
	<div class="row">
		<div class="col-12 col-md-8 offset-md-2">
			<h2>S'inscrire</h2>
			<form method="post" action="index.php?action=subscription">
				<div class="form-group">
					<label for="name">Nom</label>
					<input type="text" class="form-control" name="name" id="name" autofocus required />
				</div>

				<div class="form-group">
					<label for="first_name">Prénom</label>
					<input type="text" class="form-control" name="first_name" id="first_name" required />
				</div>

				<div class="form-group">
					<label for="pseudo">Pseudo</label>
					<input type="text" class="form-control" name="pseudo" id="pseudo" required />
				</div>
				<div class="form-group">
					<label for="email">Adresse mail</label>
					<input type="text" class="form-control" name="email" id="email" required />
				</div>
				<div class="form-group">
					<label for="pass">Mot de passe</label>
					<input type="password" class="form-control" name="pass" id="pass" aria-describedby="pass_format" required />
					<small id="pass_format" class="text-muted">
					Doit contenir entre 8 et 20 caractères dont 1 chiffre, 1 minuscule, 1 majuscule et 1 caractère spécial
					</small>
				</div>
				<div class="form-group">
					<label for="pass_confirm">Confirmation de mot de passe</label>
					<input type="password" class="form-control" name="pass_confirm" id="pass_confirm" required />
				</div>

				<button class="btn btn-primary" type="submit">Valider</button>
			</form>
		</div>
	</div>
</div>
<?php $content=ob_get_clean(); ?>

<?php require('template.php'); ?>