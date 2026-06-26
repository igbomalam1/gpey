<div class="row">
    <div class="col-12">
        <div class="box">
            <div class="box-header with-border d-flex align-items-center justify-content-between">
              <h4 class="box-title">Services Pricing</h4>
              <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#addVerificationPricing">
                  <i class="fa fa-plus"></i> Add Price
              </button>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                  <table id="example1" class="table table-sm table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Service Type</th>
                            <th>Plan Name</th>
                            <th>User Price</th>
                            <th>Agent Price</th>
                            <th>Vendor Price</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                    <?php 
                        $cnt=1; $results=$data;
                        $serviceLabels = [
                            "buy_number" => "Buy Number",
                            "buy_logs" => "Buy Logs",
                            "boost_socials" => "Boost Socials",
                            "bvn" => "BVN",
                            "cac_registration" => "CAC Registration"
                        ];
                        if(is_array($results) && count($results) > 0){foreach($results as $result){   ?>
                        <tr>
                            <td><?php echo htmlentities($cnt);?></td>
                            <td><?php echo $serviceLabels[$result->service_type] ?? $result->service_type; ?></td>
                            <td><?php echo $result->plan_name; ?></td>
                            <td>N <?php echo $result->user_price; ?></td>
                            <td>N <?php echo $result->agent_price; ?></td>
                            <td>N <?php echo $result->vendor_price; ?></td>
                            <td><?php echo $result->status; ?></td>
                            <td>
                                <a href="#" onclick="editVerification('<?php echo $result->id; ?>','<?php echo $result->service_type; ?>','<?php echo $result->plan_name; ?>','<?php echo $result->user_price; ?>','<?php echo $result->agent_price; ?>','<?php echo $result->vendor_price; ?>','<?php echo $result->status; ?>')" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                <a href="verification-pricing&delete-verification-pricing=<?php echo base64_encode($result->id); ?>" onclick="return confirm('Delete this pricing?')" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php $cnt=$cnt+1;}} else { ?>
                        <tr><td colspan="8" class="text-center">No pricing records found</td></tr>
                        <?php } ?>
                        
                    </tbody>
                    </table>
                </div>
            </div>
          </div>
    </div>
</div>

<!-- Add Verification Pricing Modal -->
<div class="modal fade" data-backdrop="false" id="addVerificationPricing" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border">
            <div class="modal-header bg-success">
                <h5 class="modal-title">Add Verification Pricing</h5>
            </div>
            <div class="modal-body">
                <form method="post" class="form-submit">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="control-label">Service Type</label>
                            <select name="service_type" class="form-control" required>
                                <option value="">Select Service</option>
                                <option value="buy_number">Buy Number</option>
                                <option value="buy_logs">Buy Logs</option>
                                <option value="boost_socials">Boost Socials</option>
                                <option value="bvn">BVN</option>
                                <option value="cac_registration">CAC Registration</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="control-label">Plan Name</label>
                            <input type="text" name="plan_name" class="form-control" placeholder="e.g. Basic, Premium" required>
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="control-label">User Price</label>
                            <input type="number" name="user_price" placeholder="User Price" class="form-control" required>
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="control-label">Agent Price</label>
                            <input type="number" name="agent_price" placeholder="Agent Price" class="form-control" required>
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="control-label">Vendor Price</label>
                            <input type="number" name="vendor_price" placeholder="Vendor Price" class="form-control" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <label class="control-label">Status</label>
                            <select name="status" class="form-control">
                                <option value="On">Enable</option>
                                <option value="Off">Disable</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="d-flex justify-content-between">
                            <button type="submit" name="add-verification-pricing" class="btn btn-success btn-submit"><i class="fa fa-save"></i> Add Pricing</button>
                            <button type="button" class="btn btn-bold btn-pure btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Verification Pricing Modal -->
<div class="modal fade" data-backdrop="false" id="editVerificationPricing" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border">
            <div class="modal-header bg-info">
                <h5 class="modal-title">Edit Verification Pricing</h5>
            </div>
            <div class="modal-body">
                <form method="post" class="form-submit">
                    <div class="row">
                        <input type="hidden" id="eid" name="id" />
                        <div class="col-md-6 form-group">
                            <label class="control-label">Service Type</label>
                            <select name="service_type" id="eservice_type" class="form-control" required>
                                <option value="buy_number">Buy Number</option>
                                <option value="buy_logs">Buy Logs</option>
                                <option value="boost_socials">Boost Socials</option>
                                <option value="bvn">BVN</option>
                                <option value="cac_registration">CAC Registration</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="control-label">Plan Name</label>
                            <input type="text" id="eplan_name" name="plan_name" class="form-control" required>
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="control-label">User Price</label>
                            <input type="number" id="euser_price" name="user_price" class="form-control" required>
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="control-label">Agent Price</label>
                            <input type="number" id="eagent_price" name="agent_price" class="form-control" required>
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="control-label">Vendor Price</label>
                            <input type="number" id="evendor_price" name="vendor_price" class="form-control" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <label class="control-label">Status</label>
                            <select name="status" id="estatus" class="form-control">
                                <option value="On">Enable</option>
                                <option value="Off">Disable</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="d-flex justify-content-between">
                            <button type="submit" name="update-verification-pricing" class="btn btn-info btn-submit"><i class="fa fa-save"></i> Update Pricing</button>
                            <button type="button" class="btn btn-bold btn-pure btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function editVerification(id,service_type,plan_name,user_price,agent_price,vendor_price,status){
    $('#eid').val(id);
    $('#eservice_type').val(service_type);
    $('#eplan_name').val(plan_name);
    $('#euser_price').val(user_price);
    $('#eagent_price').val(agent_price);
    $('#evendor_price').val(vendor_price);
    $('#estatus').val(status);
    $('#editVerificationPricing').modal('show');
}
</script>