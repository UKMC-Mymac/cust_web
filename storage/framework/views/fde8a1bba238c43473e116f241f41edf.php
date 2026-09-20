
<?php $__env->startSection('title', 'Results'); ?>

<?php $__env->startSection('content'); ?>

<section class="py-5 bg-light">
    <div class="container">
    
        <!-- Page Header -->
        <div class="row mb-4 align-items-center">
            <div class="col-lg-6">
                <div class="d-flex align-items-center mb-2">
                    <div class="bg-success rounded-circle d-flex align-items-center justify-content-center me-3"
                         style="width: 42px; height: 42px;">
                        <i class="fa-solid fa-graduation-cap text-white"></i>
                    </div>
                    <div>
                        <h3 class="fw-bold mb-0">
                            <?php echo e(__('Academic Results')); ?>

                        </h3>
                        <small class="text-muted">
                            <?php echo e(__('Search and view publication of academic results')); ?>

                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="card border rounded-3 shadow-sm mb-4">
            <div class="card-body p-4">
                <form method="GET" action="<?php echo e(route('result')); ?>" class="result-filter-form">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label for="faculty" class="form-label small fw-semibold text-muted"><?php echo e(__('field_faculty')); ?></label>
                            <select class="form-select faculty" name="faculty" id="faculty">
                                <option value=""><?php echo e(__('All Departments')); ?></option>
                                <?php $__currentLoopData = $faculties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faculty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($faculty->id); ?>" <?php if($selected_faculty == $faculty->id): echo 'selected'; endif; ?>><?php echo e($faculty->title); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="program" class="form-label small fw-semibold text-muted"><?php echo e(__('field_program')); ?></label>
                            <select class="form-select program" name="program" id="program">
                                <option value=""><?php echo e(__('All Programs')); ?></option>
                                <?php $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($program->id); ?>" <?php if($selected_program == $program->id): echo 'selected'; endif; ?>><?php echo e($program->title); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label for="session" class="form-label small fw-semibold text-muted"><?php echo e(__('field_session')); ?></label>
                            <select class="form-select session" name="session" id="session">
                                <option value=""><?php echo e(__('All Sessions')); ?></option>
                                <?php $__currentLoopData = $sessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($session->id); ?>" <?php if($selected_session == $session->id): echo 'selected'; endif; ?>><?php echo e($session->title); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label for="batch" class="form-label small fw-semibold text-muted"><?php echo e(__('field_batch')); ?></label>
                            <select class="form-select batch" name="batch" id="batch">
                                <option value=""><?php echo e(__('All Batches')); ?></option>
                                <?php $__currentLoopData = $batches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $batch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($batch->id); ?>" <?php if($selected_batch == $batch->id): echo 'selected'; endif; ?>><?php echo e($batch->title); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-2 d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-100 py-2">
                                <i class="fa-solid fa-magnifying-glass me-1"></i> <?php echo e(__('Search')); ?>

                            </button>
                             <?php if($selected_faculty || $selected_program || $selected_session || $selected_batch): ?>
                                <a href="<?php echo e(route('result')); ?>" class="btn btn-outline-secondary py-2" title="Reset Filters">
                                    <i class="fa-solid fa-xmark"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Result List -->
        <div class="bg-white rounded-3 shadow-sm overflow-hidden border">

            <?php $__empty_1 = true; $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $itemRoute = route('result.show', ['result' => $result->id]);
                    $dayDiff = \Carbon\Carbon::parse($result->date)
                        ->diffInDays(\Carbon\Carbon::today(), false);
                    $isNew = $dayDiff >= 0 && $dayDiff <= 7;
                ?>

                <a href="<?php echo e($itemRoute); ?>" class="text-decoration-none text-dark">
                    <div class="p-4 border-bottom result-row-item">
                        <div class="row align-items-center g-3">
                            <!-- Date -->
                            <div class="col-auto">
                                <div class="text-center bg-light rounded-3 px-3 py-2 border" style="min-width: 72px;">
                                    <div class="fw-bold text-success fs-4 lh-1">
                                        <?php echo e(\Carbon\Carbon::parse($result->date)->format('d')); ?>

                                    </div>
                                    <small class="text-muted text-uppercase">
                                        <?php echo e(\Carbon\Carbon::parse($result->date)->format('M Y')); ?>

                                    </small>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="col">
                                <div class="d-flex align-items-center gap-2 flex-wrap mb-2">
                                    <?php if($result->faculty): ?>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle">
                                            <?php echo e($result->faculty->title); ?>

                                        </span>
                                    <?php endif; ?>
                                    <?php if($result->program): ?>
                                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                                            <?php echo e($result->program->title); ?>

                                        </span>
                                    <?php endif; ?>
                                    <?php if($result->session): ?>
                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">
                                            <?php echo e(__('field_session')); ?>: <?php echo e($result->session->title); ?>

                                        </span>
                                    <?php endif; ?>
                                    <?php if($result->batch): ?>
                                        <span class="badge bg-dark-subtle text-dark border border-dark-subtle">
                                            Batch: <?php echo e($result->batch->title); ?>

                                        </span>
                                    <?php endif; ?>
                                    <?php if($isNew): ?>
                                        <span class="badge bg-danger">
                                            <?php echo e(__('NEW')); ?>

                                        </span>
                                    <?php endif; ?>
                                </div>

                                <h5 class="fw-semibold mb-1">
                                    <?php echo e($result->title); ?>

                                </h5>

                                <small class="text-muted">
                                    <i class="fa-regular fa-calendar me-1"></i>
                                    <?php echo e(\Carbon\Carbon::parse($result->date)->format('l, d F Y')); ?>

                                </small>
                            </div>

                            <!-- Action -->
                            <div class="col-auto">
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                                    <i class="fa-solid fa-arrow-right text-muted small"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="fa-solid fa-file-invoice fa-3x text-muted"></i>
                    </div>
                    <h5 class="fw-bold mb-2">
                        <?php echo e(__('No Results Found')); ?>

                    </h5>
                    <p class="text-muted mb-0">
                        <?php echo e(__('Try adjusting your filter settings or search criteria.')); ?>

                    </p>
                </div>
            <?php endif; ?>

        </div>

        <!-- Pagination -->
        <?php if($results->count() > 0 || $results->total() > 0): ?>
            <div class="d-flex justify-content-center mt-4">
                <?php echo e($results->appends(request()->query())->links('pagination::bootstrap-4')); ?>

            </div>
        <?php endif; ?>

    </div>
</section>

<style>
    .result-row-item {
        transition: background-color 0.15s ease-in-out;
    }
    .result-row-item:hover {
        background-color: #f8fafc;
    }
</style>

<script src="<?php echo e(asset('plugins/jquery/js/jquery.min.js')); ?>"></script>
<script type="text/javascript">
    "use strict";
    $(".faculty").on('change', function(e){
        e.preventDefault();
        var program = $(".program");
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: "<?php echo e(route('filter-program')); ?>",
            data: {
                _token: $('input[name=_token]').val(),
                faculty: $(this).val()
            },
            success: function(response){
                $('option', program).remove();
                $('.program').append('<option value=""><?php echo e(__("All Programs")); ?></option>');
                $.each(response, function(){
                    $('<option/>', {
                        'value': this.id,
                        'text': this.title
                    }).appendTo('.program');
                });
                // reset dependables
                $('.session').html('<option value=""><?php echo e(__("All Sessions")); ?></option>');
                $('.batch').html('<option value=""><?php echo e(__("All Batches")); ?></option>');
            }
        });
    });

    $(".program").on('change', function(e){
        e.preventDefault();
        var session = $(".session");
        var batch = $(".batch");
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: "<?php echo e(route('filter-session')); ?>",
            data: {
                _token: $('input[name=_token]').val(),
                program: $(this).val()
            },
            success: function(response){
                $('option', session).remove();
                $('.session').append('<option value=""><?php echo e(__("All Sessions")); ?></option>');
                $.each(response, function(){
                    $('<option/>', {
                        'value': this.id,
                        'text': this.title
                    }).appendTo('.session');
                });
            }
        });

        $.ajax({
            type: 'POST',
            url: "<?php echo e(route('filter-batch-by-program')); ?>",
            data: {
                _token: $('input[name=_token]').val(),
                program: $(this).val()
            },
            success: function(response){
                $('option', batch).remove();
                $('.batch').append('<option value=""><?php echo e(__("All Batches")); ?></option>');
                $.each(response, function(){
                    $('<option/>', {
                        'value': this.id,
                        'text': this.title
                    }).appendTo('.batch');
                });
            }
        });
    });
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.custom.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\cust_web\resources\views/web/result.blade.php ENDPATH**/ ?>