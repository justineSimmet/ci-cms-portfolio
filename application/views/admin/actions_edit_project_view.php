<div class="col-md-2 admin-action-list" id="project-action">
  <ul>
    <li>
      <!-- Visibilité -->
      <?php
      if ($visibility == 0 ) {
      ?>
        <button type="button" class="btn btn-warning btn-block mb-3 showProject" data-toggle="tooltip" data-placement="top" title="Cliquez pour publier" data-id="<?php echo $id; ?>" data-title="<?php echo htmlspecialchars($title ,ENT_QUOTES); ?>" data-category="<?php echo $category_id; ?>" <?php if (!$this->user->is_admin()):echo 'disabled'; endif?>><span class="oi oi-eye"></span>  Publier le projet</button>
      <?php
      }
      else{
      ?>
        <button type="button" class="btn btn-success btn-block mb-3 hideProject" data-toggle="tooltip" data-placement="top" title="Cliquez pour masquer" data-id="<?php echo $id; ?>" data-title="<?php echo htmlspecialchars($title ,ENT_QUOTES); ?>" data-category="<?php echo $category_id; ?>" <?php if (!$this->user->is_admin()):echo 'disabled'; endif?>><span class="oi oi-eye"></span>  Masquer le projet</button>
      <?php  
      }
      ?>
    </li>
    <li>
      <!-- Galerie -->
      <?php echo anchor('administration/pictures/view/'.$id, '<span class="oi oi-image"></span> Voir la galerie', ['class'=>'btn btn-info btn-block mb-3', 'type'=>'button', 'role'=>'button', 'data-toggle'=>'tooltip','data-placement'=>'top', 'title'=>'Galerie' ]); ?>
    </li>
    <li>
      <?php echo anchor('administration/projects/preview/'.$id, '<span class="oi oi-laptop"></span> Prévisualiser', ['class'=>'btn btn-secondary btn-block mb-3', 'type'=>'button', 'role'=>'button', 'data-toggle'=>'tooltip','data-placement'=>'top', 'title'=>'Prévisualiser', 'target'=>'_blank' ]);?>
    </li>
    <li>
      <!-- Supprimer -->
      <button type="button" role="button" class="btn btn-danger btn-block mb-3 deleteProject" data-toggle="tooltip" data-placement="top" title="Supprimer" data-id="<?php echo $id; ?>" data-title="<?php echo htmlspecialchars($title ,ENT_QUOTES); ?>" <?php if (!$this->user->is_admin()):echo 'disabled'; endif?>><span class="oi oi-trash"></span> Supprimer</button>
    </li>
  </ul>
</div>