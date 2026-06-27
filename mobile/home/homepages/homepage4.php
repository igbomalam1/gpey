<div class="page-content header-clear" style="background:#F4F4F6; min-height:100vh;">

<style>
.dash-card { display:flex; flex-direction:column; align-items:center; justify-content:center; background:#FFFFFF; border-radius:18px; padding:20px 10px; box-shadow:0 1px 4px rgba(0,0,0,0.04); border:1px solid #EFEFF1; text-decoration:none; transition:all 0.2s ease; width:100%; }
.dash-card:active { transform:scale(0.96); }
.dash-icon { width:52px; height:52px; border-radius:14px; display:flex; align-items:center; justify-content:center; font-size:22px; margin-bottom:10px; flex-shrink:0; }
.dash-label { font-size:13px; font-weight:500; color:#1A1A1A; text-align:center; line-height:1.3; }

.services-heading { font-size:16px; font-weight:700; color:#1A1A1A; margin-bottom:4px; }
.services-underline { width:28px; height:3px; background:<?php echo $color; ?>; border-radius:2px; margin-bottom:16px; }
.dash-balance-card { background:#FFFFFF; border-radius:18px; border:1px solid #EFEFF1; box-shadow:0 1px 4px rgba(0,0,0,0.04); padding:16px 18px; }
</style>

<div class="card notch-clear rounded-0 mb-n5 mt-0" data-card-height="200" style="background-color:<?php echo $color; ?>;">
    <div class="card-body pt-4 mt-2 mb-n2">
        <h1 class="font-20 float-start color-white"><?php echo "Hi, ".$data->sFname; ?>!</h1>
        <h3 class="font-17 float-end color-white">(<?php echo $controller->formatUserType($data->sType); ?>)</h3>
        <div class="clearfix"></div>
    </div>
    <div class="dash-balance-card mt-0 mb-5">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <div class="font-12" style="color:#6B7280; margin-bottom:2px;">Wallet Balance</div>
                <div class="font-20 font-700" style="color:#1A1A1A;">
                    <span id="hideEyeDiv" style="display:none;">&#8358;<?php echo number_format($data->sWallet); ?></span>
                    <span id="openEyeDiv">&#8358; *********</span>
                    <span id="hideEye" style="cursor:pointer;"><i class="fa fa-eye-slash" style="font-size:15px; margin-left:6px; color:#6B7280;"></i></span>
                    <span id="openEye" style="display:none; cursor:pointer;"><i class="fa fa-eye" style="font-size:15px; margin-left:6px; color:#6B7280;"></i></span>
                </div>
            </div>
            <a href="fund-wallet" class="btn" style="background-color:<?php echo $color; ?>; color:#FFFFFF; border-radius:5rem; padding:8px 22px; font-weight:600; font-size:14px;">Fund</a>
        </div>
    </div>
</div>

<div class="splide single-slider slider-no-arrows slider-no-dots splide--loop splide--ltr splide--draggable is-active mb-1" id="single-slider-1" style="visibility: visible;">
    <div class="splide__arrows"><button class="splide__arrow splide__arrow--prev" type="button" aria-controls="single-slider-1-track" aria-label="Go to last slide"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40" width="40" height="40"><path d="m15.5 0.932-4.3 4.38 14.5 14.6-14.5 14.5 4.3 4.4 14.6-14.6 4.4-4.3-4.4-4.4-14.6-14.6z"></path></svg></button><button class="splide__arrow splide__arrow--next" type="button" aria-controls="single-slider-1-track" aria-label="Next slide"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40" width="40" height="40"><path d="m15.5 0.932-4.3 4.38 14.5 14.6-14.5 14.5 4.3 4.4 14.6-14.6 4.4-4.3-4.4-4.4-14.6-14.6z"></path></svg></button></div>
    <div class="splide__track" id="single-slider-1-track">
            <div class="splide__list" id="single-slider-1-list" style="transform: translateX(-624px);">

                    <div class="splide__slide splide__slide--clone" aria-hidden="true" tabindex="-1" style="width: 312px;">
                        <div class="card card-style bg-20" data-card-height="190" style="height: 190px;">
                            <img class="img-fluid" style="height: 190px;" src="../../assets/img/ads/ads1.png" />
                        </div>
                    </div>

                    <div class="splide__slide" id="single-slider-1-slide02" aria-hidden="true" tabindex="-1" style="width: 312px;">
                       <div class="card card-style bg-20" data-card-height="190" style="height: 190px;">
                            <img class="img-fluid" style="height: 190px;" src="../../assets/img/ads/ads2.png" />
                        </div>
                    </div>

                    <div class="splide__slide" id="single-slider-1-slide03" aria-hidden="true" tabindex="-1" style="width: 312px;">
                       <div class="card card-style bg-20" data-card-height="190" style="height: 190px;">
                            <img class="img-fluid" style="height: 190px;" src="../../assets/img/ads/ads3.png" />
                        </div>
                    </div>

            </div>
    </div>
</div>

<div class="mt-2 mb-2">
    <div class="services-heading">Services</div>
    <div class="services-underline"></div>
</div>

<div class="row g-2">
    <div class="col-4">
        <a href="buy-airtime" class="dash-card">
            <div class="dash-icon" style="background:#DBEAFE; color:#2563EB;"><i class="fa fa-phone"></i></div>
            <span class="dash-label">Airtime</span>
        </a>
    </div>
    <div class="col-4">
        <a href="buy-data" class="dash-card">
            <div class="dash-icon" style="background:#D1FAE5; color:#059669;"><i class="fa fa-wifi"></i></div>
            <span class="dash-label">Data</span>
        </a>
    </div>
    <div class="col-4">
        <a href="cable-tv" class="dash-card">
            <div class="dash-icon" style="background:#E8E5FF; color:#4F46E5;"><i class="fa fa-tv"></i></div>
            <span class="dash-label">Cable TV</span>
        </a>
    </div>

    <div class="col-4">
        <a href="electricity" class="dash-card">
            <div class="dash-icon" style="background:#FEF9C3; color:#D97706;"><i class="fa fa-bolt"></i></div>
            <span class="dash-label">Electricity</span>
        </a>
    </div>
    <div class="col-4">
        <a href="exam-pins" class="dash-card">
            <div class="dash-icon" style="background:#FFEDD5; color:#EA580C;"><i class="fa fa-graduation-cap"></i></div>
            <span class="dash-label">Exam Pins</span>
        </a>
    </div>
    <div class="col-4">
        <a href="nin-verification" class="dash-card">
            <div class="dash-icon" style="background:#FCE7F3; color:#DB2777;"><i class="fa fa-id-card"></i></div>
            <span class="dash-label">NIN</span>
        </a>
    </div>

    <div class="col-4">
        <a href="bvn" class="dash-card">
            <div class="dash-icon" style="background:#CFFAFE; color:#0891B2;"><i class="fa fa-university"></i></div>
            <span class="dash-label">BVN</span>
        </a>
    </div>
    <div class="col-4">
        <a href="buy-number" class="dash-card">
            <div class="dash-icon" style="background:#CCFBF1; color:#0D9488;"><i class="fa fa-phone"></i></div>
            <span class="dash-label">Buy Number</span>
        </a>
    </div>
    <div class="col-4">
        <a href="buy-logs" class="dash-card">
            <div class="dash-icon" style="background:#F3E8FF; color:#9333EA;"><i class="fa fa-user-secret"></i></div>
            <span class="dash-label">Buy Logs</span>
        </a>
    </div>

    <div class="col-4">
        <a href="boost-socials" class="dash-card">
            <div class="dash-icon" style="background:#FEE2E2; color:#DC2626;"><i class="fa fa-rocket"></i></div>
            <span class="dash-label">Boost Socials</span>
        </a>
    </div>
    <div class="col-4">
        <a href="cac-registration" class="dash-card">
            <div class="dash-icon" style="background:#E0E7FF; color:#4338CA;"><i class="fa fa-building"></i></div>
            <span class="dash-label">CAC Reg</span>
        </a>
    </div>
    <div class="col-4">
        <a href="buy-data-pin" class="dash-card">
            <div class="dash-icon" style="background:#D1FAE5; color:#047857;"><i class="fa fa-barcode"></i></div>
            <span class="dash-label">Data Card</span>
        </a>
    </div>

    <div class="col-4">
        <a href="recharge-pin" class="dash-card">
            <div class="dash-icon" style="background:#F3F4F6; color:#4B5563;"><i class="fa fa-receipt"></i></div>
            <span class="dash-label">Recharge Card</span>
        </a>
    </div>
    <div class="col-4">
        <a href="airtime2cash" class="dash-card">
            <div class="dash-icon" style="background:#FFF7ED; color:#C2410C;"><i class="fa fa-retweet"></i></div>
            <span class="dash-label">Airtime2Cash</span>
        </a>
    </div>
    <div class="col-4">
        <a href="transactions" class="dash-card">
            <div class="dash-icon" style="background:#E0F2FE; color:#0284C7;"><i class="fa fa-history"></i></div>
            <span class="dash-label">History</span>
        </a>
    </div>

    <div class="col-4">
        <a href="fund-wallet" class="dash-card">
            <div class="dash-icon" style="background:#ECFCCB; color:#4D7C0F;"><i class="fa fa-arrow-up"></i></div>
            <span class="dash-label">Add Fund</span>
        </a>
    </div>
    <div class="col-4">
        <a href="profile" class="dash-card">
            <div class="dash-icon" style="background:#F1F5F9; color:#475569;"><i class="fa fa-user"></i></div>
            <span class="dash-label">Profile</span>
        </a>
    </div>
    <div class="col-4">
        <a href="contact-us" class="dash-card">
            <div class="dash-icon" style="background:#FFE4E6; color:#E11D48;"><i class="fa fa-envelope"></i></div>
            <span class="dash-label">Contact</span>
        </a>
    </div>

    <div class="col-4">
        <a href="buy-airtime" class="dash-card">
            <div class="dash-icon" style="background:#EDE9FE; color:#7C3AED;"><i class="fa fa-download"></i></div>
            <span class="dash-label">Download App</span>
        </a>
    </div>
    <div class="col-4">
        <a href="#agent-upgrade-modal" data-menu="agent-upgrade-modal" class="dash-card">
            <div class="dash-icon" style="background:#FFF7ED; color:#C2410C;"><i class="fa fa-user-secret"></i></div>
            <span class="dash-label">Agent</span>
        </a>
    </div>
    <div class="col-4">
        <a href="logout" class="dash-card">
            <div class="dash-icon" style="background:#FEF2F2; color:#B91C1C;"><i class="fa fa-lock"></i></div>
            <span class="dash-label">Logout</span>
        </a>
    </div>
</div>

</div>
