<div class="page-content header-clear-medium">
    <div class="card card-style bg-theme pb-0">
        <div class="content">
            <?php $pricing = $data[0]; $profile = $data[1]; $result = isset($data[2]) ? $data[2] : null; ?>
            <?php if($result && $result->status == "success"): ?>
            <div class="text-center mb-3" id="resultCard">
                <div class="card card-style shadow-l rounded-m" style="background: linear-gradient(135deg, #1a237e 0%, #283593 100%); border: none;">
                    <div class="card-top pt-3 ps-3 pe-3 text-center">
                        <span class="icon icon-l rounded-sm bg-white"><i class="fa fa-check-circle font-30 color-green-dark"></i></span>
                        <h5 class="color-white font-700 mt-2">REGISTRATION SUBMITTED</h5>
                    </div>
                    <div class="card-center text-center pt-2 pb-2">
                        <p class="color-white opacity-70 font-12 mb-1">Reference</p>
                        <h2 class="color-white font-800 mb-0"><?php echo $result->ref; ?></h2>
                        <p class="color-white opacity-70 font-12 mt-2 mb-0">We will process this and contact you within 24-48 hours.</p>
                    </div>
                </div>
            </div>
            <a href="cac-registration" class="btn btn-full btn-l font-600 font-15 bg-blue-dark color-white rounded-s"><i class="fa fa-refresh me-2"></i> New Registration</a>
            <?php else: ?>
            <div class="text-center">
                <span class="icon icon-l gradient-blue shadow-l rounded-sm"><i class="fa fa-building font-30 color-white"></i></span>
                <h4 class="text-primary mt-3">CAC Business Registration</h4>
                <p class="mb-2 text-dark font-600 font-14">Register your business with the Corporate Affairs Commission (CAC). Fill the form and we handle the rest.</p>
            </div>
            <?php if($result && $result->status == "error"): ?>
            <div class="alert alert-danger text-center font-13 mb-3"><i class="fa fa-exclamation-circle me-2"></i> <?php echo $result->msg; ?></div>
            <?php endif; ?>
            <form method="post" id="cacForm">
                <!-- Plan (auto-selected by business type) -->
                <div class="input-style input-style-always-active has-borders mb-3" style="display:none;">
                    <label class="color-theme opacity-80 font-700 font-12">Registration Plan <span class="color-red">*</span></label>
                    <select name="plan" id="planSelect" class="form-control" required>
                        <option value="">Select Plan</option>
                        <?php if(is_array($pricing) || is_object($pricing)): foreach($pricing as $p): ?>
                        <option value="<?php echo $p->id; ?>" data-plan-name="<?php echo $p->plan_name; ?>"><?php echo $p->plan_name; ?> - N<?php echo number_format($p->user_price); ?></option>
                        <?php endforeach; endif; ?>
                    </select>
                </div>

                <!-- Business Type -->
                <div class="input-style input-style-always-active has-borders mb-3">
                    <label class="color-theme opacity-80 font-700 font-12">Business Type <span class="color-red">*</span></label>
                    <select name="business_type" id="businessType" class="form-control" required onchange="toggleSections()">
                        <option value="">Select Type</option>
                        <option value="Business Name" data-plan-label="Business Name / Enterprise Registration" data-price="28,000" data-delivery="2-48 hours">Business Name (Sole Proprietor / Enterprise)</option>
                        <option value="Limited Liability" data-plan-label="Limited Liability Company Registration" data-price="50,000" data-delivery="2-5 days">Limited Liability Company (Ltd)</option>
                        <option value="Incorporated Trustee" data-plan-label="Incorporated Trustees Registration" data-price="120,000" data-delivery="6-8 weeks">Incorporated Trustee (NGO / Church / Foundation)</option>
                    </select>
                </div>

                <!-- Price & Delivery Info (shown when business type selected) -->
                <div id="pricingInfo" class="alert alert-success font-13 p-2 mb-3" style="display:none;">
                    <i class="fa fa-info-circle me-1"></i>
                    <b>Price:</b> N<span id="displayPrice"></span>
                    &nbsp;&nbsp;|&nbsp;&nbsp;
                    <b>Delivery:</b> <span id="displayDelivery"></span>
                </div>

                <!-- ====== COMMON FIELDS (All Types) ====== -->
                <div class="divider mt-3 mb-3"><i class="fa fa-asterisk color-blue-dark"></i> Business Details</div>

                <div class="input-style input-style-always-active has-borders mb-3">
                    <label class="color-theme opacity-80 font-700 font-12">Proposed Business Name (1st Choice) <span class="color-red">*</span></label>
                    <input type="text" name="first_choice_name" class="form-control" placeholder="e.g. Greenbox Ventures" required>
                </div>
                <div class="input-style input-style-always-active has-borders mb-3">
                    <label class="color-theme opacity-80 font-700 font-12">Alternative Business Name (2nd Choice)</label>
                    <input type="text" name="second_choice_name" class="form-control" placeholder="e.g. Lush Touch Enterprise">
                </div>
                <div class="input-style input-style-always-active has-borders mb-3">
                    <label class="color-theme opacity-80 font-700 font-12">Nature of Business</label>
                    <input type="text" name="nature_of_business" class="form-control" placeholder="e.g. Trading, Consulting, ICT, Agriculture">
                </div>
                <div class="input-style input-style-always-active has-borders mb-3">
                    <label class="color-theme opacity-80 font-700 font-12">Business Address (Physical) <span class="color-red">*</span></label>
                    <textarea name="business_address" class="form-control" placeholder="Full street address (PO Box not accepted)" rows="2" required></textarea>
                </div>

                <div class="divider mt-3 mb-3"><i class="fa fa-user color-blue-dark"></i> Your Contact Information</div>

                <div class="row mb-0">
                    <div class="col-6">
                        <div class="input-style input-style-always-active has-borders mb-3">
                            <label class="color-theme opacity-80 font-700 font-12">Your Full Name <span class="color-red">*</span></label>
                            <input type="text" name="applicant_name" class="form-control" placeholder="Full name" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="input-style input-style-always-active has-borders mb-3">
                            <label class="color-theme opacity-80 font-700 font-12">Your Email</label>
                            <input type="email" name="applicant_email" class="form-control" placeholder="Email address" value="<?php echo $profile->sEmail??''; ?>">
                        </div>
                    </div>
                </div>
                <div class="input-style input-style-always-active has-borders mb-3">
                    <label class="color-theme opacity-80 font-700 font-12">Your Phone Number</label>
                    <input type="tel" name="applicant_phone" class="form-control" placeholder="Phone number" value="<?php echo $profile->sPhone??''; ?>">
                </div>

                <!-- ====== BUSINESS NAME SPECIFIC ====== -->
                <div id="businessNameSection" style="display:none;">
                    <div class="divider mt-3 mb-3"><i class="fa fa-user-circle color-green-dark"></i> Proprietor Details (Business Name)</div>
                    <div class="input-style input-style-always-active has-borders mb-3">
                        <label class="color-theme opacity-80 font-700 font-12">Proprietor Full Name <span class="color-red">*</span></label>
                        <input type="text" name="proprietor_name" class="form-control" placeholder="Same as yours if sole proprietor">
                    </div>
                    <div class="row mb-0">
                        <div class="col-6">
                            <div class="input-style input-style-always-active has-borders mb-3">
                                <label class="color-theme opacity-80 font-700 font-12">Date of Birth</label>
                                <input type="date" name="proprietor_dob" class="form-control">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="input-style input-style-always-active has-borders mb-3">
                                <label class="color-theme opacity-80 font-700 font-12">Valid ID Type <span class="color-red">*</span></label>
                                <select name="id_type" class="form-control">
                                    <option value="">Select ID</option>
                                    <option value="NIN">National Identification Number (NIN)</option>
                                    <option value="Driver License">Driver's License</option>
                                    <option value="International Passport">International Passport</option>
                                    <option value="Voters Card">Voter's Card</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-0">
                        <div class="col-6">
                            <div class="input-style input-style-always-active has-borders mb-3">
                                <label class="color-theme opacity-80 font-700 font-12">ID Number</label>
                                <input type="text" name="id_number" class="form-control" placeholder="Your ID document number">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="input-style input-style-always-active has-borders mb-3">
                                <label class="color-theme opacity-80 font-700 font-12">Residential Address</label>
                                <input type="text" name="proprietor_address" class="form-control" placeholder="Home address">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ====== LIMITED LIABILITY SPECIFIC ====== -->
                <div id="limitedSection" style="display:none;">
                    <div class="divider mt-3 mb-3"><i class="fa fa-users color-orange-dark"></i> Directors & Shareholders (Limited Liability)</div>

                    <div class="input-style input-style-always-active has-borders mb-3">
                        <label class="color-theme opacity-80 font-700 font-12">Number of Directors</label>
                        <select name="num_directors" id="numDirectors" class="form-control" onchange="generateDirectorFields()">
                            <option value="1">1 Director</option>
                            <option value="2">2 Directors</option>
                            <option value="3">3 Directors</option>
                            <option value="4">4 Directors</option>
                            <option value="5">5 Directors</option>
                        </select>
                    </div>

                    <div id="directorFields">
                        <div class="card card-style bg-gray-dark p-2 mb-2 dir-card">
                            <h6 class="font-600">Director 1</h6>
                            <div class="row mb-0">
                                <div class="col-6"><input type="text" name="dir_name_1" class="form-control mb-1" placeholder="Full name"></div>
                                <div class="col-6"><input type="tel" name="dir_phone_1" class="form-control mb-1" placeholder="Phone"></div>
                            </div>
                            <div class="row mb-0">
                                <div class="col-6"><input type="email" name="dir_email_1" class="form-control mb-1" placeholder="Email"></div>
                                <div class="col-6"><input type="date" name="dir_dob_1" class="form-control mb-1"></div>
                            </div>
                            <input type="text" name="dir_address_1" class="form-control mb-1" placeholder="Residential address">
                            <div class="row mb-0">
                                <div class="col-6">
                                    <select name="dir_id_type_1" class="form-control mb-1">
                                        <option value="">ID Type</option>
                                        <option value="NIN">NIN</option>
                                        <option value="Driver License">Driver's License</option>
                                        <option value="International Passport">International Passport</option>
                                        <option value="Voters Card">Voter's Card</option>
                                    </select>
                                </div>
                                <div class="col-6"><input type="text" name="dir_id_no_1" class="form-control mb-1" placeholder="ID Number"></div>
                            </div>
                        </div>
                    </div>

                    <div class="input-style input-style-always-active has-borders mb-3">
                        <label class="color-theme opacity-80 font-700 font-12">Proposed Share Capital (₦) <span class="color-red">*</span></label>
                        <input type="number" name="share_capital" class="form-control" placeholder="Minimum ₦100,000 standard" value="100000">
                    </div>
                    <div class="input-style input-style-always-active has-borders mb-3">
                        <label class="color-theme opacity-80 font-700 font-12">Shareholder Details</label>
                        <textarea name="shareholder_details" class="form-control" rows="2" placeholder="Names of shareholders and share allocation"></textarea>
                    </div>
                </div>

                <!-- ====== INCORPORATED TRUSTEE SPECIFIC ====== -->
                <div id="trusteeSection" style="display:none;">
                    <div class="divider mt-3 mb-3"><i class="fa fa-gavel color-purple-dark"></i> Trustees Details (Incorporated Trustee)</div>

                    <div class="input-style input-style-always-active has-borders mb-3">
                        <label class="color-theme opacity-80 font-700 font-12">Aims & Objectives <span class="color-red">*</span></label>
                        <textarea name="aims_objectives" class="form-control" rows="3" placeholder="Describe the aims and objectives of the organization"></textarea>
                    </div>

                    <div class="input-style input-style-always-active has-borders mb-3">
                        <label class="color-theme opacity-80 font-700 font-12">Number of Trustees</label>
                        <select name="num_trustees" id="numTrustees" class="form-control" onchange="generateTrusteeFields()">
                            <option value="2">2 Trustees</option>
                            <option value="3">3 Trustees</option>
                            <option value="4">4 Trustees</option>
                            <option value="5">5 Trustees</option>
                            <option value="6">6 Trustees</option>
                        </select>
                    </div>

                    <div id="trusteeFields">
                        <div class="card card-style bg-gray-dark p-2 mb-2 trust-card">
                            <h6 class="font-600">Trustee 1</h6>
                            <div class="row mb-0">
                                <div class="col-6"><input type="text" name="trust_name_1" class="form-control mb-1" placeholder="Full name"></div>
                                <div class="col-6"><input type="tel" name="trust_phone_1" class="form-control mb-1" placeholder="Phone"></div>
                            </div>
                            <div class="row mb-0">
                                <div class="col-6"><input type="email" name="trust_email_1" class="form-control mb-1" placeholder="Email"></div>
                                <div class="col-6"><input type="text" name="trust_address_1" class="form-control mb-1" placeholder="Address"></div>
                            </div>
                        </div>
                        <div class="card card-style bg-gray-dark p-2 mb-2 trust-card">
                            <h6 class="font-600">Trustee 2</h6>
                            <div class="row mb-0">
                                <div class="col-6"><input type="text" name="trust_name_2" class="form-control mb-1" placeholder="Full name"></div>
                                <div class="col-6"><input type="tel" name="trust_phone_2" class="form-control mb-1" placeholder="Phone"></div>
                            </div>
                            <div class="row mb-0">
                                <div class="col-6"><input type="email" name="trust_email_2" class="form-control mb-1" placeholder="Email"></div>
                                <div class="col-6"><input type="text" name="trust_address_2" class="form-control mb-1" placeholder="Address"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Info -->
                <div class="input-style input-style-always-active has-borders mb-3">
                    <label class="color-theme opacity-80 font-700 font-12">Additional Information</label>
                    <textarea name="additional_info" class="form-control" rows="2" placeholder="Anything else we should know"></textarea>
                </div>

                <!-- Document Notice -->
                <div class="alert alert-info font-12 p-2 mb-3">
                    <i class="fa fa-info-circle me-1"></i> <b>Documents Required:</b> After submission, our team will request scanned copies of your ID, passport photo, and signature. Have these ready: NIN, Passport, Driver's License, or Voter's Card.
                </div>

                <button type="submit" name="submit-cac" style="width:100%" class="btn btn-full btn-l font-600 font-15 gradient-highlight mt-2 rounded-s"><i class="fa fa-paper-plane me-2"></i> Submit Registration</button>
                <div class="divider mt-3 mb-3"></div>
                <p class="font-11 color-theme opacity-60 text-center mb-0">By submitting, you agree to our terms. A dedicated agent will contact you to complete the registration.</p>
            </form>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function toggleSections() {
    var sel = document.getElementById('businessType');
    var bt = sel.value;
    var option = sel.options[sel.selectedIndex];
    document.getElementById('businessNameSection').style.display = (bt === 'Business Name') ? 'block' : 'none';
    document.getElementById('limitedSection').style.display = (bt === 'Limited Liability') ? 'block' : 'none';
    document.getElementById('trusteeSection').style.display = (bt === 'Incorporated Trustee') ? 'block' : 'none';

    // Show pricing and delivery info
    var info = document.getElementById('pricingInfo');
    if(bt && option) {
        document.getElementById('displayPrice').textContent = option.getAttribute('data-price');
        document.getElementById('displayDelivery').textContent = option.getAttribute('data-delivery');
        info.style.display = 'block';
    } else {
        info.style.display = 'none';
    }

    // Auto-select the matching plan
    var planLabel = option ? option.getAttribute('data-plan-label') : '';
    var planSelect = document.getElementById('planSelect');
    if(planLabel && planSelect) {
        for(var i=0; i<planSelect.options.length; i++) {
            if(planSelect.options[i].getAttribute('data-plan-name') === planLabel) {
                planSelect.value = planSelect.options[i].value;
                break;
            }
        }
    }
    setRequired();
}
function setRequired() {
    var bt = document.getElementById('businessType').value;
    var pn = document.querySelector('input[name="proprietor_name"]');
    var idt = document.querySelector('select[name="id_type"]');
    if(bt === 'Business Name') {
        if(pn) pn.required = true;
        if(idt) idt.required = true;
    } else {
        if(pn) pn.required = false;
        if(idt) idt.required = false;
    }
}
function generateDirectorFields() {
    var num = parseInt(document.getElementById('numDirectors').value) || 1;
    var html = '';
    for(var i=1;i<=num;i++){
        html += '<div class="card card-style bg-gray-dark p-2 mb-2 dir-card">';
        html += '<h6 class="font-600">Director '+i+'</h6>';
        html += '<div class="row mb-0"><div class="col-6"><input type="text" name="dir_name_'+i+'" class="form-control mb-1" placeholder="Full name"></div><div class="col-6"><input type="tel" name="dir_phone_'+i+'" class="form-control mb-1" placeholder="Phone"></div></div>';
        html += '<div class="row mb-0"><div class="col-6"><input type="email" name="dir_email_'+i+'" class="form-control mb-1" placeholder="Email"></div><div class="col-6"><input type="date" name="dir_dob_'+i+'" class="form-control mb-1"></div></div>';
        html += '<input type="text" name="dir_address_'+i+'" class="form-control mb-1" placeholder="Residential address">';
        html += '<div class="row mb-0"><div class="col-6"><select name="dir_id_type_'+i+'" class="form-control mb-1"><option value="">ID Type</option><option value="NIN">NIN</option><option value="Driver License">Driver License</option><option value="International Passport">International Passport</option><option value="Voters Card">Voters Card</option></select></div><div class="col-6"><input type="text" name="dir_id_no_'+i+'" class="form-control mb-1" placeholder="ID Number"></div></div>';
        html += '</div>';
    }
    document.getElementById('directorFields').innerHTML = html;
}
function generateTrusteeFields() {
    var num = parseInt(document.getElementById('numTrustees').value) || 2;
    var html = '';
    for(var i=1;i<=num;i++){
        html += '<div class="card card-style bg-gray-dark p-2 mb-2 trust-card">';
        html += '<h6 class="font-600">Trustee '+i+'</h6>';
        html += '<div class="row mb-0"><div class="col-6"><input type="text" name="trust_name_'+i+'" class="form-control mb-1" placeholder="Full name"></div><div class="col-6"><input type="tel" name="trust_phone_'+i+'" class="form-control mb-1" placeholder="Phone"></div></div>';
        html += '<div class="row mb-0"><div class="col-6"><input type="email" name="trust_email_'+i+'" class="form-control mb-1" placeholder="Email"></div><div class="col-6"><input type="text" name="trust_address_'+i+'" class="form-control mb-1" placeholder="Address"></div></div>';
        html += '</div>';
    }
    document.getElementById('trusteeFields').innerHTML = html;
}
</script>