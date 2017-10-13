<div class="col-md-3 ml-auto admin-action-list" id="picture-action">
  <ul>
    <li>
      <!-- Nouveau visuel -->
      <?php echo anchor('administration/pictures/view/'.$project_id.'/new/', '<span class="oi oi-image"></span> Ajouter un visuel', ['class'=>'btn btn-primary btn-block mb-3', 'type'=>'button', 'role'=>'button', 'data-toggle'=>'tooltip','data-placement'=>'top', 'title'=>'Ajouter un visuel']);?>
    </li>
    <li>
      <!-- Projet -->
      <?php echo anchor('administration/projects/edit/'.$project_id, '<span class="oi oi-file"></span> Modifier le projet', ['class'=>'btn btn-info btn-block mb-3', 'type'=>'button', 'role'=>'button', 'data-toggle'=>'tooltip','data-placement'=>'top', 'title'=>'Modifier le projet']);?>
    </li>
    <li>
      <!-- Preview -->
      <?php echo anchor('administration/projects/preview/'.$project_id, '<span class="oi oi-laptop"></span> Prévisualiser le projet', ['class'=>'btn btn-secondary btn-block mb-3', 'type'=>'button', 'role'=>'button', 'data-toggle'=>'tooltip','data-placement'=>'top', 'title'=>'Prévisualiser la galerie', 'target'=>'_blank' ]);?>
    </li>
    <li>
      <!-- Vider -->
      <button type="button" role="button" class="btn btn-danger btn-block mb-3 emptyGallery" data-toggle="tooltip" data-placement="top" title="Vider la galerie" data-id="<?php echo $project_id; ?>" data-title="<?php echo htmlspecialchars($project_title ,ENT_QUOTES); ?>" <?php if (!$this->user->is_admin()):echo 'disabled'; endif?>><span class="oi oi-trash"></span> Vider la galerie</button>
    </li>
  </ul>
</div>