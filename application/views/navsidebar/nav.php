<nav class="navbar bg-light navbar-light mb-2">
    <div class="container-fluid">
        <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#bdSidebar"> -->
        <!-- <span class="navbar-toggler-icon"></span> -->
        <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#bdSidebar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <span></span>
        <div class="dropdown dropdown-menu-end me-4 cursor-pointer" role="button"> 
            <span class="dropdown-toggle" data-bs-toggle="dropdown"> <img src="<?php echo base_url('icons/profile_icon.jpg') ?>" alt="Welcome" width="20px" style="color: #0377DE"> <?php echo htmlspecialchars($_SESSION['name']); ?></span>
            <ul class="dropdown-menu">
                <li><a href="<?php echo base_url('Dashboard')?>" class="dropdown-item">Home</a></li>
                <li><a href="<?php echo base_url('Logout')?>" class="dropdown-item">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>