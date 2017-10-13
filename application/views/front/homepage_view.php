<div class="row content-area" id="onePage">
    <div class="col-md-12 section"><!-- SECTION 1 -->
        <div class="row justify-content-end">
            <div class="col-md-8">
                <h1 class="state">Accroche</h1>
                <div class="row">
                    <div class="col-md-6">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    </div>
                    <div class="col-md-6">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p> 
                    </div>
                </div>
                <div class="row liste">
                    <div class="col-12 col-md-12">
                        <h3>Liste Titre</h3>
                    </div>
                    <div class="col-md-6 ">
                        <ul class="listing">
                            <li>
                            <span class="list-title">Liste sous-titre</span>
                                <ul>
                                    <li class="intitule">Liste sous-titre</li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="listing">
                            <li>
                            <span class="list-title">Liste sous-titre</span>
                                <ul>
                                    <li class="intitule">Liste sous-titre</li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 section"><!-- SECTION 2 -->
        <div class="row justify-content-end">
            <div class="col-md-8">
                <h2>Section projets</h2>
                <ul id="grid-filter">
                    <li data-filter="all" class="filtr-active">Tout types</li>
                    <?php
                        if ($avaible_categories !== NULL && $avaible_categories !== FALSE) {
                            if(count($avaible_categories) == 1){
                            ?>
                            <li data-filter="<?php echo $avaible_categories->id; ?>"><?php echo $avaible_categories->title; ?></li>
                            <?php
                            }
                            else{
                                foreach ($avaible_categories as $category) {
                                ?>
                                <li data-filter="<?php echo $category->id; ?>"><?php echo $category->title; ?></li>
                                <?php
                                }
                            }
                        }
                    ?>
                </ul>
                <div id="grid-book" class="filtr-container d-flex justify-content-between">

                    <?php
                    if ($avaible_projects !== NULL && $avaible_projects !== FALSE) {
                        if (count($avaible_projects) == 1) {
                        ?>
                            <div class="filtr-item" data-category="<?php echo $avaible_projects->category_id ; ?>">
                                <div class="content">
                                    <div class="project-desc animated bounceInLeft"><h3><?php echo $avaible_projects->title; ?></h3></div>
                                    <?php if (!empty($avaible_projects->main_picture)){ ?>
                                        <img src="<?php echo img_project_thumb($avaible_projects->id, $avaible_projects->main_picture->filename); ?>" alt="<?php echo $avaible_projects->main_picture->alt; ?>">
                                    <?php }
                                        else{
                                    ?>
                                        <div class="no-img"></div>
                                    <?php }?>
                                    <a href="<?php echo base_url().'project/'.$avaible_projects->public_url; ?>"></a>
                                </div>
                            </div>
                        <?php
                        }
                        else{
                            foreach ($avaible_projects as $project) {
                            ?>
                            <div class="filtr-item" data-category="<?php echo $project->category_id ; ?>">
                                <div class="content">
                                    <div class="project-desc animated bounceInLeft"><h3><?php echo $project->title; ?></h3></div>
                                    <?php if (!empty($project->main_picture)){ ?>
                                        <img src="<?php echo img_project_thumb($project->id,$project->main_picture->filename); ?>" alt="<?php echo $project->main_picture->alt; ?>">
                                    <?php }
                                        else{
                                    ?>
                                        <div class="no-img"></div>
                                    <?php }?>
                                    <a href="<?php echo base_url().'project/'.$project->public_url; ?>"></a>
                                </div>
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

    <div class="col-md-12 section"><!-- SECTION 3 -->
        <div class="row justify-content-end">
            <div class="col-md-8">
                <h2>Titre de section</h2>
                <div class="row liste">
                    <div class="col-12 col-md-12">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                        <h3>Liste Titre</h3>
                    </div>
                    <div class="col-md-6 ">
                        <ul class="listing">
                            <li>
                            <span class="list-title">Liste sous-titre</span>
                                <ul>
                                    <li class="intitule">Liste sous-titre</li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="listing">
                            <li>
                            <span class="list-title">Liste sous-titre</span>
                                <ul>
                                    <li class="intitule">Liste sous-titre</li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 section"><!-- SECTION 4 -->
        <div class="row justify-content-end">
            <div class="col-md-8">
                <h2>Section contact</h2>
                <div class="row">
                    <div class="col">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>