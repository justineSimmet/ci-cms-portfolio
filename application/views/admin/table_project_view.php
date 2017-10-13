<div class="col-md-12 admin-table" id="list-project-table">
  <div class="card">

    <div class="card-body d-flex justify-content-between align-items-center">
      <h2 class="m-0">
        Projets créés : <?php echo $this->project->count_total(); ?>
      </h2>
        <?php echo anchor('administration/projects/new', 'Créer un nouveau projet', ['class'=>'btn btn-primary', 'role'=>'button' ]); ?>
    </div>
  </div>
  <table class="table table-bordered table-hover table-responsive">
    <thead>
      <tr>
        <th class="text-center">
          #id
        </th>
        <th>
          Titre
        </th>
        <th class="text-center">
          Catégorie
        </th>
        <th class="text-center">
          Visibilité
        </th>
        <th class="text-center">
          Visuels :
        </th>
        <th>
          Actions :
        </th>
      </tr>
    </thead>

    <?php
      if ($list_projects !== NULL && $list_projects !== FALSE) {
      ?>
      <tbody>
        
      <?php  
        if (count($list_projects) == 1) {
        ?>
        <tr class="align-middle" data-project="<?php echo $list_projects->id ?>">
          <td class="text-center align-middle">
            <?php echo $list_projects->id ?>
          </td>
          <td class="align-middle">
            <a href="<?php echo base_url() ?>administration/projects/edit/<?php echo $list_projects->id; ?>"><?php echo $list_projects->title ?></a>
          </td>
          <td class="text-center align-middle">
            <?php $category = $this->category->get_item($list_projects->category_id); echo $category->title?>
          </td>
          <td class="text-center align-middle">
            <?php
            if ($list_projects->visibility == 0 ) {
            ?>
              <button type="button" class="btn btn-block btn-warning showProject" data-toggle="tooltip" data-placement="top" title="Cliquez pour publier"data-id="<?php echo $list_projects->id; ?>" data-title="<?php echo htmlspecialchars($list_projects->title ,ENT_QUOTES); ?>" data-category="<?php echo $list_projects->category_id; ?>" <?php if (!$this->user->is_admin()):echo 'disabled'; endif?>><span class="oi oi-eye"></span>  Publier le projet</button>
            <?php
            }
            else{
            ?>
              <button type="button" class="btn btn-block btn-success hideProject" data-toggle="tooltip" data-placement="top" title="Cliquez pour masquer" data-id="<?php echo $list_projects->id; ?>" data-title="<?php echo htmlspecialchars($list_projects->title ,ENT_QUOTES); ?>" data-category="<?php echo $list_projects->category_id; ?>" <?php if (!$this->user->is_admin()):echo 'disabled'; endif?>><span class="oi oi-eye"></span>  Masquer le projet</button>
            <?php  
            }
            ?>
          </td>
          <td class="text-center align-middle">
            <?php echo $list_projects->nbr_pictures; ?>
          </td>
          <td class="text-center align-middle">  
            <div class="btn-group" role="group">
            <!-- Galerie -->
              <?php echo anchor('administration/pictures/view/'.$list_projects->id, '<span class="oi oi-image"></span>', ['class'=>'btn btn-info', 'type'=>'button', 'role'=>'button', 'data-toggle'=>'tooltip','data-placement'=>'top', 'title'=>'Galerie' ]); ?>
            <!-- Visionner -->
              <?php echo anchor('administration/projects/preview/'.$list_projects->id, '<span class="oi oi-laptop"></span>', ['class'=>'btn btn-secondary', 'type'=>'button', 'role'=>'button', 'data-toggle'=>'tooltip','data-placement'=>'top', 'title'=>'Prévisualiser', 'target'=>'_blank' ]); ?>
            <!-- Modifier -->
              <?php echo anchor('administration/projects/edit/'.$list_projects->id, '<span class="oi oi-pencil"></span>', ['class'=>'btn btn-primary', 'type'=>'button', 'role'=>'button', 'data-toggle'=>'tooltip','data-placement'=>'top', 'title'=>'Modifier' ]); ?>
            <!-- Supprimer -->
              <button type="button" class="btn btn-danger deleteProject" data-toggle="tooltip" data-placement="top" title="Supprimer" data-id="<?php echo $list_projects->id; ?>" data-title="<?php echo htmlspecialchars($list_projects->title ,ENT_QUOTES); ?>" <?php if (!$this->user->is_admin()):echo 'disabled'; endif?>><span class="oi oi-trash"></span></button>
            </div>
          </td>
        </tr>
        <?php
        }
        else{
          foreach ($list_projects as $project) {
          ?>
          <tr data-project="<?php echo $project->id ?>">
            <td class="text-center align-middle">
              <?php echo $project->id; ?>
            </td>
            <td class="align-middle">
              <a href="<?php echo base_url() ?>administration/projects/edit/<?php echo $project->id; ?>"><?php echo $project->title; ?></a>
            </td>
            <td class="text-center align-middle">
              <?php $category = $this->category->get_item($project->category_id); echo $category->title;?>
            </td>
            <td class="text-center align-middle">
              <?php
              if ($project->visibility == 0 ) {
              ?>
                <button type="button" class="btn btn-block btn-warning showProject" data-toggle="tooltip" data-placement="top" title="Cliquez pour publier" data-id="<?php echo $project->id; ?>" data-title="<?php echo htmlspecialchars($project->title ,ENT_QUOTES); ?>" data-category="<?php echo $project->category_id; ?>" <?php if (!$this->user->is_admin()):echo 'disabled'; endif?>><span class="oi oi-eye"></span>  Publier le projet</button>
              <?php
              }
              else{
              ?>
                <button type="button" class="btn btn-block btn-success hideProject" data-toggle="tooltip" data-placement="top" title="Cliquez pour masquer" data-id="<?php echo $project->id; ?>" data-title="<?php echo htmlspecialchars($project->title ,ENT_QUOTES); ?>" data-category="<?php echo $project->category_id; ?>" <?php if (!$this->user->is_admin()):echo 'disabled'; endif?>><span class="oi oi-eye"></span>  Masquer le projet</button>
              <?php  
              }
              ?>
            </td>
            <td class="text-center align-middle">
              <?php echo $project->nbr_pictures; ?>
            </td>
            <td class="text-center align-middle">  
              <div class="btn-group" role="group">
              <!-- Galerie -->
                <?php echo anchor('administration/pictures/view/'.$project->id, '<span class="oi oi-image"></span>', ['class'=>'btn btn-info', 'type'=>'button', 'role'=>'button', 'data-toggle'=>'tooltip','data-placement'=>'top', 'title'=>'Galerie' ]); ?>
              <!-- Visionner -->
                <?php echo anchor('administration/projects/preview/'.$project->id, '<span class="oi oi-laptop"></span>', ['class'=>'btn btn-secondary', 'type'=>'button', 'role'=>'button', 'data-toggle'=>'tooltip','data-placement'=>'top', 'title'=>'Prévisualiser', 'target'=>'_blank' ]);?>
              <!-- Modifier -->
                <?php echo anchor('administration/projects/edit/'.$project->id, '<span class="oi oi-pencil"></span>', ['class'=>'btn btn-primary', 'type'=>'button', 'role'=>'button', 'data-toggle'=>'tooltip','data-placement'=>'top', 'title'=>'Modifier' ]); ?>
              <!-- Supprimer -->
                <button type="button" role="button" class="btn btn-danger deleteProject" data-toggle="tooltip" data-placement="top" title="Supprimer" data-id="<?php echo $project->id; ?>" data-title="<?php echo htmlspecialchars($project->title ,ENT_QUOTES); ?>" <?php if (!$this->user->is_admin()):echo 'disabled'; endif?>><span class="oi oi-trash"></span></button>
              </div>
            </td>
          </tr>
          <?php  
          }
        }
      ?>

      </tbody>
      <?php
      }
    ?>
  </table>
  <input type="hidden" name="csrf_token" value="<?php echo $this->security->get_csrf_hash(); ?>">
</div>