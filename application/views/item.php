<div class="container mb-3">
    <div class="tabs">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-table-tab" data-bs-toggle="tab" data-bs-target="#nav-table"
                    type="button" role="tab" aria-controls="nav-table">All Items</button>
                <button class="nav-link" id="nav-form-tab" data-bs-toggle="tab" data-bs-target="#nav-form" type="button"
                    role="tab" aria-controls="nav-form">Add Item</button>
            </div>
        </nav>
    </div>

    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active mt-3" id="nav-table" role="tabpanel">
            <div class="container mb-3 p-3" id="searchDiv">
                <form action="" method="post" id="fitem-data" autocomplete="off">
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <label for="fitemName" class="form-check-label form-label">Item Name</label>
                            <input type="text" class="form-control form-control-sm" id="fitemName" name="fitemName">
                        </div>
                        <div class="col-md-3 mb-2">
                            <label for="fitemDesc" class="form-check-label form-label">Item Description</label>
                            <input type="text" class="form-control form-control-sm" id="fitemDesc" name="fitemDesc">
                        </div>
                        <div class="col-md-3 mb-2">
                            <label for="fitemPrice" class="form-check-label form-label">Item Price</label>
                            <input type="text" class="form-control form-control-sm text-end" id="fitemPrice" name="fitemPrice">
                        </div>
                        <div class="col-md-3 d-flex align-items-end mb-2">
                            <button type="submit" id="findBtn" class="btn btn-sm btn-primary me-2">Search</button>
                            <button type="button" id="resetBtn" class="btn btn-sm btn-danger">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="tablePart p-3" id="tab-0">
                <div class="d-flex flex-column flex-md-row justify-content-between">
                    <div class="records d-flex align-items-center mb-2 mb-md-0">
                        <label for="tableLimit" class="form-check-label form-label mb-0 overflow-visible">No. of Records:</label>
                        <select class="form-select ms-2" name="tableLimit" id="tableLimit">
                            <option value="2">2</option>
                            <option value="4">4</option>
                            <option value="6">6</option>
                            <option value="8">8</option>
                        </select>
                    </div>
                    <div class="navbar mb-2 mb-md-0">
                        <nav aria-label="Page navigation example" class="d-flex">
                            <ul class="pagination mb-0" id="pageInfo">
                                <li class="page-item"><a class="page-link" href="javascript:void(0);">1</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="table-responsive">

                <table class="table table-striped" id="data-table">
                <thead>
                    <tr>
                    <th class="col-lg-1 col-md-1 col-1">S.No.</th>
                    <th class="col-lg-1 col-md-1 col-1"  data-column="id"><span>ID</span><img src="<?php echo base_url('icons/sort.svg'); ?>" alt=""></th>
                    <th class="col-lg-2 col-md-2 col-2" data-column="name"><span>Name</span><img src="<?php echo base_url('icons/sort.svg'); ?>" alt="" ></th>
                    <th class="col-lg-3 col-md-3 col-3">Description</th>
                    <th class="col-lg-2 col-md-2 col-2" data-column="price"><span>Price</span><img src="<?php echo base_url('icons/sort.svg'); ?>" alt="" ></th>
                    <th class="col-lg-3 col-md-3 col-3"><span>Image</span></th>
                    <th class="col-lg-3 col-md-3 col-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
                </table>
                </div>
                <div id="notFound">
                    <h2 class="text-center text-danger">NOT FOUND!</h2>
                </div>
                <div class="d-flex justify-content-end fst-italic" id="recordsCount">
                    <span id="hideRecords">Showing Records <span id='limitRecords' class="ms-2 me-2">2</span> Of <span id="RecordsTotal" class="ms-2 me-4">5</span></span>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="nav-form" role="tabpanel">
            <div class="container pt-3 pb-3" id="tab-1">
                <form method="POST" id="item-data" enctype="multipart/form-data" autocomplete="off">
                    <input type="hidden" id="itemId" name="itemId">
                    <input type="hidden" name="current_image" id="current_image">
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <label class="form-check-label form-label" for="itemName">Item name <span class="required">*</span></label>
                            <input class="form-control form-control-sm" type="text" id="itemName" name="itemName">
                            <span class="error" id="itemNameErr">Can only contain letters</span>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label for="itemDesc" class="form-check-label form-label">Item description <span class="required">*</span></label>
                            <input type="text" class="form-control form-control-sm" id="itemDesc" name="itemDesc">
                        </div>
                        <div class="col-md-3 mb-2">
                            <label for="itemPrice" class="form-check-label form-label">Item price <span class="required">*</span></label>
                            <input type="text" name="itemPrice" id="itemPrice" class="form-control form-control-sm text-end">
                            <span class="error" id="priceErr">Invalid phone number</span>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label for="itemImage" class="form-check-label form-label">Item image</label>
                            <input type="file" class="form-control form-control-sm" id="itemImage" name="itemImage" accept="image/*">
                            <div class="pic mt-3" id="itemPic">
                                <img src="" alt="Preview Image" id="currentImage">
                                <p id="imgName" style="display: none; font-style: italic; padding-top: 15px;"></p>
                                <div id="imgDel" class="mb-4" style="display: none;" onclick="imageDelete()"><img src="<?php echo base_url('icons/trash.svg'); ?>" alt=""></div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" id="itemSubmit" class="btn btn-sm btn-primary btn-block">Submit</button>
                    <button type="button" id="resetForm" class="btn btn-sm btn-danger ms-1">Reset</button>
                </form>
            </div>
        </div>
    </div>
</div>
