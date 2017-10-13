<div class="col-md-12 admin-form">
  <div class="card card-outline-secondary">
    <div class="card-header">
      <h2 class="mb-0">Modifier utilisateur <?php echo $username ?></h2>
    </div>
    <div class="card-body">

    <?php
      echo form_open('administration/users/edit/'.$id, ['class' => 'form', 'autocomplete'=>'off']);

        if (empty(form_error('username'))){
          $class_username = 'form-control';
        }
        else{
          $class_username = 'form-control is-invalid';
        };

        echo '<div class="form-group row">';
          echo form_label("Nom d'utilisateur :", "username", ['class' => "col-md-2 col-form-label form-control-label"]);
          ?><div class="col-md-10"><?php
          echo form_input(['name' => "username", 'id' => "username", 'class' => $class_username], set_value('username',$username, FALSE), 'required');
          echo form_error('username', '<div class="invalid-feedback">', '</div>');
          echo '</div>';
        echo '</div>';

        if (empty(form_error('first_name'))){
          $class_first_name = 'form-control';
        }
        else{
          $class_first_name = 'form-control is-invalid';
        };
        if (empty(form_error('last_name'))){
          $class_last_name = 'form-control';
        }
        else{
          $class_last_name = 'form-control is-invalid';
        };

        echo '<div class="form-group row">';
          echo form_label("Prénom (optionnel) :", "first_name", ['class' => "col-md-2 ml-auto col-form-label form-control-label font-italic"]);
          ?><div class="col-md-3"><?php
          echo form_input(['name' => "first_name", 'id' => "first_name", 'class' => $class_first_name], set_value('first_name', $first_name, FALSE));
          echo form_error('first_name', '<div class="invalid-feedback">', '</div>');
          echo '</div>';

          echo form_label("Nom (optionnel) :", "last_name", ['class' => "col-md-2 col-form-label form-control-label font-italic"]);
          ?><div class="col-md-3"><?php
          echo form_input(['name' => "last_name", 'id' => "last_name", 'class' => $class_last_name], set_value('last_name', $last_name, FALSE));
          echo form_error('first_name', '<div class="invalid-feedback">', '</div>');
          echo '</div>';
        echo '</div>';

        if (empty(form_error('email'))){
          $class_email = 'form-control';
        }
        else{
          $class_email = 'form-control is-invalid';
        };
        echo '<div class="form-group row">';
          echo form_label("Adresse e-mail :", "email", ['class' => "col-md-2 col-form-label form-control-label"]);
          ?><div class="col-md-10"><?php
          echo form_input(['name' => "email", 'id' => "email", 'class' => $class_email, 'type'=>'email'], set_value('email', $email), 'required');
          echo form_error('email', '<div class="invalid-feedback">', '</div>');
          echo '</div>';
        echo '</div>';

        
        echo '<div class="form-group row">';
          echo form_label("Est administrateur ?", "check", ['class' => "col-md-2 col-form-label form-control-label"]);
          ?><div class="col-md-10 <?= empty(form_error('is_admin')) ? "" : "is-invalid" ?> switch">
           <input type="checkbox" id="is_admin" class='switch' name="is_admin" value="1">
           <label for="is_admin"></label>
          <?php
          echo '</div>';
        echo '</div>';

        echo form_hidden('id', $id);

        echo '<div class="form-group row">';
        ?>
          <div class="col-md-12 ml-auto text-right">
            <?php echo anchor('administration/users', 'Créer un nouvel utilisateur', ['class'=>'btn btn-secondary', 'role'=>'button']); ?>
            <?php echo anchor('administration/users/edit/'.$id, 'Annuler', ['class'=>'btn btn-secondary', 'role'=>'button']); ?>
            <?php echo form_submit('send', "Modifier", ['class' => "btn btn-primary"]); ?>
          </div>
        <?php
        echo '</div>';
      echo form_close();
    ?>


    </div>
  </div>
</div>