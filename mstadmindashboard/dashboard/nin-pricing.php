<div class="row">
    <div class="col-12">
        <div class="box">
            <div class="box-header with-border d-flex align-items-center justify-content-between">
              <h4 class="box-title">NIN Slip Pricing</h4>
              <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#addNinPricing">
                  <i class="fa fa-plus"></i> Add Price
              </button>
            </div>
            <div class="box-body">
				<div class="table-responsive">
				  <table id="example1" class="table table-sm table-bordered table-striped">
					<thead>
						<tr>
							<th>#</th>
			                <th>Slip Type</th>
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
                        if(is_array($results) && count($results) > 0){foreach($results as $result){   ?>
                        <tr>
                            <td><?php echo htmlentities($cnt);?></td>
                            <td><?php echo $result->slip_type; ?></td>
                            <td>N <?php echo $result->user_price; ?></td>
                            <td>N <?php echo $result->agent_price; ?></td>
                            <td>N <?php echo $result->vendor_price; ?></td>
                            <td><?php echo $result->status; ?></td>
                            <td>
                                <a href="#" onclick="editNinPricing('<?php echo $result->id; ?>','<?php echo $result->slip_type; ?>','<?php echo $result->user_price; ?>','<?php echo $result->agent_price; ?>','<?php echo $result->vendor_price; ?>','<?php echo $result->status; ?>')" class="btn btn-primary"><i class="fa fa-edit"></i></a> 
						    </td>
                        </tr>
                        <?php $cnt=$cnt+1;}} else { ?>
                        <tr><td colspan="7" class="text-center">No pricing records found</td></tr>
                        <?php } ?>
						
					</tbody>
					</table>
				</div>
            </div>
          </div>
    </div>
</div>

<!-- Add NIN Pricing Modal -->
<div class="modal fade" data-backdrop="false" id="addNinPricing" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border">
            <div class="modal-header bg-success">
                <h5 class="modal-title">Add NIN Pricing</h5>
            </div>
            <div class="modal-body">
                <form method="post" class="form-submit">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label class="control-label">Slip Type</label>
                            <input type="text" name="slip_type" class="form-control" placeholder="e.g. NIN Slip" required>
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
                            <button type="submit" name="add-nin-pricing" class="btn btn-success btn-submit"><i class="fa fa-save"></i> Add Pricing</button>
                            <button type="button" class="btn btn-bold btn-pure btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit NIN Pricing Modal -->
<div class="modal fade" data-backdrop="false" id="editNinPricing" tabindex="-1">
				  <div class="modal-dialog modal-lg">
					<div class="modal-content border">
					  <div class="modal-header bg-info">
						<h5 class="modal-title">Edit NIN Pricing</h5>
					</div>
					  <div class="modal-body">
					  <form method="post" class="form-submit">

                      <div class="row">
                            <input type="hidden" id="id" name="id" />
                            <div class="col-md-12 form-group">
                                <label class="control-label">Slip Type</label>
                                <div class="">
                                <input type="text" id="slip_type" name="slip_type" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="col-md-4 form-group">
                                <label class="control-label">User Price</label>
                                <div class="">
                                <input type="number" id="user_price" placeholder="User Price" name="user_price" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-4 form-group">
                                <label class="control-label">Agent Price</label>
                                <div class="">
                                <input type="number" id="agent_price" placeholder="Agent Price" name="agent_price" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-4 form-group">
                                <label class="control-label">Vendor Price</label>
                                <div class="">
                                <input type="number" id="vendor_price" placeholder="Vendor Price" name="vendor_price" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-12 form-group">
                                <label class="control-label">Status</label>
                                <div class="">
                                <select name="status" id="status" class="form-control">
                                    <option value="On">Enable</option>
                                    <option value="Off">Disable</option>
                                </select>
                                </div>
                            </div>

                            </div>

                       <div class="form-group">
                        <div class="d-flex justify-content-between">
                           <button type="submit" name="update-nin-pricing" class="btn btn-info btn-submit"><i class="fa fa-save" aria-hidden="true"></i> Update Pricing</button>
						   <button type="button" class="btn btn-bold btn-pure btn-secondary" data-dismiss="modal">Close</button>
						</div>
                        </div>
                      </form>
					  </div>
					</div>
				  </div>
</div>

<script>
function editNinPricing(id,slip_type,user_price,agent_price,vendor_price,status){
    $('#id').val(id);
    $('#slip_type').val(slip_type);
    $('#user_price').val(user_price);
    $('#agent_price').val(agent_price);
    $('#vendor_price').val(vendor_price);
    $('#status').val(status);
    $('#editNinPricing').modal('show');
}
</script>