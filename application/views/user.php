<div class="container-sm mb-3">
    <div class="tabs">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-table-tab" data-bs-toggle="tab" data-bs-target="#nav-table" type="button" role="tab" aria-controls="nav-table">All Users</button>
                <button class="nav-link" id="nav-form-tab" data-bs-toggle="tab" data-bs-target="#nav-form" type="button" role="tab" aria-controls="nav-form">Add User</button>
            </div>
        </nav>
    </div>

    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active mt-3" id="nav-table" role="tabpanel" aria-labelledby="nav-table-tab">
            <div class="container-fluid mb-3 p-3" id="searchDiv">
                <form action="" method="post" id="fuser-data" autocomplete="off">
                    <div class="row">
                        <div class="col-md-3 col-sm-6 mb-1 mt-1">
                            <label for="fuserName" class="form-label">User Name</label>
                            <input type="text" class="form-control form-control-sm" id="fuserName" name="fuserName">
                        </div>
                        <div class="col-md-3 col-sm-6 mb-1 mt-1">
                            <label for="fuserEmail" class="form-label">Email</label>
                            <input type="text" class="form-control form-control-sm" id="fuserEmail" name="fuserEmail">
                        </div>
                        <div class="col-md-3 col-sm-6 mb-1 mt-1">
                            <label for="fuserPhone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control form-control-sm" id="fuserPhone" name="fuserPhone">
                        </div>
                        <div class="col-md-3 col-sm-6 d-flex align-items-end mb-2 mt-1">
                            <button type="submit" id="findBtn" class="btn btn-sm btn-primary me-2">Search</button>
                            <button type="button" id="resetBtn" class="btn btn-sm btn-danger">Reset</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="p-3" id="tab-0">
                <div class="d-flex flex-column flex-md-row justify-content-between" id="tableTop">
                    <div class="records d-flex align-items-center mb-2 mb-md-0" >
                        <label for="tableLimit" class="form-check-label form-label mb-0 overflow-visible">No. of Records:</label>
                        <select class="form-select ms-2" name="tableLimit" id="tableLimit">
                            <option value="2">2</option>
                            <option value="4">4</option>
                            <option value="6">6</option>
                            <option value="8">8</option>
                        </select>
                    </div>

                    <div class="navbar" id="pagin">
                        <nav aria-label="Page navigation example" class="d-flex">
                            <ul class="pagination" id="pageInfo">
                                <li class="page-item"><a class="page-link" href="javascript:void(0);">1</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- <div class="row d-md-flex justify-content-between align-items-center mb-3">
                    <div class="records d-flex align-items-center col-12 col-md-6 mb-2 mb-md-0">
                        <label for="tableLimit" class="form-label mb-0">No. of Records:</label>
                        <select class="form-select ms-2 w-25" name="tableLimit" id="tableLimit">
                            <option value="2">2</option>
                            <option value="4">4</option>
                            <option value="6">6</option>
                            <option value="8">8</option>
                        </select>
                    </div>
                    <div class="pagination-container col-12 col-md-6 d-md-flex justify-content-md-end">
                        <nav aria-label="Page navigation example" class="d-flex justify-content-center justify-content-md-end">
                            <ul class="pagination" id="pageInfo">
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                            </ul>
                        </nav>
                    </div>
                </div> -->
                <div class="table-responsive">
                    <table class="table table-striped table-sm" id="data-table">
                        <thead>
                            <tr>
                                <th class="col-lg-1 col-md-1">S.No.</th>
                                <th class="col-lg-1 col-md-1" data-column="id"><span>ID</span><img src="<?php echo base_url('icons/sort.svg') ?>" alt=""></th>
                                <th class="col-lg-3 col-md-3" data-column="name"><span>Name</span><img src="<?php echo base_url('icons/sort.svg') ?>" alt=""></th>
                                <th class="col-lg-4 col-md-4" data-column="email"><span>Email</span><img src="<?php echo base_url('icons/sort.svg') ?>" alt=""></th>
                                <th class="col-lg-4 col-md-4" data-column="phone"><span>Phone Number</span><img src="<?php echo base_url('icons/sort.svg') ?>" alt=""></th>
                                <th class="col-lg-3 col-md-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data rows will go here -->
                        </tbody>
                    </table>
                </div>

                <div id="notFound">
                    <h2 style="text-align: center; color: red;">NOT FOUND!</h2>
                </div>
                <div class="d-flex justify-content-end fst-italic" id="recordsCount">
                    <span id="hideRecords">Showing Records <span id="limitRecords" class="ms-2 me-2">2</span> Of <span id="RecordsTotal" class="ms-2 me-4">5</span></span>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="nav-form" role="tabpanel" aria-labelledby="nav-form-tab">
            <div class="container pt-3 pb-3" id="tab-1">
                <form method="POST" id="user-data" autocomplete="off">
                    <input type="hidden" id="userId" name="userId">
                    <div class="row mb-3">
                        <div class="col-md-3 col-sm-6 mt-3">
                            <label class="form-label" for="userName">Name <span class="required">*</span></label>
                            <input class="form-control form-control-sm" type="text" id="userName" name="userName" >
                            <span class="error" id="userNameErr">Can only contain letters</span>
                        </div>
                        <div class="col-md-3 col-sm-6 mt-3">
                            <label for="userEmail" class="form-label">Email <span class="required">*</span></label>
                            <input type="email" class="form-control form-control-sm" id="userEmail" name="userEmail" autocomplete="username">
                            <span class="error" id="userEmailErr">Email is invalid</span>
                        </div>
                        <div class="col-md-3 col-sm-6 mt-3">
                            <label for="userPhone" class="form-label">Phone Number <span class="required">*</span></label>
                            <input type="tel" name="userPhone" id="userPhone" class="form-control form-control-sm">
                            <span class="error" id="userPhoneErr">Invalid phone number</span>
                        </div>
                        <div class="col-md-3 col-sm-6 mt-3">
                            <label for="userPswd" class="form-label">Password <span class="required" id="pswdRqr">*</span></label>
                            <div class="pswdEye" style="position: relative;">
                                <input type="password" class="form-control form-control-sm" id="userPswd" name="userPswd" autocomplete="current-password">
                                <div class="eye-toggle">
                                    <img src="<?php echo base_url('icons/eye-alt.svg') ?>" id="togglePassword" width="11" height="11" style="cursor: pointer;">
                                </div>
                            </div>
                            <span class="error" id="userPassErr">Invalid Password</span>
                        </div>
                    </div>

                    <button type="submit" id="userSubmit" class="btn btn-sm btn-primary btn-block" name="userSubmit">Submit</button>
                    <button type="button" id="resetForm" class="btn btn-sm btn-danger ms-1">Reset</button>
                </form>
            </div>
        </div>
    </div>
</div>
