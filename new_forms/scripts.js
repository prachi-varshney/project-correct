let currentRowCount = 0;
let currentSortColumn = 'id';
let currentSortDirection = 'asc';
$(document).ready(function() {

    let currentPage = 1;
    const recordsPerPage = 5;
    loadTableData(currentPage, recordsPerPage, currentSortColumn, currentSortDirection);
    loadStateData();
    loadPassword(10, 'Raunak@1234');

    $('#togglePassword').click(function() {
        const type = $('#password').attr('type')==='password' ? 'text': 'password';
        $('#password').attr('type', type);
        if(type=='text') {
            $(this).attr('src', 'icons/eye-slash-alt.svg');
            // $(this).attr('class', 'far fa-eye-slash');
        }else {
            $(this).attr('src', 'icons/eye-alt.svg');
            // $(this).attr('class', 'far fa-eye');
        }
        // $(this).toggleClass('fa-eye fa-eye-slash');
    });

    $('#password').blur(function() {
        $(this).attr('type', 'password');
        $('#togglePassword').attr('src', 'icons/eye-alt.svg');
    });


   // $('#data-table').DataTable();

    $('#data-table th span').click(function() {
        currentSortColumn = $(this).data('column');
        currentSortDirection = $(this).hasClass('asc')? 'desc' : 'asc';

        $(this).removeClass('asc desc');
        $(this).addClass(currentSortDirection);
        loadTableData(currentPage, recordsPerPage, currentSortColumn, currentSortDirection);
    });

    
    
    
    $('#nav-table-tab').click(function() {
        loadTableData(currentPage, recordsPerPage, currentSortColumn, currentSortDirection);
    });

    $('#nav-form-tab').click(function() {
        $('#form-data')[0].reset();
        clearFormId();
        clearSubmit();   
        clearImage();
        clearImgName(); 
        hideInput();
    });

    $('#state').on('change', function() {
        const state_id = $(this).val();
        if(state_id) {
            loadCityData(state_id);
        } else {
            $('#city').empty();
            $('#city').append('<option value="">Select a City</option>')
        }
    });

    $('#form-data').on('submit', function(event) {
        event.preventDefault();
        if ($('.error:visible').length > 0) {
            alert('Please fix the errors before submitting the form.');
        }
        else{
            const formData = new FormData(this);

            $.ajax({
                url: 'submit_data.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(data) {
                    if(data.success) {
                        if(data.update) {
                            updateRowInTable(data);
                        } else {
                            appendRowToTable(data);
                            loadTableData(currentPage, recordsPerPage, currentSortColumn, currentSortDirection);
                        }
                        switchToTab('nav-table-tab');
                    } else {
                        alert(data.error || 'Failed to submit data.');
                    }
                    console.log(data.error);
                    $('#form-data')[0].reset();
                    clearFormId();
                    clearSubmit();   
                    clearImage();
                    clearImgName(); 
                    hideInput();
                },
                error: function (error) {
                    console.error('Error:', error);
                // alert('An error occured while submitting the data.');
                }
            });

        }
        
    });

        $('#profile').on('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    $('#currentImage').attr('src', e.target.result).show();
                    $('#imgName').text(file.name).show();
                    $('#imgDel').show();
                };
                reader.readAsDataURL(file);
            }
        });

        $('#otherhobby').on('change', function () {
            
            if(this.checked) {
                $('#inputContainer').slideDown();
            }
            else {
                $('#textInput').val('');
                $('#inputContainer').slideUp();        
            }
        });

});


function loadTableData(pageNum, records, column, direction) {
    const offset = (pageNum-1) * records;
    $.ajax({
        url: 'fetch_data.php',
        type: 'POST',
        data: {page: pageNum, limit: records, column:column, direction: direction},
        dataType: 'json',
        success: function (data) {
            currentRowCount = offset + 1;
            const tbody = $('#data-table tbody');
            tbody.empty();
            data.data.forEach(row => {
                appendRowToTable(row);
                ++currentRowCount;
            });
            setPagination(data.current_page, data.total_pages);
        },
        error: function (error) {
            console.error('Error:', error);
            alert('An error occurred while fetching the data.');
        }
    });
}

function setPagination(current_page, total_pages) {
    $('#pagination').html('');
    const records = 5;
    for(let i=1; i <= total_pages; i++) {
        const paginBtn = $('<button></button>').addClass('btn btn-secondary m-1').text(i);
        if(i==current_page) {
            paginBtn.addClass('active');    
        } 
        paginBtn.click(function() {
            loadTableData(i, records, currentSortColumn, currentSortDirection);
        });
        $('#pagination').append(paginBtn);
    }
}

function loadStateData() {
    $.ajax({
        url: 'fetch_states.php',
        type: 'POST',
        dataType: 'json',
        success: function (data) {
            const stateSelect = $('#state');
            stateSelect.empty();
            stateSelect.append('<option value="">Select a state</option>');
            data.forEach(state => {
                stateSelect.append(`<option value="${state.state_id}">${state.state_name}</option>`);
            });
        },
        error: function (error) {
            console.error('Error:', error);
            alert('An error occurred while fetching the state data.');
        }
    });
}


// function loadCityData(id) {
//     $.ajax({
//         url: `fetch_cities_by_state.php?state_id = ${id}`,
//         type: 'GET',
//         dataType: 'json',
//         success: function (data) {
//             const citySelect = $('#city');
//             citySelect.empty();
//             citySelect.append('<option value="">Select a city</option>');
//             data.forEach(city=> {
//                 citySelect.append(`<option value="${city.district_id}">${city.district_name}</option>`)
//             });
//         }
//     });
// }


function loadCityData(stateId, callback) {
    $.ajax({
        url: 'fetch_cities_by_state.php',
        type: 'POST',
        data: { state_id: stateId },
        dataType: 'json',
        success: function (data) {
            const citySelect = $('#city');
            citySelect.empty();
            citySelect.append('<option value="">Select a city</option>');
            data.forEach(city => {
                citySelect.append(`<option value="${city.district_id}">${city.district_name}</option>`);
            });
            if(callback) {
                callback();
            }
        },
        error: function (error) {
            console.error('Error:', error);
            alert('An error occurred while fetching the city data.');
        }
    });
}


function appendRowToTable(row) {
    const recordsPerPage = 5;
    const tbody = $('#data-table tbody');
    // const rowCount = tbody.children('tr').length + i;
    const sNum = currentRowCount;
    const tr = $('<tr>').attr('data-id', row.id);
    tr.html(`
        <td>${sNum}</td>
        <td>${row.id}</td>
        <td>${row.name}</td>
        <td>${row.email}</td>
        <td>${row.phone}</td>
        <td>${row.dob}</td>
        <td>${row.Address}</td>
        <td>${row.experience}</td>
        <td>${row.salary}</td>
        <td>${row.hobbies}</td>
        <td>${row.gender}</td>
        <td>${row.bio}</td>
        <td>${row.profile ? `<a href = "uploads/${row.profile}" target="_blank"><img src="uploads/${row.profile}" alt="Profile Image" style="width: 50px; height: 50px; border-radius: 5px;"></a>` : ""}</td>
        
        <td>
            <ul class="list-inline m-0">
                <li class="list-inline-item">
                    <button class="btn btn-sm rounded-0" data-toggle="tooltip" title="Edit" data-placement="top" onclick="editEntry(${row.id})"><img src="icons/pencil-square.svg"></button>
                </li>
                <li class="list-inline-item">
                    <button class="btn btn-sm rounded-0" data-toggle="tooltip" title="Delete" data-placement="top" onclick="deleteEntry(${row.id})"><img src="icons/trash.svg"></button>
                </li>
            </ul>
        </td>
    `);
    tbody.append(tr);
        // ++currentRowCount;
    // const totalRows = $('#data-table tbody tr').length;

    // if(totalRows % recordsPerPage === 0) {
    //     const newPage = Math.ceil(totalRows/recordsPerPage);
    //     loadTableData(newPage, recordsPerPage);
    // }
    console.log(`Appended row for ID: ${row.id}`);
}

function updateRowInTable(data) {
    const row =$(`#data-table tr[data-id='${data.id}']`);
    if(row.length) {
        // const rowIndex = row.index() + 1;
        row.html(`
            <td>${row.find('td:first').text()}</td>
            <td>${data.id}</td>
            <td>${data.name}</td>
            <td>${data.email}</td>
            <td>${data.phone}</td>
            <td>${data.dob}</td>
            <td>${data.Address}</td>
            <td>${data.experience}</td>
            <td>${data.salary}</td>
            <td>${data.hobbies}</td>
            <td>${data.gender}</td>
            <td>${data.bio}</td>
            <td>${data.profile ? `<a href="uploads/${data.profile}" target="_blank"><img src="uploads/${data.profile}" alt="Profile Image" style="width: 50px; height: 50px; border-radius: 5px;"></a>` : ''}</td>
            
            <td>
                <ul class="list-inline m-0">
                    <li class="list-inline-item">
                        <button class="btn btn-sm rounded-0" data-toggle="tooltip" title="Edit" data-placement="top" onclick="editEntry(${data.id})"><img src="icons/pencil-square.svg"></button>
                    </li>
                    <li class="list-inline-item">
                        <button class="btn btn-sm rounded-0" data-toggle="tooltip" title="Delete" data-placement="top" onclick="deleteEntry(${data.id})"><img src="icons/trash.svg"></button>
                    </li>
                </ul>
            </td>
        `);
        
        console.log(`Updated row for ID: ${data.id}`);
    }  else {
        console.error(`Row with ID ${data.id} not found`);
    }
}


// function updateSerialNumbers() {
//     $('#data-table tbody tr').each(function(index) {
//         $(this).find('td:first').text(index + 1); // Update the S.No column      
//     });
// }

function editEntry(_id) {
    $.ajax({
        url: `get_entry.php`,
        type: 'POST',
        data: {id : _id},
        dataType: 'json',
        success: function (data) {
            if (data.success) {
                const entry = data.entry;
                $('#id').val(entry.id);
                $('#name').val(entry.name);
                // $('#password').val(entry.password);
                $('#email').val(entry.email);
                $('#phone').val(entry.phone);
                $('#dob').val(entry.dob);
                $('#address').val(entry.address);

                $('#state').val(entry.state_id);
                loadCityData(entry.state_id, function() {
                });

                // $('#city').val(entry.district_id);

                console.log(entry.city);
                // $('#state').val(entry.state_id);
                console.log(entry.state);
                $('#pincode').val(entry.pincode);
                $('#country').val(entry.country);
                $('#experience').val(entry.experience);
                $('#salary').val(entry.salary);
                
                const hobbies = entry.hobbies.split(", ");
                $('[name="hobbies[]"]').each(function() {
                    $(this).prop('checked', hobbies.includes($(this).val()))
                });

                if(entry.otherhobby !== "" && entry.otherhobby !== null) {
                    $('#otherhobby').prop('checked', true);
                    $('#inputContainer').show();
                    $('#textInput').val(entry.otherhobby);
                }
                else {
                    $('#textInput').val('');
                    $('inputContainer').hide();
                }
                console.log(entry.otherhobby);

                $(`input[name='gender'][value='${entry.gender}']`).prop('checked', true);
                $('#bio').val(entry.bio);

                if (entry.profile) {
                    $('#current_image').val(entry.profile);                   
                    const imageUrl = `uploads/${entry.profile}`;
                    $('#currentImage').attr('src', imageUrl).show();
                    $('#imgName').text(entry.profile).show();
                } else {
                    $('#currentImage').hide();
                    $('#imgName').hide();
                }
                
                console.log(entry.profile);
                $('#submit').text('Update');
                switchToTab('nav-form-tab');
                
                // $('#nav-form-tab').click(function() {
                //     $('#form-data')[0].reset();
                // });
                
            
            } else {
                alert('failed to load entry data.');
            }
        },
        error: function(error) {
            console.error('Error:', error);
            alert('An error occurred while loading the entry data.');
        }
    });
}

function deleteEntry(id) {
    if(confirm('Are you sure you want to delete!')) {
        $.ajax({
            url: `delete_entry.php?id=${id}`,
            type:'DELETE',
            dataType: 'json',
            success: function(data) {
                if(data.success) {
                    $(`#data-table tr[data-id='${id}']`).remove();
                    loadTableData(currentPage, recordsPerPage, currentSortColumn, currentSortDirection);
                } else {
                    alert(data.message || 'Failed to delete entry');
                }
            },
            error: function(error) {
                console.error('Error:', error);
                alert('The alert occurred while deleting the entry.');
            }
        });
    }
}

function clearFormId() {
    $('#id').val('');
}

function clearSubmit() {
    $('#submit').text('Submit');
}

function switchToTab(tabId) {
    $(`#${tabId}`).tab('show');
}

function clearImage() {
    $('#currentImage').hide();
}

function clearImgName() {
    $('#imgName').hide();
}

function hideInput() {
    // if($('#textInput').prop('checked', false)) {
    // }
    // $('#textInput').hide();

    if($('#textInput').checked) {
        $('#inputContainer').slideDown();
    }
    else {
        $('#textInput').val('');
        $('#inputContainer').slideUp();
        
    }
}


function loadPassword(_id, password) {
    $.ajax({
        url: 'password_chk.php',
        type: 'POST',
        data: {id: _id, password: password},
        // dataType: 'json',
        success: function(data) {
            console.log(data);  
        },
        error: function(error) {
            console.error("Error password:", error);
            alert('password error');
        }
    });
}







