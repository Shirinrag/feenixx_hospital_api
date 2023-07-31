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
            <td><?= $data['invoice_no']?></td>
            <td><?= $data['date']?></td>
            <!-- <td>[Payment Due Date]</td> -->
        </tr>
    </table>

    <h2>Patient Information</h2>

    <table>
        <tr>
            <th>Patient ID</th>
            <td><?= $data['charges_data']['0']['patient_id']?></td>
           
           
        </tr>
        <tr>  
            <th>Patient Name</th>
            <td><?= $data['charges_data']['0']['first_name']." ".$data['charges_data']['0']['last_name']?></td>
        </tr>
        <tr>  
            <th>Date of Addmission</th>
            <td><?= $data['date_of_discharge']['appointment_date']?></td>
        </tr>
        <tr>  
            <th>Date of Discharge</th>
            <td><?= $data['date_of_discharge']['date_of_discharge']?></td>
        </tr>
        <tr>  
             <th>Consultant</th>
            <td><?= $data['doctor_data']['first_name']." ".$data['doctor_data']['last_name']?></td>
        </tr>
    </table>

    <h2>Invoice Details</h2>

    <table>
        <tr>
            <th>Description</th>
            <th>Price</th>
            <th>Unit</th>
            <th>Total</th>
            
        </tr>

        <?php 
        $charges_data =  $data['charges_data'];
        foreach ($charges_data as $charges_data_key => $charges_data_row) { ?>
       
        <tr>
            <td><?= $charges_data_row['charges_name']?></td>
            <td><?= $charges_data_row['single_price_unit']?></td>
            <td><?= $charges_data_row['final_count']?></td>
            <td><?= $charges_data_row['final_amount']?></td>

        </tr>
         <?php }?>
        <!-- Add more rows for additional items -->
    </table>

    <h2>Payment Summary</h2>

    <table>      
        <tr class="total-row">
            <td>Total:</td>
            <td><?= $data['payment_data']['total_charges']; ?></td>
        </tr>
        <tr class="total-row">
            <td>Total Paid Amount:</td>
            <td><?= $data['payment_data']['total_paid_amount']; ?></td>
        </tr>
        <tr class="total-row">
            <td>Total Remaining Amount:</td>
            <td><?= $data['payment_data']['remaining_amount']; ?></td>
        </tr>
    </table>

<!-- <p>Please make all checks payable to [Your Company's Name].</p> -->
<p><strong>For any inquiries or questions, please contact us at (+91) 8097090308 / 8097653705 or hospitalfeenixx@gmail.com.</strong></p>
<p>Thank you !</p>
</body>
</html>