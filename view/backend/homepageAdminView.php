<?php $title = 'Administration'; ?>

<?php ob_start(); ?>


<div class="container content">
    <div class="row">
        <div class="col-12 table-responsive">
            <table class="table table-striped table-hover table-bordered last_posts">
                <thead>
                    <tr>
                        <th colspan="4">
                            <div class="category">Les articles</div>
                        </th>
                    </tr>
                </thead>
        
                <tbody>
                    <tr>
                        <th></th>
                        <th>Catégorie</th>
                        <th>Créé par</th>
                        <th>Opérations</th>
                    </tr>


                    <?php foreach ($posts as $post):?>
                        <tr>
                            <td>
                                <div class="title"><i class="fas fa-comment"></i><?= htmlspecialchars($post['title']) ?></div>
                                <div><?= htmlspecialchars($post['content']) ?></div>
                            </td>
                            <td>
                                <div class="title"><a href="index.php?action=category&categoryId=<?= $post['category_id'] ?>"><?= htmlspecialchars($post['category_title']) ?></a></div>
                            </td>
                            <td>
                                <div><?= htmlspecialchars($post['pseudo']) ?>
                                <br /><small><?= date('d/m/Y à H:i', strtotime($post['created'])) ?></small>
                                </div>
                            </td>

                            <td>
                                <a href="index.php?action=admin&operation=deletePost&postId=<?= $post['id'] ?>">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>             
            </table>
        </div>
    </div>

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