<div class="row">
    <div class="col-lg-8">
        <div class="box">
            <div class="box-header with-border d-flex align-items-center justify-content-between">
                <h4 class="box-title">CAC Order Details</h4>
                <a href="cac-orders" class="btn btn-info btn-sm"><i class="fa fa-arrow-left"></i> Back</a>
            </div>
            <div class="box-body">
                <?php if($data): ?>
                <table class="table table-striped table-bordered">
                    <tr><th style="width:220px;">Reference</th><td><b><?php echo $data->ref; ?></b></td></tr>
                    <tr><th>User</th><td><?php echo $data->sFname." ".$data->sLname; ?> (<?php echo $data->sEmail; ?> - <?php echo $data->sPhone; ?>)</td></tr>
                    <tr><th>Plan</th><td><?php echo $data->plan_name; ?> - N<?php echo number_format($data->amount,2); ?></td></tr>
                    <tr><th>Business Type</th><td><span class="badge badge-info"><?php echo $data->business_type; ?></span></td></tr>
                    <tr><th>Proposed Name (1st Choice)</th><td><?php echo $data->first_choice_name; ?></td></tr>
                    <tr><th>Alternative Name (2nd Choice)</th><td><?php echo $data->second_choice_name ?? "N/A"; ?></td></tr>
                    <tr><th>Nature of Business</th><td><?php echo nl2br($data->nature_of_business??"N/A"); ?></td></tr>
                    <tr><th>Business Address</th><td><?php echo nl2br($data->business_address??"N/A"); ?></td></tr>
                    <tr><th>Applicant Name</th><td><?php echo $data->applicant_name; ?></td></tr>
                    <tr><th>Applicant Email</th><td><?php echo $data->applicant_email; ?></td></tr>
                    <tr><th>Applicant Phone</th><td><?php echo $data->applicant_phone; ?></td></tr>
                    <?php if($data->business_type == "Business Name"): ?>
                    <tr><th colspan="2" class="bg-gray">Business Name - Proprietor Details</th></tr>
                    <tr><th>Proprietor Name</th><td><?php echo $data->proprietor_name??"N/A"; ?></td></tr>
                    <tr><th>Date of Birth</th><td><?php echo $data->proprietor_dob ? date("d/m/Y",strtotime($data->proprietor_dob)) : "N/A"; ?></td></tr>
                    <tr><th>Residential Address</th><td><?php echo nl2br($data->proprietor_address??"N/A"); ?></td></tr>
                    <tr><th>ID Type</th><td><?php echo $data->id_type??"N/A"; ?></td></tr>
                    <tr><th>ID Number</th><td><?php echo $data->id_number??"N/A"; ?></td></tr>
                    <?php endif; ?>
                    <?php if($data->business_type == "Limited Liability"): ?>
                    <tr><th colspan="2" class="bg-gray">Limited Liability - Directors & Shareholders</th></tr>
                    <?php if($data->director_details): $directors = json_decode($data->director_details,true); if(is_array($directors)): $di=1; foreach($directors as $d): ?>
                    <tr><th>Director <?php echo $di++; ?></th>
                        <td>
                            <b>Name:</b> <?php echo $d['name']??""; ?><br>
                            <b>Phone:</b> <?php echo $d['phone']??""; ?><br>
                            <b>Email:</b> <?php echo $d['email']??""; ?><br>
                            <b>DOB:</b> <?php echo $d['dob']??""; ?><br>
                            <b>Address:</b> <?php echo $d['address']??""; ?><br>
                            <b>ID:</b> <?php echo ($d['id_type']??"")." - ".($d['id_no']??""); ?>
                        </td>
                    </tr>
                    <?php endforeach; endif; endif; ?>
                    <tr><th>Share Capital</th><td>N<?php echo number_format((float)$data->share_capital,2); ?></td></tr>
                    <tr><th>Shareholder Details</th><td><?php echo nl2br($data->shareholder_details??"N/A"); ?></td></tr>
                    <?php endif; ?>
                    <?php if($data->business_type == "Incorporated Trustee"): ?>
                    <tr><th colspan="2" class="bg-gray">Incorporated Trustee - Trustees</th></tr>
                    <tr><th>Aims & Objectives</th><td><?php echo nl2br($data->aims_objectives??"N/A"); ?></td></tr>
                    <?php if($data->trustee_details): $trustees = json_decode($data->trustee_details,true); if(is_array($trustees)): $ti=1; foreach($trustees as $t): ?>
                    <tr><th>Trustee <?php echo $ti++; ?></th>
                        <td>
                            <b>Name:</b> <?php echo $t['name']??""; ?><br>
                            <b>Phone:</b> <?php echo $t['phone']??""; ?><br>
                            <b>Email:</b> <?php echo $t['email']??""; ?><br>
                            <b>Address:</b> <?php echo $t['address']??""; ?>
                        </td>
                    </tr>
                    <?php endforeach; endif; endif; ?>
                    <?php endif; ?>
                    <tr><th>Additional Info</th><td><?php echo nl2br($data->additional_info??"N/A"); ?></td></tr>
                    <tr><th>Current Status</th>
                        <td>
                            <?php if($data->status == "pending"): ?>
                            <span class="badge badge-warning" style="font-size:14px;">Pending</span>
                            <?php elseif($data->status == "processing"): ?>
                            <span class="badge badge-info" style="font-size:14px;">Processing</span>
                            <?php elseif($data->status == "completed"): ?>
                            <span class="badge badge-success" style="font-size:14px;">Completed</span>
                            <?php elseif($data->status == "rejected"): ?>
                            <span class="badge badge-danger" style="font-size:14px;">Rejected</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr><th>Admin Notes</th><td><?php echo nl2br($data->admin_notes??"None"); ?></td></tr>
                    <tr><th>Document</th>
                        <td>
                            <?php if($data->document_path && file_exists("../../".$data->document_path)): ?>
                            <a href="../../<?php echo $data->document_path; ?>" class="btn btn-success btn-sm" target="_blank"><i class="fa fa-download"></i> Download CAC Document</a>
                            <?php elseif($data->document_path): ?>
                            <span class="text-muted">File: <?php echo $data->document_path; ?></span>
                            <?php else: ?>
                            <span class="text-muted">No document uploaded yet</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr><th>Submitted</th><td><?php echo date("d/m/Y H:i",strtotime($data->created_at)); ?></td></tr>
                    <?php if($data->updated_at): ?>
                    <tr><th>Last Updated</th><td><?php echo date("d/m/Y H:i",strtotime($data->updated_at)); ?></td></tr>
                    <?php endif; ?>
                </table>
                <?php else: ?>
                <div class="alert alert-danger">Order not found.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <?php if($data): ?>
        <!-- Update Status -->
        <div class="box">
            <div class="box-header with-border"><h4 class="box-title">Update Status</h4></div>
            <div class="box-body">
                <form method="post" class="form-submit">
                    <input type="hidden" name="order_id" value="<?php echo $data->id; ?>">
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control" required>
                            <option value="pending" <?php echo $data->status=="pending"?"selected":""; ?>>Pending</option>
                            <option value="processing" <?php echo $data->status=="processing"?"selected":""; ?>>Processing</option>
                            <option value="completed" <?php echo $data->status=="completed"?"selected":""; ?>>Completed</option>
                            <option value="rejected" <?php echo $data->status=="rejected"?"selected":""; ?>>Rejected</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Admin Notes (sent to user via email)</label>
                        <textarea name="notes" class="form-control" rows="3" placeholder="Add notes for the user..."><?php echo $data->admin_notes; ?></textarea>
                    </div>
                    <button type="submit" name="update-cac-status" class="btn btn-info btn-submit btn-block"><i class="fa fa-save"></i> Update Status & Notify User</button>
                </form>
            </div>
        </div>

        <!-- Upload Document -->
        <div class="box">
            <div class="box-header with-border"><h4 class="box-title">Upload CAC Certificate</h4></div>
            <div class="box-body">
                <form method="post" enctype="multipart/form-data" class="form-submit">
                    <input type="hidden" name="order_id" value="<?php echo $data->id; ?>">
                    <div class="form-group">
                        <label>CAC Document (PDF, DOC, JPG, PNG)</label>
                        <input type="file" name="document" class="form-control" required accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                        <small class="text-muted">Upload the certificate/document for user to download</small>
                    </div>
                    <button type="submit" name="upload-cac-document" class="btn btn-success btn-submit btn-block"><i class="fa fa-upload"></i> Upload & Notify User</button>
                </form>
            </div>
        </div>

        <!-- Send Email -->
        <div class="box">
            <div class="box-header with-border"><h4 class="box-title">Send Feedback / Email</h4></div>
            <div class="box-body">
                <form method="post" class="form-submit">
                    <input type="hidden" name="email" value="<?php echo $data->sEmail; ?>">
                    <div class="form-group">
                        <label>Subject</label>
                        <input type="text" name="subject" class="form-control" value="CAC Registration Update - <?php echo $data->ref; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Message</label>
                        <textarea name="message" class="form-control" rows="4" required placeholder="Write your message...">Dear <?php echo $data->sFname; ?>,

Regarding your CAC registration (Ref: <?php echo $data->ref; ?>) for <?php echo $data->first_choice_name; ?>:

[Your message here]

Best regards,
<?php echo $_SESSION["sysName"]??"Admin"; ?></textarea>
                    </div>
                    <button type="submit" name="send-cac-email" class="btn btn-primary btn-submit btn-block"><i class="fa fa-envelope"></i> Send Email</button>
                </form>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>