<?php
// session_start();

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
    <title>Client Master</title>
    <link rel="stylesheet" href="<?php echo base_url('styles/styles.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('styles/style1.css') ?>">
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
        #searchDiv {
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        #notFound {
            display: none;
        }   
        #data-table {
            max-height: 220px;
            width: 100%;
            overflow-y: auto;
            display: block;
        }
        @media screen and (max-width: 772px) {
            #backgroundImg {
                width: 80%;
                height: 150%;
            }
            [class^="col-md-"] {
                margin-bottom: 10px;
            }

        }
        @media screen and (max-width: 1965px) and (min-width: 772px) {
            #backgroundImg {
                width: 75%;
                height: 100%;
            }
            /* #data-table {
                border: 1px solid red; 
                width: 100%;
            } */
        }
    </style>
</head>
<body>
<div class="container-fluid p-0 d-flex h-100">
    <?php $this->load->view('navsidebar/sidebar'); ?>
    <div class="bg-secondary flex-fill" id="backgroundImg"> 
        <?php $this->load->view('navsidebar/nav');
        $this->load->view('client'); 
        ?>
    </div>
</div>

<?php $this->load->view('foot') ?>
<script>
    let isSearching = false;
    let Sno = 0;
    let currentSortColumn = 'id';
    let currentSortDirection = 'DESC';
    var recordsPerPage = 2;
    let currentPage = 1;
    let totalPages = 1;
    $(document).ready(function() {
        loadTableData(recordsPerPage, currentPage, currentSortColumn, currentSortDirection, isSearching);
        loadStateData();

        $('#nav-table-tab').click(function() {
            $('#client-data')[0].reset();
            $('#nav-form-tab').text('Add Client');
            clearSubmit();
            $('#resetForm').show();
        });

        $('#data-table th[data-column]').on('click', function() {
            currentSortColumn = $(this).data('column');
            currentSortDirection = currentSortDirection=='DESC' ? 'ASC' : 'DESC';
            loadTableData(recordsPerPage, currentPage, currentSortColumn, currentSortDirection, isSearching);    
        });

        $('#tableLimit').on('change', function() {
            recordsPerPage = $('#tableLimit option:selected').val();
            console.log(recordsPerPage);
            loadTableData(recordsPerPage, 1, currentSortColumn, currentSortDirection, isSearching);
        });

        $('#pageInfo').on('click', '#firstPage', function() {
            console.log(isSearching);
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

        $('#fclient-data').on('submit', function(event) {
            event.preventDefault();
            // $('#hideRecords').show();
            if($('#fclientName').val() == '' && $('#fclientEmail').val() == '' && $('#fclientPhone').val() == '') {
                loadTableData(recordsPerPage, 1, currentSortColumn, currentSortDirection, false);
            } else {
                isSearching = true;
                loadTableData(recordsPerPage, 1, currentSortColumn, currentSortDirection, isSearching);
            }
        });

        $('#client-data').on('submit', function(event) {
            event.preventDefault();
            const formFields = ['cName', 'cEmail', 'cPhone', 'cAddress', 'cState', 'cCity', 'cPincode'];
            var isValid = true;
            formFields.forEach(function(key){
                if($('#' + key).val()==='') {
                    isValid = false;
                    return false;
                }
            });

            if(!isValid) {
                toastr.error('All values are required!');
            } else {
                if($('.error:visible').length>0) {
                    toastr.error('Fix the errors!');
                } else {
                    const formdata = new FormData(this);
                    formdata.append('type', 'insert_update');
                    
                    $.ajax({
                        url: 'clientmaster/insertOrUpdate',
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
                                    loadTableData(recordsPerPage, currentPage, currentSortColumn, currentSortDirection, false);
                                    toastr.success('Client Updated!');
                                } else {
                                    // appendDataInTable(data.data[0]);
                                    loadTableData(recordsPerPage, currentPage, currentSortColumn, currentSortDirection, false);
                                    toastr.success('Client added successfully');
                                }
                                switchToTab('nav-table-tab');
                                $('#client-data')[0].reset();
                                $('#nav-form-tab').text('Add Client');
                                clearSubmit();
                                clearFormId();
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
                            console.error('error: ', error);
                            alert('An error occurred while submitting the data');
                        }
                    });
                }
            }
        });

        $('#resetBtn').click(function() {
            $('#fclient-data')[0].reset();
            $('#hideRecords').show();
            isSearching = false;
            loadTableData(recordsPerPage, 1, currentSortColumn, currentSortDirection, isSearching);
        });

        $('#cState').on('change', function() {
            const stateid = $(this).val();
            if(stateid) {
                loadCityData(stateid);
            } else {
                $('#cCity').empty();
                $('#cCity').append('<option value="">Select a City</option>')
            }  
        });
    });

    function loadTableData(records='2', current_page=1, currentSortColumn='id', currentSortDirection='DESC', isSearching=false) {
        console.log(isSearching);
        const offset = (current_page - 1) * records;
        const data = {
            type: isSearching ? 'searchUser' : 'fetch_data',
            col: currentSortColumn,
            direction: currentSortDirection,
            limit: records,
            // page: current_page,
            offset: offset
        };

        if (isSearching) {
            data.fclientName = $('#fclientName').val();
            data.fclientEmail = $('#fclientEmail').val();
            data.fclientPhone = $('#fclientPhone').val();
        }

        $.ajax({
            url: isSearching ? 'clientmaster/searchUser' : 'clientmaster/fetchData',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(data) {
                console.log(data);
                // if(data.success) {
                Sno = offset;
                $('#notFound').hide();
                const tbody = $('#data-table tbody');
                tbody.empty();
                data.data.forEach(row=> {
                    ++Sno;
                    appendDataInTable(row);
                });    

                totalPages = Math.ceil(data.total_records / records);
                if(current_page==totalPages) {
                    const lastPageRecords = (data.total_records)% (records);
                    $('#limitRecords').text(lastPageRecords==0 ? records : lastPageRecords);
                } else {
                    $('#limitRecords').text(Math.min(records, data.total_records));
                }
                $('#RecordsTotal').text(data.total_records);
                currentPage = current_page;

                setPagination(data.total_records, currentPage, false);
                // } 
                if(data.total_records==0) {
                    $('#notFound').show();
                    $('#hideRecords').hide();
                } else {
                    $('#hideRecords').show();
                }
            }, error: function(error) {
                console.error('Error:', error);
                alert('an error occured while fetching the data');
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


    function loadStateData() {
        $.ajax({
            url: 'clientmaster/fetchState',
            type: 'post',
            data: {type: 'fetch_state'},
            dataType: 'json',
            success: function(data) {
                const state = $('#cState');
                data.forEach(row=> {
                    state.append(`<option value=${row.state_id}>${row.state_name}</option>`);
                });
            }
        });
    }

    function loadCityData(id, callback) {
        $.ajax({
            url: 'clientmaster/fetchCity',
            type: 'post',
            data: {
                type: 'fetch_city',
                id: id
            },
            dataType: 'json',
            success: function(data) {
                const city = $('#cCity');
                city.empty();
                city.append('<option value="">Select a city</option>');
                data.forEach(row=>{
                    city.append(`<option value=${row.district_id}>${row.district_name}</option>`);
                });
                if(callback) {
                    callback();
                }
            }
        });
            
    }

    function appendDataInTable(data) {
        const tbody = $('#data-table tbody');
        const tr = $('<tr>').attr('data-id', data.id);
        tr.html(`
            <td>${Sno}</td>
            <td><a onclick="editEntry(${data.id})" class="text-decoration-none" role="button" >${data.id}</a></td>
            <td><a onclick="editEntry(${data.id})" class="text-decoration-none" role="button" >${data.name}</a></td>
            <td>${data.email}</td>
            <td>${data.phone}</td>
            <td>${data.Address}</td>
            <td>
                <ul class="list-inline m-0">
                    <li class="list-inline-item">
                    <button class="btn btn-sm rounded-0" data-toggle="tooltip" title="Edit" data-placement="top" onclick="editEntry(${data.id})"><img src="<?php echo base_url('icons/pencil-square.svg') ?>"></button>
                    </li>
                    <li class="list-inline-item">
                    <button class="btn btn-sm rounded-0" data-toggle="tooltip" title="Delete" data-placement="top" onclick="deleteEntry(${data.id}, '${data.name}')"><img src="<?php echo base_url('icons/trash.svg') ?>"></button>
                    </li> 
                </ul>
            </td>
        `);
        tbody.append(tr);
        console.log(`Appended row for ID: ${data.id}`);
    }

    function editEntry(id) {
        $.ajax({
            url: 'clientmaster/editEntry',
            type: 'post',
            data: {
                type: 'editEntry',
                id: id
            },
            dataType: 'json',
            success: function(data) {
                console.log(data);
                $('#clientId').val(data[0].id);
                $('#cName').val(data[0].name);
                $('#cEmail').val(data[0].email);
                $('#cPhone').val(data[0].phone);
                $('#cAddress').val(data[0].address);
                $('#cState').val(data[0].state);

                const state = data[0].state;
                loadCityData(state, function() {
                    $('#cCity').val(data[0].city);
                });
                console.log(parseInt(data[0].city));
                $('#cPincode').val(data[0].pincode);
                $('#cSubmit').text('Update');
                $('#nav-form-tab').text('Edit Client');
                switchToTab('nav-form-tab');
                $('#resetForm').hide();
            }
        });
    }


    function deleteEntry(id, name) {
        $.confirm({
            theme: 'material',
            title: 'Delete user account?',
            content: `Are you sure you want to delete <b>${name}</b> account?`,
            autoClose: 'cancel|8000',
            buttons: {
                deleteUser: {
                    text: `delete user`,
                    btnClass: 'btn-danger',
                    action: function () {
                        $.ajax({
                            url: 'clientmaster/deleteData',
                            type: 'post',
                            data: {
                                type: 'delete_data',
                                id: id
                            },
                            dataType: 'json',
                            success: function(data) {
                                console.log(data);
                                if(data.success) {
                                    $(`#data-table tr[data-id='${id}']`).remove();
                                    // $.alert(`You deleted <b>${name}'s</b> account`);
                                    toastr.success(`You deleted <b>${name}'s</b> account`);
                                    loadTableData(recordsPerPage, currentPage, currentSortColumn, currentSortDirection, isSearching);
                                } else { 
                                    if(data.error_code=='1451') {
                                        toastr.error('Client is in Invoice.', 'Failed!');
                                        // $.confirm({
                                        // title: 'Encountered an error!',
                                        // content: "Client is in Invoice!",
                                        // type: 'red',
                                        // typeAnimated: true,
                                        // buttons: {
                                        //     Ok: function () {
                                        //     }
                                        // }
                                        // });
                                        // $.alert({
                                        //     title: "Failed!",
                                        //     content: "Client is in Invoice!"
                                        // });
                                    } else {
                                        toastr.error('Something went wrong!');
                                    }
                                }
                            },
                            error: function(error) {
                                console.error('Error: ', error);    
                                // $.alert({
                                //     title: 'Alert!',
                                //     content: 'Delete Unsuccessful',
                                // });
                                toastr.error('Delete Unsuccessful!');
                            }
                        });                    
                    }
                },
                cancel: function () {
                    text: 'cancel'
                    // $.alert(`<b>${name}</b> just got saved!`);
                    toastr.info(`<b>${name}</b> just got saved!`);
                }
            }
        });
    }



    function switchToTab(tabId) {
        $(`#${tabId}`).tab('show');
    }

    function clearSubmit() {
        $('#cSubmit').text('Submit');
    }

    function clearFormId() {
        $('#clientId').val('');
    }

    $('#resetForm').on('click', function() {
        $('#client-data')[0].reset();
        $('.error').hide();
        $('#nav-form-tab').text('Add Client');
        clearSubmit();
    });
</script>
<script src="<?php echo base_url('application/views/scripts/validation.js') ?>"></script>
</body>
</html>