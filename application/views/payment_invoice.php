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

    <h2>Customer Information</h2>

    <table>
        <tr>
            <th>Customer ID</th>
            <th>Customer Name</th>
        </tr>
        <tr>
            <td><?= $data['patient_id']?></td>
            <td><?= $data['first_name']." ".$data['last_name']?></td>           
        </tr>
    </table>

    <h2>Invoice Details</h2>

    <table>
        <tr>
            <th>Description</th>
            <th>Unit Price</th>
        </tr>      
       
        <tr>
            <td>Payment</td>
            <td><?=$data['amount']?></td>         
        </tr>
        <tr>
            <td>Mediclaim</td>
            <td><?=$data['mediclaim_amount']?></td>         
        </tr>
        <!-- Add more rows for additional items -->
    </table>

    <h2>Payment Summary</h2>

    <table>
        
        <tr class="total-row">
            <td>Total:</td>
            <td><?= $data['total_amount'] ?></td>
        </tr>
    </table>

    <h2>Payment Details</h2>

    <table>
        <tr>
            <td>Payment Method:</td>
            <td><?= $data['payment_type'] ?></td>
        </tr>
</table>

<!-- <p>Please make all checks payable to [Your Company's Name].</p> -->
<p><strong>For any inquiries or questions, please contact us at (+91) 8097090308 / 8097653705 or hospitalfeenixx@gmail.com.</strong></p>
<p>Thank you !</p>
</body>
</html>