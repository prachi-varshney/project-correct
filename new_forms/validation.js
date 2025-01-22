$(document).ready(function() {

    
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

    $('#password').on('input', function() {
        const passVal = $('#password').val();
        const passErr = $('#passErr');

        // if(passVal.length>)
    
        if(!/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,15}$/.test(passVal)) {
            $('#passErr').text("Min 8 chars, max 15 chars at least one Upper, Lower, number, special char needed!");
            passErr.show();
        }
        else {    
            passErr.hide();
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


    $('#phone').on('input', function() {
        const phoneVal = $('#phone').val();
        const phoneErr = $('#phoneErr');
        const maxDigits = /^0/.test(phoneVal) ? 11 : 10;

        if(phoneVal.length > maxDigits) {
            $(this).val(phoneVal.substring(0, maxDigits));
            // $(this).val(nameVal.replace(/[^a-zA-Z ]/g, ''));
            // phoneErr.show();
        } else if(/\D/.test(phoneVal)) {
            // phoneErr.show();
            $(this).val(phoneVal.replace(/\D/, ""));
        } else if(phoneVal.length<10) {
            phoneErr.show();
        }
        else {
            phoneErr.hide();
        }
       
    });

    $('#dob').on('input', function() {
        const dobVal = new Date($('#dob').val());
        const dobErr = $('#dobErr');

        var d = new Date();
        var d2 = new Date('1900');
        // console.log(d2);
        // console.log(new Date(dobVal));
        if(dobVal> d || dobVal< d2) {
            dobErr.show();
        }
        else {
            dobErr.hide();
        }
    });


    $('#pincode').on('input', function() {
        const pinVal = $('#pincode').val();
        const pinErr = $('#pinErr'); 
        
        if(pinVal.length > 6) {
            $(this).val(pinVal.substring(0, 6));
        }
        else if(/^[1-9][0-9]{5,}$/.test(pinVal)) {
            pinErr.hide();
        } else if(/\D/.test(pinVal)) {
            // pinErr.show();
            $(this).val(pinVal.replace(/\D/, ""));
        }
        else {
            pinErr.show();  
        }
    });

    $('#experience').on('input', function() {
        const expVal = $('#experience').val();
        const expErr = $('#expErr');

        if(/^[- ]*$/.test(expVal)) {
            $(this).val(expVal.replace(/^[- ]/, ""));
        } else if(!/^\d*\.?\d?$/.test(expVal)) {
            // expErr.show();
            $(this).val(expVal.replace(/(\.\d{1})\d+$/, "$1"));
        }
        if(expVal>100) {                            // /^[1-9][0-9]{0,2}/.test(expVal)
            $(this).val("");
            // expErr.text('Must be less than 100!');
            // expErr.show();
        }
        // else {
        //     expErr.hide();
        // }


    });

    $('#salary').on('input', function() {
        const salVal = $('#salary').val();

        if(/^[- ]*$/.test(salVal)) {
            $(this).val(salVal.replace(/^[- ]/, ""));
        } 
        if(!/^\d*\.?\d{0,2}$/.test(salVal)) {
            $(this).val(salVal.replace(/(\.\d{2})\d+$/, "$1"));  
        }
    });




    $('#textInput').on('input', function() {
        const hobbVal = $('#textInput').val();
        const hobErr = $('#hobErr');

        if(!/^[a-zA-Z, ]*$/.test(hobbVal)) {
            $(this).val(hobbVal.replace(/[^a-zA-Z, ]/, ""));   
        } 
    });




});