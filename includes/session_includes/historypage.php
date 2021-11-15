<?php

$hu_id = $_SESSION['id'];
//echo $hu_id;
 include('phpscripts/connection.php');
   $sql = "SELECT * FROM `history` WHERE u_id = '$hu_id'";
$prods = [];
          if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            $prods[] = $row;
            
        }
    }
          }
//print_r($prods);
$r_months = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
if(isset($_SESSION['history_type'])){
    $history_type = $_SESSION['history_type'];
}else{
    $history_type = "";
}
if(isset($_SESSION['history_start_date'])){
    $history_start_date = $_SESSION['history_start_date'];
    $history_start_exploded = explode('-', $history_start_date);
    
    $history_start_month = $r_months[$history_start_exploded[1] -1 ];
}else{
    $history_start_date = "";
}
if(isset($_SESSION['history_end_date'])){
    $history_end_date = $_SESSION['history_end_date'];
    $history_end_exploded = explode('-', $history_end_date);
    $history_end_month = $r_months[$history_end_exploded[1] -1 ];
}else{
    $history_end_date = "";
}





if($history_start_date != "" && $history_end_date != ""){
    $prods = filter_date($prods, $history_start_date, $history_end_date);
}

if($history_type != ""){
    $prods = filter_type($prods, $history_type);
}

?>

<link rel="stylesheet" href="stylesheets/history.css">
<script language=javascript>
    function go(p) {
        document.opts.page.value = p;
        document.opts.submit();
    }

</script>


<div class="col-md-8 col-sm-8">
    <div class="earning-history">
        <div class="dashboard-content__title">
            <svg viewBox="0 0 23.13 27.23">
                <use xlink:href="#earningHistory"></use>
            </svg>
            Transactions History <span>Track your account activities such as investments, earnings and withdraws.</span> </div>
        <div class="earning-history-search">
            <div class="search-inputs">
                <form method=post name="opts" id="history_filter_form"><input type="hidden" name="form_id" value="16082423818046"><input type="hidden" name="form_token" value="2fd532a633c374c57629a9838a241d41">
                    <input type=hidden name=a value=earnings>
                    <input type=hidden name=page value=1>
                    <fieldset class="from-date" style="width: 253px;">
                        <legend>From Date:</legend>
                        <div>
                            <label for="from-day">Day</label>
                            <select name=day_from id="from-day" class="day">
                                <?php if($history_start_date != ""){ echo "<option value='". $history_start_exploded[0] ."' selected>". $history_start_exploded[0] ."";} ?>
                                <option value=1>1
                                <option value=2>2
                                <option value=3>3
                                <option value=4>4
                                <option value=5>5
                                <option value=6>6
                                <option value=7>7
                                <option value=8>8
                                <option value=9>9
                                <option value=10>10
                                <option value=11>11
                                <option value=12>12
                                <option value=13>13
                                <option value=14>14
                                <option value=15 <?php if($history_start_date == ""){ echo "selected";} ?>>15
                                <option value=16>16
                                <option value=17>17
                                <option value=18>18
                                <option value=19>19
                                <option value=20>20
                                <option value=21>21
                                <option value=22>22
                                <option value=23>23
                                <option value=24>24
                                <option value=25>25
                                <option value=26>26
                                <option value=27>27
                                <option value=28>28
                                <option value=29>29
                                <option value=30>30
                                <option value=31>31
                            </select>
                        </div>
                        <div>
                            <label for="from-month">Month</label>
                            <select name=month_from id="from-month" class="month">
                                <?php if($history_start_date != ""){ echo "<option value='". $history_start_exploded[1] ."' selected>". $history_start_month ."";} ?>
                                <option value=1>Jan
                                <option value=2>Feb
                                <option value=3>Mar
                                <option value=4>Apr
                                <option value=5>May
                                <option value=6>Jun
                                <option value=7>Jul
                                <option value=8>Aug
                                <option value=9>Sep
                                <option value=10>Oct
                                <option value=11>Nov
                                <option value=12 <?php if($history_end_date == ""){ echo "selected";} ?>>Dec
                            </select>
                        </div>
                        <div>
                            <label for="from-year">Year</label>
                            <select name=year_from id="from-year" class="year">
                                <?php if($history_start_date != ""){ echo "<option value='". $history_start_exploded[2] ."' selected>". $history_start_exploded[2] ."";} ?>
                                <option value=2008>2008
                                <option value=2009>2009
                                <option value=2010>2010
                                <option value=2011>2011
                                <option value=2012>2012
                                <option value=2013>2013
                                <option value=2014>2014
                                <option value=2015>2015
                                <option value=2016>2016
                                <option value=2017>2017
                                <option value=2018>2018
                                <option value=2019>2019
                                <option value=2020>2020
                                <option value=2021 <?php if($history_start_date == ""){ echo "selected";} ?>>2021
                                <option value=2022>2022
                                <option value=2023>2023
                                <option value=2024>2024
                            </select>
                        </div>
                    </fieldset>
                    <fieldset class="to-date" style="width: 253px;">
                        <legend>To Date:</legend>
                        <div>
                            <label for="to-day">Day</label>
                            <select name=day_to id="to-day" class="day">
                                <?php if($history_end_date != ""){ echo "<option value='". $history_end_exploded[0] ."' selected>". $history_end_exploded[0] ."";} ?>
                                <option value=1>1
                                <option value=2>2
                                <option value=3>3
                                <option value=4>4
                                <option value=5>5
                                <option value=6>6
                                <option value=7>7
                                <option value=8>8
                                <option value=9>9
                                <option value=10>10
                                <option value=11>11
                                <option value=12>12
                                <option value=13>13
                                <option value=14>14
                                <option value=15>15
                                <option value=16>16
                                <option value=17 <?php if($history_end_date == ""){ echo "selected";} ?>>17
                                <option value=18>18
                                <option value=19>19
                                <option value=20>20
                                <option value=21>21
                                <option value=22>22
                                <option value=23>23
                                <option value=24>24
                                <option value=25>25
                                <option value=26>26
                                <option value=27>27
                                <option value=28>28
                                <option value=29>29
                                <option value=30>30
                                <option value=31>31
                            </select>
                        </div>
                        <div>
                            <label for="to-month">Month</label>
                            <select name=month_to id="to-month" class="month">
                                <?php if($history_end_date != ""){ echo "<option value='". $history_end_exploded[1] ."' selected>". $history_end_month ."";} ?>
                                <option value=1>Jan
                                <option value=2>Feb
                                <option value=3>Mar
                                <option value=4>Apr
                                <option value=5>May
                                <option value=6>Jun
                                <option value=7>Jul
                                <option value=8>Aug
                                <option value=9>Sep
                                <option value=10>Oct
                                <option value=11>Nov
                                <option value=12 <?php if($history_end_date == ""){ echo "selected";} ?>>Dec
                            </select>
                        </div>
                        <div>
                            <label for="to-year">Year</label>
                            <select name=year_to id="to-year" class="year">
                                <?php if($history_end_date != ""){ echo "<option value='". $history_end_exploded[2] ."' selected>". $history_end_exploded[2] ."";} ?>
                                <option value=2008>2008
                                <option value=2009>2009
                                <option value=2010>2010
                                <option value=2011>2011
                                <option value=2012>2012
                                <option value=2013>2013
                                <option value=2014>2014
                                <option value=2015>2015
                                <option value=2016>2016
                                <option value=2017>2017
                                <option value=2018>2018
                                <option value=2019>2019
                                <option value=2020>2020
                                <option value=2021 <?php if($history_end_date == ""){ echo "selected";} ?>>2021
                                <option value=2022>2022
                                <option value=2023>2023
                                <option value=2024>2024
                            </select>

                        </div>
                    </fieldset>
                    <fieldset>
                        <legend>Search Type:</legend>
                        <div style="width:100%;">
                            <select name="type" id="history-type" class="search-type">
                                <?php if($history_type != ""){ echo "<option value='". $history_type ."' selected>". $history_type ."</option>";} ?>
                                <option value="">All transactions</option>
                                <option value="Deposit">Deposit</option>
                                <option value="Withdrawal">Withdrawal</option>
                                <option value="Earning">Earning</option>
                                <option value="Referral commission">Referral commission</option>
                            </select>
                        </div>
                    </fieldset>
                    <button class="btn btn--blue" id="filter_submit">
                        <svg viewBox="0 0 9.24 11.31">
                            <use xlink:href="#searchIcon"></use>
                        </svg>
                        Search </button>
                </form>
            </div>
        </div>
        <div class="deposits-list">


            <div class="container-table100">
                <div class="wrap-table100">
                    <div class="table100">

                        <table>
                            <thead>
                                <tr class="table100-head">
                                    <td style="text-align:center;" class="column1"><b>Type</b></td>
                                    <td style="text-align:center;" class="column2"><b>Amount</b></td>
                                    <td style="text-align:center;" class="column3"><b>Date</b></td>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- <tr>
 <td colspan=3 align=center>No transactions found</td>
</tr> -->                       <?php
                                if(!empty($prods) && $prods[0] != ''){
                                    foreach($prods as $prod){
                                        
                                    
                                    ?>
                                    <tr>
                                    <td><?php echo $prod['type']; ?></td>
                                    <td>$<?php echo  normalize_amount($prod['amount']); ?></td>
                                    <td><?php echo $prod['date']; ?></td>
                                </tr>
                                <?php
                                    }
                                }else{
                                    ?>
                                    <tr>
                                        <td id="selector" colspan=3 align=center style="padding-left: 20px!important;padding-right: 20px;padding-top: 20px;padding-bottom: 10px;">
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
                                
                                
                                <!-- <tr><td colspan=3>&nbsp;</td> -->

                                <tr>
                                    <td colspan=2>Total:</td>
                                    <td align=right><b>$ <?php echo history_sum($prods); ?></b></td>
                                </tr>
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








    
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<div class="fi_message"></div>
    <script>
        $(document).ready(function() {
            $("#history_filter_form").submit(function(event) {
                event.preventDefault();
//
                var u_id = <?php echo '"' . $_SESSION['id'] . '"'; ?>;
                var main_email = <?php echo '"' . $email . '"'; ?>;
                var from_day = $("#from-day").val();
                var from_month = $("#from-month").val();
                var from_year = $("#from-year").val();
                var to_day = $("#to-day").val();
                var to_month = $("#to-month").val();
                var to_year = $("#to-year").val();
//                var ethereum_wallet = $("#ethereum_wallet").val();
                var history__type = $("#history-type").val();
                var filter_submit = $("#filter_submit").val();
                
                console.log("u_id: " + u_id + " main_email: " + main_email + " from_day: " + from_day + " from_month: " + from_month + " from_year: " + from_year + " to_day: " + to_day + " to_month: " + to_month + " to_year: " + to_year + " history__type: " + history__type + " filter_submit: " + filter_submit);

//                $("#new-password--js").val('');
                $("#filter_submit").html('<b>....</b>');
                $.ajax({
                    type: "POST",
                    url: "phpscripts/history_filter.php/",
                    data: {
                        u_id: u_id,
                        main_email: main_email,
                        from_day: from_day,
                        from_month: from_month,
                        from_year: from_year,
                        to_day: to_day,
                        to_month: to_month,
                        to_year: to_year,
                        history__type: history__type,
                        filter_submit: filter_submit
                    },
                    success: function(response) {
                        $(".fi_message").html(response);
                        //      console.log(response);
                        //      console.log("Done"); 
                        $("#filter_submit").html('Search');
                    },
                    error: function(response) {
                        console.log(response);
                        $("#filter_submit").html('Search');
                    }
                });

            });

        });

    </script>
