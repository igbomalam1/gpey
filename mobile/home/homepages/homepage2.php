<style>
.dash-card {
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    background: #FFFFFF; border-radius: 18px; padding: 20px 10px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.04); border: 1px solid #EFEFF1;
    text-decoration: none; transition: all 0.2s ease; width: 100%;
}
.dash-card:active { transform: scale(0.96); }
.dash-icon {
    width: 52px; height: 52px; border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 22px; margin-bottom: 10px; flex-shrink: 0;
}
.dash-label {
    font-size: 13px; font-weight: 500; color: #1A1A1A;
    text-align: center; line-height: 1.3;
}
.section-heading {
    font-size: 16px; font-weight: 700; color: #1A1A1A; margin-bottom: 4px;
}
.section-underline {
    width: 28px; height: 3px; background: #2563EB; border-radius: 2px; margin-bottom: 16px;
}
</style>

<div class="page-content header-clear-medium" style="background:#F4F4F6; min-height:100vh;">

    <div class="card card-style bg-20" data-card-height="200" style="height:130px; background-image:linear-gradient(to top, <?php echo $color; ?> 0%, <?php echo $color; ?> 0%);">
        <div class="card-top ps-3 pt-2">
            <h1 class="color-white font-19" style="text-shadow:2px 2px 2px #000000;"><?php echo "Hi, ".$data->sFname; ?></h1>
        </div>
        <div class="card-top pe-3 pt-2">
            <h5 class="color-white float-end" style="text-shadow:2px 2px 2px #000000;">(<?php echo $controller->formatUserType($data->sType); ?>)</h5>
        </div>
        <div class="card-center ps-3 pt-2">
            <h2 class="color-white font-20" style="text-shadow:2px 2px 2px #000000;">N<?php echo number_format($data->sWallet); ?></h2>
            <h4 class="color-white font-16" style="text-shadow:2px 2px 2px #000000;">Wallet Balance</h4>
        </div>
        <div class="card-center pe-3 pt-2">
            <a href="fund-wallet" class="float-end text-center">
                <span class="icon icon-l bg-light shadow-l rounded-sm">
                    <i class="fa fa-arrow-up font-18" style="color:<?php echo $color; ?>"></i>
                </span>
                <h5 class="mb-0 pt-1 font-14 text-white" style="text-shadow:2px 2px 2px #000000;">Add Funds</h5>
            </a>
        </div>
        <div class="card-bottom ps-3 pb-2 bt-3">
            <h3 class="font-15"><a href="fund-wallet" style="text-shadow:2px 2px 2px #000000;"><b class="text-white">Click Here To Fund Your Wallet</b></a></h3>
        </div>
        <div class="card-overlay bg-gradient"></div>
    </div>

    <div class="px-3">
        <div class="section-heading">Services</div>
        <div class="section-underline"></div>

        <div class="row mb-0">
            <div class="col-4 mb-3"><a href="buy-airtime" class="dash-card"><div class="dash-icon" style="background:#DBEAFE;color:#2563EB;"><i class="fa fa-phone"></i></div><span class="dash-label">Airtime</span></a></div>
            <div class="col-4 mb-3"><a href="buy-data" class="dash-card"><div class="dash-icon" style="background:#D1FAE5;color:#059669;"><i class="fa fa-wifi"></i></div><span class="dash-label">Data</span></a></div>
            <div class="col-4 mb-3"><a href="cable-tv" class="dash-card"><div class="dash-icon" style="background:#E8E5FF;color:#4F46E5;"><i class="fa fa-tv"></i></div><span class="dash-label">Cable TV</span></a></div>

            <div class="col-4 mb-3"><a href="electricity" class="dash-card"><div class="dash-icon" style="background:#FEF9C3;color:#D97706;"><i class="fa fa-bolt"></i></div><span class="dash-label">Electricity</span></a></div>
            <div class="col-4 mb-3"><a href="exam-pins" class="dash-card"><div class="dash-icon" style="background:#FFEDD5;color:#EA580C;"><i class="fa fa-graduation-cap"></i></div><span class="dash-label">Exam Pins</span></a></div>
            <div class="col-4 mb-3"><a href="nin-verification" class="dash-card"><div class="dash-icon" style="background:#FCE7F3;color:#DB2777;"><i class="fa fa-id-card"></i></div><span class="dash-label">NIN</span></a></div>

            <div class="col-4 mb-3"><a href="bvn" class="dash-card"><div class="dash-icon" style="background:#CFFAFE;color:#0891B2;"><i class="fa fa-university"></i></div><span class="dash-label">BVN</span></a></div>
            <div class="col-4 mb-3"><a href="buy-number" class="dash-card"><div class="dash-icon" style="background:#CCFBF1;color:#0D9488;"><i class="fa fa-phone"></i></div><span class="dash-label">Buy Number</span></a></div>
            <div class="col-4 mb-3"><a href="buy-logs" class="dash-card"><div class="dash-icon" style="background:#F3E8FF;color:#9333EA;"><i class="fa fa-user-secret"></i></div><span class="dash-label">Buy Logs</span></a></div>

            <div class="col-4 mb-3"><a href="boost-socials" class="dash-card"><div class="dash-icon" style="background:#FEE2E2;color:#DC2626;"><i class="fa fa-rocket"></i></div><span class="dash-label">Boost Socials</span></a></div>
            <div class="col-4 mb-3"><a href="cac-registration" class="dash-card"><div class="dash-icon" style="background:#E0E7FF;color:#4338CA;"><i class="fa fa-building"></i></div><span class="dash-label">CAC Reg</span></a></div>
            <div class="col-4 mb-3"><a href="recharge-pin" class="dash-card"><div class="dash-icon" style="background:#F3F4F6;color:#4B5563;"><i class="fa fa-receipt"></i></div><span class="dash-label">Recharge Pin</span></a></div>

            <div class="col-4 mb-3"><a href="buy-data-pin" class="dash-card"><div class="dash-icon" style="background:#D1FAE5;color:#047857;"><i class="fa fa-barcode"></i></div><span class="dash-label">Data Card</span></a></div>
            <div class="col-4 mb-3"><a href="transactions" class="dash-card"><div class="dash-icon" style="background:#E0F2FE;color:#0284C7;"><i class="fa fa-history"></i></div><span class="dash-label">Transactions</span></a></div>
            <div class="col-4 mb-3"><a href="pricing" class="dash-card"><div class="dash-icon" style="background:#FDF4FF;color:#A21CAF;"><i class="fa fa-list"></i></div><span class="dash-label">Pricing</span></a></div>

            <div class="col-4 mb-3"><a href="fund-wallet" class="dash-card"><div class="dash-icon" style="background:#ECFCCB;color:#4D7C0F;"><i class="fa fa-arrow-up"></i></div><span class="dash-label">Add Fund</span></a></div>
            <div class="col-4 mb-3"><a href="profile" class="dash-card"><div class="dash-icon" style="background:#F1F5F9;color:#475569;"><i class="fa fa-user"></i></div><span class="dash-label">Profile</span></a></div>
            <div class="col-4 mb-3"><a href="contact-us" class="dash-card"><div class="dash-icon" style="background:#FFE4E6;color:#E11D48;"><i class="fa fa-envelope"></i></div><span class="dash-label">Contact</span></a></div>

            <div class="col-4 mb-3"><a href="#agent-upgrade-modal" data-menu="agent-upgrade-modal" class="dash-card"><div class="dash-icon" style="background:#FFF7ED;color:#C2410C;"><i class="fa fa-user-secret"></i></div><span class="dash-label">Agent</span></a></div>
            <div class="col-4 mb-3"><a href="logout" class="dash-card"><div class="dash-icon" style="background:#FEF2F2;color:#B91C1C;"><i class="fa fa-lock"></i></div><span class="dash-label">Logout</span></a></div>
        </div>
    </div>

</div>
