<div class="row content-area">
    <div class="col-md-12">
        <div class="row justify-content-end">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6" id="project-description">
                        <h1><?php echo $title; ?></h1>
                        <h2>Catégorie : </h2>
                        <p><?php echo $category; ?></p>
                        <h2>Contexte :</h2>
                        <p><?php echo $context; ?></p>
                        <h2>Descripion :</h2>
                        <p><?php echo $description; ?></p>
                        <?php if($external_link !== NULL && $external_link !== FALSE): ?>
                            <p class="my-button">
                                <a href="<?php echo $external_link; ?>" role="button" target="_blank"><span class="oi oi-external-link"></span>En voir +</a>
                            </p>
                        <?php endif ?>

                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-5" id="project-gallery">
                    <?php 
                        if ($gallery !== NULL && $gallery !== FALSE) {
                            if (count($gallery) == 1) {
                            ?>
                            <div class="grid-item">
                                <a href="<?php echo img_project($id, $gallery->filename); ?>" data-fancybox="gallery" data-caption="<?php echo $gallery->alt; ?>">
                                    <img src="<?php echo  img_project_thumb($id, $gallery->filename); ?>"  title="<?php echo $gallery->title; ?>" alt="<?php echo $gallery->alt; ?>" />
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
                    <?php if (isset($previous_project)): ?>
                        <div class="col-12 d-flex justify-content-between" id="nav-project">
                            <?php if ($previous_project !== NULL && $previous_project !== FALSE): ?>
                                <a href="<?php echo base_url().'project/'.$previous_project->public_url; ?>" class="btn btn-outline-secondary" role="button" ><span class="oi oi-arrow-circle-left left"></span><?php echo $previous_project->title; ?></a>
                            <?php endif ?>
                            <?php if ($next_project !== NULL && $next_project !== FALSE): ?>
                                <a href="<?php echo base_url().'project/'.$next_project->public_url; ?>" class="btn btn-outline-secondary ml-auto" role="button" ><?php echo $next_project->title; ?><span class="oi oi-arrow-circle-right right"></span></a> 
                            <?php endif ?>
                        </div>
                    <?php endif ?>

                </div>
            </div>
        </div>
    </div>
</div>