<nav class="navbar navbar-expand-md navbar-light fixed-top" id="main-nav">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse navbar-light" id="navbarCollapse">
    <a class="navbar-brand" href="<?php echo base_url().'administration/dashboard' ?>">Administration</a>
        <ul class="navbar-nav d-md-none d-lg-none">
            <li class="nav-item <?php if ($this->uri->segment(2) == 'dashboard') { echo 'active'; } ?> mb-1">
              <?php echo anchor('administration/dashboard', '<span class="oi oi-dashboard"></span> Tableau de bord <span class="sr-only">(current)</span>','class="nav-link"' ); ?>
            </li>
            <?php
            if ($admin) {
            ?>
            <li class="nav-item <?php if ($this->uri->segment(2) == 'parameters') { echo 'active'; } ?> mb-1">
              <?php echo anchor('administration/parameters', '<span class="oi oi-wrench"></span> Paramètres du site','class="nav-link"' ); ?>
            </li>
            <li class="nav-item <?php if ($this->uri->segment(2) == 'users' && $this->uri->segment(3) !== 'profil') { echo 'active'; } ?> mb-1">
              <?php echo anchor('administration/users', '<span class="oi oi-people"></span> Gestion des utilisateurs','class="nav-link"' ); ?>
            </li>
            <?php
            };
            ?>
            <li  class="nav-item"> 
              <a class="nav-link">Gestion du portfolio</a>
              <ul class="nav flex-column">
                <li class=" <?php if ($this->uri->segment(2) == 'categories') { echo 'active'; } ?> pl-4 mb-2">
                  <?php echo anchor('administration/categories', '<span class="oi oi-box"></span> Les categories','class="nav-link"' ); ?>
                </li>

                <li class=" <?php if ($this->uri->segment(2) == 'projects') { echo 'active'; } ?> pl-4 mb-2">
                  <?php echo anchor('administration/projects', '<span class="oi oi-brush"></span> Les projets','class="nav-link"' ); ?>
                </li>

                <li class=" <?php if ($this->uri->segment(2) == 'pictures') { echo 'active'; } ?> pl-4 mb-2">
                  <?php echo anchor('administration/pictures', '<span class="oi oi-image"></span> Les galeries','class="nav-link"' ); ?>
                </li>
              </ul>
            </li>
          </ul>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item <?php if ($this->uri->segment(3) == 'profil') { echo 'active'; } ?>">
              <?php echo anchor('administration/users/profil', '<span class="oi oi-person"></span> Gérer votre profil','class="nav-link"' ); ?>
            </li>
            
            <li class="nav-item">
              <?php echo anchor('', '<span class="oi oi-eye"></span> Voir le site','class="nav-link"' ); ?>
            </li>
            <li class="nav-item">
              <?php echo anchor('administration/dashboard/logout', '<span class="oi oi-account-logout"></span> Se déconnecter','class="nav-link"' ); ?>
            </li>
        </ul>
    </div>
</nav>
