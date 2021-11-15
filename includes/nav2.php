<?php
//echo '<br><br><br><pre>' . print_r($_SESSION, TRUE) . '</pre>';
if(isset($_SESSION['id'])){
    ?>
<div class="col-lg-3 col-md-3 col-sm-4 col-xs-6 text-right" bis_skin_checked="1">
          <button class="navigation__menuButton">
          <svg id="menuIcon" viewBox="0 0 114.03 93">
            <svg style="fill:#3e617f;" height="100px" viewBox="0 -53 384 384" width="100px" xmlns="http://www.w3.org/2000/svg"><path d="m368 154.667969h-352c-8.832031 0-16-7.167969-16-16s7.167969-16 16-16h352c8.832031 0 16 7.167969 16 16s-7.167969 16-16 16zm0 0"></path><path d="m368 32h-352c-8.832031 0-16-7.167969-16-16s7.167969-16 16-16h352c8.832031 0 16 7.167969 16 16s-7.167969 16-16 16zm0 0"></path><path d="m368 277.332031h-352c-8.832031 0-16-7.167969-16-16s7.167969-16 16-16h352c8.832031 0 16 7.167969 16 16s-7.167969 16-16 16zm0 0"></path></svg>
          </svg>
          </button>
                    					 <a href="?page=account" id="dashboardBtn" class="btn btn--blue hidden-xs">Dashboard</a>
    
    
                     <a href="?page=logout" class="logout_button" id="logoutBtn" class="btn hidden-xs" style="margin-left: 10px;background: rgba(255,255,255,0.4);box-shadow: 0 10px 10px 0 rgba(19, 150, 215, 0.11); padding:10px 10px;border-radius:5.5px">Sign Out</a>
    
							</div>
    <?php
}else{
    ?>
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6 text-right">
                        <button class="navigation__menuButton">
                            <svg id="menuIcon" viewBox="0 0 114.03 93">
                                <svg style="fill:#3e617f;" height="100px" viewBox="0 -53 384 384" width="100px" xmlns="http://www.w3.org/2000/svg">
                                    <path d="m368 154.667969h-352c-8.832031 0-16-7.167969-16-16s7.167969-16 16-16h352c8.832031 0 16 7.167969 16 16s-7.167969 16-16 16zm0 0" />
                                    <path d="m368 32h-352c-8.832031 0-16-7.167969-16-16s7.167969-16 16-16h352c8.832031 0 16 7.167969 16 16s-7.167969 16-16 16zm0 0" />
                                    <path d="m368 277.332031h-352c-8.832031 0-16-7.167969-16-16s7.167969-16 16-16h352c8.832031 0 16 7.167969 16 16s-7.167969 16-16 16zm0 0" /></svg>
                            </svg>
                        </button>
                        <div id="signupBtn" class="btn hidden-xs pointer" onclick="openModal('register-modal')" style="margin-right: 10px;background: rgba(255,255,255,0.4);box-shadow: 0 10px 10px 0 rgba(19, 150, 215, 0.11);">Signup</div>
                        <div id="loginBtn" class="btn btn--blue hidden-xs pointer" onclick="openModal('account-modal')">Login</div>
                    <a style="display:none" id="forgot_p_onclick" onclick="openModal('forgot-modal2')">
         </a>
                    </div>
    <?php
}

?>

