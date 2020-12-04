<?php $title = 'Administration - Articles'; ?>

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
            <table class="table table-striped table-hover table-bordered last_posts">
                <thead>
                    <tr>
                        <th colspan="4">
                            <div>Les articles</div>
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
                                <div class="title"><a href="index.php?action=category&categoryId=<?= $post['category_id'] ?>"><?= $post['category_title'] ?></a></div>
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
        <nav>
            <ul class="pagination justify-content-center">
                <li class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>">
                    <a href="index.php?action=admin&operation=postsView&page=<?= $currentPage - 1 ?>" class="page-link">Précédente</a>
                </li>
                <?php for($page = 1; $page <= $numberOfPages; $page++): ?>
                    <li class="page-item <?= ($currentPage == $page) ? "active" : "" ?>">
                        <a href="index.php?action=admin&operation=postsView&page=<?= $page ?>" class="page-link"><?= $page ?></a>
                    </li>
                <?php endfor ?>
                    <li class="page-item <?= ($currentPage == $numberOfPages) ? "disabled" : "" ?>">
                    <a href="index.php?action=admin&operation=postsView&page=<?= $currentPage + 1 ?>" class="page-link">Suivante</a>
                </li>
            </ul>
        </nav>
    </div>
</div>
<div class="row">
    <div class="col-12 text-right back_to_top">
        <a href="#top">
            Retour au sommet de la page 
            <i class="fas fa-angle-double-up"></i>
        </a>
    </div>
</div>

<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>