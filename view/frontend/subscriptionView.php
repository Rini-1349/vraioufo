<?php $title='Inscription'; ?>

<?php ob_start(); ?>

<div class="container content form_page">
	<div class="row">
		<div class="col-12 col-md-8 offset-md-2">
			<h2>S'inscrire</h2>
			<form method="post" class="needs-validation" novalidate action="index.php?action=subscription">
				<div class="form-group">
					<label for="name">Nom</label>
					<input type="text" class="form-control" name="name" id="name" autofocus required />
					<div class="invalid-feedback">Ce champ est requis</div>
				</div>

				<div class="form-group">
					<label for="first_name">Prénom</label>
					<input type="text" class="form-control" name="first_name" id="first_name" required />
					<div class="invalid-feedback">Ce champ est requis</div>
				</div>

				<div class="form-group">
					<label for="pseudo">Pseudo</label>
					<input type="text" class="form-control" name="pseudo" id="pseudo" required />
					<div class="invalid-feedback">Ce champ est requis</div>
				</div>
				<div class="form-group">
					<label for="email">Adresse mail</label>
					<input type="text" pattern="^[a-z0-9_.-]+@[a-z0-9_.-]{2,}\.[a-z]{2,4}$" class="form-control" name="email" id="email" required />
					<div class="invalid-feedback">Adresse email incorrecte</div>
				</div>
				<div class="form-group">
					<label for="pass">Mot de passe</label>
					<input type="password" pattern="^\S*(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[0-9])(?=\S*[\W])\S{8,20}$" class="form-control" name="pass" id="pass" aria-describedby="pass_format" required />
					<div class="invalid-feedback">Format de mot de passe incorrect</div>
					<small id="pass_format" class="text-muted">
					Doit contenir entre 8 et 20 caractères dont 1 chiffre, 1 minuscule, 1 majuscule et 1 caractère spécial
					</small>
				</div>
				<div class="form-group">
					<label for="pass_confirm">Confirmation de mot de passe</label>
					<input type="password" class="form-control" name="pass_confirm" id="pass_confirm" required />
					<div class="invalid-feedback" id="pass_confirm_error">Confirmation de mot de passe incorrecte</div>
				</div>

				<button class="btn btn-primary" type="submit">Valider</button>
			</form>
		</div>
	</div>
</div>
<script>
	(function() 
	{
	'use strict';
		window.addEventListener('load', function() 
		{
			var forms = document.getElementsByClassName('needs-validation');
			var validation = Array.prototype.filter.call(forms, function(form) 
			{
				form.addEventListener('submit', function(event) { 
					if (form.checkValidity() === false) 
					{
					event.preventDefault();
					event.stopPropagation();
					}

					const pass = document.getElementById('pass');
					const pass_confirm = document.getElementById('pass_confirm');
					const error = document.getElementById('pass_confirm_error');
					if (pass_confirm.value != pass.value || pass_confirm.value == '') 
					{
						pass_confirm.style.borderColor = '#dc3545';
						error.style.display = 'block';
						pass_confirm.style.backgroundImage = "none";
						event.preventDefault();
						event.stopPropagation();					
					}
					else
					{
						pass_confirm.style.borderColor = '#28a745';
						error.style.display = 'none';
						pass_confirm.style.backgroundImage = "none";
					}
					form.classList.add('was-validated');
				}, false);
			});
		}, false);
	})();
</script>
<?php $content=ob_get_clean(); ?>

<?php require('template.php'); ?>