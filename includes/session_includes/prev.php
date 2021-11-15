      <div class="modal-holder" bis_skin_checked="1" style="display: none;">      
        <div class="modal-general withdraw-modal" bis_skin_checked="1" style="display: none;">
            <button class="modal-close">
                <svg viewBox="0 0 11.58 11.58">
                    <use xlink:href="#closeIcon"></use>
                </svg>
            </button>
            <form method="post" target="">
                <?php
                if(normalize_amount($account_balance) > 0){
                    ?>
                <div class="input-holder-byicon">
                    <label for="country" style="margin-left:10px;color:#696969">Bitcoin Wallet Adress:</label><br>
                    <input type="text" name="withdraw_bitcoin_address" id="withdraw_bitcoin_address" value="<?php
                        if(!empty($bitcoin_wallet_address)){
                            echo $bitcoin_wallet_address;
                        }else{
                            echo "Not Set";
                        }
                        ?>" style="font-size: 14px;background-color:grey" autofocus placeholder="Username" readonly>
                    <label for="country" style="margin-left:10px;color:#000">Make sure your wallet address is correct:</label><br>
                </div><br>
                <div class="input-holder-byicon">
                    <label for="country" style="margin-left:10px;color:#696969">Amount:</label><br>
                    <input type="text" name="withdraw_amount" id="withdraw_amount" value='' style="font-size: 14px;" autofocus placeholder="Amount">
                </div>
                
                
                <div class="account-modal-bottom" style="padding: 0 !important; position: relative; margin: 40px auto !important;text-align: center;display: flex;justify-content: center; ">
		<button class="btn btn--blue register-btn" style="text-decoration:none" id="register_submit"> <span>Withdraw Funds</span>
				<div class="spinner" style="display:block">
					<div class="bounce1"></div>
					<div class="bounce2"></div>
					<div class="bounce3"></div>
				</div>
			</button>
		</div>
                <div class="account-modal-bottom wi_message" style="padding: 0 !important; position: relative; margin: 40px auto !important;text-align: center;display: flex;justify-content: center; ">
                    <div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px"> Registration Successful</div>
                </div>
                <?php
                }else{
                    ?>
                <div class="error-modal">
                  <div class="modal-head">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 99.5 99.95">
                      <defs>
                        <linearGradient id="linear-gradient-error" x1="856.76" y1="412.02" x2="937.99" y2="412.02" gradientUnits="userSpaceOnUse">
                          <stop offset="0" stop-color="#ff6873"></stop>
                          <stop offset="1" stop-color="#ff896c"></stop>
                        </linearGradient>
                      </defs>
                      <path d="M902.85,455.57c-17.44,6.74-58.1-16.06-62.89-31.67-3.31-10.78,11.94-20.53,17.07-30.49,5-9.66,3.83-25.67,14.3-30.51,23-10.6,52.71.23,60.43,24.53,3.49,11-6.38,23.39-10.89,34.11C916.54,431.86,914.12,451.22,902.85,455.57Z" transform="translate(-838.49 -357.84)" fill="none" stroke="#e8f3fc" stroke-miterlimit="10" stroke-width="2"></path>
                      <path d="M937.83,411c.78,10.66-1.18,22.21-7.61,30.51a27.82,27.82,0,0,1-21.9,10.86,32.92,32.92,0,0,1-8.78-1C880,444,848,426,859,403c7-15,23-33,42.67-31.22a32.64,32.64,0,0,1,8.61,1.79,33.31,33.31,0,0,1,15.82,9.93,49.94,49.94,0,0,1,4,4.9C933,392,937.76,406.81,937.83,411Z" transform="translate(-838.49 -357.84)" fill="url(#linear-gradient-error)"></path>
                      <line x1="51.74" y1="46.79" x2="68.31" y2="63.35" fill="none" stroke="#fff" stroke-linecap="round" stroke-miterlimit="10" stroke-width="4"></line>
                      <line x1="68.31" y1="46.79" x2="51.74" y2="63.35" fill="none" stroke="#fff" stroke-linecap="round" stroke-miterlimit="10" stroke-width="4"></line>
                    </svg>
                    <h2>Sorry!</h2>
                  </div>
                  <ul>
                    <li>
                      <p>You have no funds to withdraw.</p>
                    </li>
                  </ul>
                </div>
                <?php
                }
                ?>
                
                
            </form>
        </div>
    </div>