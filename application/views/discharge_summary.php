<!DOCTYPE html>
<html>
<head>
    <title>Discharge Summary</title>
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
                width: 210px;

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

    <h1>Patient Details</h1>
    <table>
        <tr>
            <th>Customer Name</th>
            <td><?= $data['first_name']." ".$data['last_name'];?></td>  
        </tr>
        <tr>
            <th>Admission Date</th>
            <td><?= $data['appointment_date'];?></td>

        </tr>
            <th>Discharge Date</th>
            <td><?= $data['date_of_discharge'];?></td>
          
        </tr>
        <tr>
             <th>Under Care of Dr. Name</th>
            <td><?= $data['doctor_first_name']." ".$data['doctor_last_name'];?></td>
            
        </tr>
    </table>

    <h2>Discharge Summary</h2>       
         <?= $data['discharge_summary'];?>
            

<!-- <p>Please make all checks payable to [Your Company's Name].</p> -->
<p><strong>For any inquiries or questions, please contact us at (+91) 8097090308 / 8097653705 or hospitalfeenixx@gmail.com.</strong></p>
<p>Thank you !</p>
</body>
</html>