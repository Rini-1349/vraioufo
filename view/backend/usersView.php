<?php $title = 'Administration - Utilisateurs'; ?>

<?php ob_start(); ?>


<div class="container content">
    <div class="row">
        <div class="col-12 table-responsive">
            <table class="table table-striped table-hover table-bordered last_posts">
                <thead>
                    <tr>
                        <th colspan="4">
                            <div class="category">Les utilisateurs</div>
                        </th>
                    </tr>
                </thead>
        
                <tbody>
                    <tr>
                        <th>Utilisateur</th>
                        <th>Mail</th>
                        <th></th>
                        <th>Opérations</th>
                    </tr>

                    <?php foreach ($users as $user):?>
                        <tr>
                            <td>
                                <div class="title"><i class="fas fa-comment"></i><?= htmlspecialchars($user['first_name']) . ' ' . htmlspecialchars($user['name']) ?></div>
                                <div><?= htmlspecialchars($user['pseudo']) ?></div>
                            </td>
                            <td>
                                <div class="title"><?= htmlspecialchars($user['email']) ?></div>
                            </td>
                            <td>
                                <div>
                                </div>
                            </td>

                            <td>
                                <a href="index.php?action=admin&operation=deleteUser&userId=<?= $user['id'] ?>">Supprimer</a>
                            </td>
                        </tr>
                    <?php
                    endforeach
                    ?>
                </tbody>             
            </table>
        </div>
    </div>
</div>



<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>