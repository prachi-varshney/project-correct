<div id="bdSidebar" 
             class="d-flex flex-column   
                    p-3
                    text-white offcanvas-lg offcanvas-start">
            <div class="d-flex flex-row justify-content-between align-items-center">
                <a href="https://sansoftwares.com/" 
                   class="navbar-brand" target="_blank" ><img src="<?php echo base_url('images/sansoftlogo.png') ?>" alt="" width="200px" id="sidebarLogo">
                </a>        
                <div class="navbar">
                    <a class="navbar-dark navbar-toggler d-lg-none ms-1" data-bs-toggle="collapse" data-bs-target="#bdSidebar" role="button">
                    <span id="toggleBtn" class="navbar-toggler-icon"></span>
                </a></div>
            </div>
        <hr>
            <ul class="mynav nav nav-pills flex-column mb-auto">
                <li class="nav-item mb-1">
                    <a href="<?php echo site_url('Dashboard'); ?>">
                        <!-- <i class="fa-regular fa-bookmark"></i> -->
                         <div class="d-flex sidediv">
                             <div><i class="fas fa-home"></i></div>
                             <div>Dashboard</div>
                         </div>
                    </a>
                </li>
                
                <li class="nav-item mb-1">
                    <a href="<?php echo site_url('UserMaster'); ?>">
                        <div class="d-flex sidediv">
                            <div><i class="fa-solid fa-user-pen"></i></div>
                            <!-- <i class="fa-solid fa-user-plus"></i> -->
                            <div>User Master</div>
                        </div>
                        
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="<?php echo site_url('ClientMaster'); ?>">
                        <div class="d-flex sidediv">
                            <div><i class="fa-solid fa-user-tie"></i></div>
                        <!-- <i class="fa-solid fa-archway"></i> -->
                            <div>Client Master</div>
                        </div>
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="<?php echo site_url('ItemMaster'); ?>">
                        <div class="d-flex sidediv">
                            <div><i class="fa-solid fa-list-alt" aria-hidden="true"></i></div>
                            <div>Item Master</div>
                        </div>
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="<?php echo site_url('InvoiceMaster') ?>">
                        <div class="d-flex sidediv">
                            <div><i class="fa-solid fa-file-invoice"></i></div>
                            <div>Invoice</div>
                        </div>
                    </a>
                </li>

                <li class="sidebar-item  nav-item mb-1">
                    <a href="" 
                       class="sidebar-link collapsed" 
                       data-bs-toggle="collapse"
                       data-bs-target="#settings"
                       aria-expanded="false"
                       aria-controls="settings">
                       <div class="d-flex sidediv">
                           <div><i class="fas fa-cog pe-2"></i></div>
                           <div><span class="topic">Settings </span></div>
                       </div>
                    </a>
                    <ul id="settings" 
                        class="sidebar-dropdown list-unstyled collapse" 
                        data-bs-parent="#sidebar">
                        <!-- <li class="sidebar-item">
                            <a href="logout.php" class="sidebar-link">
                                <i class="fas fa-sign-in-alt pe-2"></i>
                                <span class="topic"> Login</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="createAccount.php" class="sidebar-link">
                                <i class="fas fa-user-plus pe-2"></i>
                                <span class="topic">Register</span>
                            </a>
                        </li> -->
                        <li class="sidebar-item">
                            <a href="<?php echo base_url('Logout')?>" class="sidebar-link">
                                <i class="fas fa-sign-out-alt pe-2"></i>
                                <span class="topic">Log Out</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            <hr>
            <div class="d-flex">
                <!-- <i class="fa-solid fa-book  me-2"></i> -->
                <span>
                    <h6 class="mt-1 mb-0">
                    © 2024 SAN Softwares Pvt Ltd
                    </h6>
                </span>
            </div>
        </div>