<div class="col-md-6 ml-auto admin-form">
  <div class="card card-outline-secondary">
    <div class="card-header">
      <h2 class="mb-0">Modifier catégorie "<?php echo $title; ?>"</h2>
    </div>
    <div class="card-body">

    <?php
      echo form_open('administration/categories/edit/'.$id, ['class' => 'form', 'autocomplete'=>'off']);

        if (empty(form_error('title'))){
          $class_title = 'form-control';
        }
        else{
          $class_title = 'form-control is-invalid';
        };

        echo '<div class="form-group row">';
          echo form_label("Titre :", "title", ['class' => "col-md-2 col-form-label form-control-label"]);
          ?><div class="col-md-10"><?php
          echo form_input(['name' => "title", 'id' => "title", 'class' => $class_title], set_value('title', $title), 'required');
          echo form_error('title', '<div class="invalid-feedback">', '</div>');
          echo '</div>';
        echo '</div>';

        echo form_hidden('id', $id);

        echo '<div class="form-group row">';
        ?>
          <div class="col-md-12 ml-auto text-right">
            <?php echo anchor('administration/categories/index', 'Créer une nouvelle catégorie', ['class'=>'btn btn-secondary', 'role'=>'button']); ?>
            <?php echo anchor('administration/categories/edit/'.$id, 'Annuler', ['class'=>'btn btn-secondary', 'role'=>'button']); ?>
            <?php echo form_submit('send', "Modifier", ['class' => "btn btn-primary"]); ?>
          </div>
        <?php
        echo '</div>';
      echo form_close();
    ?>


    </div>
  </div>
</div>