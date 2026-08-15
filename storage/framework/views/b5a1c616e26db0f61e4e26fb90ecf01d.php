<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-md-12 col-lg-10">
                <form class="needs-validation" novalidate action="<?php echo e(route($route.'.store')); ?>" method="post" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                    <div class="card">
                        <div class="card-header">
                            <h5><?php echo e(__('btn_update')); ?> <?php echo e($title); ?></h5>
                        </div>
                        <div class="card-block">
                          <div class="row">
                            <!-- Form Start -->
                            <div class="container">
                            <div class="row">
                            <div class="col-md-12">
                            
                            
                            <div class="form-group">
                                <label for="status" class="form-label"><?php echo e(__('Select Gateway')); ?> <span>*</span></label>
                                <select class="form-control" name="status" id="status" required>
                                    <option value="none" <?php if(config('payment.status') == 'none'): ?> selected <?php endif; ?>><?php echo e(__('None')); ?></option>
                                    <option value="bkash" <?php if(config('payment.status') == 'bkash'): ?> selected <?php endif; ?>>Bkash</option>
                                    <option value="nagad" <?php if(config('payment.status') == 'nagad'): ?> selected <?php endif; ?>>Nagad</option>
                                    <option value="sslcommerz" <?php if(config('payment.status') == 'sslcommerz'): ?> selected <?php endif; ?>>SSLCommerz</option>
                                </select>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('Payment Gateway')); ?>

                                </div>
                            </div>

                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active text-uppercase" id="Bkash-tab" data-bs-toggle="tab" href="#Bkash" role="tab" aria-controls="Bkash" aria-selected="false">Bkash</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-uppercase" id="Nagad-tab" data-bs-toggle="tab" href="#Nagad" role="tab" aria-controls="Nagad" aria-selected="true">Nagad</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-uppercase" id="SSLCommerz-tab" data-bs-toggle="tab" href="#SSLCommerz" role="tab" aria-controls="SSLCommerz" aria-selected="false">SSLCommerz</a>
                                </li>
                            </ul>

                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="Bkash" role="tabpanel" aria-labelledby="Bkash-tab">
                                    <div class="container mt-3">
                                        <div class="form-group">
                                            <label for="bkash_merchant_number" class="form-label">Merchant Number</label>
                                            <input type="text" class="form-control" name="bkash_merchant_number" id="bkash_merchant_number" value="<?php echo e(config('payment.bkash.merchant_number')); ?>" placeholder="Enter merchant number">
                                        </div>
                                        <div class="form-group">
                                            <label for="bkash_app_key" class="form-label">App Key</label>
                                            <input type="text" class="form-control" name="bkash_app_key" id="bkash_app_key" value="<?php echo e(config('payment.bkash.app_key')); ?>" placeholder="Enter app key">
                                        </div>
                                        <div class="form-group">
                                            <label for="bkash_app_secret" class="form-label">App Secret</label>
                                            <input type="text" class="form-control" name="bkash_app_secret" id="bkash_app_secret" value="<?php echo e(config('payment.bkash.app_secret')); ?>" placeholder="Enter app secret">
                                        </div>
                                        <div class="form-group">
                                            <label for="bkash_username" class="form-label">Username</label>
                                            <input type="text" class="form-control" name="bkash_username" id="bkash_username" value="<?php echo e(config('payment.bkash.username')); ?>" placeholder="Enter username">
                                        </div>
                                        <div class="form-group">
                                            <label for="bkash_password" class="form-label">Password</label>
                                            <input type="password" class="form-control" name="bkash_password" id="bkash_password" value="<?php echo e(config('payment.bkash.password')); ?>" placeholder="Enter password">
                                        </div>
                                        <div class="form-group">
                                            <label for="bkash_base_url" class="form-label">Base URL</label>
                                            <input type="text" class="form-control" name="bkash_base_url" id="bkash_base_url" value="<?php echo e(config('payment.bkash.base_url')); ?>" placeholder="Enter base URL">
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="Nagad" role="tabpanel" aria-labelledby="Nagad-tab">
                                    <div class="container mt-3">
                                        <div class="form-group">
                                            <label for="nagad_merchant_id" class="form-label">Merchant ID</label>
                                            <input type="text" class="form-control" name="nagad_merchant_id" id="nagad_merchant_id" value="<?php echo e(config('payment.nagad.merchant_id')); ?>" placeholder="Enter merchant ID">
                                        </div>
                                        <div class="form-group">
                                            <label for="nagad_merchant_number" class="form-label">Merchant Number (Wallet Number)</label>
                                            <input type="text" class="form-control" name="nagad_merchant_number" id="nagad_merchant_number" value="<?php echo e(config('payment.nagad.merchant_number')); ?>" placeholder="Enter merchant number">
                                        </div>
                                        <div class="form-group">
                                            <label for="nagad_merchant_private_key" class="form-label">Merchant Private Key</label>
                                            <textarea class="form-control" name="nagad_merchant_private_key" id="nagad_merchant_private_key" rows="4" placeholder="Enter merchant private key"><?php echo e(config('payment.nagad.merchant_private_key')); ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="nagad_pg_public_key" class="form-label">Nagad PG Public Key</label>
                                            <textarea class="form-control" name="nagad_pg_public_key" id="nagad_pg_public_key" rows="4" placeholder="Enter Nagad PG public key"><?php echo e(config('payment.nagad.pg_public_key')); ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="nagad_mode" class="form-label">Mode</label>
                                            <select class="form-control" name="nagad_mode" id="nagad_mode">
                                                <option value="sandbox" <?php if(config('payment.nagad.mode') == 'sandbox'): ?> selected <?php endif; ?>>Sandbox</option>
                                                <option value="live" <?php if(config('payment.nagad.mode') == 'live'): ?> selected <?php endif; ?>>Live</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="SSLCommerz" role="tabpanel" aria-labelledby="SSLCommerz-tab">
                                    <div class="container mt-3">
                                        <div class="form-group">
                                            <label for="ssl_store_id" class="form-label">Store ID</label>
                                            <input type="text" class="form-control" name="ssl_store_id" id="ssl_store_id" value="<?php echo e(config('payment.sslcommerz.store_id')); ?>" placeholder="Enter store ID">
                                        </div>
                                        <div class="form-group">
                                            <label for="ssl_store_password" class="form-label">Store Password</label>
                                            <input type="password" class="form-control" name="ssl_store_password" id="ssl_store_password" value="<?php echo e(config('payment.sslcommerz.store_password')); ?>" placeholder="Enter store password">
                                        </div>
                                        <div class="form-group">
                                            <label for="ssl_mode" class="form-label">Mode</label>
                                            <select class="form-control" name="ssl_mode" id="ssl_mode">
                                                <option value="sandbox" <?php if(config('payment.sslcommerz.mode') == 'sandbox'): ?> selected <?php endif; ?>>Sandbox</option>
                                                <option value="live" <?php if(config('payment.sslcommerz.mode') == 'live'): ?> selected <?php endif; ?>>Live</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>

                            </div>
                            </div>
                            <!-- Form End -->
                          </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> <?php echo e(__('btn_update')); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\office_project\cust\resources\views/admin/payment-setting/index.blade.php ENDPATH**/ ?>