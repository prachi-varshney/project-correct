<div class="container mb-3">
    <div class="tabs">
      <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
          <button class="nav-link active" id="nav-table-tab" data-bs-toggle="tab" data-bs-target="#nav-table"
            type="button" role="tab" aria-controls="nav-table">All Clients</button>
          <button class="nav-link" id="nav-form-tab" data-bs-toggle="tab" data-bs-target="#nav-form" type="button"
            role="tab" aria-controls="nav-form" >Add Client</button>
        </div>
      </nav>
    </div>

    <div class="tab-content" id="nav-tabContent">
      <div class="tab-pane fade show active mt-3" id="nav-table" role="tabpanel" > 
          <div class="container mb-3 p-3" id="searchDiv">
                <!-- <h6 class="mb-3">Search for User:</h6>  -->
              <form action="" method="post" id="fclient-data" autocomplete="off">
                    <div class="row ">
                        <div class="col-md-3 mb-md-4">
                          <label for="fclientName" class="form-check-label form-label">Client Name</label>
                          <input type="text" class="form-control form-control-sm" id="fclientName" name="fclientName">
                        </div>
                        <div class="col-md-3">
                          <label for="fclientEmail" class="form-check-label form-label">Client Email</label>
                          <input type="text" class="form-control form-control-sm" id="fclientEmail" name="fclientEmail">   
                        </div>
                        <div class="col-md-3">
                          <label for="fclientPhone" class="form-check-label form-label">Phone Number</label>
                          <input type="tel" class="form-control form-control-sm" id="fclientPhone" name="fclientPhone">
                        </div>
                        <div class="col-md-3 d-flex align-items-end mb-md-4">
                          <button type="submit" id="findBtn" class="btn btn-sm btn-primary me-2"> Search </button>
                          <button type="button" id="resetBtn" class="btn btn-sm btn-danger"> Reset </button>
                        </div>
                    </div>
                </form>

            </div>
        <div class="p-3" id="tab-0">
            <div class="d-flex flex-column flex-md-row justify-content-between">
                <div class="records d-flex align-items-center mb-md-0">
                    <label for="tableLimit" class="form-check-label form-label mb-0 overflow-visible">No. of Records:</label>
                    <select class="form-select ms-2" name="tableLimit" id="tableLimit">
                        <option value="2">2</option>
                        <option value="4">4</option>
                        <option value="6">6</option>
                        <option value="8">8</option>
                    </select>
                </div>
                
                <div class="navbar overflow-auto">
                    <nav aria-label="Page navigation example" class="d-flex">
                        <ul class="pagination" id="pageInfo">
                            <li class="page-item"><a class="page-link" href="javascript:void(0);">1</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        <div class="table-responsive"> 
          <table class="table table-striped table-sm" id="data-table">
            <thead>
              <tr>
                <th class="col-lg-1">S.No.</th>
                <th class="col-lg-1" data-column="id"><span>ID</span><img src="<?php echo base_url('icons/sort.svg') ?>" alt=""></th>
                <th class="col-lg-2" data-column="name"><span>Name</span><img src="<?php echo base_url('icons/sort.svg') ?>" alt="" ></th>
                <th class="col-lg-3" data-column="email"><span>Email</span><img src="<?php echo base_url('icons/sort.svg') ?>" alt=""></th>
                <th class="col-lg-2" data-column="phone"><span>Phone Number</span><img src="<?php echo base_url('icons/sort.svg') ?>" alt="" ></th>   
                <th class="col-lg-4">Address</th>
                <th class="col-lg-2">Action</th>
              </tr>
            </thead>
            <tbody>
              
            </tbody>
          </table>
        </div>
        <div id="notFound">
                    <h2 style="text-align: center; color: red;">NOT FOUND!</h2>
        </div>
        <div class="d-flex justify-content-end fst-italic" id="recordsCount">
          <span id="hideRecords">Showing Records <span id='limitRecords' class="ms-2 me-2"> 2 </span> Of <span id="RecordsTotal" class="ms-2 me-4">5</span></span>
        </div>
       </div>
      </div>

      <div class="tab-pane fade" id="nav-form" role="tabpanel"> <!--aria-labelledby="nav-form-tab"-->
        <div class="container pt-3 pb-3" id="tab-1">
          <form action="" method="POST" id="client-data" autocomplete="off">
            <input type="hidden" id="clientId" name="clientId">
            <!-- <input type="hidden" name="current_image" id="current_image"> -->
            <div class="row mb-md-3">
              <div class="col-md-3">
                <label class="form-check-label form-label" for="cName">Client Name <span class="required">*</span></label>
                <input class="form-control form-control-sm" type="text" id="cName" name="cName">
                <span class="error" id="cNameErr">Can only contain letters</span>
              </div>
              <div class="col-md-3">
                <label for="cEmail" class="form-check-label form-label">Email <span class="required">*</span></label>
                <input type="email" class="form-control form-control-sm" id="cEmail" name="cEmail">
                <span class="error" id="cEmailErr">Email is invalid</span>
              </div>
              <div class="col-md-3">
                <label for="cPhone" class="form-check-label form-label">Phone Number <span class="required">*</span></label>
                <input type="tel" name="cPhone" id="cPhone" class="form-control form-control-sm">
                <span class="error" id="cPhoneErr">Invalid phone number</span>
              </div>
              <div class="col-md-3">
                <label for="cAddress" class="form-check-label form-label">Address <span class="required" id="cAddRqr">*</span></label>
                <input type="text" id="cAddress" name="cAddress" class="form-control form-control-sm">
              </div>   
            </div>

            <div class="row">
              <div class="col-md-3">
                <label for="cState" class="form-check-label form-label">State<span class="required">*</span></label>
                <select name="cState" id="cState" class="form-select form-select-sm" aria-label="cState">
                  <option value="">Select a state</option>
                </select>
              </div>
              <div class="col-md-3">
                <label for="cCity" class="form-check-label form-label">City<span class="required">*</span></label>
                <select id="cCity" name="cCity" class="form-select form-select-sm" aria-label="cCity">
                  <option value="">Select a city</option>
                </select>
              </div>
              <div class="col-md-3">
                <label for="cPincode" class="form-check-label form-label" >Pincode<span class="required">*</span></label>
                <input type="text" id="cPincode" name="cPincode" class="form-control form-control-sm">
                <span class="error" id="cPinErr">Invalid pincode</span>
              </div>
            </div>

            <button type="submit" id="cSubmit" class="btn btn-sm btn-primary mt-3 btn-block">Submit</button>
            <button type="button" id="resetForm" class="btn btn-sm btn-danger mt-3 ms-1">Reset</button>
          </form>
        </div>
      </div>
    </div>
</div>