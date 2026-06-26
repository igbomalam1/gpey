

<div class="page-content header-clear-medium">
      
        
        <div class="card card-style bg-theme pb-0">
            <div class="content" id="tab-group-1">
                <div class="tab-controls tabs-small tabs-rounded" data-highlight="bg-highlight">
                    <a href="#" data-active data-bs-toggle="collapse" data-bs-target="#tab-1">Bank</a>
                    <a href="#" data-bs-toggle="collapse" data-bs-target="#tab-2">Direct Funding</a>
                    <a href="#" data-bs-toggle="collapse" data-bs-target="#tab-3">Manual</a>
                </div>
                <div class="clearfix mb-3"></div>

                <div data-bs-parent="#tab-group-1" class="collapse show" id="tab-1">

                  <?php if($data->sKYC == 0): ?>

                  <div class="text-center">
                    <span class="icon icon-l gradient-blue shadow-l rounded-sm">
                      <i class="fa fa-arrow-up font-30 color-white"></i>
                    </span>
                    <h4 class="text-primary mt-3">Generate Your Dedicated Account</h4>
                    <p class="mb-2 text-dark font-600 font-14">
                      To fund your wallet automatically via bank transfer, verify your BVN below. 
                      Your BVN is used solely for verification — we do not store it on our servers.
                    </p>
                  </div>

                  <form method="post" class="bvnForm">
                    <div class="input-style input-style-always-active has-borders mb-3">
                      <label class="color-theme opacity-80 font-700 font-12">Enter Your BVN</label>
                      <input type="number" name="bvn" placeholder="11-digit BVN" value="" class="round-small" required maxlength="11" />
                    </div>
                    <div class="input-style input-style-always-active has-borders mb-3">
                      <label class="color-theme opacity-80 font-700 font-12">BVN Registered Mobile</label>
                      <input type="number" name="bvn_mobile" placeholder="Phone number linked to BVN" value="" class="round-small" required />
                    </div>
                    <span class="text-danger font-12">* This number is registered to your BVN. Used only for verification.</span>
                    <button type="submit" name="upgrade-bvn" style="width: 100%;" class="btn btn-full btn-l font-600 font-15 gradient-highlight mt-4 rounded-s">
                      <i class="fa fa-check-circle mr-2"></i> Verify & Generate Account
                    </button>
                  </form>

                  <?php else: ?>

                  <div class="text-center">
                    <span class="icon icon-l gradient-green shadow-l rounded-sm">
                      <i class="fa fa-check font-30 color-white"></i>
                    </span>
                    <h4 class="text-primary mt-3">Your Dedicated Accounts</h4>
                    <p class="mb-2 text-dark font-600 font-14">
                      Use any of the accounts below to fund your wallet automatically.
                    </p>
                  </div>

                  <?php $chargesText = $controller->getConfigValue($data2,"monifyCharges"); ?>
                  <?php if($chargesText == 50 || $chargesText == "50"){$chargesText = "N".$chargesText;} else {$chargesText = $chargesText."%";} ?>

                  <div class="row mb-0">
                    <?php if($controller->getConfigValue($data2,"monifyWeStatus") == "On" && !empty($data->sBankNo)): ?>
                    <div class="col-12 col-sm-6 col-lg-4 mb-3">
                      <div class="card card-style bg-blue-dark shadow-xl rounded-m" data-card-height="170">
                        <div class="card-top mt-3 ms-3 me-3">
                          <h5 class="color-white font-700">Wema Bank</h5>
                        </div>
                        <div class="card-center text-center">
                          <h3 class="color-white font-800 mb-0" style="letter-spacing:2px;"><?php echo $data->sBankNo; ?></h3>
                        </div>
                        <div class="card-bottom mb-3 ms-3 me-3">
                          <a href="#" class="btn btn-s font-600 float-start rounded-s bg-white color-blue-dark" onclick="copyToClipboard('<?php echo $data->sBankNo; ?>')">
                            <i class="fa fa-copy me-1"></i> Copy
                          </a>
                          <span class="float-end color-white opacity-70 font-10 mt-2">+<?php echo $chargesText; ?> charge</span>
                        </div>
                      </div>
                    </div>
                    <?php endif; ?>

                    <?php if($controller->getConfigValue($data2,"monifyMoStatus") == "On" && !empty($data->sRolexBank)): ?>
                    <div class="col-12 col-sm-6 col-lg-4 mb-3">
                      <div class="card card-style bg-green-dark shadow-xl rounded-m" data-card-height="170">
                        <div class="card-top mt-3 ms-3 me-3">
                          <h5 class="color-white font-700">Moniepoint Bank</h5>
                        </div>
                        <div class="card-center text-center">
                          <h3 class="color-white font-800 mb-0" style="letter-spacing:2px;"><?php echo $data->sRolexBank; ?></h3>
                        </div>
                        <div class="card-bottom mb-3 ms-3 me-3">
                          <a href="#" class="btn btn-s font-600 float-start rounded-s bg-white color-green-dark" onclick="copyToClipboard('<?php echo $data->sRolexBank; ?>')">
                            <i class="fa fa-copy me-1"></i> Copy
                          </a>
                          <span class="float-end color-white opacity-70 font-10 mt-2">+<?php echo $chargesText; ?> charge</span>
                        </div>
                      </div>
                    </div>
                    <?php endif; ?>

                    <?php if($controller->getConfigValue($data2,"monifySaStatus") == "On" && !empty($data->sSterlingBank)): ?>
                    <div class="col-12 col-sm-6 col-lg-4 mb-3">
                      <div class="card card-style bg-red-dark shadow-xl rounded-m" data-card-height="170">
                        <div class="card-top mt-3 ms-3 me-3">
                          <h5 class="color-white font-700">Sterling Bank</h5>
                        </div>
                        <div class="card-center text-center">
                          <h3 class="color-white font-800 mb-0" style="letter-spacing:2px;"><?php echo $data->sSterlingBank; ?></h3>
                        </div>
                        <div class="card-bottom mb-3 ms-3 me-3">
                          <a href="#" class="btn btn-s font-600 float-start rounded-s bg-white color-red-dark" onclick="copyToClipboard('<?php echo $data->sSterlingBank; ?>')">
                            <i class="fa fa-copy me-1"></i> Copy
                          </a>
                          <span class="float-end color-white opacity-70 font-10 mt-2">+<?php echo $chargesText; ?> charge</span>
                        </div>
                      </div>
                    </div>
                    <?php endif; ?>
                  </div>

                  <?php endif; ?>

                </div>

                <div data-bs-parent="#tab-group-1" class="collapse" id="tab-2">
                        <div class="text-center">
                            <p class="text-center">
                                <span class="icon icon-l gradient-blue shadow-l rounded-sm">
                                    <i class="fa fa-arrow-up font-30 color-white"></i>
                                </span>
                            </p>
                            <h4 class="text-primary">FUND WALLET</h4>
                            <p class="mb-2 text-dark font-600 font-16">
                                Pay with card, bank transfer, ussd, or bank deposit. Secured by Novac
                            </p>
                    
                        </div>
                        
                        <?php if($controller->getConfigValue($data2,"novacStatus") == "On"): ?>
                        <form  method="post">
                        <div class="mt-5 mb-3">
                            
                            <div class="input-style has-borders no-icon input-style-always-active mb-4">
                                <input type="hidden" value="<?php echo $controller->getConfigValue($data2,"novacCharges"); ?>" id="paystackcharges" name="paystackcharges" />
                                <input type="number" onkeyup="calculatePaystackCharges()" class="form-control" id="amount" name="amount" placeholder="Amount" required>
                                <label for="amount" class="color-highlight">Amount</label>
                                <em>(required)</em>
                            </div>
                            <div class="input-style has-borders no-icon input-style-always-active  mb-4">
                                <input type="text" class="form-control" id="charges" placeholder="Charges" readonly>
                                <label for="charges" class="color-highlight">Charges</label>
                                <em>(required)</em>
                            </div>
                            <div class="input-style has-borders no-icon input-style-always-active  mb-4">
                                <input type="text" class="form-control" id="amounttopay" placeholder="You Would Get" readonly>
                                <label for="amounttopay" class="color-highlight">You Would Get</label>
                                <em>(required)</em>
                            </div>

                            <input type="hidden" name="email" value="<?php echo $data->sEmail; ?>" />
                        </div>

                        <div class="text-center">
                            <i class="fa fa-credit-card fa-4x text-primary"></i>
                            <h5 class="mt-2">Novac Payment</h5>
                        </div>
                        <button type="submit" id="fund-with-novac" name="fund-with-novac" style="width: 100%;" class="btn btn-full btn-l font-600 font-15 gradient-highlight mt-4 rounded-s">
                                Pay Now
                        </button>
                        </form>
                        <?php else : ?>
                            <h3 class="text-center text-danger">Opps!! Novac Payment Is Disabled, Please Contact Admin</h3>
                        <?php endif; ?>
                </div>

                <div data-bs-parent="#tab-group-1" class="collapse" id="tab-3">
                <div class="text-center">
                    <p class="text-center">
                        <span class="icon icon-l gradient-blue shadow-l rounded-sm">
                            <i class="fa fa-arrow-up font-30 color-white"></i>
                        </span>
                    </p>
                    <h4 class="text-primary">FUND WALLET</h4>
                    <p class="mb-2 text-dark font-600 font-16"><b>Bank Name: </b><?php echo $data3->bankname; ?></p>
                    <p class="mb-2 text-dark font-600 font-16"><b>Account Name: </b><?php echo $data3->accountname; ?></p>
                    <p class="mb-2 text-dark font-600 font-16"><b>Account No: </b><?php echo $data3->accountno; ?></p>
                    <p class="mb-2 text-danger font-600 font-15"><b>Note: </b> Send Payment screenshot and your Gpey email to admin to get funded immediately</p>
                    <button class="btn btn-primary font-700 rounded-xl mt-3" onclick="copyToClipboard('<?php echo $data3->accountno; ?>')">Copy Account No</button>
                    <a class="btn btn-success font-700 rounded-xl mt-3" href="https://wa.me/234<?php echo $data3->whatsapp; ?>">Contact Admin</a>
                    
                </div>
                </div>

                
                
            </div>
        </div> 

</div>

