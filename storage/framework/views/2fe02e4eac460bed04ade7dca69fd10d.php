<!-- Show modal content -->
<div id="showModal-<?php echo e($row->id); ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel"><?php echo e(__('modal_view')); ?> <?php echo e($title); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <!-- Details View Start -->
                <h4><mark class="text-primary"><?php echo e(__('field_title')); ?>:</mark> <?php echo e($row->title); ?></h4>
                <hr/>
                <div class="">
                    <div class="row">
                        <div class="col-md-12">
                            <p><mark class="text-primary"><?php echo e(__('field_sub_title')); ?>:</mark> <?php echo e($row->sub_title); ?></p><hr/>
                            <p><mark class="text-primary"><?php echo e(__('field_button_text')); ?>:</mark> <?php echo e($row->button_text); ?></p><hr/>
                            <p><mark class="text-primary"><?php echo e(__('field_button_link')); ?>:</mark> <?php echo e($row->button_link); ?></p><hr/>
                            <?php if($row->page_id || $row->route_name || $row->button_link): ?>
                                <?php
                                    $buttonOneUrl = $row->button_link ?? '';
                                    if (!empty($row->page_id)) {
                                        $page = \App\Models\Web\Page::find($row->page_id);
                                        if ($page) {
                                            $buttonOneUrl = route('page.single', $page->slug);
                                        }
                                    } elseif (!empty($row->route_name)) {
                                        try {
                                            $buttonOneUrl = route($row->route_name);
                                        } catch (\Exception $e) {
                                            $buttonOneUrl = $row->button_link ?? '';
                                        }
                                    }
                                ?>
                                <p><mark class="text-primary">Button 1 Link Type:</mark>
                                    <?php if(!empty($row->page_id)): ?>
                                        <span class="badge badge-info">Page: <?php echo e(\App\Models\Web\Page::find($row->page_id)->title ?? 'N/A'); ?></span>
                                    <?php elseif(!empty($row->route_name)): ?>
                                        <span class="badge badge-warning">Route: <?php echo e($row->route_name); ?></span>
                                    <?php else: ?>
                                        <span class="badge badge-secondary">Custom URL</span>
                                    <?php endif; ?>
                                </p><hr/>
                                <?php if($buttonOneUrl): ?>
                                <p><mark class="text-primary">Button 1 Resolved URL:</mark> <a href="<?php echo e($buttonOneUrl); ?>" target="_blank"><?php echo e($buttonOneUrl); ?></a></p><hr/>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php if($row->button_text_2): ?>
                            <p><mark class="text-primary">Button Text 2:</mark> <?php echo e($row->button_text_2); ?></p><hr/>
                            <?php endif; ?>
                            <?php if($row->page_id_2 || $row->route_name_2 || $row->button_link_2): ?>
                                <?php
                                    $buttonTwoUrl = $row->button_link_2 ?? '';
                                    if (!empty($row->page_id_2)) {
                                        $page = \App\Models\Web\Page::find($row->page_id_2);
                                        if ($page) {
                                            $buttonTwoUrl = route('page.single', $page->slug);
                                        }
                                    } elseif (!empty($row->route_name_2)) {
                                        try {
                                            $buttonTwoUrl = route($row->route_name_2);
                                        } catch (\Exception $e) {
                                            $buttonTwoUrl = $row->button_link_2 ?? '';
                                        }
                                    }
                                ?>
                                <p><mark class="text-primary">Button 2 Link Type:</mark>
                                    <?php if(!empty($row->page_id_2)): ?>
                                        <span class="badge badge-info">Page: <?php echo e(\App\Models\Web\Page::find($row->page_id_2)->title ?? 'N/A'); ?></span>
                                    <?php elseif(!empty($row->route_name_2)): ?>
                                        <span class="badge badge-warning">Route: <?php echo e($row->route_name_2); ?></span>
                                    <?php else: ?>
                                        <span class="badge badge-secondary">Custom URL</span>
                                    <?php endif; ?>
                                </p><hr/>
                                <?php if($buttonTwoUrl): ?>
                                <p><mark class="text-primary">Button 2 Resolved URL:</mark> <a href="<?php echo e($buttonTwoUrl); ?>" target="_blank"><?php echo e($buttonTwoUrl); ?></a></p><hr/>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php if(!empty($row->video_url)): ?>
                                <p><mark class="text-primary">Video URL:</mark> <a href="<?php echo e($row->video_url); ?>" target="_blank"><?php echo e($row->video_url); ?></a></p><hr/>
                            <?php endif; ?>

                            <p><mark class="text-primary"><?php echo e(__('field_status')); ?>:</mark>
                                <?php if( $row->status == 1 ): ?>
                                <span class="badge badge-pill badge-success"><?php echo e(__('status_active')); ?></span>
                                <?php else: ?>
                                <span class="badge badge-pill badge-danger"><?php echo e(__('status_inactive')); ?></span>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Details View End -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> <?php echo e(__('btn_close')); ?></button>
            </div>
        </div>
    </div>
</div>
<?php /**PATH D:\office_project\cust\resources\views/admin/web/slider/show.blade.php ENDPATH**/ ?>