let currentRowCount = 0;
let currentPage = 1;
let totalPages = 1;
let currentSortColumn = 'id';
let currentSortDirection = 'asc';
const recordsPerPage = 5;
$(document).ready(function() {

    loadTableData(currentSortColumn, currentSortDirection, currentPage, recordsPerPage);
    loadStateData();


    $('#data-table th img').click(function() {
        currentSortColumn = $(this).data('column');
        currentSortDirection = $(this).hasClass('asc')? 'desc' : 'asc';

        $(this).removeClass('asc desc');
        $(this).addClass(currentSortDirection);
        loadTableData(currentSortColumn, currentSortDirection, currentPage, recordsPerPage);
    });


    $('#prevPage').click(function() {
        if(currentPage>1) {
            currentPage--;
            loadTableData(currentSortColumn, currentSortDirection, currentPage, recordsPerPage);
        }
    });
    
    $('#nextPage').click(function() {
        if(currentPage < totalPages)
        currentPage++;
        loadTableData(currentSortColumn, currentSortDirection, currentPage, recordsPerPage);
    });

    $('#name').on('input', function() {
        const nameVal = $('#name').val();
        const nameErr = $('#nameErr');

        if(/[^a-zA-Z ]/.test(nameVal)) {
            // nameErr.show();
            $(this).val(nameVal.replace(/[^a-zA-Z ]/g, ''));
        }else {
            nameErr.hide();
        }

    });

    $('#phone').on('input', function() {
        const phoneVal = $('#phone').val();
        const phoneErr = $('#phoneErr');
        const maxDigits = /^0/.test(phoneVal) ? 11 : 10;

        if(phoneVal.length > maxDigits) {
            // $(this).val(phoneVal.substring(0, maxDigits));
            phoneErr.show();
        } else if(/\D/.test(phoneVal)) {
            // phoneErr.show();
            $(this).val(phoneVal.replace(/\D/, ""));
        } 
        else {
            phoneErr.hide();
        }
       
    });


    $('#email').on('input', function() {
        const emailVal = $('#email').val();
        const emailErr = $('#emailErr');
        
        if (!/^[\w]+(\.[\w]+)*@([\w]+\.)+[a-zA-Z]{2,7}$/.test(emailVal)) {
            emailErr.show();
        } else {
            emailErr.hide();
        }
    });

    $('#pincode').on('input', function() {
        const pinVal = $('#pincode').val();
        const pinErr = $('#pinErr'); 
        
        if(/^[1-9][0-9]{0,5}$/.test(pinVal)) {
            pinErr.hide();
        } else if(/\D/.test(pinVal)) {
            // pinErr.show();
            $(this).val(pinVal.replace(/\D/, ""));
        } 
        else {
            pinErr.show();  
        }
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
                alert('An error occured while submitting the data.');
            }
        });
    });

        $('#profile').on('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    $('#currentImage').attr('src', e.target.result).show();
                    $('#imgName').text(file.name).show();
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


function loadTableData(columns, directions, page, limit) {
    const offset = (page-1)* limit;
    $.ajax({
        url: 'fetch_data.php',
        type: 'POST',
        data: {column : columns, direction : directions, page : page, limit: limit},
        dataType: 'json',
        success: function (data) {
            currentRowCount = offset + 1;
            const tbody = $('#data-table tbody');
            tbody.empty();
            data.records.forEach(row => {
                appendRowToTable(row);
                ++currentRowCount;
            });
            setPagination(data.totalRecords, page, limit);
        }, 
        error: function (error) {
            console.error('Error:', error);
            alert('An error occurred while fetching the data.');
        }
    });
}

function setPagination(totalRecords, page, limit) {
    totalPages = Math.ceil(totalRecords / limit);
    if(page<=totalPages) {
        $('#pageInfo').text(`Page ${page} of ${totalPages}`);
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


function loadCityData(stateId, myfunction) {
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
            myfunction();
        },
        error: function (error) {
            console.error('Error:', error);
            alert('An error occurred while fetching the city data.');
        }
    });
}


function appendRowToTable(row) {
   
    const tbody = $('#data-table tbody');
    // const rowCount = tbody.children('tr').length + i;
    const sNum = currentRowCount;
    const tr = $('<tr>').attr('data-id', row.id);
    tr.html(`
        <td>${sNum}</td>
        <td>${row.id}</td>
        <td>${row.name}</td>
        <td>${row.password}</td>
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
    console.log(`Appended row for ID: ${row.id}`);
}

function updateRowInTable(data) {
    const row =$(`#data-table tr[data-id='${data.id}']`);
    if(row.length) {
        row.html(`
            <td>${row.find('td:first').text()}</td>
            <td>${data.id}</td>
            <td>${data.name}</td>
            <td>${data.password}</td>
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
                $('#password').val(entry.password);
                $('#email').val(entry.email);
                $('#phone').val(entry.phone);
                $('#dob').val(entry.dob);
                $('#address').val(entry.address);

                $('#state').val(entry.state_id);
                loadCityData(entry.state_id, function() {
                    $('#city').val(entry.district_id);
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








