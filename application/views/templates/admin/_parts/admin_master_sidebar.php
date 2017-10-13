<nav class="col-sm-3 col-md-2 d-none d-sm-block" id="sidebar">
  <ul class="nav flex-column mt-4">
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
</nav>