$(document).ready(function() {
    $('#userName').on('input', function() {
        nameValid('#userName', '#userNameErr');
    });
    $('#fuserName').on('input', function() {
        nameValid('#fuserName', '');
    });
    $('#fuserPhone').on('input', function() {
        phoneValid('#fuserPhone', '');
    });
    $('#fclientName').on('input', function() {
        nameValid('#fclientName', '');
    });

    $('#fclientPhone').on('input', function() {
        phoneValid('#fclientPhone', '');
    });
    
    $('#cName').on('input', function() {
        nameValid('#cName', '#cNameErr');
    });

    $('#itemName').on('input', function() {
        nameValid('#itemName', '#itemNameErr');
    });
    $('#fitemName').on('input', function() {
        nameValid('#fitemName', '');
    });
    $('#fitemPrice').on('input', function() {
        const price = $(this).val();

        if(/[^0-9]/.test(price)) {
            $(this).val(price.replace(/[^0-9]/, ''));
        }
    });

    $('#userEmail').on('input', function() {
        emailValid('#userEmail', '#userEmailErr');
    });

    $('#cEmail').on('input', function() {
        emailValid('#cEmail', '#cEmailErr');
    });

    $('#userPhone').on('input', function() {
        phoneValid('#userPhone', '#userPhoneErr');        
    });

    $('#cPhone').on('input', function() {
        phoneValid('#cPhone', '#cPhoneErr');
    });

    $('#invoiceNo').on('input', function() {
        var invNo = $(this).val();
        if(invNo.length>4) {
            $(this).val(invNo.substr(0,4));
        }
        if(/[^0-9]/.test(invNo)) {
            $(this).val(invNo.replace(/[^0-9]/, ''));
        }
    });
    $('#finvoiceNo').on('input', function() {
        var invNo = $(this).val();
        if(/[^0-9]/.test(invNo)) {
            $(this).val(invNo.replace(/[^0-9]/, ''));
        }
    });

    $('#invoiceDate').on('input', function() {
        var invoicedate = new Date($(this).val());
        var dateErr = $('#dateErr');

        var d = new Date();
        var d2 = new Date('1900');

        if(invoicedate> d || invoicedate<d2) {
            dateErr.show();
        } else {
            dateErr.hide();
        }
    });

    // $('.quantity').on('input', function() {

    //     var qty = $(this).val();
    //     const pattern = /^[1-9]\d*$/;

    //     if(qty.length<1) {
    //         $(this).val(1);
    //     }
    //     if(!pattern.test(qty)) {
    //         $(this).val(qty.replace(/^(?!([1-9]\d*$)).*$/, '')); 
    //     }
    // });

    $('#loginEmail').on('focusout', function() {
        var email = $(this).val();
        var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        if(email.length<1) {
            $('#loginMailErr').text('Email required!').show();
        } else if(!emailPattern.test(email)) {
            $('#loginMailErr').text('invalid Email!').show();
        } else {
          $('#loginMailErr').hide();
        }
    });

    $('#loginEmail').on('input', function() {
        var email = $(this).val();
        if(email.length>0) {
            $('#loginMailErr').hide();
        } else {
            $('#loginMailErr').show();
        }
    });

    $('#loginPswd').on('focusout', function() {
    var pswd = $(this).val();
    if(pswd.length<1) {
        $('#loginPswdErr').text('Password required!').show();
    } else {
        $('#loginPswdErr').hide();
    }
    });

    // $('#cPincode').on('input', function() {
    //     const pincode = $(this).val();
    //     const pinErr = $('#cPinErr');

    //     if(pincode.length>6) {
    //         $(this).val(pincode.substr(0,6));
    //     }
    //     if(pincode.length<6) {
    //         pinErr.show();
    //     } else {
    //         pinErr.hide();
    //     }
    //     if(/[^0-9]/.test(pincode)|| pincode=='') {
    //         $(this).val(pincode.replace(/[^0-9]/, ''));
    //         pinErr.hide();
    //     }
    //     // if(pincode=='') {
    //     //     pinErr.hide();
    //     // }
    // });

    $('#cPincode').on('input', function() {
        const pincode = $(this).val();
        const pinErr = $('#cPinErr');

        if(pincode.length>=6) {
            $(this).val(pincode.substr(0,6));
            pinErr.hide();
        } else {
            pinErr.show();
        }
        if(/[^0-9]/.test(pincode)) {
            $(this).val(pincode.replace(/[^0-9]/, '')); 
            pinErr.hide();
        }

        if(pincode.length<6) {
            pinErr.show();
        } 
        if(pincode=='' || (/[^0-9]/.test(pincode))) {
            pinErr.hide();
        }

    });


    $('#userPswd').on('input', function() {
        passValid('#userPswd', '#userPassErr');
    });

    // $('#itemPrice').on('input', function() {
    //     const price = $(this).val();
    //     const priceErr = $('#priceErr');

    //     if(/[^0-9]/.test(price)) {
    //         $(this).val(price.replace(/[^0-9.]/, ''));
    //     }
    //     if(price.length>10) {
    //         $(this).val(price.substr(0,10));
    //     }

    // });

    $('#itemPrice').on('input', function() {
        let price = $(this).val();
        const priceErr = $('#priceErr');
    
        price = price.replace(/[^0-9.]/g, '');
        
        const decimalIndex = price.indexOf('.');
        if (decimalIndex !== -1) {
            const integerPart = price.slice(0, decimalIndex);
            let decimalPart = price.slice(decimalIndex + 1).replace(/\./g, '');
            decimalPart = decimalPart.slice(0, 2); 
            price = integerPart + '.' + decimalPart;
        }
    
        if (decimalIndex === -1) {
            price = price.slice(0, 10);
        } else {
            const integerPart = price.slice(0, decimalIndex);
            const decimalPart = price.slice(decimalIndex + 1);
            if (integerPart.length > 10) {
                price = integerPart.slice(0, 10) + '.' + decimalPart;
            }
            price = price.slice(0, 13); 
        }
    
        $(this).val(price);
    });




});

function nameValid(nameid, errorid) {
    const Name = $(nameid).val();
    const Err = $(errorid);
    if(/[^a-zA-Z ]/.test(Name)) {
        $(nameid).val(Name.replace(/[^a-zA-Z ]/, ''));
    } else {
        Err.hide();
    } 
    // if(Name=='') {
    //     Err.text('Name required!');
    //     Err.show();
    // }
}

function emailValid(emailid, errorid) {
    const email = $(emailid).val();
    const Err = $(errorid);

    if(!/^[\w]+(\.[\w]+)*@([\w]+\.)+[a-zA-Z]{2,3}$/.test(email)) {
        Err.show();
    }
    else{
        Err.hide();
    }
    if(email=='') {
        Err.hide();
    }
    // if(email=='') {
    //     Err.text('Email required!');
    //     Err.show();
    // }
}

function phoneValid(phoneid, errorid) {
    const phone = $(phoneid).val();
    const Err = $(errorid);

    if(phone.length>10) {
        $(phoneid).val(phone.substr(0,10));
        Err.hide();
    } 
    if(phone.length<10) {
        Err.show();
    } else {
        Err.hide();
    }

    if(/[^0-9]/.test(phone)) {
        $(phoneid).val(phone.replace(/[^0-9]/, ''));
        // Err.hide();
        if($(phoneid).val().length==0) {
            Err.hide();
        } else if($(phoneid).val().length<10){
            Err.show();
        }
    }
    if($(phoneid).val().length==0) {
        Err.hide();
    }
    // if(phone=='') {
    //     Err.text('Phone required!');
    //     Err.show();

    // }
    // if(phone.length<10) {
    //     Err.show();
    // } else if(phone.length==0){
    //     Err.hide();
    // }
}

function passValid(userpassid, passErr) {
    const userPswd  = $(userpassid).val();
    const userPassErr = $(passErr);

    if(!/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#$!%*?&])[A-Za-z\d@#$!%*?&]{8,15}$/.test(userPswd)) {
        userPassErr.text("Min 8 chars, max 15 chars at least one Upper, Lower, number, special char needed!");
        userPassErr.show();
    } else {
        userPassErr.hide();
    }

    if(userPswd.length>14) {
        $(userpassid).val(userPswd.substr(0,15));
    }
    if(userPswd=='') {
        console.log('NULL VALUE');
        userPassErr.hide();
    }
    // if(userPswd=='') {
    //     userPassErr.text('Password required!');
    //     userPassErr.show();
    // }
}

