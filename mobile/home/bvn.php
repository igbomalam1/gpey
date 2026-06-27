<div class="page-content header-clear-medium">
    <div class="card card-style bg-theme pb-0">
        <div class="content">
            <?php $pricing = $data[0]; $profile = $data[1]; $result = isset($data[2]) ? $data[2] : null; ?>
            <?php if($result && $result->status == "success"): ?>
            <div class="text-center mb-3" id="resultCard">
                <div class="card card-style shadow-l rounded-m" style="background: linear-gradient(135deg, #1a237e 0%, #283593 100%); border: none;">
                    <div class="card-top pt-3 ps-3 pe-3 text-center">
                        <span class="icon icon-l rounded-sm bg-white"><i class="fa fa-university font-30 color-dark"></i></span>
                        <h5 class="color-white font-700 mt-2">BVN VERIFIED</h5>
                    </div>
                    <div class="card-center text-center pt-2 pb-2">
                        <p class="color-white opacity-70 font-12 mb-1">BVN</p>
                        <h2 class="color-white font-800 mb-0"><?php echo $result->id_number; ?></h2>
                    </div>
                    <div class="card-bottom pb-3 ps-3 pe-3">
                        <div class="row mb-0">
                            <div class="col-6"><p class="color-white opacity-70 font-11 mb-0">Full Name</p><p class="color-white font-600 font-13 mb-0"><?php echo $result->fullname; ?></p></div>
                            <div class="col-6 text-end"><p class="color-white opacity-70 font-11 mb-0">Ref</p><p class="color-white font-600 font-13 mb-0"><?php echo $result->ref; ?></p></div>
                        </div>
                    </div>
                </div>
            </div>
            <a href="bvn" class="btn btn-full btn-l font-600 font-15 bg-blue-dark color-white rounded-s"><i class="fa fa-refresh me-2"></i> New Verification</a>
            <?php else: ?>
            <div class="text-center">
                <span class="icon icon-l gradient-blue shadow-l rounded-sm"><i class="fa fa-university font-30 color-white"></i></span>
                <h4 class="text-primary mt-3">BVN Verification</h4>
                <p class="mb-2 text-dark font-600 font-14">Verify Bank Verification Number (BVN) or modify BVN details.</p>
            </div>
            <?php if($result && $result->status == "error"): ?>
            <div class="alert alert-danger text-center font-13 mb-3"><i class="fa fa-exclamation-circle me-2"></i> <?php echo $result->msg; ?></div>
            <?php endif; ?>
            <?php
            // Build BVN plan options: use DB pricing, fallback to seeded defaults
            $bvnPlans = [];
            if (is_array($pricing) || is_object($pricing)) {
                foreach ($pricing as $p) {
                    $price = (float)$p->user_price;
                    $bvnPlans[] = [
                        'id' => $p->id,
                        'name' => $p->plan_name,
                        'price' => $price > 0 ? $price : 0
                    ];
                }
            }
            if (empty($bvnPlans)) {
                $bvnPlans = [
                    ['id' => 0, 'name' => 'BVN Verification', 'price' => 100],
                    ['id' => 0, 'name' => 'BVN Modification', 'price' => 500],
                ];
            }
            ?>
            <form method="post">
                <div class="input-style input-style-always-active has-borders mb-4">
                    <label class="color-theme opacity-80 font-700 font-12">Service Type</label>
                    <select name="plan" class="form-control" required>
                        <option value="">Select Service</option>
                        <?php foreach ($bvnPlans as $opt): ?>
                        <option value="<?php echo $opt['id']; ?>"><?php echo $opt['name']; ?> - N<?php echo number_format($opt['price']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="input-style input-style-always-active has-borders mb-4">
                    <label class="color-theme opacity-80 font-700 font-12">BVN Number</label>
                    <input type="number" name="bvn_number" class="form-control" placeholder="Enter 11-digit BVN" required>
                </div>
                <hr class="mt-4 mb-4">
                <button type="submit" name="verify-bvn" style="width:100%" class="btn btn-full btn-l font-600 font-16 gradient-highlight rounded-s"><i class="fa fa-search mr-2"></i> Verify BVN</button>
            </form>
            <?php endif; ?>
        </div>
    </div>
</div>