<link rel="stylesheet" href="stylesheets/history.css">
<?php

$hu_id = $_SESSION['id'];
//echo $hu_id;
 include('phpscripts/connection.php');
   $sql = "SELECT * FROM `deposit_list` WHERE u_id = '$hu_id' AND status = 'pending'";
$prods = [];
          if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            $prods[] = $row;
            
        }
    }
          }
//print_r($prods);
?>

                <div class="col-md-8 col-sm-8">
                    <div class="deposits">
                        <div class="dashboard-content__title">
                            <svg viewBox="0 0 23.26 23.93">
                                <use xlink:href="#depositIcon"></use>
                            </svg>
                            My Deposits
                        </div>
                        <div class="deposits-list">



                                                        <div class="container-table100">
                                <div class="wrap-table100">
                                    <div class="table100">
                                        <table>
                                            <thead>
                                                <tr class="table100-head">
                                                    <th style="text-align:center;" class="column1" colspan="3">STANDARD PLAN</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- <tr class="table100-head">
								<td class="column1">Plan</th>
								<td class="column2">Amount Spent ($)</th>
								<td class="column3"> Profit (%)</th>
						</tr> -->
                                                <tr>
                                                    <td class="column1">Plan STANDARD PLAN</td>
                                                    <td class="column2">$100.00 - $5,000.00</td>
                                                    <td class="column3"> Profit 3.30% daily</td>
                                                </tr>
                                                                                                

                                                <?php
                                                $basic_prods = [];
                                                if(!empty($prods) && $prods[0] != ''){
                                                    foreach($prods as $prod){
                                                        if($prod['type'] == '1'){
                                                            $basic_prods[] = $prod;
                                                        }
                                                    
                                                }
                                                }
                                                if(!empty($basic_prods) && $basic_prods[0] != ''){
                                                    foreach($basic_prods as $prod){
                                                        $profit = (3.3/100) * $prod['amount'];
                                                        $profit = normalize_amount($profit);
                                                        ?>
                                                    <tr>
                                                        <td></td>
                                                        <td>$ <?php echo $prod['amount']; ?></td>
                                                        <td>$ <?php echo $profit; ?></td>
                                                    </tr>
                                                        <?php
                                                    }
                                                }else{
                                                    ?>
                                                <tr>
                                                    <td id="selector" colspan=4 align=center style="padding-left: 20px!important;padding-right: 20px;padding-top: 20px;padding-bottom: 10px;">
                                                        <div class="form-alert form-alert--error">
                                                            <svg class="error-icon" viewBox="0 0 15.22 15.22">
                                                                <use xlink:href="#errorIcon"></use>
                                                            </svg>
                                                            <span>No transactions found.</span> </div>
                                                    </td>
                                                </tr>
                                                    <?php
                                                }
                                                ?>
                                                


                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                                                        <div class="container-table100">
                                <div class="wrap-table100">
                                    <div class="table100">
                                        <table>
                                            <thead>
                                                <tr class="table100-head">
                                                    <th style="text-align:center;" class="column1" colspan="3">PROFESSIONAL PLAN</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- <tr class="table100-head">
								<td class="column1">Plan</th>
								<td class="column2">Amount Spent ($)</th>
								<td class="column3"> Profit (%)</th>
						</tr> -->
                                                                                                <tr>
                                                    <td class="column1">Plan PROFESSIONAL PLAN</td>
                                                    <td class="column2">$5,000.00 - $20,000.00</td>
                                                    <td class="column3"> Profit 6.0% daily</td>
                                                </tr>
                                                                                                


                                                <?php
                                                $bronze_prods = [];
                                                if(!empty($prods) && $prods[0] != ''){
                                                    foreach($prods as $prod){
                                                        if($prod['type'] == '2'){
                                                            $bronze_prods[] = $prod;
                                                        }
                                                    
                                                }
                                                }
                                                if(!empty($bronze_prods) && $bronze_prods[0] != ''){
                                                    foreach($bronze_prods as $prod){
                                                        $profit = (6.0/100) * $prod['amount'];
                                                        $profit = normalize_amount($profit);
                                                        ?>
                                                    <tr>
                                                        <td></td>
                                                        <td>$ <?php echo $prod['amount']; ?></td>
                                                        <td>$ <?php echo $profit; ?></td>
                                                    </tr>
                                                        <?php
                                                    }
                                                }else{
                                                    ?>
                                                <tr>
                                                    <td id="selector" colspan=4 align=center style="padding-left: 20px!important;padding-right: 20px;padding-top: 20px;padding-bottom: 10px;">
                                                        <div class="form-alert form-alert--error">
                                                            <svg class="error-icon" viewBox="0 0 15.22 15.22">
                                                                <use xlink:href="#errorIcon"></use>
                                                            </svg>
                                                            <span>No transactions found.</span> </div>
                                                    </td>
                                                </tr>
                                                    <?php
                                                }
                                                ?>


                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                                                        <div class="container-table100">
                                <div class="wrap-table100">
                                    <div class="table100">
                                        <table>
                                            <thead>
                                                <tr class="table100-head">
                                                    <th style="text-align:center;" class="column1" colspan="3">ADVANCED PLAN</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- <tr class="table100-head">
								<td class="column1">Plan</th>
								<td class="column2">Amount Spent ($)</th>
								<td class="column3"> Profit (%)</th>
						</tr> -->
                                                                                                <tr>
                                                    <td class="column1">Plan ADVANCED PLAN</td>
                                                    <td class="column2">$10,000.00 - Unlimited</td>
                                                    <td class="column3"> Profit 6.4% daily</td>
                                                </tr>
                                                                                                


                                                <?php
                                                $silver_prods = [];
                                                if(!empty($prods) && $prods[0] != ''){
                                                    foreach($prods as $prod){
                                                        if($prod['type'] == '3'){
                                                            $silver_prods[] = $prod;
                                                        }
                                                    
                                                }
                                                }
                                                if(!empty($silver_prods) && $silver_prods[0] != ''){
                                                    foreach($silver_prods as $prod){
                                                        $profit = (6.4/100) * $prod['amount'];
                                                        $profit = normalize_amount($profit);
                                                        ?>
                                                    <tr>
                                                        <td></td>
                                                        <td>$ <?php echo $prod['amount']; ?></td>
                                                        <td>$ <?php echo $profit; ?></td>
                                                    </tr>
                                                        <?php
                                                    }
                                                }else{
                                                    ?>
                                                <tr>
                                                    <td id="selector" colspan=4 align=center style="padding-left: 20px!important;padding-right: 20px;padding-top: 20px;padding-bottom: 10px;">
                                                        <div class="form-alert form-alert--error">
                                                            <svg class="error-icon" viewBox="0 0 15.22 15.22">
                                                                <use xlink:href="#errorIcon"></use>
                                                            </svg>
                                                            <span>No transactions found.</span> </div>
                                                    </td>
                                                </tr>
                                                    <?php
                                                }
                                                ?>


                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                                                        <div class="container-table100">
                                <div class="wrap-table100">
                                    <div class="table100">
                                        <table>
                                            <thead>
                                                <tr class="table100-head">
                                                    <th style="text-align:center;" class="column1" colspan="3">PREMIUM PLAN</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- <tr class="table100-head">
								<td class="column1">Plan</th>
								<td class="column2">Amount Spent ($)</th>
								<td class="column3"> Profit (%)</th>
						</tr> -->
                                                                                                <tr>
                                                    <td class="column1">Plan PREMIUM PLAN</td>
                                                    <td class="column2">$10000.00 - unlimited</td>
                                                    <td class="column3"> Profit 15% daily</td>
                                                </tr>
                                                                                                


                                                <?php
                                                $premium_prods = [];
                                                if(!empty($prods) && $prods[0] != ''){
                                                    foreach($prods as $prod){
                                                        if($prod['type'] == '4'){
                                                            $premium_prods[] = $prod;
                                                        }
                                                    
                                                }
                                                }
                                                if(!empty($premium_prods) && $premium_prods[0] != ''){
                                                    foreach($premium_prods as $prod){
                                                        $profit = (15/100) * $prod['amount'];
                                                        $profit = normalize_amount($profit);
                                                        ?>
                                                    <tr>
                                                        <td></td>
                                                        <td>$ <?php echo $prod['amount']; ?></td>
                                                        <td>$ <?php echo $profit; ?></td>
                                                    </tr>
                                                        <?php
                                                    }
                                                }else{
                                                    ?>
                                                <tr>
                                                    <td id="selector" colspan=4 align=center style="padding-left: 20px!important;padding-right: 20px;padding-top: 20px;padding-bottom: 10px;">
                                                        <div class="form-alert form-alert--error">
                                                            <svg class="error-icon" viewBox="0 0 15.22 15.22">
                                                                <use xlink:href="#errorIcon"></use>
                                                            </svg>
                                                            <span>No transactions found.</span> </div>
                                                    </td>
                                                </tr>
                                                    <?php
                                                }
                                                ?>


                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer>
