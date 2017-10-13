<div class="col-md-12 admin-form">
  <div class="card card-outline-secondary">
    <div class="card-header">
      <h2 class="mb-0">Nouveau projet</h2>
    </div>
    <div class="card-body">
    <?php
      echo form_open('administration/projects/new', ['class' => 'form', 'autocomplete'=>'off']);

        if (empty(form_error('title'))){
          $class_title = 'form-control';
        }
        else{
          $class_title = 'form-control is-invalid';
        };
        echo '<div class="form-group row">';
          echo form_label("Titre :", "title", ['class' => "col-md-2 col-form-label form-control-label"]);
          ?><div class="col-md-10"><?php
          echo form_input(['name' => "title", 'id' => "title", 'class' => $class_title], set_value('title', '', FALSE), 'required');
          echo form_error('title', '<div class="invalid-feedback">', '</div>');
          echo '</div>';
        echo '</div>';

        if (empty(form_error('category_id'))){
          $class_category_id = 'form-control';
        }
        else{
          $class_category_id = 'form-control is-invalid';
        };
        echo '<div class="form-group row">';
          echo form_label("Catégorie :", "category_id", ['class' => "col-md-2 col-form-label form-control-label"]);
          ?><div class="col-md-10"><?php
          echo form_dropdown('category_id', $opt_categories ,'',['id' => "category_id", 'class' => $class_category_id], set_value('category_id', '', FALSE), 'required');
          echo form_error('category_id', '<div class="invalid-feedback">', '</div>');
          echo '</div>';
        echo '</div>';

        if (empty(form_error('context'))){
          $class_context = 'form-control';
        }
        else{
          $class_context = 'form-control is-invalid';
        };
        echo '<div class="form-group row">';
          echo form_label("Contexte :", "context", ['class' => "col-md-2 col-form-label form-control-label"]);
          ?><div class="col-md-10"><?php
          echo form_input(['name' => "context", 'id' => "context", 'class' => $class_context], set_value('context', '', FALSE), 'required');
          echo form_error('context', '<div class="invalid-feedback">', '</div>');
          echo '</div>';
        echo '</div>';

        if (empty(form_error('description'))){
          $class_description = 'form-control';
        }
        else{
          $class_description = 'form-control is-invalid';
        };
        echo '<div class="form-group row">';
          echo form_label("Description :", "description", ['class' => "col-md-2 col-form-label form-control-label"]);
          ?><div class="col-md-10"><?php
          echo form_textarea(['name' => "description", 'id' => "description", 'class' => $class_description, 'rows'=>'6'], set_value('description', '', FALSE), 'required');
          echo form_error('description', '<div class="invalid-feedback">', '</div>');
          echo '</div>';
        echo '</div>';

        if (empty(form_error('external_link'))){
          $class_external_link = 'form-control';
        }
        else{
          $class_external_link = 'form-control is-invalid';
        };
        echo '<div class="form-group row">';
          echo form_label("Lien externe:", "external_link", ['class' => "col-md-2 col-form-label form-control-label"]);
          ?><div class="col-md-10"><?php
          echo form_input(['name' => "external_link", 'id' => "external_link", 'class' => $class_external_link, 'type'=>'url'], set_value('external_link', '', FALSE));
          echo form_error('external_link', '<div class="invalid-feedback">', '</div>');
          echo '</div>';
        echo '</div>';

        echo '<div class="form-group row">';
        ?>
          <div class="col-md-9 ml-auto text-right">
            <?php echo anchor('administration/projects/index', 'Retour à la liste', ['class'=>'btn btn-secondary', 'role'=>'button']); ?>
            <?php echo anchor('administration/projects/new', 'Annuler', ['class'=>'btn btn-secondary', 'role'=>'button']); ?>
            <?php echo form_submit('send', "Enregistrer", ['class' => "btn btn-primary"]); ?>
          </div>
        <?php
        echo '</div>';
      echo form_close();
    ?>


    </div>
  </div>
</div>