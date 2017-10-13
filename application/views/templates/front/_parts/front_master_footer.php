    <script type="text/javascript" src='<?php echo js_url('vendor.min') ?>'></script>
    <script type="text/javascript" src='<?php echo js_url('front.min') ?>'></script>
    <?php
      if($this->uri->rsegment(2) == 'index'){
    ?>
    <script type="text/javascript" src='<?php echo js_url('homepage.min') ?>'></script>
    <?php 
      }
      if ($this->uri->rsegment(2) == 'project') {
    ?>
    <script type="text/javascript" src='<?php echo js_url('project.min') ?>'></script>
    <?php
      }
    ?>
</body>
</html>