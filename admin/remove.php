<?php
require ('../action/main_work.php');
if(isset($_GET['user'])) {
    $userid = $_GET['user'];
}
$user = $for->getsingledetail(($userid));
$currencies = $for->courrency();
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
                              <h2>Remove Amount</h2>
                           </div>
                        </div>
                     </div>

                        <div class="container">
                            <h2>Debit Account</h2><br>
                            <form action="../action/main_work.php?option=remove" method="post">
                            <input type="hidden" name="userid" value="<?php echo isset($userid) ? $userid : ''; ?>">

                            <div class="form-group">
                                <label for="loan">Loan Balance:$<?php echo $user->loan_balance?></label>
                                <input type="text" id="loanAmountInput" name="loan" value="0">
                            </div>

                            <div class="form-group">
                                <label for="saving">Saving Balance:  $<?php echo $user->saving_balance?></label>
                                <input type="text" id="savingAmountInput" name="saving" value="0">
                            </div>

                            <div class="form-group">
                                <label for="current">Current Balance: $<?php echo $user->current_balance?></label>
                                <input type="text" id="currentAmountInput" name="current" value="0">
                            </div>

                                <div class="form-group">
                                    <label>Bank Country</label>
                                    <select class="form-control" name="bank_country" id="currencySelector">
                                        <?php
                                        if ($currencies !== 'No Data was returned') {
                                            foreach ($currencies as $currency) {
                                                echo "<option value='{$currency->id}' data-rate='{$currency->currency}'>{$currency->name}</option>";
                                            }
                                        } else {
                                            echo "<option value=''>No Account Types Available</option>";
                                        }
                                        ?>
                                    </select>
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