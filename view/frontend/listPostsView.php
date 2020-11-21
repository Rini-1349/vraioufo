<?php $title = 'Vré ù Fô - Accueil'; ?>

<?php ob_start(); ?>


<div class="container-fluid content">
    <?php if ($_SESSION)
    {
    ?>
        <a href="index.php?action=addPost" class="btn btn-primary btn-lg active" role="button"><i class="fas fa-pen-nib"></i> Ajouter un article</a>
    <?php
    }

    if (isset($category) AND !empty($category)): ?>
        <div class="row">
            <div class="col-12 col-md-6 mx-auto">
                <h2><?= $category['title'] ?></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 mx-auto">
                <p><?= $category['description'] ?></p>
            </div>
        </div>
    <?php else:?>
        <div class="row align-items-center justify-content-center mx-auto">    
            <?php foreach ($categories as $category): ?>
                <div class="col-9 col-md-3 col-sm-5 text-center category">     
                    <a href="index.php?action=category&categoryId=<?= $category['id'] ?>">
                        <div><?= $category['img'] ?><?= $category['title'] ?></div>         
                    </a>                            
                </div>
            <?php endforeach ?>  
        </div>
    <?php endif ?>

        <div class="row align-items-center">
            <?php foreach ($posts as $post): ?>
                <div class="col-12 col-lg-6 col-md-6">
                    <article class="last_posts text-center">
                        <div class="row">
                            <div class= "col-12 mx-auto">
                                <h3><?= htmlspecialchars(strtoupper($post['title'])) ?></h3>
                            </div>
                            <div class="col-12 infos_article">
                                <p>Par <?= htmlspecialchars($post['pseudo']) ?> &bull;
                                    <a href="index.php?action=category&categoryId=<?= $post['category_id'] ?>">
                                        <?= htmlspecialchars($post['category_title']) ?>
                                    </a>&bull;
                                    <?= date('d/m/Y à H:i', strtotime($post['created'])) ?>
                                </p>
                            </div>
                            <div class="col-12 article_content">
                                <p><?= htmlspecialchars($post['content']) ?></p>
                            </div>
                            <div class="col-12 justify-content-center">
                                <div class="row">
                                    <?php if (!isset($_SESSION['id'])): ?>
                                        <div class="col-6 mx-auto possible_votes">
                                                <div class="btn">
                                                    <a href="index.php?action=connection">                                                   
                                                    VOTER
                                                        <span class="false">
                                                            <i class="fas fa-angle-double-right"></i>
                                                        </span>
                                                    </a>
                                                </div>
                                        </div>
                                    <?php else: 
                                        if ($post['user_id'] == $_SESSION['id'] OR $post['vote'] != null):

                                            if ($post['user_id'] == $_SESSION['id']):                                                                            
                                                if ($post['true_value' == 0])
                                                {
                                                    $response = '<span class="false">
                                                                    <i class="fas fa-times"></i>
                                                                </span>
                                                                C\'est faux bien-sûr';
                                                }  
                                                else 
                                                {
                                                    $response = '<span class="true">
                                                                    <i class="far fa-check-circle"></i>
                                                                </span>
                                                                Oui, c\'est vrai';
                                                }
                                            elseif ($post['vote'] != null):                                      
                                                if ($post['vote'] == $post['true_value'])
                                                {
                                                    $response = '<span class="true">
                                                                    <i class="far fa-check-circle"></i>
                                                                </span>
                                                                EN EFFET ! BRAVO !';
                                                }
                                                else
                                                {
                                                    $response = '<span class="false">
                                                                    <i class="fas fa-times"></i>
                                                                </span>
                                                                PAS DE BOL...';
                                                }
                                            endif
                                        
                                        ?>
                                        <div class="col-3 responses">
                                            <div class="btn">
                                                <span class="true">
                                                    <i class="far fa-check-circle"></i>
                                                </span>
                                                <?= $responses[$post['id']][1] ?>
                                            </div>
                                        </div>
                                        <div class="col-6 responses">
                                            <div class="btn">
                                                <?= $response ?>
                                            </div>
                                        </div>
                                        <div class="col-3 responses">
                                            <div class="btn">
                                                <span class="false">
                                                    <i class="fas fa-times"></i>
                                                </span>
                                                <?= $responses[$post['id']][0] ?>
                                            </div>
                                        </div>                     
                                            
                                        <?php else: ?>                       
                                            <div class="col-4 possible_votes">
                                                <form action="index.php?action=vote&postId=<?=  $post['id'] ?>&page=<?= $currentPage ?>" method="post">
                                                    <button class="btn" type="submit" name="vote" value="1">
                                                        <span class="true">
                                                            <i class="far fa-check-circle"></i>
                                                        </span>
                                                        VRAI
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="col-4 possible_votes">
                                                <div class="btn deja" id="deja-<?= $post['id']?>" onclick = "deja(this)">
                                                    <span class="sosoon">
                                                        <i class="far fa-clock"></i>
                                                    </span>
                                                    D&Eacute;J&Agrave; ?
                                                </div>
                                            </div>
                                            <div class="col-4 possible_votes">
                                                <form action="index.php?action=vote&postId=<?= $post['id'] ?>&page=<?=  $currentPage ?>" method="post">
                                                    <button class="btn" type="submit" name="vote" value="0">
                                                        <span class="false">
                                                            <i class="fas fa-times"></i>
                                                        </span>
                                                        FAUX
                                                    </button>
                                                </form>
                                            </div>                               
                                        <?php endif ?>   
                                    <?php endif ?>                     
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            <?php endforeach ?>
        </div>
        <nav>
            <ul class="pagination">
                <!-- Lien vers la page précédente (désactivé si on se trouve sur la 1ère page) -->
                <li class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>">
                    <a href="index.php?action=homepage&page=<?= $currentPage - 1 ?>" class="page-link">Précédente</a>
                </li>
                <?php for($page = 1; $page <= $numberOfPages; $page++): ?>
                    <!-- Lien vers chacune des pages (activé si on se trouve sur la page correspondante) -->
                    <li class="page-item <?= ($currentPage == $page) ? "active" : "" ?>">
                        <a href="index.php?action=homepage&page=<?= $page ?>" class="page-link"><?= $page ?></a>
                    </li>
                <?php endfor ?>
                    <!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
                    <li class="page-item <?= ($currentPage == $numberOfPages) ? "disabled" : "" ?>">
                    <a href="index.php?action=homepage&page=<?= $currentPage + 1 ?>" class="page-link">Suivante</a>
                </li>
            </ul>
        </nav>
</div>
<div class="hidden" id="hidden_deja"><?= $dejaElements ?></div>
    <script>
        const dejaElmts = document.getElementById('hidden_deja').innerHTML.split(';');

        function deja(dejaButton){
            const random = Math.floor(Math.random() * (dejaElmts.length - 1));
            const dejaElmt = (random, dejaElmts[random]);
            //element.innerHTML = "<p>" + dejaElmt + "</p>";
            dejaButton.innerHTML = '<span class="sosoon"><i class="far fa-clock"></i></span> ' + dejaElmt;
        }
    </script>

<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>
