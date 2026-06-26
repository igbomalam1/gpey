<div class="row">
    <div class="col-12">
        <div class="box">
            <div class="box-header with-border d-flex align-items-center justify-content-between">
                <h4 class="box-title">CAC Registration Orders</h4>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Ref</th>
                                <th>User</th>
                                <th>Business Name</th>
                                <th>Plan</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(is_array($data) || is_object($data)): $i=1; foreach($data as $order): ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><b><?php echo $order->ref; ?></b></td>
                                <td><?php echo $order->sFname." ".$order->sLname; ?><br><small class="text-muted"><?php echo $order->sEmail; ?></small></td>
                                <td><?php echo $order->first_choice_name; ?></td>
                                <td><?php echo $order->plan_name; ?></td>
                                <td>N<?php echo number_format($order->amount,2); ?></td>
                                <td>
                                    <?php if($order->status == "pending"): ?>
                                    <span class="badge badge-warning">Pending</span>
                                    <?php elseif($order->status == "processing"): ?>
                                    <span class="badge badge-info">Processing</span>
                                    <?php elseif($order->status == "completed"): ?>
                                    <span class="badge badge-success">Completed</span>
                                    <?php elseif($order->status == "rejected"): ?>
                                    <span class="badge badge-danger">Rejected</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo date("d/m/Y",strtotime($order->created_at)); ?></td>
                                <td>
                                    <a href="cac-order-details?id=<?php echo $order->id; ?>" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> View</a>
                                </td>
                            </tr>
                            <?php endforeach; else: ?>
                            <tr><td colspan="9" class="text-center">No CAC orders found.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>