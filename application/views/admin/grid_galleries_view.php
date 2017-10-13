<div class="col-md-12 admin-grid" id="grid-gallery-card">
  <div class="row">
    <div class="card-deck d-flex flex-wrap">
    <?php
      if ($galleries !== NULL && $galleries !== FALSE) {
        if (count($galleries) == 1) {
        ?>
          <div class="card" data-gallery="<?php echo $galleries->id; ?>">
            <?php
              if (array_key_exists($galleries->id, $main_pictures)) {
              ?>
                <a href="<?php echo base_url().'administration/pictures/view/'.$galleries->id; ?>">
                <img class="card-img-top" style="background-image: url('<?php echo img_project_thumb($galleries->id,$main_pictures[$galleries->id]->filename); ?>')"></a>
              <?php 
              }
              else{
                ?>
                <a href="<?php echo base_url().'administration/pictures/view/'.$galleries->id; ?>"><div class="card-img-top no-img">
                </div></a>
                <?php
              } 
            ?>
            <div class="card-body">
              <h3 class="card-title"><?php echo $galleries->title ?></h3>
              <h6 class="card-subtitle mb-2 text-muted">Visuels : <?php echo $this->picture->count_total($galleries->id); ?> | Visuels publiés : <?php echo $this->picture->count_visible($galleries->id); ?></h6>
            </div>
            <div class="card-footer text-center">
              <div class="btn-group" role="group">
                <?php echo anchor('administration/pictures/view/'.$galleries->id, '<span class="oi oi-image"></span>', ['class'=>'btn btn-info', 'type'=>'button', 'role'=>'button', 'data-toggle'=>'tooltip','data-placement'=>'top', 'title'=>'Voir la galerie' ]); ?>
                <?php echo anchor('administration/projects/preview/'.$galleries->id, '<span class="oi oi-laptop"></span>', ['class'=>'btn btn-secondary', 'type'=>'button', 'role'=>'button', 'data-toggle'=>'tooltip','data-placement'=>'top', 'title'=>'Prévisualiser le projet', 'target'=>'_blank' ]); ?>
                <button type="button" class="btn btn-danger emptyGallery" data-toggle="tooltip" data-placement="top" title="Vider la galerie" data-id="<?php echo $galleries->id; ?>" data-title="<?php echo htmlspecialchars($galleries->title ,ENT_QUOTES); ?>" <?php if (!$this->user->is_admin()):echo 'disabled'; endif?>><span class="oi oi-trash"></span></button>
              </div>
            </div>
          </div>
        <?php
        }
        else{
          foreach ($galleries as $gallery) {
          ?>
              <div class="card" data-gallery="<?php echo $gallery->id; ?>">
                <?php
                  if (array_key_exists($gallery->id, $main_pictures)) {
                  ?>
                    <a href="<?php echo base_url().'administration/pictures/view/'.$gallery->id; ?>">
                    <img class="card-img-top" style="background-image: url('<?php echo img_project_thumb($gallery->id, $main_pictures[$gallery->id]->filename); ?>')"></a>
                  <?php 
                  }
                  else{
                    ?>
                    <a href="<?php echo base_url().'administration/pictures/view/'.$gallery->id; ?>"><div class="card-img-top no-img">
                    </div></a>
                    <?php
                  } 
                ?>
                <div class="card-body">
                  <h3 class="card-title"><?php echo $gallery->title ?></h3>
                  <h6 class="card-subtitle mb-2 text-muted">Visuels : <?php echo $this->picture->count_total($gallery->id); ?> | Visuels publiés : <?php echo $this->picture->count_visible($gallery->id); ?></h6>
                </div>
                <div class="card-footer text-center">
                  <div class="btn-group" role="group">
                    <?php echo anchor('administration/pictures/view/'.$gallery->id, '<span class="oi oi-image"></span>', ['class'=>'btn btn-info', 'type'=>'button', 'role'=>'button', 'data-toggle'=>'tooltip','data-placement'=>'top', 'title'=>'Voir la galerie' ]); ?>
                    <?php echo anchor('administration/projects/preview/'.$gallery->id, '<span class="oi oi-laptop"></span>', ['class'=>'btn btn-secondary', 'type'=>'button', 'role'=>'button', 'data-toggle'=>'tooltip','data-placement'=>'top', 'title'=>'Prévisualiser le projet', 'target'=>'_blank' ]); ?>
                    <button type="button" class="btn btn-danger emptyGallery" data-toggle="tooltip" data-placement="top" title="Vider la galerie" data-id="<?php echo $gallery->id; ?>" data-title="<?php echo htmlspecialchars($gallery->title ,ENT_QUOTES); ?>" <?php if (!$this->user->is_admin()):echo 'disabled'; endif?>><span class="oi oi-trash"></span></button>
                  </div>
                </div>
              </div>
          <?php
          }
        }
      }
    ?>
    </div>
  </div>
  <?php echo form_hidden('csrf_token', $this->security->get_csrf_hash()); ?>
</div>