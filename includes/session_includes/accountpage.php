
                <div class="col-md-8 col-sm-8" bis_skin_checked="1">
                    <div class="invest-dark-bg" style="display:none;" bis_skin_checked="1"></div>
                    <div class="make-invest" bis_skin_checked="1">
                        <div id="spinnerdepo" class="spinner" style="padding-top: 180px; position: absolute; display: none;" bis_skin_checked="1">
                            <div class="bounce1" bis_skin_checked="1"></div>
                            <div class="bounce2" bis_skin_checked="1"></div>
                            <div class="bounce3" bis_skin_checked="1"></div>
                        </div>
<!--                        <iframe name="depositrex" src="./?page=deposit" id="depositIframe" frameborder="0" scrolling="no" onload="resizeIframe($(this))" style="min-height: 450px; height: 1071px;" bis_size="{&quot;x&quot;:447,&quot;y&quot;:421,&quot;w&quot;:796,&quot;h&quot;:450,&quot;abs_x&quot;:447,&quot;abs_y&quot;:421}">
</iframe>-->
                        <form method="post" name="spendform">

                            <div class="make-invest" style="border-radius: initial!important;background-color: initial!important;box-shadow:initial!important;">
                                <script language="javascript">
						<!--
						                        function openCalculator(id) {
						
						                            w = 225;
						                            h = 400;
						                            t = (screen.height - h - 30) / 2;
						                            l = (screen.width - w - 30) / 2;
						                            window.open('./?a=calendar&type=' + id, 'calculator' + id, "top=" + t + ",left=" + l + ",width=" + w + ",height=" + h + ",resizable=1,scrollbars=0");
						
						                            {
						                                /literal} {
						                                if $qplans > 1
						                            } {
						                                literal
						                            }
						                            for (i = 0; i < document.spendform.h_id.length; i++) {
						                                if (document.spendform.h_id[i].value == id) {
						                                    document.spendform.h_id[i].checked = true;
						                                }
						                            } {
						                                /literal} { /
						                                if
						                            } {
						                                literal
						                            }
						
						                        }
						
						                        function updateCompound() {
						                            var id = 0;
						                            var tt = document.spendform.h_id.type;
						                            if (tt && tt.toLowerCase() == 'hidden') {
						                                id = document.spendform.h_id.value;
						                            } else {
						                                for (i = 0; i < document.spendform.h_id.length; i++) {
						                                    if (document.spendform.h_id[i].checked) {
						                                        id = document.spendform.h_id[i].value;
						                                    }
						                                }
						                            }
						
						                            var cpObj = document.getElementById('compound_percents');
						                            if (cpObj) {
						                                while (cpObj.options.length != 0) {
						                                    cpObj.options[0] = null;
						                                }
						                            }
						
						                            if (cps[id] && cps[id].length > 0) {
						                                document.getElementById('coumpond_block').style.display = '';
						
						                                for (i in cps[id]) {
						                                    cpObj.options[cpObj.options.length] = new Option(cps[id][i]);
						                                }
						                            } else {
						                                document.getElementById('coumpond_block').style.display = 'none';
						                            }
						                        }
						                        var cps = {};
						
						                        -->
					</script>
                                <div class="make-invest__top">
                                    <div class="invest-title">
                                        <svg viewBox="0 0 22.74 22.02">
                                            <use xlink:href="#investIcon"></use>
                                        </svg> <strong>Make a New Deposit</strong>  <span>Minimum Deposit Amount: 100 USD</span> 
                                    </div>
                                    <div class="invest-input">
                                        <div>
                                            <input id="txtAmount" name="amount" value="100" type="number" placeholder="Enter Deposit Amount" style="border:2px solid rgba(90, 144, 177, 0.5)">
                                            <svg class="icon" viewBox="0 0 512 512" fill="#47a9d4">
                                                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="555.366px" height="555.366px" viewBox="0 0 555.366 555.366" style="enable-background:new 0 0 555.366 555.366;" xml:space="preserve">
                                                    <g>
                                                        <g>
                                                            <path d="M312.843,224.751c-29.798-8.244-67.889-14.59-86.99-41.75c-6.622-9.418-9.933-19.608-9.933-30.576
                c0-12.001,3.623-22.975,10.863-32.907c6.952-9.535,17.607-16.267,29.541-19.963c26.775-8.28,54.964-1.848,70.001,22.699
                c1.628,2.656,14.468,26.42,11.897,26.756c0.043-0.006,78.537-10.245,78.537-10.245c-5.379-31.041-17.797-55.827-37.252-74.346
                s-45.631-29.75-78.538-33.685V0h-45.013v30.735c-35.594,3.519-64.107,16.818-85.527,39.89s-32.13,51.585-32.13,85.527
                c0,33.525,9.468,62.033,28.403,85.521c22.381,27.717,55.582,42.13,89.107,53.079c9.81,3.2,19.639,6.107,29.235,8.966
                c20.178,6.003,42.02,9.73,56.126,27.05c8.171,10.037,12.259,21.989,12.259,35.852c0,15.52-4.859,29.026-14.59,40.514
                c-29.089,34.352-87.657,24.964-113.312-8.843c-9.107-12.002-15.312-26.285-18.624-42.84l-81.022,8.69
                c6.206,40.771,20.49,72.332,42.84,94.682c22.351,22.351,51.426,35.698,87.229,40.044v56.5h45.013v-58.049
                c40.355-5.796,71.867-21.523,94.523-47.185c22.662-25.662,33.996-57.223,33.996-94.683c0-33.525-9.002-60.998-27.007-82.418
                C380.396,246.747,344.942,233.631,312.843,224.751z"></path>
                                                        </g>
                                                    </g>
                                                    <g></g>
                                                    <g></g>
                                                    <g></g>
                                                    <g></g>
                                                    <g></g>
                                                    <g></g>
                                                    <g></g>
                                                    <g></g>
                                                    <g></g>
                                                    <g></g>
                                                    <g></g>
                                                    <g></g>
                                                    <g></g>
                                                    <g></g>
                                                    <g></g>
                                                </svg>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="make-invest__bottom">
								<h4 style="text-transform: uppercase; margin-bottom: 10px;">Select Your Investment Plan</h4>
                                   <div class="select-plan">   									<input type="hidden" class="plantyper" value="1">
									<input type="radio" name="h_id" value="1" class="plantyper planRadio planyx" id="plan-1" checked="">
									<label for="plan-1" class="select-plan-item col-xl-6 col-lg-6 col-md-12 col-sm-12" style="margin-bottom: 10px;"> <b>3.30%</b>  Profit daily<span>For 3  Day(s)</span>
										</label>    									<input type="hidden" class="plantyper" value="2">
									<input type="radio" name="h_id" value="2" class="plantyper planRadio planyx" id="plan-2">
									<label for="plan-2" class="select-plan-item col-xl-6 col-lg-6 col-md-12 col-sm-12" style="margin-bottom: 10px;"> <b>6.00%</b>  Profit daily <span>For 5  Day(s)</span>
										</label>    									<input type="hidden" class="plantyper" value="3">
									<input type="radio" name="h_id" value="3" class="plantyper planRadio planyx" id="plan-3">
									<label for="plan-3" class="select-plan-item col-xl-6 col-lg-6 col-md-12 col-sm-12" style="margin-bottom: 10px;"> <b>6.40%</b>  Profit daily <span>For 7  Day(s)</span>
										</label>    									<input type="hidden" class="plantyper" value="4">
									<input type="radio" name="h_id" value="4" class="plantyper planRadio planyx" id="plan-4">
									<label for="plan-4" class="select-plan-item col-xl-6 col-lg-6 col-md-12 col-sm-12" style="margin-bottom: 10px;"> <b>15.00%</b>  Profit daily <span>For 6-12months(s)</span>
										</label> </div> 
                                    <div class="float-profit-svg dashboard">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 346.47 410.99">
										<defs>
											<linearGradient id="linear-gradient-profit" x1="558.59" y1="275.14" x2="753.4" y2="275.14" gradientUnits="userSpaceOnUse">
												<stop offset="0" stop-color="#ff6873"></stop>
												<stop offset="1" stop-color="#ff896c"></stop>
											</linearGradient>
											<clipPath id="clip-path" transform="translate(-507.77 -176.92)">
												<path d="M752.92,273.24c-1.34,16.77-5.32,32.81-11.1,43.67-5.78,11.2-13.37,17.23-22.13,21.63s-18.73,7.2-29.44,12.15C679.53,355.34,668,362.17,656,367.57s-23.53,7.74-34.25,3.9C611,368,601.09,358.21,592.31,346.65c-17.47-25.57-30.49-50.47-33.23-68.56s5.94-46.78,23.54-74c8.77-12.67,19.7-22.77,32.18-25.86,12.47-3.45,26.48.09,41.2,6.61s28.73,14.42,41.2,19.24c12.48,5.17,23.41,7.29,32.18,10.51s15.37,7.55,19.4,17.36C752.81,241.46,754.26,256.42,752.92,273.24Z" fill="none"></path>
											</clipPath>
											<linearGradient id="linear-gradient-profit-2" x1="529.87" y1="425.18" x2="854.24" y2="425.18" gradientUnits="userSpaceOnUse">
												<stop offset="0" stop-color="#9f95ed"></stop>
												<stop offset="1" stop-color="#a567a3"></stop>
											</linearGradient>
											<linearGradient id="linear-gradient-profit-3" x1="507.77" y1="438.84" x2="834.44" y2="438.84" gradientUnits="userSpaceOnUse">
												<stop offset="0" stop-color="#69d2cd"></stop>
												<stop offset="1" stop-color="#44a5d5"></stop>
											</linearGradient>
										</defs>
										<path d="M755.88,280.67c2.28,10.26,3.2,21,1.31,32.11A100.21,100.21,0,0,1,747,341.88a41.92,41.92,0,0,1-16.31,18.46c-7.33,4.54-16.09,7.79-25.3,10.37-9,2.39-18.63,2.87-27.83,2.56-9.25-.67-18.35-1.66-27.52-3.17a217.09,217.09,0,0,0-24,.07c-9,.66-17.21.55-24.58-2.05s-14.24-8.56-20.37-17.1a185.74,185.74,0,0,1-11.53-19.54c-3.48-6.77-6.65-13.54-9.57-20.54-3.15-6.65-6.46-13.87-10.17-22.08a128.7,128.7,0,0,1-10-31.55c-1.61-11.34-1-21.27,2.12-29.18a39.67,39.67,0,0,1,15.5-18.66c7-4.65,15-8.37,23.12-11.8s15.61-7.23,22.9-10.66a79.8,79.8,0,0,1,23.3-7,102.48,102.48,0,0,1,21.39-.63c7.45.43,15.62,1,24.89.69s19.11-1.42,27.61-1.14,15,3,18.91,8.48,6.77,13.85,10.45,24.14,8.22,21.46,12.77,32.78q4.17,9.48,7.52,18.6C752.46,269,754.36,274.91,755.88,280.67Z" transform="translate(-507.77 -176.92)" fill="none" stroke="#e8f3fc" stroke-miterlimit="10" stroke-width="3"></path>
										<path d="M752.92,273.24c-1.34,16.77-5.32,32.81-11.1,43.67-5.78,11.2-13.37,17.23-22.13,21.63s-18.73,7.2-29.44,12.15C679.53,355.34,668,362.17,656,367.57s-23.53,7.74-34.25,3.9C611,368,601.09,358.21,592.31,346.65c-17.47-25.57-30.49-50.47-33.23-68.56s5.94-46.78,23.54-74c8.77-12.67,19.7-22.77,32.18-25.86,12.47-3.45,26.48.09,41.2,6.61s28.73,14.42,41.2,19.24c12.48,5.17,23.41,7.29,32.18,10.51s15.37,7.55,19.4,17.36C752.81,241.46,754.26,256.42,752.92,273.24Z" transform="translate(-507.77 -176.92)" fill="url(#linear-gradient-profit)"></path>
										<g clip-path="url(#clip-path)">
											<path class="percent-path" d="M840.72,448c-26.43,35.59-63.65,65.51-89.39,88-27.09,22.32-42.69,37.21-56.88,39.11-14.18,1.65-29.77-10.89-56.85-37.49-25.73-26.24-63-66.53-89.38-112.07s-22.09-106-1.09-135.63c17.54-24.77,25.54,32.28,119.54,5.52,182.66-52,175,6.82,178,53.85C847.15,388.63,867.13,412.5,840.72,448Z" fill="url(#linear-gradient-profit-2)" style="transform: translateY(-116px) translateX(-507.77px);"></path>
											<path class="percent-path" d="M820.92,460.67c-26.43,35.58-63.65,65.51-89.39,88-27.08,22.32-42.69,37.2-56.88,39.11-14.18,1.65-29.77-10.9-56.85-37.5C592.07,524,554.85,483.74,528.42,438.2s-28.25-111.48-1.09-135.62C553.14,278.08,566,318.33,662,301,847.19,267.56,821.89,314.92,824.86,362,827.35,401.29,847.33,425.17,820.92,460.67Z" fill="url(#linear-gradient-profit-3)" style="transform: translateY(-116px) translateX(-507.77px);"></path>
										</g>
									</svg>
									<div> <strong id="lblProfit"></strong><b>%</b>
										<span id="lblProfitType">Profit</span>
									</div> <small id="lblProfitPeriod" style="position:relative;"></small>
								</div>
                                    <div class="profit-calc">
									<div class="profit-calc__item"> <strong id="lblSelectedPlan"></strong>  <span>Trading Plan</span> 
									</div>
									<div class="profit-calc__item"> <strong id="lblDailyProfit"></strong><strong> USD</strong>  <span>Profit</span> 
									</div>
									<div class="profit-calc__item"> <strong id="lblTotalProfit"></strong><strong> USD</strong>  <span>Total Profit</span> 
									</div>
									<div class="profit-calc__item"> <strong id="lblTotalReturn"></strong><strong> USD</strong>  <span> Total Return</span> 
									</div>
								</div>
                                    <div class="deposit-payment">
									<h4 style="text-transform: uppercase; margin-bottom: 10px;text-align:center">Select Your Payment Method</h4>
									<div > 										
                                        <div class="payment-item hvr-float-shadow" style="margin-bottom: 20px;">
											<div class="icon-holder" style="display: flex;justify-content: center; ">
												<img style="height:28px;width:28px" id="payment_1006" src="https://astroforex.net/styles/img/pay/0d.svg" alt="Template Rex">
											</div>
											<div class="balance" style="text-align:center">Bitcoin <br><span>0.00 USD</span>
											</div>
											<div class="select-method" style="display:none">
												<label class="radio-container d-block">Direct Investment
													<input id="process_1006" class="pt" type="radio" name="type" value="process_1006" checked=""> <span class="checkmark"></span>
												</label></div>
										</div> </div>
                                        <div class="make-invest-action" style="padding-bottom: 70px;">
									<button class="btn btn--blue calculateMakeInvest" id="make_deposit">Make a Deposit</button>
                                      <div class="account-modal-bottom de_message" style="padding: 0 !important; position: relative; margin: 40px auto !important;text-align: center;display: flex;justify-content: center; ">
                    
                                        </div>
								</div>
								</div>
                                 
							</div>
                                
                                
                                
                                
                            </div>
                        </form>
                    </div>
                      <div class="invest-rate" bis_skin_checked="1">
                        <div class="invest-rate__left" bis_skin_checked="1">
                            <div class="invest-rate__title" bis_skin_checked="1">
                                <svg viewBox="0 0 49.05 57.09">
                                    <use xlink:href="#investColor"></use>
                                </svg> <strong>$<?php echo  normalize_amount($total_deposit); ?> USD</strong> Total Investment</div>
                            <div class="invest-rate__detail" bis_skin_checked="1">
<!--
                                <ul>
                                    <li>Active Investment:</li>
                                    <li><strong>$<?php echo  normalize_amount($active_deposit); ?> USD</strong>
                                    </li>
                                </ul>
-->
                                <ul>
                                    <li>Last Investment:</li>
                                    <li><strong>$<?php echo  normalize_amount($last_deposit); ?> USD</strong> <span class="date-time" style="opacity:0; visibility:hidden;">n/a</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div bis_skin_checked="1">
                            <div class="invest-rate__title" bis_skin_checked="1">
                                <svg viewBox="0 0 58.58 50.99">
                                    <use xlink:href="#withdrawColor"></use>
                                </svg> <strong>$<?php echo  normalize_amount($total_withdrawal); ?> USD</strong> Total Withdrawals</div>
                            <div class="invest-rate__detail" bis_skin_checked="1">
                                <ul>
                                    <li>Withdrawals Pending:</li>
                                    <li><strong>$<?php echo  normalize_amount($pending_withdrawal); ?> USD</strong>
                                    </li>
                                </ul>
                                <ul>
                                    <li>Last Withdrawal</li>
                                    <li><strong>$<?php echo  normalize_amount($last_withdrawal); ?> USD</strong> <span class="date-time" style="opacity:0; visibility:hidden;">n/a</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer>
    <div class="hidden-menu" style="display:none;" bis_skin_checked="1">
        <button class="hidden-menu-close">
            <svg viewBox="0 0 11.58 11.58" stroke="#3e617f" style="width: 18px; height: 18px; ">
                <use xlink:href="#closeIcon"></use>
            </svg>
        </button>
        <ul class="menuList">
            <li><a href="./?a=cust&amp;page=about">About Us</a></li>
            <!--<li><a href="./?a=cust&amp;page=guide">How It Works</a></li>-->
            <li><a href="./?a=cust&amp;page=testimonials">Testimonials</a></li>
            <li><a href="./?a=cust&amp;page=partnership">Invite a Friend</a></li>
            <!--
    <li><a href="./?a=news">Blog</a></li> -->
            <li><a href="./?page=support">Contact Us</a></li>
            <!--<li><a href="/proofs">Payment Proofs</a></li>-->
            <li><a href="./?page=account">Member Area</a></li>
            <li><a href="" class="logout_button">Sign Out</a></li>
        </ul>
    </div>
    <div class="modal-holder" bis_skin_checked="1" style="display: none;">
        <div class="modal-general deposit-modal" bis_skin_checked="1">
            <button class="modal-close">
                <svg viewBox="0 0 11.58 11.58">
                    <use xlink:href="#closeIcon"></use>
                </svg>
            </button>
            <iframe src="./?page=deposit" id="depositIframe" frameborder="0" scrolling="no" onload="resizeIframe($(this))" bis_size="{&quot;x&quot;:0,&quot;y&quot;:0,&quot;w&quot;:0,&quot;h&quot;:0,&quot;abs_x&quot;:0,&quot;abs_y&quot;:0}" style="height: 0px;"></iframe>
        </div>

        <div class="modal-general release-modal" bis_skin_checked="1">
            <button class="modal-close">
                <svg viewBox="0 0 11.58 11.58">
                    <use xlink:href="#closeIcon"></use>
                </svg>
            </button>
            <iframe id="releaseIframe" frameborder="0" scrolling="no" onload="resizeIframe($(this))" style="height: 0px;"></iframe>
        </div>
    </div>
    <script>
        $('#depositIframe').on("load", function() {
            document.getElementById('spinnerdepo').style.display = "none"; <
            !--console.log('iframe loaded completely');
            -- > //replace with code to hide loader
        });

    </script>


    

        
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>       
    <script>
        var type;
        $(document).ready(function() {
            $("#make_deposit").click(function(event) {
                
                event.preventDefault();
                var d_am = $("#txtAmount").val();
                type = $("input[name='h_id']:checked").val();
                console.log('Type: ' + type);
                if(d_am < 100){
                    $('.de_message').html('<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Minimum amount is $200</div>');
                }else{
                    if(type == "1" && d_am < 100){
                       $('.de_message').html('<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Minimum amount for this plan is $100</div>');
                    }else if(type == "2" && d_am < 5000){
                        $('.de_message').html('<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Minimum amount for this plan is $5000</div>');
                    }else if(type == "3" && d_am < 10000){
                         $('.de_message').html('<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Minimum amount for this plan is $10000</div>');    
                    }else if(type == "4" && d_am < 1000){
                         $('.de_message').html('<div class="alert alert-danger" style="border-radius:3px;text-align:center;background-color:#E23D28;color:#fff;padding:10px 85px;margin-top:0px">Minimum amount for this plan is $1000</div>');    
                    }else{
//                        if(d_am > 999){
//                           type = "2"; 
//                        }else if(d_am > 4999){
//                           type = "3";      
//                        }else if(d_am > 9999){
//                           type = "4";      
//                        }
                        
                        if(type == "1" && d_am > 4999){
                            type = "2";
                        }else if(type == "2" && d_am > 19999){
                            type = "3";     
                        }
                        
                      $('#de_amount').attr('value', d_am)
                    $("#deposit_onclick1").trigger("click");       
                    }
                    
                }

            });

        });

    </script>
