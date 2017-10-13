<!-- First row - outside the flux on large screen -->
        <div class="row">
            <header class="col-12 col-md-3" id="main-header">
                    <!-- Logotype area -->
                <div id="header-top">
                    <a href="<?php echo base_url(); ?>"><img src="<?php echo img_url('logotype.svg') ?>" class="img-fluid svg-item" alt="Logotype "></a>
                    <div id='hamburger' class="d-md-none"><span class="oi oi-menu"></span></div>
                    <!-- Main Navigation -->
                </div>
                <nav id="main-nav">
                    <ul>
                        <li data-menuanchor="section1">
                            <a href="<?php echo site_url() ?>#section1">Section 1</a>
                        </li>
                        <li data-menuanchor="projets">
                            <a href="<?php echo site_url() ?>#projets">Projets</a>
                        </li>
                        <li data-menuanchor="section2">
                            <a href="<?php echo site_url() ?>#section2">Section 2</a>
                        </li>
                        <li data-menuanchor="contact">
                            <a href="<?php echo site_url() ?>#contact">Contact</a>
                        </li>
                    </ul>
                    <p class="copyright"> &copy; <?php echo SITE_AUTHOR.' '.date('Y');  ?></p>
                </nav>
            </header>
        </div>