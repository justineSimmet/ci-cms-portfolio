<div class="col-md-12 admin-table" id="list-user-table">
  <table class="table table-bordered table-hover table-responsive">

    <thead>
      <tr>
        <th class="text-center">#id</th>
        <th>Username</th>
        <th>E-mail</th>
        <th>Identité</th>
        <th>Dernière visite</th>
        <th>Actions :</th>
      </tr>
      </thead>

      <?php 
        if ($list_users !== NULL && $list_users !== FALSE) {
          ?>
          <tbody>
            <?php
            // var_dump(count($list_users));
            if(count($list_users) == 1){
            ?>
            <tr class="align-middle">
              <td class="text-center <?php if($list_users->is_admin == 1){ echo 'is-admin"';} ?>">
                <?php echo $list_users->id; ?>
              </td>
              <td>
                <?php echo $list_users->username; ?>
              </td>
              <td>
                <?php echo $list_users->email; ?>
              </td>
              <td>
                <?php echo $list_users->first_name; ?> <?php echo $list_users->last_name; ?>
              </td>
              <td>
                <?php if($list_users->last_login !== NULL){echo 'Le '.date("d/m/Y à\ H:i:s", $list_users->last_login);}else{echo 'xxxx';} ?>
              </td>
              <td class="text-right"> 
                <div class="btn-group" role="group">
                  <a type="button" href="<?php echo base_url(); ?>administration/users/edit/<?php echo $list_users->id; ?>" role="button"  class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Modifier"><span class="oi oi-pencil"></span></a>
                </div>
              </td>
            </tr>
            <?php
            }
            else{
              foreach ($list_users as $user) {
              ?>
              <tr class="align-middle" data-user="<?php echo $user->id; ?>">
                <td class="text-center <?php if($user->is_admin == 1){ echo 'is-admin"';} ?>">
                    <?php echo $user->id; ?>
                </td>
                <td>
                  <?php echo $user->username; ?>
                </td>
                <td>
                  <?php echo $user->email; ?>
                </td>
                <td>
                  <?php echo $user->first_name; ?> <?php echo $user->last_name; ?>
                </td>

                <td>
                  <?php if($user->last_login !== NULL){echo 'Le '.date("d/m/Y à\ H:i:s", $user->last_login);}else{echo 'jamais connecté';} ?>
                </td>
                <td class="text-right"> 
                  <div class="btn-group" role="group">
                    <a type="button" href="<?php echo base_url(); ?>administration/users/edit/<?php echo $user->id; ?>" role="button"  class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Modifier"><span class="oi oi-pencil"></span></a>
                    <?php if($user->is_admin == FALSE){ ?>
                    <button type="button" class="btn btn-danger deleteUser" data-toggle="tooltip" data-placement="top" title="Supprimer" data-id ="<?php echo $user->id; ?>" data-username="<?php echo htmlspecialchars($user->username ,ENT_QUOTES); ?>"><span class="oi oi-trash"></span></button>
                    <?php } ?>
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
</div>