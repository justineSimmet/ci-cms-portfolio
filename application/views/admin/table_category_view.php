<div class="col-md-5 admin-table" id="list-category-table">
  <table class="table table-bordered table-hover table-responsive">

    <thead>
      <tr>
        <th class="text-center">#id</th>
        <th>Titre</th>
        <th class="text-center">Visibilité</th>
        <th class="text-center">Actions :</th>
      </tr>
      </thead>

      <?php 
        if ($list_categories !== NULL && $list_categories !== FALSE) {
          ?>
          <tbody>
            <?php
            if(count($list_categories) == 1){
            ?>
            <tr class="align-middle" data-category="<?php echo $list_categories->id; ?>">
              <td class="text-center">
                <?php echo $list_categories->id; ?>
              </td>
              <td>
                <?php echo $list_categories->title; ?>
              </td>
              <td class="text-center">
                <?php 
                  if ($list_categories->id == 1) {
                  ?>
                    <button type="button" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Vous ne pouvez pas publier la catégorie par défaut"><span class="oi oi-eye"></span></button>
                  <?php
                  } 
                  elseif ($list_categories->visibility == 0 && $list_categories->id !=1) {
                  ?>
                    <button type="button" class="btn btn-warning showCategory" data-toggle="tooltip" data-placement="top" title="Cliquez pour publier" data-id="<?php echo $list_categories->id; ?>"  data-title="<?php echo htmlspecialchars($list_categories->title ,ENT_QUOTES); ?>" <?php if (!$this->user->is_admin()):echo 'disabled'; endif?>><span class="oi oi-eye"></span></button>
                  <?php
                  }
                  else{
                  ?>
                    <button type="button" class="btn btn-success hideCategory" data-toggle="tooltip" data-placement="top" title="Cliquez pour masquer" data-id="<?php echo $list_categories->id; ?>"  data-title="<?php echo htmlspecialchars($list_categories->title ,ENT_QUOTES); ?>" <?php if (!$this->user->is_admin()):echo 'disabled'; endif?>><span class="oi oi-eye"></span></button>
                  <?php  
                  }
                ?>
              </td>
              <td>
                <?php  
                if ($list_categories->id !== 1) {
                ?>
                  <div class="btn-group" role="group">
                    <a type="button" href="<?php echo base_url(); ?>administration/categories/edit/<?php echo $list_categories->id; ?>" role="button"  class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Modifier"><span class="oi oi-pencil"></span></a>
                    <button type="button" class="btn btn-danger deleteCategory" data-toggle="tooltip" data-placement="top" title="Supprimer" data-id="<?php echo $list_categories->id; ?>"  data-title="<?php echo htmlspecialchars($list_categories->title ,ENT_QUOTES); ?>" <?php if (!$this->user->is_admin()):echo 'disabled'; endif?>><span class="oi oi-trash"></span></button>
                  </div>
                <?php
                }
                else{
                  ?>
                  <div class="btn-group" role="group">
                    <a type="button" href="<?php echo base_url(); ?>administration/categories/edit/<?php echo $list_categories->id; ?>" role="button"  class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Modifier"><span class="oi oi-pencil"></span></a>
                  </div>
                  <?php
                }
                ?>
              </td>
            </tr>
            <?php
            }
            else{
              foreach ($list_categories as $category) {
              ?>
              <tr class="align-middle" data-category="<?php echo $category->id; ?>">
                <td class="text-center">
                  <?php echo $category->id; ?>
                </td>
                <td>
                  <?php echo $category->title; ?>
                </td>
                <td class="text-center">
                  <?php 
                    if ($category->id == 1) {
                    ?>
                      <button type="button" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Vous ne pouvez pas publier la catégorie par défaut"><span class="oi oi-eye"></span></button>
                    <?php
                    } 
                    elseif ($category->visibility == 0 && $category->id !=1) {
                    ?>
                      <button type="button" class="btn btn-warning showCategory" data-toggle="tooltip" data-placement="top" title="Cliquez pour publier" data-id="<?php echo $category->id; ?>"  data-title="<?php echo htmlspecialchars($category->title ,ENT_QUOTES); ?>" <?php if (!$this->user->is_admin()):echo 'disabled'; endif?>><span class="oi oi-eye"></span></button>
                    <?php
                    }
                    else{
                    ?>
                      <button type="button" class="btn btn-success hideCategory" data-toggle="tooltip" data-placement="top" title="Cliquez pour masquer" data-id="<?php echo $category->id; ?>"  data-title="<?php echo htmlspecialchars($category->title ,ENT_QUOTES); ?>" <?php if (!$this->user->is_admin()):echo 'disabled'; endif?>><span class="oi oi-eye"></span></button>
                    <?php  
                    }
                  ?>
                </td>
                <td class="text-center">
                  <?php  
                  if ($category->id != 1) {
                  ?>
                    <div class="btn-group" role="group">
                      <a type="button" href="<?php echo base_url(); ?>administration/categories/edit/<?php echo $category->id; ?>" role="button"  class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Modifier"><span class="oi oi-pencil"></span></a>
                      <button type="button" class="btn btn-danger deleteCategory" data-toggle="tooltip" data-placement="top" title="Supprimer" data-id="<?php echo $category->id; ?>"  data-title="<?php echo htmlspecialchars($category->title ,ENT_QUOTES); ?>" <?php if (!$this->user->is_admin()):echo 'disabled'; endif?>><span class="oi oi-trash"></span></button>
                    </div>
                  <?php
                  }
                  ?>
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
</div>