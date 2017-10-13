<nav class="navbar navbar-expand-md navbar-dark fixed-bottom" id="admin-navbar">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarCollapse">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <?php echo anchor('administration/dashboard', 'Retour à l\'administration', 'class="nav-link"'); ?>
      </li>
      <li class="nav-item">
        <?php echo anchor('administration/dashboard/logout', '<span class="oi oi-account-logout"></span> Déconnexion', 'class="nav-link"'); ?>
      </li>
    </ul>
  </div>
</nav>