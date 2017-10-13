<div class="col-md-12 admin-form" id="profil-form">

  <div class="card card-outline-secondary">
    <div class="card-header">
      <h2>Informations personnelles</h2>
    </div>
    <div class="card-body">

    <?php
      echo form_open('administration/users/profil', ['class' => 'form', 'autocomplete'=>'off']);

        if (empty(form_error('username'))){
          $class_username = 'form-control';
        }
        else{
          $class_username = 'form-control is-invalid';
        };

        echo '<div class="form-group row">';
          echo form_label("Nom d'utilisateur :", "username", ['class' => "col-md-2 col-form-label form-control-label"]);
          ?><div class="col-md-10"><?php
          echo form_input(['name' => "username", 'id' => "username", 'class' => $class_username], set_value('username', $username, FALSE), 'required');
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
        
        if (empty(form_error('password'))){
          $class_password = 'form-control';
        }
        else{
          $class_password = 'form-control is-invalid';
        };
        echo '<div class="form-group row">';
          echo form_label("Mot de passe :", "password", ['class' => "col-md-2 col-form-label form-control-label"]);
          ?><div class="col-md-10"><?php
          echo form_password(['name' => "password", 'id' => "password", 'class' => $class_password, 'data-toggle'=>"tooltip", 'data-placement'=>"top", 'title'=>"Saisissez votre mot de passe pour valider vos changements"], 'required');
          echo form_error('password', '<div class="invalid-feedback">', '</div>');
          echo '</div>';
        echo '</div>';
        ?>

        <div class="card">
          <div class="card-header">
          Modifier votre mot de passe
          </div>
          <div class="card-body">
            <?php
            if (empty(form_error('password'))){
              $class_new_password = 'form-control';
            }
            else{
              $class_new_password = 'form-control is-invalid';
            };
            echo '<div class="form-group row">';
              echo form_label("Nouveau mot de passe :", "new_password", ['class' => "col-md-4 col-form-label form-control-label"]);
              ?><div class="col-md-6"><?php
              echo form_password(['name' => "new_password", 'id' => "new_password", 'class' => $class_new_password, 'data-toggle'=>"tooltip", 'data-placement'=>"top", 'title'=>"Le nouveau mot de passe doit faire au moins 12 signes"]);
              echo form_error('new_password', '<div class="invalid-feedback">', '</div>');
              echo '</div>';
            echo '</div>';

            if (empty(form_error('valid_password'))){
              $class_valid_password = 'form-control';
            }
            else{
              $class_valid_password = 'form-control is-invalid';
            };
            echo '<div class="form-group row">';
              echo form_label("Confirmez le mot de passe :", "valid_password", ['class' => "col-md-4 col-form-label form-control-label"]);
              ?><div class="col-md-6"><?php
              echo form_password(['name' => "valid_password", 'id' => "valid_password", 'class' => $class_valid_password, 'data-toggle'=>"tooltip", 'data-placement'=>"top", 'title'=>"Confirmez votre nouveau mot de passe"]);
              echo form_error('valid_password', '<div class="invalid-feedback">', '</div>');
              echo '</div>';
            echo '</div>';
            ?>
          </div>
        </div>
        <?php

        echo form_hidden('id', $id);
        echo '<div class="form-group row">';
        ?>
          <div class="col-md-9 ml-auto text-right">
            <input type="reset" class="btn btn-secondary" value="Annuler changements" onclick="window.location.reload()">
            <?php echo form_submit('send', "Modifier", ['class' => "btn btn-primary"]); ?>
          </div>
        <?php
        echo '</div>';
      echo form_close();
    ?>


    </div>
    <div class="card-footer text-muted">
      <p class="font-italic">Un changement de votre nom d'utilisateur et/ou de votre adresse e-mail entraînera une déconnexion. Vous devrez vous reconnecter avec vos nouvelles informations.</p>
    </div>
  </div>


</div>