<div class="col-md-7">
  <div class="row">
    <!-- Welcome card -->
    <div class="col-12">
      <div class="card border-color-secondary" id="dash-card">
        <div class="card-header bg-site-secondary text-white">
          <h2 class="mb-0"><?php echo $h2_title ?></h2>
        </div>
        <div class="card-body">
          <ul class="nav nav-tabs" id="dashTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" data-toggle="tab" href="#dash-today" role="tab" aria-controls="dash-today">Quelqu'un a dit</a>
            </li>
          </ul>
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="dash-today" role="tabpanel" aria-labelledby="dash-today">
              <blockquote class="blockquote text-right">
                <p class="mb-0"></p>
                <footer class="blockquote-footer"></footer>
              </blockquote>
            </div>

          </div>
        </div>
      </div>
    </div>

    <!-- Items overview -->
    <div class="col-12 mt-4 mb-2 d-flex justify-content-between flex-wrap" id="items-overview">
      <!-- Users -->
      <div id="it-users" class="item rounded-circle">
        <div class="item-content">
          <a href="<?php echo base_url(); ?>administration/users/<?php if(!$is_admin):echo '/profil'; endif?>">
            <h4><span><?php echo $nbrUsers; ?></span><br>Utilisateurs</h4>
          </a>
        </div>
      </div>
      <!-- Categories -->
      <div id="it-categories" class="item rounded-circle">
        <div class="item-content">
          <a href="<?php echo base_url(); ?>administration/categories">
            <h4><span><?php echo $nbrCategories; ?></span><br>Catégories</h4>
          </a>
        </div>
      </div>
      <!-- Projects -->
      <div id="it-projects" class="item rounded-circle">
        <div class="item-content">
          <a href="<?php echo base_url(); ?>administration/projects">
            <h4><span><?php echo $nbrProjects; ?></span><br>Projets</h4>
          </a>
        </div>
      </div>
      <!-- Pictures -->
      <div id="it-pictures" class="item rounded-circle">
        <div class="item-content">
          <a href="<?php echo base_url(); ?>administration/projects">
            <h4><span><?php echo $nbrPictures; ?></span><br>Visuels</h4>
          </a>
        </div>
      </div>
    </div>
    <!-- Some porn graphic -->
    <div class="col-12 mt-4 mb-4">
      <div class="card border-color-secondary" id="card-graph">
        <div class="card-header bg-site-secondary text-white">
          <h2>Les visites du site</h2>
        </div>
        <div class="card-body">
          <canvas id="visitChart" class="mb-2"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="col-md-5">
  <div class="card border-color-secondary" id="log-card">
    <div class="card-header bg-site-secondary text-white">
      <h2>Les derniers visiteurs du site</h2>
    </div>
    <div class="card-body">
      <table class="table table-bordered table-hover table-responsive" id="visit-table">
        <thead>
          <tr>
            <th class="text-center">#</th>
            <th>date</th>
            <th>origine</th>
            <th>identité</th>
          </tr>
          </thead>
          <tbody>
            <?php 
            $i=1;
            if (count($visitors) > 1) {
              foreach ($visitors as $visitor) {
              ?>
                <tr>
                  <td class="text-center">
                    <?php echo $i; ?>
                  </td>
                  <td>
                    <?php echo $visitor['date']; ?>
                  </td>
                  <td>
                    <?php echo $visitor['agent']; ?>
                  </td>
                  <td>
                    <?php echo $visitor['identity']; ?>
                  </td>
                </tr>
              <?php
              $i++;
              }
            }
            else{
             ?>
              <tr>
                <td class="text-center">
                  <?php echo $i; ?>
                </td>
                <td>
                  <?php echo $visitor['date']; ?>
                </td>
                <td>
                  <?php echo $visitor['agent']; ?>
                </td>
                <td>
                  <?php echo $visitor['identity']; ?>
                </td>
              </tr>
             <?php
            }
            ?>
          </tbody>

      </table>
    </div>
  </div>
</div>
  <script>var visitsReport = <?php echo json_encode($visitsReport); ?></script>
  <script>var anonymousReport = <?php echo json_encode($anonymousReport); ?></script>
</div>
