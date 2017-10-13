<div class="container" id="preview_project">
    <div class="row justify-content-end">
        <div>
            <div class="row">
                <div class="col-md-6" id="project-description">
                    <h1><?php echo $title; ?></h1>
                    <h2>Catégorie : </h2>
                    <p><?php echo $category; ?></p>
                    <h2>Contexte :</h2>
                    <p><?php echo $context; ?></p>
                    <h2>Descripion :</h2>
                    <p><?php echo $description; ?></p>
                    <p class="my-button">
                        <?php 
                        if (!empty($external_link)) {
                        ?>
                            <a href="<?php echo $external_link; ?>" role="button" target="_blank"><span class="oi oi-external-link"></span>En voir +</a>
                        <?php
                        }
                        ?>
                    </p>
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-5" id="project-gallery">
                    <?php 
                        if ($gallery !== NULL && $gallery !== FALSE) {
                            if (count($gallery) == 1) {
                            ?>
                            <div class="grid-item">
                                <a href="<?php echo img_project($id,$gallery->filename); ?>" data-fancybox="gallery" data-caption="<?php echo $gallery->alt; ?>">
                                    <img src="<?php echo img_project_thumb($id,$gallery->filename); ?>"  title="<?php echo $gallery->title; ?>" alt="<?php echo $gallery->alt; ?>" />
                                </a>
                            </div>
                            <?php
                            }
                            else{
                                foreach ($gallery as $picture) {
                                ?>
                                <div class="grid-item">
                                    <a href="<?php echo img_project($id,$picture->filename); ?>" data-fancybox="picture" data-caption="<?php echo $picture->alt; ?>">
                                        <img src="<?php echo img_project_thumb($id,$picture->filename); ?>"  title="<?php echo $picture->title; ?>" alt="<?php echo $picture->alt; ?>" />
                                    </a>
                                </div>
                                <?php
                                }
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
