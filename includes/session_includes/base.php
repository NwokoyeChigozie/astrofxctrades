<?php
if(!isset($_SESSION['id'])){
//        echo "<script>
//function navigate(){
//window.location = '././page=login';
//}
//
//setTimeout(navigate, 0);
//</script>";
    echo "<script>window.location.replace('./');</script>";
}
$m_username = strtolower($username);
$m_username = ucfirst($m_username);

?>
    <header>
        <div class="header-menu" bis_skin_checked="1">
            <div class="container" bis_skin_checked="1">


                <div class="row" bis_skin_checked="1">
                    
                    <?php
                                include_once('includes/nav.php');
                                include_once('includes/nav2.php');
                            ?>
                </div>
            </div>
        </div>
    </header>
    <svg id="dashboard-bg" viewBox="0 0 1536.9 492.87">
        <use xlink:href="#dashboardBg"></use>
    </svg>
    <div class="container" bis_skin_checked="1">
        <div class="user-info" bis_skin_checked="1">
            <div class="user-info__top" bis_skin_checked="1">
                <div class="user-info__name" style="width: 250px;" bis_skin_checked="1"> <span>User ID:</span><strong><?php echo $m_username; ?></strong>
                    <a href="?page=logout" class="logout_button sign-out">
                        <svg viewBox="0 0 32.04 34.75">
                            <use xlink:href="#logout"></use>
                        </svg>Sign Out</a>
                </div>
                <?php 
                if($_GET['page'] == "referals"){
                    
                    ?>
                        <div class="account-balance" bis_skin_checked="1">
                            <div class="user-info__icon" bis_skin_checked="1">
                                <svg viewBox="0 0 26.68 18.7">
                                    <use xlink:href="#referralIcon"></use>
                                  </svg>
                            </div> <span>Your Referals:</span> <strong><?php echo  $no_of_referals; ?></strong>
                        </div>
                        <div class="total-earning" bis_skin_checked="1">
                            <div class="user-info__icon" bis_skin_checked="1">
                                <svg viewBox="0 0 20.04 23.34">
                                    <use xlink:href="#totalEarningIcon"></use>
                                  </svg>
                            </div> <span>Total Commissions:</span> <strong>$<?php echo  normalize_amount($total_referal_commission); ?></strong> USD
                        </div>
                    <?php
                }elseif($_GET['page'] == "promotion" || $_GET['page'] == "edit_account"){
                    echo "";
                }else{
                    ?>
                        <div class="account-balance" bis_skin_checked="1">
                            <div class="user-info__icon" bis_skin_checked="1">
                                <svg viewBox="0 0 21.67 20.49">
                                    <use xlink:href="#balanceIcon"></use>
                                </svg>
                            </div> <span>Account Balance:</span> <strong>$<?php echo  normalize_amount($account_balance); ?></strong> USD
                        </div>
                        <div class="total-earning" bis_skin_checked="1">
                            <div class="user-info__icon" bis_skin_checked="1">
                                <svg viewBox="0 0 20.04 23.34">
                                    <use xlink:href="#totalEarningIcon"></use>
                                </svg>
                            </div> <span>Total Earnings:</span> <strong>$<?php echo  normalize_amount($earned_total); ?></strong> USD
                        </div>
                
                    <?php
                }
                
                ?>
                
            </div>
            <div class="user-info__bottom" bis_skin_checked="1">
                <ul>
                    <li>
                        <svg class="svg-email" viewBox="0 0 30 22.97" style="margin-top: -3px;">
                            <use xlink:href="#dashboardEmailIcon"></use>
                        </svg> <strong><?php echo  $email; ?></strong>
                        <a href="./?page=edit_account" class="edit-account-btn">
                            <svg viewBox="0 0 29.7 32.75">
                                <use xlink:href="#settingIcon"></use>
                            </svg>Edit Account</a>
                    </li>
                    <li>Registration Date: <span><?php echo  $reg_d; ?></span>
                    </li>
                    <li>Last Access: <span><?php echo  $last_seen; ?></span>
                    </li>
                    <li>
                        <a href="?page=logout" class="logout_button sign-out">
                            <svg viewBox="0 0 32.04 34.75">
                                <use xlink:href="#logout"></use>
                            </svg>Sign Out</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

<div class="dashboard-content">
<div class="container">
<div class="row">
<div class="col-md-4 col-sm-4 ">
  <div class="dashboard-menu">
    <ul>
      <li class="active">
        <a href="./?page=account">
          <svg viewBox="0 0 25.8 18.01">
            <use xlink:href="#dashboardIcon"></use>
          </svg>
          Dashboard
        </a>
      </li>
      <li>
        <a class="make-invest-focus" href="?page=account#invest">
          <svg viewBox="0 0 23.26 23.93">
            <use xlink:href="#depositIcon"></use>
          </svg>
          Deposit
        </a>
      </li>
      <li> <a onclick="openModal('withdrawal-modal')">
        <svg viewBox="0 0 29.92 21.03">
          <use xlink:href="#WithdrawIcon"></use>
        </svg>
        Withdraw Funds </a> </li>
      <li>
        <a href="./?page=deposit_list">
          <svg viewBox="0 0 23.13 27.23"><use xlink:href="#depositIcon"></use></svg>
          My Investments
        </a>
      </li>
      <li> <a href="./?page=history">
        <svg viewBox="0 0 23.13 27.23">
          <use xlink:href="#earningHistory"></use>
        </svg>
        Transactions </a> </li>
      <li> <a href="./?page=referals">
        <svg viewBox="0 0 26.68 18.7">
          <use xlink:href="#referralIcon"></use>
        </svg>
        Referrals </a> </li>
<!--
		      <li> <a href="./?page=security">
        <svg viewBox="0 0 17.88 21.09">
            <use xlink:href="#lockIcon"></use>
        </svg>
        Security </a> </li>
-->
		      <li> <a href="./?page=edit_account">
        <svg viewBox="0 0 29.7 32.75">
          <use xlink:href="#settingIcon"></use>
        </svg>
        Settings </a> </li>
        
      <li style="display:none"> <a id="open_counter" onclick="openModal('count_down-modal')">
         </a> </li>
      <li>
      <li style="display:none"> <a id="deposit_onclick1" onclick="openModal('deposit_modal1')">
         </a> </li>
      <li>
      <li style="display:none"> <a id="deposit_onclick1" onclick="openModal('deposit_modal1')">
         </a> </li>
      <li>
      <li style="display:none"> <a id="deposit_onclick2" onclick="openModal('deposit_modal2')">
         </a> </li>
    </ul>
    <a href="?page=logout" class="logout_button edit-account-btn">
    <svg viewBox="0 0 32.04 34.75">
      <use xlink:href="#logout"></use>
    </svg>
    Sign Out </a>
  </div>
</div>
