<?php
if(!$_SESSION['allowLogin']) {
    redirect('LoginPage');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <link rel="stylesheet" href="<?php echo base_url('styles/style1.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('styles/styles.css') ?>">
    <?php $this->load->view('cdn_files') ?>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap');
        * {
            font-family: "Lato", sans-serif;
            font-size: 13px;
        }
        #backgroundImg {
            background-image: url('<?php echo base_url('images/background2.jpg')?>');
            background-size: cover;
        }
        input:read-only {
            background-color: #F2F2F2;
        }
        #searchDiv {
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        #notFound {
            display: none;
        }

        .btn-close-white {
            background-color: transparent; 
            border: none; 
            opacity: 1; 
        }

        .btn-close-white::before,
        .btn-close-white::after {
            background-color: white; 
        }

        #data-table {
            max-height: 195px;
            font-size: 12px;
            width: 100%;
            overflow-y: auto;
            display: block;
        } 
        #loader-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        @media screen and (max-width: 772px) {
            #backgroundImg {
                width: 80%;
                height: 140%;
            }
            [class^="col-md-"] {
                margin-bottom: 8px;
            }
        }
        @media screen and (max-width: 1965px) and (min-width: 772px) {
            #backgroundImg {
                width: 75%;
                height: 100%;
            }
            #data-table {
                width: 100%;
            }
        }

    </style>
</head>
<body>
    <div class="container-fluid p-0 d-flex h-100">
        <?php $this->load->view('navsidebar/sidebar') ?>
        <div class="bg-light flex-fill" id="backgroundImg">
            <?php 
                $this->load->view('navsidebar/nav');
                $this->load->view('invoice');
            ?>
        </div>
    </div>
    <?php $this->load->view('foot.php') ?>
    <script>
        var isSearching = false;
        let Sno = 0;
        let currentSortColumn = 'invoiceId';
        let currentSortDirection = 'DESC';
        var recordsPerPage = 2;
        let currentPage = 1;
        let totalPages = 1;

        $(document).ready(function() {
            loadTableData(recordsPerPage, currentPage, currentSortColumn, currentSortDirection, isSearching);
            loadInvoiceNo();
            
            $('#nav-table-tab').on('click', function() {
                $('#itemId').val('');
                $('#invoice-data')[0].reset();
                $('#nav-form-tab').text('Add Invoice');
                $('#myTable').find('tr:gt(1)').remove();
                clearSubmit();
                loadInvoiceNo();
                $('.error').hide();
                $('#resetForm').show();
            });


            $('#data-table th[data-column]').on('click', function() {
                currentSortColumn = $(this).data('column');
                currentSortDirection = currentSortDirection=='DESC' ? 'ASC' : 'DESC';
                loadTableData(recordsPerPage, currentPage, currentSortColumn, currentSortDirection, isSearching);    
            });

            $('#tableLimit').on('change', function() {
                recordsPerPage = $('#tableLimit option:selected').val();
                loadTableData(recordsPerPage, 1, currentSortColumn, currentSortDirection, isSearching);
            });

            $('#pageInfo').on('click', '#firstPage', function() {
                loadTableData(recordsPerPage, 1, currentSortColumn, currentSortDirection, isSearching);
            });
            
            $('#pageInfo').on('click', '#lastPage', function() {
                loadTableData(recordsPerPage, totalPages, currentSortColumn, currentSortDirection, isSearching);
            });
            
            $('#pageInfo').on('click', '#prevPage', function() {
                if (currentPage > 1) {
                    currentPage--;
                    loadTableData(recordsPerPage, currentPage, currentSortColumn, currentSortDirection, isSearching);
                }
            });
            
            $('#pageInfo').on('click', '#nextPage', function() {
                if (currentPage < totalPages) {
                    currentPage++;
                    loadTableData(recordsPerPage, currentPage, currentSortColumn, currentSortDirection, isSearching);
                }
            });

            $('#resetBtn').click(function() {
                $('#finvoice-data')[0].reset();
                $('#hideRecords').show();
                isSearching = false;
                loadTableData(recordsPerPage, 1, currentSortColumn, currentSortDirection, isSearching);
            });

            $('#invoice-data').on('submit', function(event) {
                event.preventDefault();
                const formFields = ['invoiceNo', 'invoiceDate', 'cName', 'cEmail'];
                var isValid = true;

                formFields.forEach(function(key){
                    if($('#' + key).val() == '') {
                        isValid = false;
                        return false;
                    }
                });

                if(isValid) {
                    if($('.error:visible').length > 0) {
                        toastr.error('Fix the errors!');
                    } else {
                        const formdata = new FormData(this);
                        formdata.append('type', 'insert_update');
                        $.ajax({
                            url: 'invoicemaster/insertOrUpdate',
                            type: 'post',
                            data: formdata,
                            contentType: false,
                            processData: false,
                            dataType: 'json',
                            success: function(data) {
                                console.log(data);
                                if(data.success) {
                                    if(data.update) {
                                        // updateDataInTable(data.data[0]);
                                        loadTableData(recordsPerPage, currentPage, currentSortColumn, currentSortDirection, isSearching);
                                        toastr.success('Invoice updated!');
                                    }
                                    else {
                                        // appendRowToTable(data.data[0]);
                                        loadTableData(recordsPerPage, currentPage, currentSortColumn, currentSortDirection, isSearching);
                                        toastr.success('Invoice added successfully!');
                                    }
                                    switchToTab('nav-table-tab');
                                    $('#invoice-data')[0].reset();
                                    $('#nav-form-tab').text('Add Invoice');
                                    $('#itemId').val('');
                                    $('#myTable').find('tr:gt(1)').remove();
                                    clearSubmit();
                                    loadInvoiceNo();
                                    clearId();
                                    $('#resetForm').show();
                                } else {
                                    if(typeof data.error === 'string' && data.error!=='') {
                                        toastr.error(data.error);
                                    } else if(typeof data.error === 'object' && data.error!==null){
                                        Object.keys(data.error).forEach(key => {
                                            if(data.error[key]!=='') {
                                                toastr.error(data.error[key]);
                                            }
                                        });
                                    }
                                }
                            }, error: function(error) {
                                console.error('Error: ', error);
                            }
                        });
                    }
                } else {
                    toastr.error('All fields are required!');
                }

            });

            $('#finvoice-data').on('submit', function(event) {
                event.preventDefault();
                if($('#finvoiceNo').val()=='' && $('#finvoiceDate').val()=='' && $('#fclientName').val()=='' && $('#fclientEmail').val()=='' && $('#fclientPhone').val()=='') {
                    loadTableData(recordsPerPage, 1, currentSortColumn, currentSortDirection, false);
                } else {
                    isSearching = true;
                    loadTableData(recordsPerPage, 1, currentSortColumn, currentSortDirection, isSearching);
                }
            });



            $('#AddItem').click(function() {
                const row = $('.itemTable tbody tr:last-child');
                if(row.find('input:gt(1)').val()!="") {
                    const newRow = $('.itemTable tbody tr:first-child').clone();
                    newRow.find("input").val('');
                    $('.itemTable').append(newRow);
                }  
            });

            $('#cName').autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: 'invoicemaster/ClientName',
                        type: 'post',
                        data: { clientname : request.term },
                        dataType: 'json',
                        success: function(data) {
                            response(data);
                        }
                    });
                }, select : function(event, ui) {
                    var id = ui.item.id;
                    console.log(id);
                    $.ajax({
                        url: 'invoicemaster/ClientAutofill',
                        type: 'post',
                        data: {
                            cid: id
                        },
                        dataType: 'json',
                        success: function(data) {
                            $('#clientId').val(data.id);
                            $('#cEmail').val(data.email);
                            $('#cPhone').val(data.phone);
                            $('#cAddress').val(data.Address);
                        }
                    });
                }
            });

        });

        function loadTableData(records='2', current_page=1, currentSortColumn='invoiceId', currentSortDirection='DESC', isSearching=false) {
            console.log(isSearching);
            const offset = (current_page-1) * records;
            const data = {
                type: isSearching ? 'search_invoice' : 'fetch_data',
                col: currentSortColumn,
                direction: currentSortDirection,
                limit: records,
                offset: offset
            }

            if(isSearching) {   
                data.finvoiceNo = $('#finvoiceNo').val();
                data.fclientName = $('#fclientName').val();
                data.fclientEmail = $('#fclientEmail').val();
                data.fclientPhone = $('#fclientPhone').val();
                data.finvoiceDate = $('#finvoiceDate').val();
            }

            $.ajax({
                url: isSearching ? 'invoicemaster/searchInvoice' : 'invoicemaster/fetchData',
                type: 'post',
                data: data,
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    Sno = offset;
                    $('#notFound').hide();
                    const tbody = $('#data-table tbody');
                    tbody.empty();
                    data.data.forEach(row => {
                        ++Sno;
                        appendRowToTable(row);
                    });
                    console.log(data.total_records);
                    totalPages = Math.ceil(data.total_records / records);
                    if(current_page==totalPages) {
                        const lastPageRecords = (data.total_records)%(records);
                        $('#limitRecords').text(lastPageRecords==0 ? records : lastPageRecords);
                    } else {
                        $('#limitRecords').text(Math.min(records, data.total_records));
                    }
                    $('#RecordsTotal').text(data.total_records);
                    currentPage = current_page;
                    
                    setPagination(data.total_records, currentPage, isSearching);

                    if(data.total_records==0) {
                        $('#notFound').show();
                        $('#hideRecords').hide();
                    } else {
                        $('#hideRecords').show();
                    }
                }
            });

        }

        function setPagination(total_records, currentPage, isSearching) {
            $('#pageInfo').html('');
            totalPages = Math.ceil(total_records / recordsPerPage);
            for(let i = 1; i <= totalPages; i++) {
                if(i==1 && i!=totalPages) {
                    const prevBtn = $('<li></li>').addClass('page-item').html($('<a></a>').addClass('page-link').attr({ href: 'javascript:void(0);', id: 'prevPage'}).html($('<span></span>').attr('aria-hidden', 'true').html('&laquo;')));
                    $('#pageInfo').append(prevBtn);
                    const firstBtn = $('<li></li>').addClass('page-item').html($('<a></a>').addClass('page-link').attr({href: 'javascript:void(0);', id: 'firstPage'}).text('First'));
                    $('#pageInfo').append(firstBtn);
                }
                const paginBtn = $('<li></li>').addClass('page-item').html($('<a></a>').addClass('page-link').attr('href','javascript:void(0);').text(i));
                if (i == currentPage) {
                    paginBtn.addClass('active');
                }
                paginBtn.click(function() {
                    loadTableData(recordsPerPage, i, currentSortColumn, currentSortDirection, isSearching);
                });
                $('#pageInfo').append(paginBtn);

                if(i==totalPages && i!=1) {
                    const lastBtn = $('<li></li>').addClass('page-item').html($('<a></a>').addClass('page-link').attr({href: 'javascript:void(0);', id: 'lastPage'}).text('Last'));
                    $('#pageInfo').append(lastBtn);
                    const nextBtn = $('<li></li>').addClass('page-item').html($('<a></a>').addClass('page-link').attr({ href: 'javascript:void(0);', id: 'nextPage'}).html($('<span></span>').attr('aria-hidden', 'true').html('&raquo;')));
                    $('#pageInfo').append(nextBtn);
                }
            }
        }

        function appendRowToTable(data) {
            const tbody = $('#data-table tbody');
            const tr = $('<tr>').attr('data-id', data.invoiceId);
            let date = data.invoiceDate;
            let dateArr = date.split('-');
            let rearrangedArr = [dateArr[2], dateArr[1], dateArr[0]];
            let invoiceDate = rearrangedArr.join('-');

            tr.html(`
                <td>${Sno}</td>    
                <td><a onclick="editEntry(${data.invoiceId})" class="text-decoration-none" role="button" >${data.invoiceId}</a></td> 
                <td>${data.invoiceNo}</td>
                <td>${invoiceDate}</td>
                <td>${data.name}</td>
                <td>${data.email}</td>
                <td>${data.phone}</td>
                <td>${data.grandTotal}</td>
                <td><button class="btn btn-sm rounded-0" data-toggle="tooltip" title="Pdf" data-placement="top" onclick="pdfCreate(${data.invoiceId})"><img src="<?php echo base_url('icons/pdf.svg') ?>" width="18px"></button></td>
                <td><button type="button" class="btn btn-sm rounded-0" data-bs-toggle="modal" title="Gmail" data-bs-target="#exampleModal" onclick="sendMail(${data.invoiceId})"><img src="<?php echo base_url('icons/gmail.svg') ?>" width="18px"></button>
                
                </td>
                <td>
                        <ul class="list-inline m-0">
                            <li class="list-inline-item">
                                <button class="btn btn-sm rounded-0" data-toggle="tooltip" title="Edit" data-placement="top" onclick="editEntry(${data.invoiceId})"><img src="<?php echo base_url('icons/pencil-square.svg') ?>"></button>
                            </li>
                            <li class="list-inline-item">
                                <button class="btn btn-sm rounded-0" data-toggle="tooltip" title="Delete" data-placement="top" onclick="deleteEntry(${data.invoiceId}, ${data.invoiceNo})"><img src="<?php echo base_url('icons/trash.svg') ?>"></button>
                            </li>
                        </ul>
                </td>
            `);
            tbody.append(tr);
            console.log(`Appended row for invoiceID: ${data.invoiceId}`);
        }

        function editEntry(id) {
            $.ajax({
                url: 'invoicemaster/getEntry',
                type: 'post',
                data: {
                    type: 'get_entry',
                    id: id
                },
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    const invData = data.invoiceData;
                    const itemData = data.itemData;
                    $('#invoiceId').val(invData.invoiceId);
                    $('#invoiceNo').val(invData.invoiceNo);
                    $('#invoiceDate').val(invData.invoiceDate);
                    $('#clientId').val(invData.id);
                    $('#cName').val(invData.name);
                    $('#cEmail').val(invData.email);
                    $('#cPhone').val(invData.phone);
                    $('#cAddress').val(invData.Address);

                    var itemTable = $('.itemTable');
                    var tbody = itemTable.find('tbody');
                    
                    tbody.find('tr:not(:first)').remove();


                    var firstrow = $('.itemTable').find('tbody tr:first-child');
                    $.each(itemData, function(index, element) {

                        if(index === 0) {
                            firstrow.find('.Id').val(element.id);
                            firstrow.find('.itemId').val(element.itemId);
                            firstrow.find('.itemname').val(element.itemName);
                            firstrow.find('.price').val(element.itemPrice);
                            firstrow.find('.quantity').val(element.qty);
                            firstrow.find('.amount').val(element.total);
                        } else {
                                var cloned = firstrow.clone();
                                cloned.find('input').val('');
                                cloned.find('.Id').val(element.id);
                                cloned.find('.itemId').val(element.itemId);
                                cloned.find('.itemname').val(element.itemName);
                                cloned.find('.price').val(element.itemPrice);
                                cloned.find('.quantity').val(element.qty);
                                cloned.find('.amount').val(element.total);
                        }
                        $('.itemTable').append(cloned);
                    });

                    $('#totalAmt').val(invData.grandTotal);
                    switchToTab('nav-form-tab');
                    $('#submit').text('Update');
                    $('#nav-form-tab').text('Edit Invoice');
                    $('#resetForm').hide();
                }
            });
        }



        function deleteEntry(id, invNo) {
            $.confirm({
                theme: 'material',
                title: 'Delete Invoice?',
                content: `Are you sure you want to delete invoice no. ${invNo}?`,
                autoClose: 'cancel|8000',
                buttons: {
                    deleteInvoice: {
                        text: `delete invoice`,
                        btnClass: 'btn-danger',
                        action: function () {
                            $.ajax({
                                url: 'invoicemaster/deleteData',
                                type: 'post',
                                data: {
                                    type: 'delete_invoice',
                                    id: id
                                },
                                dataType: 'json',
                                success: function(data) {
                                    console.log(data);
                                    if(data.success) {
                                        $(`#data-table tr[data-id='${id}']`).remove();
                                        toastr.error(`Invoice no. ${invNo} deleted successfully`);
                                        loadTableData();
                                    }
                                },
                                error: function(error) {
                                    console.error('Error: ', error);    
                                    toastr.error('Delete Unsuccessful!');
                                }
                            });                    
                        }
                    },
                    cancel: function () {
                        text: 'cancel'
                        // $.alert(`Cancelled!`);
                        toastr.info('Cancelled!');
                    }
                }
            });
        }



        function loadInvoiceNo() {
            $.ajax({
                url: 'invoicemaster/autoInvoiceNo',
                type: 'post',
                data: {autoInvoiceNo : true},
                dataType: 'json',
                success: function(data) {
                    // console.log(data);
                    if(data.invoiceNo) {
                        $('#invoiceNo').val(parseInt(data.invoiceNo)+1);
                        invoiceNo = parseInt(data.invoiceNo) + 1;
                    } else {
                        $('#invoiceNo').val('1');
                    }
                }, error : function(error) {
                    // $('#invoiceNo').val('1');
                }
            });
            
        }


        function call() {
            $('.itemname').autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: 'invoicemaster/itemName',
                        type: 'post',
                        data: {
                            itemname: request.term
                        },
                        dataType: 'json',
                        success: function(data) {
                            response(data);
                        }
                    });
                }, select: function(event, ui) {
                    // console.log(ui.item.price);
                    const row = $(this).parents('tr');
                    row.find('.itemId').val(ui.item.id);
                    row.find('.itemname').val(ui.item.value);
                    row.find('.price').val(ui.item.price);
                    row.find('.quantity').val(1);
                    row.find('.amount').val(ui.item.price);
                    totalamount();
                }
            });
        }

        function totalamount() {
            var total = 0;
            $('.amount').each(function() {
                var amount = parseFloat($(this).val()) || 0;
                total += amount;
            });
            if(total >1 ) {
                $('#totalAmt').val(total);
            } else {
                $('#totalAmt').val('');
            }
        }


        function totalQty(qnty) {
            var qty = $(qnty).val();
            const row = $(qnty).parents('tr');
            const price = row.find('.price').val();
            if(qty<0) {
                qty = 0;
            }
            if(qty==0) {
                row.find('.amount').val('');
            } else {
                row.find('.amount').val(qty*price);
            }
            totalamount();
        }

        function deleteItem(itemToDel) {

            const item = $(itemToDel);
            const tbody = item.parents('tbody');
            const row = tbody.children("tr:first");
            const noOfRows = tbody.children('tr').length;
            console.log(noOfRows);
            const row1 = item.parents('tr');
            const id = row1.find('.Id').val();

            if(row[0]!=row1[0]) {
                row1.find('input').val('');
                row1.remove();
                totalamount();
                console.log('1st');
            } else if(row[0]==row1[0] && noOfRows==1){
                row.find('input').val('');
                $('#totalAmt').val('');
                console.log('2nd');
            } else if(row[0]==row1[0] && noOfRows>1) {
                row.find('input').val('');
                row1.remove();
                totalamount();
                console.log('3rd');
            }

        }

        function pdfCreate(invoiceId) {
            $.ajax({
                url: 'invoicemaster/pdfCreate',
                type: 'post',
                data: {
                    pdfId : invoiceId,
                    type: 'pdfCreate'
                },
                dataType: 'json',
                success: function(data) {
                    console.log(data.result);
                    window.open(data.result);
                }
                
            });
        }

        function sendMail(id) {
            $.ajax({
                url: 'invoicemaster/mailEntry',
                type: 'post',
                data: {
                    type: 'mailEntry',
                    mailId : id
                },
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    $('#rcptMail').val(data.email);
                    $('#invoiceMailId').val(data.invoiceId);
                    $('#rcptSubject').val('Invoice');
                    $('#rcptMessage').val("Dear "+data.name +",\n" + "Please find attached your invoice");
                }
            });
        }

        $('#mailsend').on('click', function() {
            const invoiceId = $('#invoiceMailId').val();
            const mailID = $('#rcptMail').val();
            const subject = $('#rcptSubject').val();
            const message = $('#rcptMessage').val();
            $('#loader-overlay').show();
            $.ajax({
                url: "invoicemaster/sendMail",
                type: "post",
                data: {
                    invId : invoiceId,
                    mailId : mailID,
                    subject: subject,
                    message: message,
                    type: 'sendMail'
                },
                dataType : 'json',
                success: function(data) {
                    console.log(data);
                    $('#loader-overlay').hide();
                    // $.alert({
                    //     title: 'Success!',
                    //     content: data,
                    // });
                    toastr.success(data);
                    $('#exampleModal').modal('hide');
                    $('#maildata')[0].reset();
                }
            });

        });


        function switchToTab(tabId) {
            $(`#${tabId}`).tab('show');
        }

        function clearSubmit() {
            $('#submit').text('Submit');
        }

        function clearId() {
            $('#invoiceId').val('');
        }


        function validateQuantity(row) {
                var qty = $(row).val();
                const pattern = /^[1-9]\d*$/;
            
                if(qty.length<1) {
                    $(row).val(1);
                }
                if(qty.length>2) {
                    $(row).val(qty.substr(0,2));
                }
            
                if(!pattern.test(qty)) {
                    $(row).val(qty.replace(/^(?!([1-9]\d*$)).*$/, '')); 
                }
        }

        function ItemClear(name) {
            var itemName = $(name).val();
            var row = $(name).parents('tr');

            if(itemName=="") {
                row.find('.price').val('');
                row.find('.quantity').val('');
                row.find('.amount').val('');
            }
            totalamount();
        }

        $('#resetForm').on('click', function() {
            $('#invoice-data')[0].reset();
            $('#itemId').val('');
            $('#nav-form-tab').text('Add Invoice');
            $('#myTable').find('tr:gt(1)').remove();
            clearSubmit();
            loadInvoiceNo();
            $('.error').hide();
        });
    </script>
    <script src="<?php echo base_url('application/views/scripts/validation.js') ?>"></script>
</body>
</html>