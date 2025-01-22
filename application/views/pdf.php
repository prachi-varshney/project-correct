<?php
function convert_number_to_words($number) {

    $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'fourty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        100000             => 'lakh',
        10000000          => 'crore'
    );

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction .  convert_number_to_words($remainder);
            }
            break;
        case $number < 100000:
            $thousands   = ((int) ($number / 1000));
            $remainder = $number % 1000;

            $thousands =  convert_number_to_words($thousands);

            $string .= $thousands . ' ' . $dictionary[1000];
            if ($remainder) {
                $string .= $separator .  convert_number_to_words($remainder);
            }
            break;
        case $number < 10000000:
            $lakhs   = ((int) ($number / 100000));
            $remainder = $number % 100000;

            $lakhs =  convert_number_to_words($lakhs);

            $string = $lakhs . ' ' . $dictionary[100000];
            if ($remainder) {
                $string .= $separator .  convert_number_to_words($remainder);
            }
            break;
        case $number < 1000000000:
            $crores   = ((int) ($number / 10000000));
            $remainder = $number % 10000000;

            $crores =  convert_number_to_words($crores);

            $string = $crores . ' ' . $dictionary[10000000];
            if ($remainder) {
                $string .= $separator .  convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string =  convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .=  convert_number_to_words($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }
    return $string;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF</title>
    <style>
        body {
            margin-collapse: collapse;
        }
        img {
            margin-left: 0px;
        }
        tr {
            display: flex;
            justify-content: space-between;
        }
        table {
            border-collapse: collapse;
        }
        #itemTable th, #itemTable td{
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>
    <div>
        <div style="margin-bottom: 10px;">
            <table style="width: 100%"> 
                <tr>
                    <td><h3 style="font-size: 25px;">INVOICE</h3></td>
                    <td style="width:65%; padding-left:29%;">
                        <img src="images/sansoftlogo.png" alt="" width="250px" >
                    </td>
                </tr>
                <tr>
                    <td colspan=2 style="padding-left: 70%;">419, 4th Floor, 
                        M3M Urbana, Sector 67, 
                        Gurugram, Haryana 122018.<br>
                        +919999121735
                    </td>
                </tr>
            </table>
        </div>
        <hr>
        <div>
            <table style="width: 100%; line-height: 1.5;">
                <tr>
                    <td><b>Client Details: </b></td>
                    <td style="text-align: right;"><b>Invoice No.:</b> <?php echo $invoiceData[0]['invoiceId']?></td>
                </tr>
                <tr>
                    <td><?php echo $invoiceData[0]['name'] ?></td>
                    <td style="text-align: right;"> <b>Date:</b> <?php $date = date_create($invoiceData[0]["invoiceDate"]); echo date_format($date, "d/m/Y"); ?></td>
                </tr>
                <tr>
                    <td><?php echo $invoiceData[0]['email'] ?></td>
                </tr>
                <tr>
                    <td><?php echo "+91".$invoiceData[0]['phone'] ?></td>
                </tr>
                <tr>
                    <td><?php echo $invoiceData[0]['Address'] ?>
                    </td>
                </tr>
            </table>
        </div>
        <div style="margin-top: 50px; width: 100%;">
            <form method="POST">
            <table style="width: 100%; line-height: 1.5;" id="itemTable">
                <tr>
                    <th>Item Id</th>
                    <th style="text-align: center;">Item name</th>
                    <th style="text-align: center;">Price</th>
                    <th style="text-align: center;">Quantity</th>
                    <th style="text-align: center;">Subtotal</th>
                </tr>
                <?php
                foreach($itemData as $key=>$value) {
                ?>
                <tr>
                    <td style="text-align: center;"><?php echo $itemData[$key]['itemId'] ?></td>
                    <td style="text-align: left;"><?php echo $itemData[$key]['itemName'] ?></td>
                    <td style="text-align: right;"><?php echo number_format($itemData[$key]['itemPrice'], 2) ?></td>
                    <td style="text-align: right;"><?php echo $itemData[$key]['qty'] ?></td>
                    <td style="text-align: right;"><?php echo number_format($itemData[$key]['total'], 2) ?></td>
                </tr>
                <?php
                }
                ?>
                <tr>
                    <td colspan=3 style="border: none;"></td>
                    <td style="text-align: center;"><b>Total</b></td>
                    <td style="text-align: right;"><?php echo number_format($invoiceData[0]['grandTotal'], 2) ?></td>
                </tr>
                <tr>
                    <td colspan=5 style="height: 50px; text-align: left; vertical-align: bottom; border: none;"><b>Total Amount in words:</b> <?php echo convert_number_to_words($invoiceData[0]['grandTotal'])." only."; ?></td>
                </tr>
            </table>
            </form>
        </div>
    </div>
</body>
</html>