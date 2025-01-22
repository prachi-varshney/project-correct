<?php
    // session_start();

    if(!$_SESSION['allowLogin']) {
        redirect('LoginPage');
        exit;
    }

    // include "db_connectionOOPS.php";
    // $obj = new database();
        // $user = $this->home_model->get_details('user_master');
        // $client = $this->home_model->get_details('client_master');
        // $item = $this->home_model->get_details('item_master');
        // $invoice = $this->home_model->get_details('invoice_master');
    // $result = $obj->getData('user_master', 'COUNT(*) AS totaluser');
    // $users = $result[0]['totaluser'];
    // $result = $obj->getData('client_master', 'COUNT(*) AS totalclient');
    // $clients = $result[0]['totalclient'];
    // $result = $obj->getData('item_master', 'COUNT(*) AS totalitem');
    // $items = $result[0]['totalitem'];
    // $result = $obj->getData('invoice_master', 'COUNT(*) AS totalinvoice');
    // $invoices = $result[0]['totalinvoice'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <?php $this->load->view('cdn_files') ?>
    <link rel="stylesheet" href="<?php echo base_url('styles/style1.css')?>">
    <style>
        * {
            font-size: 13px;
        }
        #backgroundImg {
            background-image: url('<?php echo base_url('images/background2.jpg')?>');
            background-size: cover;
        }
        .homediv {
            width: 300px;
            height: 150px;
            background-color: #fff;
            border-radius: 5px;
            /* box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px, rgba(0, 0, 0, 0.2) 0px 1px 2px; */
            box-shadow: rgba(50, 50, 93, 0.25) 0px 30px 60px -12px inset, rgba(0, 0, 0, 0.3) 0px 18px 36px -18px inset;
            transition: transform 0.2s, box-shadow 0.2s;
            margin: 15px;
            padding: 15px;
        }
        .homediv a {
            text-decoration: none;
            color: #333;
        }
        .homediv:hover {
            transform: translateY(-10px);
            box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px, rgba(10, 37, 64, 0.35) 0px -2px 6px 0px inset;
        }
        .homediv .icon {
            font-size: 50px;
            margin-bottom: 10px;
            color: #0377de;
        }
        .homediv h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .homediv p {
            font-size: 18px;
        }

        @media screen and (max-width: 991px) {
            .homediv {
                width: 200px;
                height: 100px;
            }
            .homediv h2 {
                font-size: 18px;
            }
            .homediv p {
                font-size: 15px; 
            }
            .homediv .icon {
                font-size: 20px;
            }
            #bdSidebar {
                width: 240px;
            }
            #sidebarLogo {
                width: 165px;
            }
        }
        @media screen and (max-width: 302px) {
            .homediv {
                width: 200px;
                height: 80px;
                padding: 0;
            }
            .homediv h2 {
                font-size: 18px;
            }
            .homediv p {
                font-size: 15px; 
            }
            .homediv .icon {
                font-size: 20px;
            }
        }
        @media screen and (max-width: 480px) {
            #backgroundImg {
                height: 110%;
            }
            #bdSidebar {
                width: 150px;
            }
            #sidebarLogo {
                width: 90px;
            }
            .sidediv {
                flex-direction: column;
                justify-content: center;
                align-items: center;
            }
            .navbar .navbar-toggler .navbar-toggler-icon {
                width: 0.75em;
                height: 0.75em;
            }
        }

    </style>
</head>
<body>

    <div class="container-fluid p-0 d-flex h-100">
        <?php $this->load->view('navsidebar/sidebar') ?>
        <div class="bg-light flex-fill" id="backgroundImg">
            <?php $this->load->view('navsidebar/nav') ?>
            <div class="container mt-5">
                <div class="d-flex flex-wrap justify-content-center">
                    <div class="homediv">
                        <a href="<?php echo site_url('UserMaster'); ?>">
                            <div class="d-flex flex-column align-items-center justify-content-center">
                                <i class="fa-solid fa-user icon"></i>
                                <h2>User Master</h2>
                                <p>Total Users: <?php echo $users ?></p>
                            </div>
                        </a>
                    </div>
                    <div class="homediv">
                        <a href="<?php echo site_url('ClientMaster') ?>">
                            <div class="d-flex flex-column align-items-center justify-content-center">
                                <i class="fa-solid fa-user-tie icon"></i>
                                <h2>Client Master</h2>
                                <p>Total Clients: <?php echo $clients ?> </p>
                            </div>
                        </a>
                    </div>
                    <div class="homediv">
                        <a href="<?php echo site_url('ItemMaster') ?>">
                            <div class="d-flex flex-column align-items-center justify-content-center">
                                <i class="fa-solid fa-list-alt icon"></i>
                                <h2>Item Master</h2>
                                <p>Total Items: <?php echo $items ?></p>
                            </div>
                        </a>
                    </div>
                    <div class="homediv">
                        <a href="<?php echo site_url('InvoiceMaster') ?>">
                            <div class="d-flex flex-column align-items-center justify-content-center">
                                <i class="fa-solid fa-file-invoice icon"></i>
                                <h2>Invoice</h2>
                                <p>Total Invoices: <?php echo $invoices ?></p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view('foot') ?>
</body>
</html>
