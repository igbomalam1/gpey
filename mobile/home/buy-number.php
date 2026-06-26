<div class="page-content header-clear-medium">
    <div class="card card-style bg-theme pb-0">
        <div class="content">
            <?php $pricing = $data[0]; $profile = $data[1]; $result = isset($data[2]) ? $data[2] : null; ?>
            <?php if($result && $result->status == "success"): ?>
            <div class="text-center mb-3" id="resultCard">
                <div class="card card-style shadow-l rounded-m" style="background: linear-gradient(135deg, #1a237e 0%, #283593 100%); border: none;">
                    <div class="card-top pt-3 ps-3 pe-3 text-center">
                        <span class="icon icon-l rounded-sm bg-white"><i class="fa fa-phone font-30 color-dark"></i></span>
                        <h5 class="color-white font-700 mt-2">VIRTUAL NUMBER</h5>
                    </div>
                    <div class="card-center text-center pt-2 pb-2">
                        <p class="color-white opacity-70 font-12 mb-1">Number</p>
                        <h2 class="color-white font-800 mb-0"><?php echo $result->id_number ?? 'N/A'; ?></h2>
                    </div>
                    <div class="card-bottom pb-3 ps-3 pe-3">
                        <div class="row mb-0">
                            <div class="col-6"><p class="color-white opacity-70 font-11 mb-0">Reference</p><p class="color-white font-600 font-13 mb-0"><?php echo $result->ref; ?></p></div>
                            <div class="col-6 text-end"><p class="color-white opacity-70 font-11 mb-0">Status</p><p class="color-white font-600 font-13 mb-0">Active</p></div>
                        </div>
                    </div>
                </div>
            </div>
            <a href="buy-number" class="btn btn-full btn-l font-600 font-15 bg-blue-dark color-white rounded-s"><i class="fa fa-refresh me-2"></i> Buy Another</a>
            <?php else: ?>
            <div class="text-center">
                <span class="icon icon-l gradient-blue shadow-l rounded-sm"><i class="fa fa-phone font-30 color-white"></i></span>
                <h4 class="text-primary mt-3">Buy Virtual Number</h4>
                <p class="mb-2 text-dark font-600 font-14">Purchase virtual numbers for SMS verification. Select a plan and country.</p>
            </div>
            <?php if($result && $result->status == "error"): ?>
            <div class="alert alert-danger text-center font-13 mb-3"><i class="fa fa-exclamation-circle me-2"></i> <?php echo $result->msg; ?></div>
            <?php endif; ?>
            <form method="post">
                <div class="input-style input-style-always-active has-borders mb-3">
                    <label class="color-theme opacity-80 font-700 font-12">Plan</label>
                    <select name="plan" class="form-control" required>
                        <option value="">Select Plan</option>
                        <?php if(is_array($pricing) || is_object($pricing)): foreach($pricing as $p): ?>
                        <option value="<?php echo $p->id; ?>"><?php echo $p->plan_name; ?> - N<?php echo number_format($p->user_price); ?></option>
                        <?php endforeach; endif; ?>
                    </select>
                </div>
                <div class="input-style input-style-always-active has-borders mb-3">
                    <label class="color-theme opacity-80 font-700 font-12">Country</label>
                    <select name="country" class="form-control" required>
                        <option value="">Select Country</option>
                        <option value="Nigeria">Nigeria</option>
                        <option value="USA">USA</option>
                        <option value="UK">United Kingdom</option>
                        <option value="Canada">Canada</option>
                    </select>
                </div>
                <button type="submit" name="purchase-number" style="width:100%" class="btn btn-full btn-l font-600 font-15 gradient-highlight mt-2 rounded-s"><i class="fa fa-shopping-cart mr-2"></i> Purchase Number</button>
            </form>
            <?php endif; ?>
        </div>
    </div>
</div>