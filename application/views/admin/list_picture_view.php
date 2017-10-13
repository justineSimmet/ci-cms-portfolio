<div class="col-md-6 admin-list" id="list-picture-sort">

  <ul id="gallery-list">
    <?php if ($list_pictures !== NULL && $list_pictures !== FALSE){
      if (count($list_pictures) == 1) {
      ?>
      <li class="gallery-item" data-id="<?php echo $list_pictures->id; ?>" >
        <div class="d-flex flex-row justify-content-between align-items-start">
          <div class="item-picture-container d-none d-md-block d-lg-block">
            <div class="item-picture" style="background-image: url(<?php echo img_project_thumb($project_id, $list_pictures->filename); ?>)">
            </div>
          </div>
          <div class="item-desc">
            <h4><span class="badge badge-info badge-pill font-weight-normal">#<?php echo $list_pictures->id; ?></span> <?php echo $list_pictures->title; ?></h4>
            <p><?php echo $list_pictures->alt; ?></p>
          </div>
          <div class="btn-group-vertical" role="group">
            <!-- Visibilité -->
            <?php  
                if ($list_pictures->visibility == 1) {
                ?>
                  <button type="button" class="btn btn-success hidePicture" data-toggle="tooltip" data-placement="top" title="Masquer le visuel" data-id="<?php echo $list_pictures->id; ?>" <?php if (!$this->user->is_admin()):echo 'disabled'; endif?>><span class="oi oi-eye"></span></button>
                <?php
                }
                else{
                ?>
                  <button type="button" class="btn btn-warning showPicture" data-toggle="tooltip" data-placement="top" title="Publier le visuel" data-id="<?php echo $list_pictures->id; ?>" <?php if (!$this->user->is_admin()):echo 'disabled'; endif?>><span class="oi oi-eye"></span></button>
                <?php
                }
              ?>
            <!-- Modifier -->
            <a type="button" href="<?php echo base_url(); ?>administration/pictures/view/<?php echo $project_id; ?>/edit/<?php echo $list_pictures->id; ?>" role="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Modifier le visuel"><span class="oi oi-pencil"></span></a>
            <!-- Supprimer -->
            <button type="button" class="btn btn-danger deletePicture" data-toggle="tooltip" data-placement="top" title="Supprimer" data-id="<?php echo $list_pictures->id; ?>" data-title="<?php echo htmlspecialchars($list_pictures->title ,ENT_QUOTES); ?>" <?php if (!$this->user->is_admin()):echo 'disabled'; endif?>><span class="oi oi-trash"></span></button>
          </div>

        </div>
      </li>
      <?php
      }
      else{
        foreach ($list_pictures as $picture) {
        ?>
        <li class="gallery-item" data-picture="<?php echo $picture->id; ?>">
          <div class="d-flex flex-row justify-content-between align-items-start">
            <div class="item-picture-container">
              <div class="item-picture" style="background-image: url(<?php echo img_project_thumb($project_id, $picture->filename); ?>)">
              </div>
            </div>
            <div class="item-desc">
              <h4><span class="badge badge-info badge-pill font-weight-normal">#<?php echo $picture->id; ?></span> <?php echo $picture->title; ?></h4>
              <p><?php echo $picture->alt; ?></p>
            </div>
            <div class="btn-group-vertical" role="group">
              <!-- Visibilité -->
              <?php  
                if ($picture->visibility == 1) {
                ?>
                  <button type="button" class="btn btn-success hidePicture" data-toggle="tooltip" data-placement="top" title="Masquer le visuel" data-id="<?php echo $picture->id; ?>" <?php if (!$this->user->is_admin()):echo 'disabled'; endif?>><span class="oi oi-eye"></span></button>
                <?php
                }
                else{
                ?>
                  <button type="button" class="btn btn-warning showPicture" data-toggle="tooltip" data-placement="top" title="Publier le visuel" data-id="<?php echo $picture->id; ?>" <?php if (!$this->user->is_admin()):echo 'disabled'; endif?>><span class="oi oi-eye"></span></button>
                <?php
                }
              ?>
              <!-- Modifier -->
              <a type="button" href="<?php echo base_url(); ?>administration/pictures/view/<?php echo $project_id; ?>/edit/<?php echo $picture->id; ?>" role="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Modifier le visuel"><span class="oi oi-pencil"></span></a>
              <!-- Supprimer -->
              <button type="button" class="btn btn-danger deletePicture" data-toggle="tooltip" data-placement="top" title="Supprimer" data-id="<?php echo $picture->id; ?>" data-title="<?php echo htmlspecialchars($picture->title ,ENT_QUOTES); ?>" <?php if (!$this->user->is_admin()):echo 'disabled'; endif?>><span class="oi oi-trash"></span></button>
            </div>
          </div>
        </li>
        <?php
        }
      }
    }
    ?>

  </ul>

  <ul id="gallery-list-count">
    <?php  
      if ($list_pictures !== NULL && $list_pictures !== FALSE){
        if (count($list_pictures) == 1) {
        ?>
        <li>
          <span>1</span>
        </li>
        <?php
        }
        else{
          for ($i=1; $i <= count($list_pictures); $i++) { 
          ?>
            <li>
              <span><?php echo $i; ?></span>
            </li>
        <?php
          }
        }
      }
    ?>
    
  </ul>

  <?php echo form_hidden('csrf_token', $this->security->get_csrf_hash()); ?>
</div>  

