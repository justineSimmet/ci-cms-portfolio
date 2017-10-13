<?php
  $this->load->view('templates/front/_parts/front_master_header');
?>

<div class="container-fluid">
  <?php
    $this->load->view('templates/front/_parts/front_master_navbar');
    echo $the_view_content;
  ?>
</div>

<?php
  $this->load->view('templates/front/_parts/front_master_footer');
?>
