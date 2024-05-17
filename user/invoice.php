<?php
require ('../action/main_work.php');
if (!isset($_SESSION['user_unique_id'])) {
    header("Location: ../login.php");
    exit;
}
$UserDetails = $for->alltable();
$user = $for->getsingledetail(($_SESSION['user_unique_id']));
if (isset($_GET['ref_id'])) {
    $ref_id = $_GET['ref_id'];
}
$row = $for->Invoice($ref_id);





$textColor = '';
if ($row[0]->transaction_type == 'Credit') {
    $textColor = 'green';
} elseif ($row[0]->transaction_type == 'Debit') {
    $textColor = 'red';
}
?>


<?php require('head.php')?>

<style>
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
        }
        .receipt {
            margin-top: 30px;
        }
        .receipt p {
            margin: 10px 0;
        }
        .receipt .details {
            border-top: 1px solid #ccc;
            padding-top: 10px;
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
        }
    </style>
<?php require('header.php') ?>

<?php require('sidebar.php') ?>


<div class="mobile-menu-overlay"></div>

 <div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">
 



    <div id="print-content"  >
        <h4 class="text-center mb-30 weight-600">Receipt</h4>

        <div class="container">
        <h1><?php  print $row[0]->type;?></h1><br>
        <h5 style="text-align: center; color: <?php echo $textColor; ?>"><?php echo $row[0]->transaction_type; ?></h5>        <div class="receipt">
            <p><strong>Transaction ID:</strong><?php echo $ref_id; ?></p>
            <p><strong>Date:</strong><?php echo date("Y-m-d", strtotime($row[0]->created_at)); ?></p>
            <p><strong>Amount:</strong> $<?php  print $row[0]->amount;?></p>
            <p><strong>Status:</strong> <?php  print $row[0]->status;?></p>
            <p><strong>From Account:</strong> <?php echo substr($row[0]->account,0); ?></p>
            <?php if (!empty($row[0]->account_numble)) : ?>
                <p><strong>To Account:</strong> <?php echo $row[0]->account_numble; ?></p>
            <?php endif; ?>
            <?php if (!empty($row[0]->details)) : ?>
                <p><strong>Description:</strong> <?php echo $row[0]->details; ?></p>
            <?php endif; ?>
        </div>
        <div class="details">
            <p><strong>Sender Name:</strong> <?php  print $user->name;?></p>
            <?php if (!empty($row[0]->bank_name)) : ?>
                <p><strong>Description:</strong> <?php echo $row[0]->bank_name; ?></p>
            <?php endif; ?>
            <!-- <p><strong>Sender Address:</strong> 123 Main St, City, Country</p>
            <p><strong>Receiver Address:</strong> 456 Park Ave, City, Country</p> -->
        </div>
        <div class="footer">
            <p><strong>Thank you for choosing our bank!</strong></p>
        </div>
        <button onclick="printContent()" class="btn btn-primary">Print</button>
    </div>        

    </div>










    </div>








    <script>
    function printContent() {
        var originalContents = document.body.innerHTML;
        var printContents = document.getElementById("print-content").innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>

<?php require('footer.php') ?>

