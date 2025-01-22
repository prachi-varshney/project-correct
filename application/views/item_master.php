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
    <title>Item Master</title>
    <!-- <link rel="stylesheet" href="style1.css"> -->
    <link rel="stylesheet" href="<?php echo base_url('styles/styles.css'); ?>">
    <link rel="stylesheet" 
          href="<?php echo base_url('styles/style1.css'); ?>">
    <?php $this->load->view('cdn_files'); ?>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap');
        * {
            font-family: "Lato", sans-serif;
            font-size: 13px;
        }
        #backgroundImg {
            background-image: url('<?php echo base_url('images/background2.jpg') ?>') !important;
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
            max-height: 250px;
            width: 100%;
            overflow-y: auto;
            display: block;
            /* border: 1px solid red; */
        }

        @media screen and (max-width: 772px) {
            #backgroundImg {
                width: 80%;
                height: 140%;
            }

        }
        @media screen and (max-width: 1350px){
            #itemPic, #currentImage, div#imgDel {
                width: 20px;   
            }
            #currentImage {
                height: 20px;
            }
        }        

    </style>
</head>
<body>
<div class="container-fluid p-0 d-flex h-100">
    <?php $this->load->view('navsidebar/sidebar'); ?>

    <div class="bg-secondary flex-fill" id="backgroundImg"> 
        <?php 
        $this->load->view('navsidebar/nav');
        $this->load->view('item'); ?>
    </div>
</div>
<?php $this->load->view('foot'); ?>
<script>
    let Sno = 0;
    let currentSortColumn = 'id';
    let currentSortDirection = 'DESC';
    var recordsPerPage = 2;
    let currentPage = 1;
    var isSearching = false;
    let totalPages = 1;
    $(document).ready(function() {
        loadTableData(recordsPerPage, currentPage, currentSortColumn, currentSortDirection, isSearching);

        $('#nav-table-tab').click(function() {
            $('#item-data')[0].reset();
            $('#nav-form-tab').text('Add Item');
            clearSubmit();
            clearImage();
            clearId();
            $('#resetForm').show();
        });

        $('#data-table th[data-column]').click(function() {
            currentSortColumn = $(this).data('column');
            currentSortDirection = currentSortDirection=='DESC' ? 'ASC' : 'DESC';
            loadTableData(recordsPerPage, currentPage, currentSortColumn, currentSortDirection, isSearching);
        });

        $('#tableLimit').on('change', function() {
            recordsPerPage = $('#tableLimit option:selected').val();
            loadTableData(recordsPerPage, 1, currentSortColumn, currentSortDirection, isSearching);
        });

        $('#pageInfo').on('click', '#prevPage', function() {
            if(currentPage>1) {
                currentPage--;
                loadTableData(recordsPerPage, currentPage, currentSortColumn, currentSortDirection, isSearching);
            }
        });
        
        $('#pageInfo').on('click', '#nextPage', function() {
            if(currentPage<totalPages) {
                currentPage++;
                loadTableData(recordsPerPage, currentPage, currentSortColumn, currentSortDirection, isSearching);
            }
        });

        $('#pageInfo').on('click', '#firstPage', function() {
            loadTableData(recordsPerPage, 1, currentSortColumn, currentSortDirection, isSearching);
        });

        $('#pageInfo').on('click', '#lastPage', function() {
            loadTableData(recordsPerPage, totalPages, currentSortColumn, currentSortDirection, isSearching);
        });

        $('#item-data').on('submit', function(event) {
            event.preventDefault();
            if($('.error:visible').length > 0) {
                toastr.error('Fix the errors!');
            } else {
                const formdata = new FormData(this);
                formdata.append('type', 'insert_update');

                const formFields = ['itemName', 'itemDesc', 'itemPrice'];
                var isValid = true;
                formFields.forEach(function(key){
                    if($('#' + key).val() == '') {
                        isValid = false;
                        return false;
                    }
                });
                var image = $('#itemImage').val();
                var itemid = $('#itemId').val();
                if(isValid && (image|| itemid!='')) {
                    $.ajax({
                        url: 'itemmaster/insertOrUpdate',
                        type: 'post',
                        data: formdata,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        success: function(data) {   
                            console.log(data);
                            if(data.success) {
                                if(data.update) {
                                    // updateDataInTable(data.data);
                                    loadTableData(recordsPerPage, currentPage, currentSortColumn, currentSortDirection, isSearching);
                                    toastr.success('Item Updated!');
                                } else {
                                    // appendRowInTable(data.data);
                                    loadTableData(recordsPerPage, currentPage, currentSortColumn, currentSortDirection, isSearching);
                                    toastr.success('Item added successfully!');
                                }
                                switchTotab('nav-table-tab');
                                $('#nav-form-tab').text('Add Item');
                                $('#item-data')[0].reset();
                                clearSubmit();
                                clearId();
                                clearImage();
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
                                // toastr.error(data.error);
                            }
                        }, error: function(error) {
                            console.error('error:', error);
                        }
                    });
                } else {
                    toastr.error('All fields are required!');
                }
            }

        });

        $('#fitem-data').on('submit', function(event) {
            event.preventDefault();
            // $('#hideRecords').show();
            if($('#fitemName').val() == '' && $('#fitemDesc').val() == '' && $('#fitemPrice').val() == '') {
                loadTableData(recordsPerPage, 1, currentSortColumn, currentSortDirection, false);
            } else {
                isSearching = true;
                loadTableData(recordsPerPage, 1, currentSortColumn, currentSortDirection, isSearching);
            }
        });

        $('#resetBtn').click(function() {
            $('#fitem-data')[0].reset();
            $('#hideRecords').show();
            isSearching = false;
            loadTableData(recordsPerPage, currentPage, currentSortColumn, currentSortDirection, isSearching);
        });

        $('#itemImage').on('change', function() {
            const file = this.files[0];
            // console.log(file);
            if(file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#currentImage').attr('src', e.target.result).show();
                    $('#imgName').text(file.name).show();
                    $('#imgDel').show();
                };
                reader.readAsDataURL(file);
            }
        });

    });

    function loadTableData(records='2', current_page=1, currentSortColumn='id', currentSortDirection='DESC', isSearching=false) {
        const offset = (current_page-1) * records;
        const data = {
            type: isSearching ? 'search_user' : 'fetch_data',
            col:currentSortColumn,
            direction: currentSortDirection,
            limit: records,
            page: current_page,
            offset: offset
        };

        if(isSearching) {
            data.fName = $('#fitemName').val();
            data.fDesc = $('#fitemDesc').val();
            data.fPrice = $('#fitemPrice').val();
        }

        $.ajax({
            url: isSearching ? 'itemmaster/searchUser' : 'itemmaster/fetchData',
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
                    appendRowInTable(row);
                });

                totalPages = Math.ceil(data.total_records / records);
                if(current_page == totalPages) {
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

            }, error: function(error) {
                console.error('Error: ', error);
                alert('An error occurred while fetching the data!');
            }
        });
    }

    function setPagination(total_records, currentPage, isSearching) {
        $('#pageInfo').html('');
        totalPages = Math.ceil(total_records / recordsPerPage);
        for(let i=1; i<=totalPages; i++) {
            if(i==1 && i!=totalPages) {
                const prevBtn = $('<li></li>').addClass('page-item').html($('<a></a>').addClass('page-link').attr({ href: 'javascript:void(0);', id: 'prevPage'}).html($('<span></span>').attr('aria-hidden', 'true').html('&laquo;')));
                $('#pageInfo').append(prevBtn);
                const firstBtn = $('<li></li>').addClass('page-item').html($('<a></a>').addClass('page-link').attr({href: 'javascript:void(0);', id: 'firstPage'}).text('First'));
                $('#pageInfo').append(firstBtn);

            }
            const paginBtn = $('<li></li>').addClass('page-item').html($('<a></a>').addClass('page-link').attr('href', 'javascript:void(0);').text(i));

            if(i==currentPage) {
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


    function appendRowInTable(data) {
        const tbody = $('#data-table tbody');
        const tr = $('<tr>').attr('data-id', data.id);
        // console.log(data);
        tr.html(`
            <td>${Sno}</td>
            <td><a onclick="editEntry(${data.id})" class="text-decoration-none" role="button" >${data.id}</a></td>    
            <td><a onclick="editEntry(${data.id})" class="text-decoration-none" role="button" >${data.name}</a></td>   
            <td>${data.description}</td>    
            <td style="text-align: right;">${data.price}</td>    
            <td>${data.imagepath ? `<a href="<?php echo base_url('uploads/') ?>${data.imagepath}" target="_blank"><img src="<?php echo base_url('uploads/') ?>${data.imagepath}" alt="Item image" style="width: 35px; height: 35px; border-radius: 5px;"></a>` : ""}</td>    
            <td>
                <ul class="list-inline">
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
    }


    function editEntry(id) {
        $.ajax({
            url: 'itemmaster/editEntry',
            type: 'post',
            data: {
                type: 'editEntry',
                id : id
            },
            dataType: 'json',
            success: function(data) {
                // console.log(data[0]['name']);
                $('#itemId').val(data[0]['id']);
                $('#itemName').val(data[0]['name']);
                $('#itemDesc').val(data[0]['description']);
                $('#itemPrice').val(data[0]['price']);

                const image = data[0]['imagepath'];
                if(image) {
                    $('#current_image').val(image);
                    const imageURL = `<?php echo base_url('uploads/') ?>${image}`;
                    // console.log(imageURL);
                    $('#currentImage').attr('src', imageURL).show();
                    $('#imgName').text(image).show();
                    $('#imgDel').show();
                } else {
                    $('#currentImage').hide();
                    $('#imgName').hide();
                    $('#imgDel').hide();
                }
                switchTotab('nav-form-tab');
                $('#itemSubmit').text('Update');
                $('#nav-form-tab').text('Edit Item');
                $('#resetForm').hide();
            }
        });
    }


    function deleteEntry(id, name) {
        $.confirm({
            theme: 'material',
            title: 'Delete Item?',
            content: `Are you sure you want to delete <b>${name}</b>?`,
            autoClose: 'cancel|8000',
            buttons: {
                deleteItem: {
                    text: `delete item`,
                    btnClass: 'btn-danger',
                    action: function () {
                        $.ajax({
                            url: 'itemmaster/deleteItem',
                            type: 'post',
                            data: {
                                type: 'delete_item',
                                id: id
                            },
                            dataType: 'json',
                            success: function(data) {
                                console.log(data);
                                if(data.success) {
                                    $(`#data-table tr[data-id='${id}']`).remove();
                                    // $.alert(`You deleted <b>${name}</b>`);
                                    toastr.success(`You deleted <b>${name}</b>`);
                                    loadTableData(recordsPerPage, currentPage, currentSortColumn, currentSortDirection, isSearching);
                                } else {
                                    if(data.error_code=='1451') {
                                    toastr.error('Item is in Invoice!', 'Failed');
                                    } else {
                                        toastr.error('Something went wrong!');
                                    }
                                }
                            },
                            error: function(error) {
                                console.error('Error: ', error);    
                                toastr.error('Delete Unsuccessful');
                            }
                        });                    
                    }
                },
                cancel: function () {
                    text: 'cancel'
                    toastr.info(`<b>${name}</b> just got saved!`);
                }
            }
        });
    }

    function switchTotab(id) {
        $(`#${id}`).tab('show');
    }

    function clearId() {
        $('#itemId').val('');
    }

    function clearSubmit() {
        $('#itemSubmit').text('Submit');
    }

    function imageDelete() {
        $('#itemImage').val('');
        $('#currentImage').attr('src', '').hide();
        $('#imgName').hide();
        $('#imgDel').hide();

        $('#current_image').val('');
    }

    function clearImage() {
        $('#currentImage').hide();
        $('#imgName').hide();
        $('#imgDel').hide();
    }


    $('#resetForm').on('click', function() {
        $('#item-data')[0].reset();
        $('.error').hide();
        $('#nav-form-tab').text('Add Item');
        clearSubmit();
        clearImage();
        clearId();
    });
</script>
<script src="<?php echo base_url('application/views/scripts/validation.js'); ?>"></script>
    
</body>
</html>