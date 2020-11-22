<?php $title = 'Administration'; ?>

<?php ob_start(); ?>


<div class="container content">
    <div class="row">
        <div class="col-6">
            <a href="index.php?action=admin&operation=postsView">Articles</a>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <a href="index.php?action=admin&operation=usersView">Utilisateurs</a>
        </div>
    </div>
</div>



<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>