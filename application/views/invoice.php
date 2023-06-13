<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    <style>
        body {
            font-family: serif;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;

        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        .total-row {
            font-weight: bold;
        }

        .invoice-header {
/*            margin-bottom: 20px;*/
            font-family: serif;
            text-align: center;
            font-weight: bold;
/*            font-size: 1px;*/
        }
    </style>
</head>
<body>
    <div class="invoice-header">
         <img src="http://localhost/feenixx_hospital/feenixx_hospital_api/uploads/logo.jpg">
        <!-- <h2>Feenixx Hospital</h2> -->
        <p>1st Floor, Above SBI,<br>
        Shyam Swastik, Plot No 4, Sector 19, Ulwe<br>
        (+91) 8097090308 / 8097653705<br>
        hospitalfeenixx@gmail.com<br>
        www.feenixhospital.com</p>
    </div>

    <h1>Invoice</h1>

    <table>
        <tr>
            <th>Invoice Number</th>
            <th>Date</th>
            <!-- <th>Due Date</th> -->
        </tr>
        <tr>
            <td><?= $data['payment_detail']['invoice_no']?></td>
            <td><?= $data['payment_detail']['payment_history'][0]['date']?></td>
            <!-- <td>[Payment Due Date]</td> -->
        </tr>
    </table>

    <h2>Customer Information</h2>

    <table>
        <tr>
            <th>Customer ID</th>
            <th>Customer Name</th>
           <!--  <th>Customer Address</th>
            <th>City, State, ZIP</th> -->
        </tr>
        <tr>
            <td><?= $data['payment_detail']['patient_id']?></td>
            <td><?= $data['payment_detail']['first_name']." ".$data['payment_detail']['last_name']?></td>
            <!-- <td>[Customer Address]</td>
            <td>[City, State, ZIP]</td> -->
        </tr>
    </table>

    <h2>Invoice Details</h2>

    <table>
        <tr>
            <th>Description</th>
            <!-- <th>Quantity</th> -->
            <th>Unit Price</th>
            <!-- <th>Total</th> -->
        </tr>

        <?php 
        $info =  $data['payment_detail'];
        foreach ($info['payment_details']['charges_name'] as $payment_details_key => $payment_details_row) { ?>
       
        <tr>
            <td><?= $payment_details_row?></td>
            <!-- <td>[Quantity]</td> -->
            <td><?= $info['payment_details']['amount'][$payment_details_key]?></td>
            <!-- <td><?= $info['payment_details']['amount'][$payment_details_key]?></td> -->

        </tr>
         <?php }?>
        <!-- Add more rows for additional items -->
    </table>

    <h2>Payment Summary</h2>

    <table>
        <tr class="total-row">
            <td>Discount:</td>
            <td><?php 
            if(empty($info['payment_details']['discount'])){
                echo 0;
            }else{
                echo $info['payment_details']['discount'];
            }
             ?></td>
        </tr>
        <!-- <tr>
            <td>Tax:</td>
            <td>[Tax Amount]</td>
        </tr>
        <tr>
            <td>Shipping:</td>
            <td>[Shipping Amount]</td>
        </tr> -->
        <tr class="total-row">
            <td>Total:</td>
            <td><?= $info['payment_details']['total_amount'] ?></td>
        </tr>
    </table>

    <h2>Payment Details</h2>

    <table>
        <tr>
            <td>Payment Method:</td>
            <td><?= $info['payment_type'] ?></td>
        </tr>
        <!-- <tr>
            <td>Bank Name:</td>
            <td>[Bank Name]</td>
        </tr>
        <tr>
            <td>Account Name:</td>
            <td>[Account Name]</td>
        </tr>
        <tr>
            <td>Account Number:</td>
            <td>[Account Number]</td>
        </tr>
        <tr>
            <td>Routing Number:</td>
        <td>[Routing Number]</td>
    </tr> -->
</table>

<!-- <p>Please make all checks payable to [Your Company's Name].</p> -->
<p><strong>For any inquiries or questions, please contact us at (+91) 8097090308 / 8097653705 or hospitalfeenixx@gmail.com.</strong></p>
<p>Thank you !</p>
</body>
</html>