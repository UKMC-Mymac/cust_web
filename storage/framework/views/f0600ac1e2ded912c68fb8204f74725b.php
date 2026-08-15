<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
              <!-- Section Heading Management -->
            <div class="col-md-12">
                <div class="card border-info">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class=""></i> Section Heading</h5>
                    </div>
                    <div class="card-block">
                        <?php
                            $news_eventSection = \App\Models\Web\ContentSection::query()
                                                                           ->where('key', 'news-event')
                                                                           ->first();
                        ?>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-2">
                                    <strong>Subtitle:</strong> 
                                    <span class="text-muted"><?php echo e($news_eventSection->subtitle ?? 'Not set'); ?></span>
                                </div>
                                <div class="mb-2">
                                    <strong>Title:</strong> 
                                    <span class="text-muted"><?php echo e($news_eventSection->title ?? 'Not set'); ?></span>
                                </div>
                                <div>
                                    <strong>Description:</strong> 
                                    <span class="text-muted"><?php echo str_limit($news_eventSection->description ?? 'Not set', 100); ?></span>
                                </div>
                            </div>
                            <div class="col-md-4 text-end">
                                <?php if($news_eventSection && $news_eventSection->status == 1): ?>
                                    <div class="mb-2"><span class="badge badge-pill badge-success"><?php echo e(__('status_active')); ?></span></div>
                                <?php else: ?>
                                    <div class="mb-2"><span class="badge badge-pill badge-danger"><?php echo e(__('status_inactive')); ?></span></div>
                                <?php endif; ?>
                                <a href="<?php echo e(route('admin.content-section.manage', 'news-event')); ?>" class="btn btn-info">
                                    <i class="fas fa-edit"></i> Section
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Section Heading Management -->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5><?php echo e($title); ?> <?php echo e(__('list')); ?></h5>
                    </div>
                    <div class="card-block">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($access.'-create')): ?>
                        <a href="<?php echo e(route($route.'.create')); ?>" class="btn btn-primary"><i class="fas fa-plus"></i> <?php echo e(__('btn_add_new')); ?></a>
                        <?php endif; ?>

                        <a href="<?php echo e(route($route.'.index')); ?>" class="btn btn-info"><i class="fas fa-sync-alt"></i> <?php echo e(__('btn_refresh')); ?></a>
                    </div>

                    <div class="card-block">
                        <form class="needs-validation" novalidate method="get" action="<?php echo e(route($route.'.index')); ?>">
                            <div class="row gx-2">
                                <div class="form-group col-md-3">
                                    <label for="title"><?php echo e(__('field_title')); ?></label>
                                    <input type="text" class="form-control" name="title" id="title" value="<?php echo e($selected_title); ?>">

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_title')); ?>

                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <button type="submit" class="btn btn-info btn-filter" style="margin-top: 25px;"><i class="fas fa-search"></i> <?php echo e(__('btn_search')); ?></button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table id="export-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo e(__('field_title')); ?></th>
                                        <th><?php echo e(__('field_thumbnail')); ?></th>
                                        <th><?php echo e(__('field_date')); ?></th>
                                        <th><?php echo e(__('field_status')); ?></th>
                                        <th><?php echo e(__('field_pinned')); ?></th>
                                        <th><?php echo e(__('field_action')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e(($rows->currentPage() - 1) * $rows->perPage() + $key + 1); ?></td>
                                        <td><?php echo str_limit($row->title, 50, ' ...'); ?></td>
                                        <td>
                                            <?php if(is_file('uploads/'.$path.'/'.$row->attach)): ?>
                                            <img style="width:150px; height:150" src="<?php echo e(asset('uploads/'.$path.'/'.$row->attach)); ?>" alt="" srcset="">
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if(isset($setting->date_format)): ?>
                                            <?php echo e(date($setting->date_format, strtotime($row->date))); ?>

                                            <?php else: ?>
                                            <?php echo e(date("Y-m-d", strtotime($row->date))); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if( $row->status == 1 ): ?>
                                            <span class="badge badge-pill badge-success"><?php echo e(__('status_active')); ?></span>
                                            <?php else: ?>
                                            <span class="badge badge-pill badge-danger"><?php echo e(__('status_inactive')); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if( !empty($row->pinned) ): ?>
                                            <span class="badge badge-pill badge-warning text-dark"><i class="fas fa-thumbtack"></i> <?php echo e($row->pinned); ?></span>
                                            <?php else: ?>
                                            -
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-icon btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#showModal-<?php echo e($row->id); ?>">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <!-- Include Show modal -->
                                            <?php echo $__env->make($view.'.show', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($access.'-edit')): ?>
                                            <a href="<?php echo e(route($route.'.edit', $row->id)); ?>" class="btn btn-icon btn-primary btn-sm">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            <?php endif; ?>

                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($access.'-delete')): ?>
                                            <button type="button" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal-<?php echo e($row->id); ?>">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            <!-- Include Delete modal -->
                                            <?php echo $__env->make('admin.layouts.inc.delete', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- [ Data table ] end -->

                        <!-- Pagination Links -->
                        <div class="d-flex justify-content-center mt-3">
                            <?php echo e($rows->appends(request()->query())->links('pagination::bootstrap-4')); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\office_project\cust\resources\views/admin/web/web-event/index.blade.php ENDPATH**/ ?>