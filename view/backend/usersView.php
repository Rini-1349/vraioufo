<?php $title = 'Administration - Utilisateurs'; ?>

<?php ob_start(); ?>


<div class="container-fluid content">
    <div class="row">       
        <div class="col-12 add_article">        
            <a href="index.php?action=admin" class="btn btn-primary btn-lg active" role="button">
                <i class="fas fa-chevron-left"></i> Retour au panel d'administration
            </a>
        </div>              
    </div>
    <div class="row align-items-center">
        <div class="col-12 table-responsive">
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th colspan="4">
                            <div>Les utilisateurs</div>
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
    <nav>
        <ul class="pagination justify-content-center">
            <!-- Lien vers la page précédente (désactivé si on se trouve sur la 1ère page) -->
            <li class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>">
                <a href="index.php?action=admin&operation=usersView&page=<?= $currentPage - 1 ?>" class="page-link">Précédente</a>
            </li>
            <?php for($page = 1; $page <= $numberOfPages; $page++): ?>
                <!-- Lien vers chacune des pages (activé si on se trouve sur la page correspondante) -->
                <li class="page-item <?= ($currentPage == $page) ? "active" : "" ?>">
                    <a href="index.php?action=admin&operation=usersView&page=<?= $page ?>" class="page-link"><?= $page ?></a>
                </li>
            <?php endfor ?>
                <!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
                <li class="page-item <?= ($currentPage == $numberOfPages) ? "disabled" : "" ?>">
                <a href="index.php?action=admin&operation=usersView&page=<?= $currentPage + 1 ?>" class="page-link">Suivante</a>
            </li>
        </ul>
    </nav>
</div>



<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>