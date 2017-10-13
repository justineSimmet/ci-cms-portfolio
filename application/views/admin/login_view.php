<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $pagetitle ; ?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo css_url('front.min') ?>">
  </head>

  <body id="login">

    <div class="container">
    
    <div id="main-alert">
    <?php
      if (isset($result_message) && $result_message !== NULL) {
        if ($result_message['state'] === 'success') {
          ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <?php echo $result_message['content'] ;?>
          </div>
          <?php
        }
        else{
          ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <?php echo $result_message['content'] ;?>
          </div>
          <?php
        }
      }
    ?>
    </div>

    <?php  
      if (!empty(validation_errors())) {
      ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <?php echo validation_errors('<span>', '</span>'); ?>
        </div>
      <?php
      }
      echo '<h2 class="text-center">Administration :<br>'.base_url().'</h2>';
      echo form_open('administration/dashboard/login', ['class' => 'form-signin']);
        echo form_label("Nom d'utilisateur", "inputUsername", ['class' => "sr-only"]);
        echo form_input(['name'=>'username', 'id'=>'inputUsername', 'class' => 'form-control '], set_value('username'), 'placeholder="Nom d\'utilisateur" required autofocus');

        echo form_label("Adresse e-mail", "inputEmail", ['class' => "sr-only"]);
        echo form_input(['name'=>'email', 'id'=>'inputEmail', 'type'=>'email', 'class' => 'form-control'], set_value('email'), 'placeholder="Adresse e-mail" required autofocus');

        echo form_label("Mot de passe", "inputPassword", ['class' => "sr-only"]);
        echo form_password(['name'=>'password', 'id'=>'inputPassword', 'class' => 'form-control'], set_value('password'), 'placeholder="Mot de passe" required autofocus');

        echo form_submit("send", "Se connecter", ['class' => "btn btn-lg btn-primary btn-block"]);

      echo form_close();
    ?>

      <div class="text-center back-button">
        <a class="btn btn-info" href="<?php echo base_url() ?>" role="button">Retourner à l'accueil</a>
      </div>

    </div> <!-- /container -->


    <script type="text/javascript" src='<?php echo js_url('vendor.min') ?>'></script>
    <script type="text/javascript" src='<?php echo js_url('front.min') ?>'></script>
  </body>
</html>
