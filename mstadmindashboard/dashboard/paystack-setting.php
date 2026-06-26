
<div class="d-flex justify-content-between">
    <a class="btn btn-success btn-block mr-2" href="api-setting">General Setting</a> 
    <a class="btn btn-primary btn-block ml-2 mt-0" href="monnify-setting">Monnify Setting</a>
    <a class="btn btn-info btn-block ml-4 mt-0" href="paystack-setting">Paystack Setting</a>
</div>
<hr/>

<div class="row">
<div class="col-12">
    
    <div class="box">
        <div class="box-header with-border">
          <h4 class="box-title">Novac API Settings</h4>
        </div>
        <div class="box-body">
        <form  method="post" class="form-submit">

                <div class="form-group">
                    <label class="control-label">Novac Public Key</label>
                    <div class="">
                    <input type="text" name="novacPublicKey" value="<?php echo $controller->getConfigValue($data,"novacPublicKey"); ?>" class="form-control" placeholder="pk_live_...">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label">Novac Secret Key</label>
                    <div class="">
                    <input type="text" name="novacSecretKey" value="<?php echo $controller->getConfigValue($data,"novacSecretKey"); ?>" class="form-control" placeholder="sk_live_...">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label">Wallet Topup Charges (In Percentage %)</label>
                    <div class="">
                    <input type="text" name="novacCharges" pattern="^\d*(\.\d{0,3})?$" value="<?php echo $controller->getConfigValue($data,"novacCharges"); ?>" class="form-control" required="required">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label">Novac Activation</label>
                    <div class="">
                        <select name="novacStatus" class="form-control">
                        <?php if($controller->getConfigValue($data,"novacStatus") == "On"): ?>
                            <option value="On" selected>On</option>
                            <option value="Off">Off</option>
                        <?php else: ?>
                            <option value="On">On</option>
                            <option value="Off" selected>Off</option>
                        <?php endif; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="">
                       <button type="submit" name="update-novac-config" class="btn btn-info btn-submit"><i class="fa fa-save" aria-hidden="true"></i> Update Novac Settings</button>
                    </div>
                </div>
        </form>
        </div>
      </div>

      <div class="box">
        <div class="box-header with-border">
          <h4 class="box-title">Paystack API Settings (Legacy)</h4>
        </div>
        <div class="box-body">
        <form  method="post" class="form-submit">
                    
                <div class="form-group">
                    <label class="control-label">Paystack Api Key</label>
                    <div class="">
                    <input type="text" name="paystackApi" value="<?php echo $controller->getConfigValue($data,"paystackApi"); ?>" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label">Wallet Topup Charges (In Percentage %)</label>
                    <div class="">
                    <input type="text" name="paystackCharges" pattern="^\d*(\.\d{0,3})?$" value="<?php echo $controller->getConfigValue($data,"paystackCharges"); ?>" class="form-control">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label">Paystack Activation</label>
                    <div class="">
                        <select name="paystackStatus" class="form-control">
                        <?php if($controller->getConfigValue($data,"paystackStatus") == "On"): ?>
                            <option value="On" selected>On</option>
                            <option value="Off">Off</option>
                        <?php else: ?>
                            <option value="On">On</option>
                            <option value="Off" selected>Off</option>
                        <?php endif; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="">
                       <button type="submit" name="update-paystack-config" class="btn btn-info btn-submit"><i class="fa fa-save" aria-hidden="true"></i> Update Details</button>
                    </div>
                </div>
        </form>
        </div>
      </div>

</div>
</div>

