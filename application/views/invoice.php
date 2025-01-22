<div class="container mb-3">
    <div class="tabs">
      <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
          <button class="nav-link active" id="nav-table-tab" data-bs-toggle="tab" data-bs-target="#nav-table"
            type="button" role="tab" aria-controls="nav-table">All Invoice</button>
          <button class="nav-link" id="nav-form-tab" data-bs-toggle="tab" data-bs-target="#nav-form" type="button"
            role="tab" aria-controls="nav-form" >Add Invoice</button>
        </div>
      </nav>
    </div>

    <div class="tab-content" id="nav-tabContent">
      <div class="tab-pane fade show active mt-3" id="nav-table" role="tabpanel" > 
        <div class="container mb-3 p-3" id="searchDiv">
            <!-- <h6 class="mb-3">Search for User:</h6>  -->
          <form method="post" id="finvoice-data" autocomplete="off">
                <div class="row ">
                  <div class="col-md-3">
                    <label for="finvoiceNo" class="form-check-label form-label">Invoice No.</label>
                    <input type="text" class="form-control form-control-sm" id="finvoiceNo" name="finvoiceNo">
                  </div>
                  <div class="col-md-3">
                    <label for="fclientName" class="form-check-label form-label">Client Name</label>
                    <input type="text" class="form-control form-control-sm" id="fclientName" name="fclientName">
                  </div>
                  <div class="col-md-3">
                    <label for="fclientEmail" class="form-check-label form-label">Email</label>
                    <input type="text" class="form-control form-control-sm" id="fclientEmail" name="fclientEmail">   
                  </div>
                  <div class="col-md-3">
                    <label for="fclientPhone" class="form-check-label form-label">Phone</label>
                    <input type="tel" class="form-control form-control-sm" id="fclientPhone" name="fclientPhone">
                  </div>
                </div>
                <div class="row mt-md-3">
                  <div class="col-md-3">
                    <label for="finvoiceDate" class="form-check-label form-label">Invoice Date</label>
                    <input type="date" class="form-control form-control-sm" id="finvoiceDate" name="finvoiceDate">
                  </div>
                  <div class="col-md-3 d-flex align-items-end mb-1">
                      <button type="submit" id="findBtn" class="btn btn-sm btn-primary me-2"> Search </button>
                      <button type="button" id="resetBtn" class="btn btn-sm btn-danger"> Reset </button>
                    </div>
                </div>
            </form>

        </div>
       
        <div class="containerTable p-2 fs-6" id="tab-0">
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
                
                <div class="navbar mb-2 mb-md-0 overflow-auto">
                    <nav aria-label="Page navigation example" class="d-flex">
                        <ul class="pagination" id="pageInfo">
                            <li class="page-item"><a class="page-link" href="javascript:void(0);">1</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        <div>
          <div class="table-responsive">
            <table class="table table-striped table-sm w-100" id="data-table">
              <thead>
                <tr>
                  <th class="col-lg-1">S.No.</th>
                  <th class="col-lg-1" data-column="invoiceId"><span>Invoice ID</span><img src="<?php echo base_url('icons/sort.svg'); ?>" alt=""></th>
                  <th class="col-lg-1" data-column="invoiceNo"><span>Invoice No.</span><img src="<?php echo base_url('icons/sort.svg'); ?>" alt="" ></th>
                  <th class="col-lg-2" data-column="invoiceDate"><span>Invoice Date</span><img src="<?php echo base_url('icons/sort.svg'); ?>" alt="" ></th>
                  <th class="col-lg-2" data-column="name"><span>Client Name</span><img src="<?php echo base_url('icons/sort.svg'); ?>" alt="" ></th>
                  <th class="col-lg-3" data-column="email"><span>Email</span><img src="<?php echo base_url('icons/sort.svg'); ?>" alt="" ></th>
                  <th class="col-lg-2" data-column="phone"><span>Phone</span><img src="<?php echo base_url('icons/sort.svg'); ?>" alt="" ></th>
                  <th class="col-lg-1" data-column="grandTotal"><span>Total</span><img src="<?php echo base_url('icons/sort.svg'); ?>" alt="" ></th>
                  <th class="col-lg-2">Pdf</th>
                  <th class="col-lg-2">Gmail</th>
                  <th class="col-lg-2">Action</th>
                </tr>
              </thead>
              <tbody>
                
              </tbody>
            </table>
          </div>
        </div>


        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header" style="background-color: #0377DE; color: #fff">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">Send Mail </h1>
                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="background-color: #EDF2F6;">
                  <form id="maildata" method="post">
                    <div class="mb-3 d-flex">
                      <label for="rcptMail" class="col-form-label me-2"><b>Recipient:</b></label>
                      <input type="text" class="form-control form-control-sm" id="rcptMail">
                      <input type="hidden" name="invoiceMailId" id="invoiceMailId">
                    </div>
                    <div class="mb-3 d-flex">
                      <label for="rcptSubject" class="col-form-label" style="margin-right: 20px;"><b>Subject:</b></label>
                      <input type="text" class="form-control form-control-sm" id="rcptSubject">
                    </div>
                    <div class="mb-3 d-flex">
                      <label for="rcptMessage" class="col-form-label me-2"><b>Message:</b></label>
                      <textarea class="form-control form-control-sm" id="rcptMessage" style="height: 100px;"></textarea>
                    </div>
                  </form>
                </div>
                <div class="modal-footer" style="background-color: #EDF2F6;">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="button" class="btn" id="mailsend" style="background-color: #0377DE; color: #FFF;">Send</button>
                </div>
              </div>
            </div>
          </div>

          <div id="loader-overlay" style="display: none;">
            <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
              <span class="visually-hidden">Loading...</span>
            </div>
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
          <form method="POST" id="invoice-data" autocomplete="off">
            <input type="hidden" id="invoiceId" name="invoiceId">
            <!-- <input type="hidden" name="current_image" id="current_image"> -->
            <div class="row mb-md-3">
              <div class="col-md-3">
                <label class="form-check-label form-label" for="invoiceNo">Invoice No. <span class="required">*</span></label>
                <input class="form-control form-control-sm" type="text" id="invoiceNo" name="invoiceNo">
                <!-- <span class="error" id="nameErr">Can only contain letters</span> -->
              </div>
              <div class="col-md-3">
                <label for="invoiceDate" class="form-check-label form-label">Invoice Date <span class="required">*</span></label>
                <input type="date" class="form-control form-control-sm" id="invoiceDate" name="invoiceDate" value= <?php echo date("Y-m-d"); ?>>
                <span class="error" id="dateErr">Date invalid</span>
              </div>
            </div>  
            <div class="row mb-3 mt-3">
              <div class="col-md-3">
                <label class="form-check-label form-label" for="cName">Client Name <span class="required">*</span></label>
                <input class="form-control form-control-sm" type="text" id="cName" name="cName" >
                <input type="hidden" name="clientId" id="clientId">
                <!-- <select id="preCName">
                    <option value="Objective C">Objective C</option>
                </select> -->
                <!-- <span class="error" id="cNameErr">Can only contain letters</span> -->
              </div>
              <div class="col-md-3">
                <label for="cEmail" class="form-check-label form-label">Email <span class="required">*</span></label>
                <input type="email" class="form-control form-control-sm" id="cEmail" name="cEmail" readonly>
                <!-- <span class="error" id="cEmailErr">Email is invalid</span> -->
              </div>
              <div class="col-md-3">
                <label for="cPhone" class="form-check-label form-label">Phone Number <span class="required">*</span></label>
                <input type="tel" name="cPhone" id="cPhone" class="form-control form-control-sm" readonly>
                <!-- <span class="error" id="cPhoneErr">Invalid phone number</span> -->
              </div>
              <div class="col-md-3">
                <label for="cAddress" class="form-check-label form-label">Address <span class="required" id="cAddRqr">*</span></label>
                <input type="text" id="cAddress" name="cAddress" class="form-control form-control-sm" readonly>
              </div> 
            </div>
            <div class="table-responsive row mb-3 bg-white rounded "> 
              <!-- mt-3 p-4 shadow-sm bg-white rounded -->
              <table class='table itemTable' id="myTable">
                <thead>
                  <tr class="text-start" style="line-height: 1">
                    <th style="font-size: 12px;">Item name<span class="required">*</span></th>
                    <th style="font-size: 12px;">Item Price</th>
                    <th style="font-size: 12px;">Quantity <span class="required">*</span></th>
                    <th style="font-size: 12px;">Amount</th>
                    <th style="font-size: 12px;">Action</th>
                  </tr>
                </thead>  
                <tbody>
                    <tr id="itemdetails">
                      <td class='col-md-3'>
                        <input type="hidden" name="Id[]" class='Id' id='Id'>
                        <input type="hidden" name="itemId[]" class='itemId' id='itemId'>
                        <input type="text" class="form-control form-control-sm itemname" name="itemName[]" id="itemName" onkeypress="call()" oninput="ItemClear(this)">
                      </td>
                      <td class='col-md-3'>
                        <input type="text" class="form-control form-control-sm price text-end" name="itemPrice[]" id="itemPrice" readonly>
                      </td>
                      <td class="col-md-2">
                        <input type="text" class="form-control form-control-sm quantity text-end" name="itemQty[]" id="itemQty" min="1" max="99" onchange="totalQty(this)" onkeyup="totalQty(this)" oninput="validateQuantity(this)">
                      </td>
                      <td class="col-md-3">
                        <input type="text" class="form-control form-control-sm amount text-end" name="Amt[]" id="Amt" readonly>
                      </td>
                      <td class="col-md-1">
                        <img src="<?php echo base_url('icons/trash.svg') ?>" alt="" onclick="deleteItem(this)" style="cursor: pointer;">
                      </td>
                    </tr>
                  </tbody>
                </table>
                <div class="d-flex justify-content-between">
                  <div>
                    <button type="button" class="btn btn-sm btn-success" id='AddItem'>Add More</button>
                  </div>
                  <div style="text-align:center;" class="mb-2">
                    <label for="totalAmt"><strong style="font-size:12px;">Total Amount</strong></label>
                    <input type="text" class="form-control form-control-sm text-end" name="totalAmt" id="totalAmt" readonly>
                </div>
              </div>
              </div>
              <button type="submit" id="submit" class="btn btn-sm btn-primary btn-block" style="font-size: 13px;">Submit</button>
              <button type="button" id="resetForm" class="btn btn-sm btn-danger ms-1" style="font-size: 13px;">Reset</button>
          </form>
        </div>
      </div>
    </div>
</div>