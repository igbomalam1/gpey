<div class="page-content header-clear-medium">

    <div class="card card-style bg-theme pb-0">
        <div class="content">

            <?php
            $pricing = $data[0];
            $profile = $data[1];
            $result = isset($data[2]) ? $data[2] : null;
            ?>

            <?php if($result && $result->status == "success"): ?>

            <div class="text-center mb-3" id="ninCard">
                <div class="card card-style shadow-l rounded-m" style="background: linear-gradient(135deg, #1a237e 0%, #283593 100%); border: none;">
                    <div class="card-top pt-3 ps-3 pe-3 text-center">
                        <img src="../../assets/images/nigeria-logo.png" alt="Nigeria" width="50" height="50" style="border-radius:50%; background: white; padding: 5px;" onerror="this.style.display='none'">
                        <h5 class="color-white font-700 mt-2">NATIONAL IDENTITY NUMBER</h5>
                    </div>
                    <div class="card-center text-center pt-2 pb-2">
                        <p class="color-white opacity-70 font-12 mb-1">NIN</p>
                        <h2 class="color-white font-800 mb-0" style="letter-spacing: 3px;"><?php echo $result->nin; ?></h2>
                    </div>
                    <div class="card-bottom pb-3 ps-3 pe-3">
                        <div class="row mb-0">
                            <div class="col-6">
                                <p class="color-white opacity-70 font-11 mb-0">Full Name</p>
                                <p class="color-white font-600 font-13 mb-0"><?php echo $result->fullname; ?></p>
                            </div>
                            <div class="col-6 text-end">
                                <p class="color-white opacity-70 font-11 mb-0">Slip Type</p>
                                <p class="color-white font-600 font-13 mb-0"><?php echo $result->slip_type; ?></p>
                            </div>
                        </div>
                        <hr class="opacity-20 mt-2 mb-2">
                        <div class="row mb-0">
                            <div class="col-6">
                                <p class="color-white opacity-70 font-11 mb-0">Date</p>
                                <p class="color-white font-600 font-13 mb-0"><?php echo $result->date; ?></p>
                            </div>
                            <div class="col-6 text-end">
                                <p class="color-white opacity-70 font-11 mb-0">Reference</p>
                                <p class="color-white font-600 font-13 mb-0"><?php echo $result->ref; ?></p>
                            </div>
                        </div>
                        <hr class="opacity-20 mt-2 mb-2">
                        <div class="row mb-0">
                            <div class="col-6">
                                <p class="color-white opacity-70 font-11 mb-0">Email</p>
                                <p class="color-white font-600 font-13 mb-0"><?php echo $result->email; ?></p>
                            </div>
                            <div class="col-6 text-end">
                                <p class="color-white opacity-70 font-11 mb-0">Phone</p>
                                <p class="color-white font-600 font-13 mb-0"><?php echo $result->phone; ?></p>
                            </div>
                        </div>
                        <hr class="opacity-20 mt-2 mb-2">
                        <div class="text-center">
                            <span class="color-white opacity-50 font-10">This is a computer-generated slip. Verify at any NIMC office.</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-6">
                    <a href="#" onclick="downloadNINPDF()" class="btn btn-full btn-l font-600 font-15 gradient-highlight rounded-s">
                        <i class="fa fa-file-pdf-o me-2"></i> Download PDF
                    </a>
                </div>
                <div class="col-6">
                    <a href="nin-verification" class="btn btn-full btn-l font-600 font-15 bg-blue-dark color-white rounded-s">
                        <i class="fa fa-refresh me-2"></i> New Request
                    </a>
                </div>
            </div>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
            <script>
            function downloadNINPDF(){
                var element = document.getElementById('ninCard');
                var opt = {
                    margin:       [0.5, 0.5, 0.5, 0.5],
                    filename:     'NIN_Slip_<?php echo $result->ref; ?>.pdf',
                    image:        { type: 'jpeg', quality: 0.98 },
                    html2canvas:  { scale: 2, useCORS: true },
                    jsPDF:        { unit: 'in', format: 'a5', orientation: 'portrait' }
                };
                html2pdf().set(opt).from(element).save();
            }
            </script>

            <?php else: ?>

            <div class="text-center">
                <span class="icon icon-l gradient-blue shadow-l rounded-sm">
                    <i class="fa fa-id-card font-30 color-white"></i>
                </span>
                <h4 class="text-primary mt-3">NIN Verification</h4>
                <p class="mb-2 text-dark font-600 font-14">
                    Get your official NIN slip instantly. Select a slip type and enter your NIN to proceed.
                </p>
            </div>

            <?php if($result && $result->status == "error"): ?>
            <div class="alert alert-danger text-center font-13 mb-3">
                <i class="fa fa-exclamation-circle me-2"></i> <?php echo $result->msg; ?>
            </div>
            <?php endif; ?>

            <form method="post" class="ninForm">
                <div class="input-style input-style-always-active has-borders mb-4">
                    <label class="color-theme opacity-80 font-700 font-12">Slip Type</label>
                    <select name="slip_type" class="form-control" required>
                        <option value="">Select Slip Type</option>
                        <?php if(is_array($pricing) || is_object($pricing)): foreach($pricing as $p): ?>
                        <option value="<?php echo $p->slip_type; ?>">
                            <?php echo $p->slip_type; ?> - N<?php echo number_format($p->user_price); ?>
                        </option>
                        <?php endforeach; endif; ?>
                    </select>
                </div>

                <div class="input-style input-style-always-active has-borders mb-4">
                    <label class="color-theme opacity-80 font-700 font-12">Verification Type</label>
                    <select name="verification_type" id="verification_type" class="form-control" required>
                        <option value="">Select Verification Type</option>
                        <option value="NIN">NIN Number</option>
                        <option value="Phone">Phone Number</option>
                    </select>
                </div>

                <div class="input-style input-style-always-active has-borders mb-4">
                    <label class="color-theme opacity-80 font-700 font-12" id="nin_label">Enter NIN Number</label>
                    <input type="number" name="nin_number" id="nin_number" placeholder="11-digit NIN" value="" class="round-small" required maxlength="11">
                </div>

                <hr class="mt-4 mb-4">

                <button type="submit" name="verify-nin" style="width: 100%;" class="btn btn-full btn-l font-600 font-16 gradient-highlight rounded-s">
                    <i class="fa fa-check-circle mr-2"></i> Verify NIN
                </button>
            </form>

            <?php endif; ?>

        </div>
    </div>

</div>

<script>
document.getElementById('verification_type').addEventListener('change', function(){
    var label = document.getElementById('nin_label');
    var input = document.getElementById('nin_number');
    if(this.value == 'NIN'){
        label.textContent = 'Enter NIN Number';
        input.placeholder = '11-digit NIN';
    } else if(this.value == 'Phone'){
        label.textContent = 'Enter Phone Number';
        input.placeholder = 'Phone number linked to NIN';
    }
});
</script>