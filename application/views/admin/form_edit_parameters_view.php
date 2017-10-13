<div class="col-md-12 admin-form">
  <div class="card card-outline-secondary">
    <div class="card-header">
      <h2 class="mb-0">Vos options</h2>
    </div>
    <div class="card-body">

    <?php
      echo form_open('administration/parameters', ['class' => 'form', 'autocomplete'=>'off']);

        if ( empty(form_error('site_name')) ){
          $class_site_name = 'form-control';
        }
        else{
          $class_site_name = 'form-control is-invalid';
        };

        echo '<div class="form-group row">';
          echo form_label("Titre du site :", "site_name", ['class' => "col-md-2 col-form-label form-control-label"]);
          ?><div class="col-md-10"><?php
          echo form_input(['name' => "site_name", 'id' => "site_name", 'class' => $class_site_name], set_value('site_name', $site_name, FALSE), 'required');
          echo form_error('site_name', '<div class="invalid-feedback">', '</div>');
          echo '</div>';
        echo '</div>';

        if ( empty(form_error('site_description')) ){
          $class_site_description = 'form-control';
        }
        else{
          $class_site_description = 'form-control is-invalid';
        };

        echo '<div class="form-group row">';
          echo form_label("Description du site :", "site_description", ['class' => "col-md-2 col-form-label form-control-label"]);
          ?><div class="col-md-10"><?php
          echo form_input(['name' => "site_description", 'id' => "site_description", 'class' => $class_site_description, FALSE], set_value('site_description', $site_description), 'required');
          echo form_error('site_description', '<div class="invalid-feedback">', '</div>');
          echo '</div>';
        echo '</div>';

        if ( empty(form_error('site_author')) ){
          $class_site_author = 'form-control';
        }
        else{
          $class_site_author = 'form-control is-invalid';
        };
        echo '<div class="form-group row">';
          echo form_label("Auteur du site :", "site_author", ['class' => "col-md-2 col-form-label form-control-label"]);
          ?><div class="col-md-10"><?php
          echo form_input(['name' => "site_author", 'id' => "site_author", 'class' => $class_site_author], set_value('site_author', $site_author, FALSE), 'required');
          echo form_error('site_author', '<div class="invalid-feedback">', '</div>');
          echo '</div>';
        echo '</div>';
        ?>

          <div class="col-md-9 ml-auto text-right">
            <?php echo anchor('administration/parameters', 'Annuler changements', ['class'=>'btn btn-secondary', 'role'=>'button']); ?>
            <?php echo form_submit('send', "Enregistrer", ['class' => "btn btn-primary"]); ?>
          </div>
        <?php
        echo '</div>';
      echo form_close();
    ?>


    </div>
  </div>
</div>