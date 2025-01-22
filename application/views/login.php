<?php

// session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <link rel="stylesheet" href="<?php echo base_url()?>styles/st.css">
  <?php $this->load->view('cdn_files'); ?>
  <style>
    .error {
      display: none;
      color:red;
      font-weight: bold;
    }
    * {
      font-size: 14px;
    }
  </style>
</head>
<body>
  <div class="imgcontainer">
    <a href="https://sansoftwares.com/" target="_blank">
      <img src="<?php echo base_url('images/sansoftwares_logo.png')?>" alt="Avatar" class="avatar">
    </a>
  </div>
  <div class="container" id="loginPage">
        <!-- <div class="container col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box" style="background: #103cbe;" id="imgForm">
           <div class="featured-image mb-3">
            <img src="<?php echo base_url('images/1.png')?>" class="img-fluid" style="width: 250px;">
           </div>
           <p class="text-white fs-2" style="font-family: 'Courier New', Courier, monospace; font-weight: 600;">Be Verified</p>
           <small class="text-white text-wrap text-center" style="width: 17rem;font-family: 'Courier New', Courier, monospace;">Join experienced Designers on this platform.</small>
        </div>  -->
    <div class="container" id="imgForm">
      <img src="<?php echo base_url('images/loginImage3.jpg')?>" alt="">
    </div>
    <div class="container" id="formContainer">
      <form class="p-4" id="logindata" method="post" action="">
        <div class="createHead">
          <h2>Login</h2>
          <h4>Sign in to continue.</h4>
        </div>
        <div class="container" id="compform">
          <label for="loginEmail" class="form-check-label form-label">Email</label>
          <input type="text" name="loginEmail" id="loginEmail" class="form-control" autocomplete="username">
          <span class="error" id="loginMailErr"></span>

          <label for="loginPswd" class="form-check-label form-label mt-3" style="display: block;">Password</label>
          <div class="pswdEye" style="position: relative;">
            <input type="password" name="loginPswd" class="form-control" id="loginPswd" autocomplete="current-password">       
            <div class="eye-toggle" style='position: absolute; top: 15px;'>
              <img src="<?php echo base_url('icons/eye-alt.svg')?>" id="togglePassword" width="18px" height="18px" style="cursor: pointer;">
            </div>
            <span class="error mt-0" id="loginPswdErr"></span></div>
          </div>

            <div style='margin:15px' class="d-flex align-items-center">
              <div><img src="<?php echo base_url('LoginPage/captcha') ?>" id="captchaImg"></div>
              <div class="ms-2"><a onclick="captchaRefresh()" role="button"><img src="<?php echo base_url('icons/refresh.svg')?>" width="20px" alt=""></a></div>
            </div>
            <!-- <label for="captcha"></label> -->
            <input type="text" name="captcha" id="captcha" class="form-control" placeholder="Enter captcha">
            <span class="error" id="capErr"></span>

          <button class="btn mt-3 mb-3" id="submit" type="submit" name="login">Login</button>
          <!-- <div class="newUser">
            <span>New User? <a href="createAccount.php">Create an account</a></span>
          </div> -->
          
          <!-- <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mt-2" role="alert" style="padding: 0.5rem; font-size: 1em; position: relative;">
             <div>invalid email and password!</div>
             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="font-size: 10px; position: absolute;"></button>
          </div> -->
          <div class="alert alert-danger alert-dismissible fade show custom-alert-small mt-2 mb-2" role="alert" style="padding: 0.5rem; font-size: 1em; position: relative; display: none" id="alertt">
            <span id="alertErr"></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="position: absolute; top: -.25rem; right: 0.25rem; font-size: 10px;"></button>
          </div>


        </div>
      </form>  
    </div>
  </div>
  <?php $this->load->view('foot') ?>
  <script>
    $(document).ready(function() {
    $('#togglePassword').click(function() {
      const type = $('#loginPswd').attr('type') === 'password' ? 'text' : 'password';
      $('#loginPswd').attr('type', type);
      if (type === "text") {
        $(this).attr('src', "<?php echo base_url('icons/eye-slash-alt.svg')?>");
      } else {
        $(this).attr('src', "<?php echo base_url('icons/eye-alt.svg')?>");
      }
    });

    $('#captcha').on('input', function() {
      var cap = $(this).val();
      var capErr = $('#capErr');
      // console.log(cap.length);
      if(cap=='') {
        capErr.show();         
      } else {
        capErr.hide();
      }
    });

    $('#logindata').on('submit', function(event) {
        event.preventDefault();
        // console.log('hello');
        const formdata = new FormData(this);
        formdata.append('type', 'submit');
        $.ajax({
            url: 'loginpage/verify_data',
            type: 'post',
            data: formdata,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {
                console.log(data);
                if(data.success) {
                    window.location.replace("<?php echo base_url('Dashboard') ?>");
                } else {
                  $('#loginMailErr').html(data.loginEmailErr).show();
                  $('#loginPswdErr').html(data.loginPswdErr).show();
                  $('#capErr').html(data.captchaErr).show();
                }
                if(data.error) {
                    $('#alertErr').text(data.error);
                    $('#alertt').show();
                } else {
                    $('#alertt').hide();
                }   
            }, error: function(error) {
                console.error('Error:', error);
            }
        });
    });


    
  });
 
 function captchaRefresh() {
    $('#captchaImg').attr('src', "<?php echo base_url('LoginPage/captcha') ?>");
 }
  </script>
  <script src="<?php echo base_url('application/views/scripts/validation.js') ?>"></script>
</body>
</html>
