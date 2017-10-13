<div class="col-md-6 ml-auto admin-form" id="picture-form">
  <div class="card card-outline-secondary">
    <div class="card-header">
      <h2 class="mb-0">Modifier <?php echo $title; ?></h2>
    </div>
    <div class="card-body">

    <?php
      echo form_open_multipart('administration/pictures/view/'.$project_id.'/edit/'.$id, ['class' => 'form', 'autocomplete'=>'off']);

        if (empty(form_error('title'))){
          $class_title = 'form-control';
        }
        else{
          $class_title = 'form-control is-invalid';
        };

        echo '<div class="form-group row">';
          echo form_label("Titre :", "title", ['class' => "col-md-3 col-form-label form-control-label"]);
          ?><div class="col-md-9"><?php
          echo form_input(['name' => "title", 'id' => "title", 'class' => $class_title], set_value('title', $title, FALSE), 'required');
          echo form_error('title', '<div class="invalid-feedback">', '</div>');
          echo '</div>';
        echo '</div>';

        if (empty(form_error('alt'))){
          $class_alt = 'form-control';
        }
        else{
          $class_alt = 'form-control is-invalid';
        };

        echo '<div class="form-group row">';
          echo form_label("Description :", "alt", ['class' => "col-md-3 col-form-label form-control-label"]);
          ?><div class="col-md-9"><?php
          echo form_input(['name' => "alt", 'id' => "alt", 'class' => $class_alt], set_value('alt', $alt, FALSE), 'required');
          echo form_error('alt', '<div class="invalid-feedback">', '</div>');
          echo '</div>';
        echo '</div>';

        if (empty(form_error('file'))){
          $class_file = '';
        }
        else{
          $class_file = 'is-invalid';
        };

        echo '<div class="form-group row">';
        ?>
          <div class="col-md-9 ml-auto">
            <input type="file" name="file" id="file" class="input-file">
            <label for="file" class="btn btn-tertiary js-labelFile col-form-label form-control-label <?php echo $class_file; ?>">
              <!-- <i class="oi oi-check"></i> -->
              <span class="js-fileName"><span class="oi oi-data-transfer-upload"></span> Choisissez un fichier</span>
            </label>
          </div>

          <div class="col-md-9 ml-auto">
            <?php echo form_error('file', '<div class="invalid-feedback d-inline">', '</div>'); ?>
          </div>

        <?php
        echo '</div>';

        echo '<div class="form-group row">';
        ?>
        <div class="col-md-9 ml-auto" id='new-img'>
            <div class="container d-flex justify-content-between">
              <div id="img-preview" class="img-thumbnail col-md-6">
                  
              </div>
              <div id="img-desc" class="col-md-6">
                  
              </div>
            </div>
        </div>
        <?php
        echo '</div>';

        echo form_hidden('project', $project_id);
        echo form_hidden('id', $id);

        echo '<div class="form-group row">';
        ?>
          <div class="col-12 ml-auto text-right">
            <?php echo anchor('administration/pictures/index', 'Retour aux galeries', ['class'=>'btn btn-secondary', 'role'=>'button']); ?>
            <?php echo anchor('administration/pictures/view/'.$project_id.'/new/', 'Nouveau visuel', ['class'=>'btn btn-secondary', 'role'=>'
            button']); ?>
            <?php echo anchor('administration/pictures/view/'.$project_id.'/edit/'.$id, 'Annuler modification', ['class'=>'btn btn-secondary', 'role'=>'
            button']); ?>
            <?php echo form_submit('send', "Modifier", ['class' => "btn btn-primary"]); ?>
          </div>
        <?php
        echo '</div>';
      echo form_close();
    ?>


    </div>
  </div>
</div>