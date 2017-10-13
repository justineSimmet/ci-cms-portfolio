    <script src='<?php echo js_url('vendor.min') ?>'></script>
    <script src='<?php echo js_url('back.min') ?>'></script>
    <?php if ($this->uri->rsegment(1) == 'dashboard'): ?>
      <script src='<?php echo js_url('dashboard.min') ?>'></script>
    <?php endif ?>
    <?php if ($this->uri->rsegment(1) == 'parameters'): ?>
      <script src='<?php echo js_url('parameters.min') ?>'></script>
    <?php endif ?>
    <?php if ($this->uri->rsegment(1) == 'users'): ?>
      <script src='<?php echo js_url('users.min') ?>'></script>
    <?php endif ?>
    <?php if ($this->uri->rsegment(1) == 'categories'): ?>
      <script src='<?php echo js_url('categories.min') ?>'></script>
    <?php endif ?>
    <?php if ($this->uri->rsegment(1) == 'projects'): ?>
      <script src='<?php echo js_url('projects.min') ?>'></script>
    <?php endif ?>
    <?php if ($this->uri->rsegment(1) == 'pictures'): ?>
      <script src='<?php echo js_url('pictures.min') ?>'></script>
    <?php endif ?>
</body>
</html>
