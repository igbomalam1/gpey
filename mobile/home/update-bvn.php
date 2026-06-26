

<div class="page-content header-clear-medium">
        
        <div class="card card-style">
            
            <div class="content">
              <?php if($data->sKYC == 1){ 
			  ?>
			  <div class="">
            <p class="mb-0 font-600 color-highlight">KYC Update</p>
                <h1>Your KYC application has been validated successfully</h1>
                <div class="list-group list-custom-small">
                                        <a href="tel:08147679277" class="external-link">
                        <i class="font-14 fa fa-address-card color-phone"></i>
                        <span>BVN</span>
                        <span class="badge bg-success">Approved</span>
                        <i class="fa fa-angle-right"></i>
                    </a>
                                        <a href="mailto:Dovesub9922@gmail.com" class="external-link">
                        <i class="fa font-14 fa-check-circle color-phone"></i>
                        <span>Approval date</span>
                        <span class="float-end"><?php echo $data->sKycDate;?></span>
                        <i class="fa fa-checkmark"></i>
                    </a>
                                              
                    

                </div>

        <a  href="./" style="width: 100%;" class="btn btn-full btn-l font-600 font-15 gradient-highlight mt-4 rounded-s">
                               <i class="fa fa-home mr-2"></i> Back to home
                            </a>
            </div>
			  <?php
			  
			  }else{?>  
                <p class="mb-0 text-center font-600 color-highlight">Update your BVN</p>
                <h1 class="text-center">Update BVN</h1>

                <hr/>
                <div class="d-flex">
                    <h5 class="d-none" style="background:<?php echo $sitecolor; ?>; color:#ffffff; padding:9px;  margin-right:5px;">Code: </h5>
                    <marquee direction="left" scrollamount="5" style="background:#f2f2f2; padding:3px; border-radius:5rem;">
                        <h5 class="py-2">
                        Kindly update your BVN .Easy and highly secure. Please note that we do not have access to your BVN nor do we store it on our SERVERS
                        </h5>
                    </marquee>
                </div>
                <hr/>
                
                <form method="post" class="bvnForm">
                        <fieldset>
 
                      
                            <div class="input-style input-style-always-active has-borders mb-4">
                                <label for="airtimeamount" class="color-theme opacity-80 font-700 font-12">Enter Your BVN</label>
                                <input type="number" name="bvn" placeholder="(BVN)" value="" class="round-small" id="bvn" required  />
                            </div>

                          
<!--
                            <div class="input-style input-style-always-active has-borders mb-2">
                                <label for="airtimeamount" class="color-theme opacity-80 font-700 font-12">First Name on BVN <span class="text-danger">*</span></label>
                                <input type="text" name="bvn_fname" placeholder="First Name on BVN " value="" class="round-small" id="bvn_fname" required  />
                            </div> 


                            <div class="input-style input-style-always-active has-borders mb-2">
                                <label for="airtimeamount" class="color-theme opacity-80 font-700 font-12">Last Name on BVN <span class="text-danger">*</span></label>
                                <input type="text" name="bvn_lname" placeholder="Last Name on BVN " value="" class="round-small" id="bvn_lname" required  />
                            </div> -->

							<div class="input-style input-style-always-active has-borders mb-2">
                                <label for="airtimeamount" class="color-theme opacity-80 font-700 font-12">BVN Registered Mobile<span class="text-danger">*</span></label>
                                <input type="number" name="bvn_mobile" placeholder="BVN Registered Mobile" value="" class="round-small" id="bvn_mobile" required  />
                            </div>
<span class="text-danger">* This is the number that is registered to your  Bank Verification Number .
It is used to verify your BVN info. We will not store it or share with third party</span>
                          

                            
                            <div class="form-button">
                            <button type="submit"  name="upgrade-bvn" style="width: 100%;" class="btn btn-full btn-l font-600 font-15 gradient-highlight mt-4 rounded-s">
                                  Upgrade
                            </button>
                            </div>
                        </fieldset>
                    </form>  

			  <?php } ?>					
            </div>

        </div>

</div>


