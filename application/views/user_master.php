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
    <title>User Master</title>
    <!-- <link rel="stylesheet" href="style1.css"> -->
    <link rel="stylesheet" href="<?php echo base_url('styles/styles.css') ?>">
    <link rel="stylesheet" 
          href="<?php echo base_url('styles/style1.css') ?>">
    <?php $this->load->view('cdn_files') ?>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap');
        * {
            font-family: "Lato", sans-serif;
            font-size: 13px;
        }
        #backgroundImg {
            background-image: url('<?php echo base_url('images/background2.jpg')?>');
            /* background-repeat: repeat-y !important; */
            background-size: cover;
        }

        #data-table {
            max-height: 200px !important;
            overflow: auto !important;
        }
        #searchDiv {
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        #notFound {
            display: none;
        }        
        .table-striped>tbody>tr:nth-child(odd)>td, 
        .table-striped>tbody>tr:nth-child(odd)>th {
            background-color: #EDFEFE;
        }
        #data-table {
            max-height: 250px;
            width: 100%;
            overflow-y: auto;
            display: block;
            /* border: 1px solid red; */
        }
        @media screen and (max-width: 770px) {
            #backgroundImg {
                width: 90%;
                height: 100%;
                height: 120%;
            }
        }
    </style>
</head>
<body>
<div class="container-fluid p-0 d-flex h-100">
    <?php $this->load->view('navsidebar/sidebar') ?>

    <div class="bg-light flex-fill" id="backgroundImg"> 
        <!-- <div class="p-2 d-md-none d-flex text-white bg-primary">
            <a href="#" class="text-white" data-bs-toggle="offcanvas" data-bs-target="#bdSidebar">
                <i class="fa-solid fa-bars"></i>
            </a>
            <span class="ms-3">San Softwares</span>
        </div>  -->
        <?php 
        $this->load->view('navsidebar/nav');
        $this->load->view('user.php');
        // include("user1.php"); 
        ?>
    </div>
</div>
<?php $this->load->view('foot.php') ?>
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

        $('#nav-table-tab').click(function() {
            $('#user-data')[0].reset();
            $('#nav-form-tab').text('Add User');
            clearSubmit();
            clearFormId();
            $('.error').hide();
            $('#resetForm').show();
        });


        $('#tableLimit').on('change', function() {
            recordsPerPage = $("#tableLimit option:selected").val();
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
        
        $('#data-table th[data-column]').click(function() {
            currentSortColumn = $(this).data('column');
            currentSortDirection = (currentSortDirection == 'ASC') ? 'DESC' : 'ASC';
            loadTableData(recordsPerPage, currentPage, currentSortColumn, currentSortDirection, isSearching );
        });

        $('#user-data').on('submit', function(event) {
            event.preventDefault();
            const formFields = ['userName', 'userEmail', 'userPhone'];
            var isValid = true;

            formFields.forEach(function(key){
                if($('#' + key).val() == '') {
                    isValid = false;
                    return false;
                }
            });
            if (!isValid ||($('#userPswd').val()=='' && $('#userId').val()=='')) {
                toastr.error('All values are required!');
            } 
            else {
                if($('.error:visible').length > 0) {
                    toastr.error('Fix the errors!');
                } else {
                    const formdata = new FormData(this);
                    formdata.append('type', 'insert_update');
                    $.ajax({
                        url: 'usermaster/insertOrUpdate',
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
                                    toastr.success('User Updated!');
                                }else {
                                    // appendDataInTable(data.data[0]);
                                    loadTableData(recordsPerPage, currentPage, currentSortColumn, currentSortDirection, isSearching);
                                    toastr.success('User added successfully');
                                } 
                                switchToTab('nav-table-tab');
                                $('#user-data')[0].reset();
                                $('#nav-form-tab').text('Add User');
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
                        },
                        error: function(error) {
                            console.error("Error:", error);
                        }
                    });
                }
            }
        });

        $('#fuser-data').on('submit', function(event) {
            event.preventDefault();
            const formFields = ['fuserName', 'fuserEmail', 'fuserPhone'];
            var count = 0;

            formFields.forEach(function(key){
                if($('#' + key).val() == '') {
                    count++;
                }
            });
            if (count==3) {
                loadTableData(recordsPerPage, 1, currentSortColumn, currentSortDirection, false);
            } else {
                isSearching = true;
                loadTableData(recordsPerPage, 1, currentSortColumn, currentSortDirection, isSearching);
                
            }
        });

        $('#resetBtn').click(function() {
            $('#fuser-data')[0].reset();
            $('#hideRecords').show();
            isSearching = false;
            loadTableData(recordsPerPage, 1, currentSortColumn, currentSortDirection, isSearching);
        })

        $('#togglePassword').click(function() {
            const type = $('#userPswd').attr('type') === 'password' ? 'text' : 'password';
            $('#userPswd').attr('type', type);
            if(type=='text') {
                $(this).attr('src', '<?php echo base_url('icons/eye-slash-alt.svg') ?>');
            }else {
                $(this).attr('src', '<?php echo base_url('icons/eye-alt.svg') ?>');
            }
        });
    });

    function loadTableData(records='2', current_page=1, currentSortColumn='id', currentSortDirection='DESC', isSearching) {
        console.log(isSearching);
        const offset = (current_page - 1) * records;
        const data = {
            type: isSearching ? 'searchUser' : 'fetchData',
            col: currentSortColumn,
            direction: currentSortDirection,
            limit: records,
            page: current_page,
            offset: offset
        };

        if (isSearching) {
            data.fuserName = $('#fuserName').val();
            data.fuserEmail = $('#fuserEmail').val();
            data.fuserPhone = $('#fuserPhone').val();
        }


        $.ajax({
            url: isSearching ? 'usermaster/searchUser' : 'usermaster/fetchData',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(data) {
                console.log(data);
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
                
                setPagination(data.total_records, currentPage, isSearching);
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

    function appendDataInTable(row) {
        const tbody = $('#data-table tbody');
        const tr = $('<tr>').attr('data-id', row.id);
        tr.html(`
            <td>${Sno}</td>
            <td><a onclick="editEntry(${row.id})" class="text-decoration-none" role="button" >${row.id}</a></td>
            <td><a onclick="editEntry(${row.id})" class="text-decoration-none" role="button" >${row.name}</a></td>
            <td>${row.email}</td>
            <td>${row.phone}</td>
            <td>
                <ul class="list-inline m-0">
                    <li class="list-inline-item">
                        <button class="btn btn-sm rounded-0" data-toggle="tooltip" title="Edit" data-placement="top" onclick="editEntry(${row.id})"><img src="<?php echo base_url('icons/pencil-square.svg') ?>"></button>
                    </li>
                    <li class="list-inline-item">
                        <button class="btn btn-sm rounded-0" data-toggle="tooltip" title="Delete" data-placement="top" onclick="deleteEntry(${row.id}, '${row.name}')"><img src="<?php echo base_url('icons/trash.svg') ?>"></button>
                    </li>
                </ul>
            </td>
        `);
        tbody.append(tr);
        console.log(`Appended row for ID: ${row.id}`);
    }

    function editEntry(id) {
        $.ajax({
            url: 'usermaster/editEntry',
            type: 'post',
            data: {
                type: 'editEntry',
                id: id
            },
            dataType: 'json',
            success: function(data) {
                $('#userId').val(data[0].id);
                $('#userName').val(data[0].name);
                $('#userEmail').val(data[0].email);
                $('#userPhone').val(data[0].phone);
                // $('#userPswd').val(data[0].password);
                $('#userSubmit').text('Update');
                $('#nav-form-tab').text('Edit User');
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
                            url: 'usermaster/deleteData',
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
                                    toastr.error("Already logined can't be deleted!");
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
        $('#userSubmit').text('Submit');
    }

    function clearFormId() {
        $('#userId').val('');
    }

    $('#resetForm').on('click', function() {
        $('#user-data')[0].reset();
        $('.error').hide();
        $('#nav-form-tab').text('Add User');
        clearSubmit();
        clearFormId();
    });
</script>  
<script src="<?php echo base_url('application/views/scripts/validation.js') ?>"></script>  
</body>
</html>



