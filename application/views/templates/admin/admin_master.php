<?php
  $this->load->view('templates/admin/_parts/admin_master_header');
?>

  <?php
    $this->load->view('templates/admin/_parts/admin_master_navbar');
  ?>

<div class="container-fluid">
  <div class="row">
    <?php
      $this->load->view('templates/admin/_parts/admin_master_sidebar');
    ?>
    <div class="col-sm-9 ml-sm-auto col-md-10 content-area">
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
      <h1><?php echo $h1_title; ?></h1>
      <div class="row">
      <?php 
        if (!is_array($the_view_content)){
          echo $the_view_content;
        }
        else{
          foreach ($the_view_content as $view) {
            echo $view;
          }
        }
      ?>
      </div>
    </div>
  </div>
</div>
<?php
  $this->load->view('templates/admin/_parts/admin_master_footer');
?>
