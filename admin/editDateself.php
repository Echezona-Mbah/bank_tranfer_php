<?php
require ('../action/main_work.php');
if(isset($_GET['id'])) {
    $id = $_GET['id'];
}
$user = $for->getsingleselftransfer(($id));
//  print_r($user->loan_balance);die();


?>
<?php require('head.php')?>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 500px;
        margin: 50px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
    }

    .form-group input[type="text"],
    .form-group input[type="email"],
    .form-group textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .form-group textarea {
        height: 100px;
    }

    .form-group button {
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .form-group button:hover {
        background-color: #0056b3;
    }
</style>
<?php require('sidebar.php')?>
<?php require('topbar.php')?>

             <!-- dashboard inner -->
             <div class="midde_cont">
                  <div class="container-fluid">
                     <div class="row column_title">
                        <div class="col-md-12">
                           <div class="page_title">
                              <h2>Edit Date Self Transfer</h2>
                           </div>
                        </div>
                     </div>

                        <div class="container">
                            <h2>Edit Date</h2><br>
                            <form action="../action/main_work.php?option=editDateself" method="post">
                            <input type="hidden" name="id" value="<?php echo isset($id) ? $id : ''; ?>">

                            <div class="form-group">
                                <label for="loan">Date:<?php echo date('Y-m-d', strtotime($user->created_at)); ?></label>
                                <input type="date" class="form-control" id="exampleFormControlInput1" name="date" value="<?php echo $user->created_at?>">
                            </div>


                                

                                <div class="form-group">
                                    <button type="submit">Submit</button>
                                </div>
                            </form>
                        </div>


                        <script>
    const currencySelector = document.getElementById('currencySelector');
    function convertAmount(amount, exchangeRate) {
        return parseFloat(amount) * exchangeRate;
    }
    function updateConvertedAmount(inputField, exchangeRate) {
        const enteredAmount = inputField.value.trim();
        if (enteredAmount !== '') {
            const convertedAmount = convertAmount(enteredAmount, exchangeRate).toFixed(2);
            inputField.value = convertedAmount;
        }
    }
    currencySelector.addEventListener('change', function() {
        const selectedOption = currencySelector.options[currencySelector.selectedIndex];
        const exchangeRate = parseFloat(selectedOption.dataset.rate);
        updateConvertedAmount(document.getElementById('loanAmountInput'), exchangeRate);
        updateConvertedAmount(document.getElementById('savingAmountInput'), exchangeRate);
        updateConvertedAmount(document.getElementById('currentAmountInput'), exchangeRate);
    });
</script>
<?php require('footer.php')?>