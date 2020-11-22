<?php $title='Connexion'; ?>

<?php ob_start(); ?>
<div class="container content form_page">
	<div class="row">
		<div class="col-12 col-md-8 offset-md-2">
			<h2>Se connecter</h2>
			<form method="post" action="index.php?action=connection">
				<div class="form-group">
					<label for="login">Login</label>
					<input type="text" class="form-control" name="login" id="login" aria-describedby="login_info" autofocus required />
					<small id="login_info" class="text-muted">Adresse email ou pseudo</small>
				</div>

				<div class="form-group">
					<label for="pass">Mot de passe</label>
					<input type="password" class="form-control" name="pass" id="pass" required />
				</div>

				<button class="btn btn-primary" type="submit">Valider</button>
			</form>
			<p>Pas encore de compte ? <a href="index.php?action=subscription">Inscrivez-vous</a></p>
		</div>
	</div>
</div>

<?php $content=ob_get_clean(); ?>

<?php require('template.php'); ?>