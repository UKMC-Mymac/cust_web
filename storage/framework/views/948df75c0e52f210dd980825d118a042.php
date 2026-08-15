<section class="cat-area-1 position-relative overflow-hidden space">
    <div class="shape-mockup" data-top="0%" data-left="0%">
        <img src="<?php echo e(asset('dist/img/shape/feature-shep-home-1.png')); ?>" alt="Stadum">
    </div>
    <div class="container th-container3">
        <div class="row justify-content-center text-center">
            <?php if(isset($contentSections['student_zone'])): ?>
                <?php
                    $section = $contentSections['student_zone'];
                ?>
            <div class="col-xl-8 col-md-8">
                <div class="title-area">
                    <span class="sub-title text-anim"><?php echo e($section->subtitle ?? ''); ?></span>
                    <h2 class="sec-title text-anim2"><?php echo e($section->title ?? ''); ?></h2>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <div class="cat-wrap1">
            <?php if(isset($studentZones) && $studentZones->count() > 0): ?>
                <?php $__currentLoopData = $studentZones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    // $linkHref = $zone->link;
                    // $display = $zone->title;
                    // if (empty($linkHref) && !empty($zone->page)) {
                    //     $linkHref = url('page/' . ($zone->page->slug ?? $zone->page->id));
                    //     $display = $zone->page->title;
                    // } elseif (empty($linkHref) && !empty($zone->route_name)) {
                    //     try {
                    //         $linkHref = route($zone->route_name);
                    //         $display = $zone->route_name;
                    //     } catch (\Exception $e) {
                    //         $linkHref = '#';
                    //         $display = $zone->route_name;
                    //     }
                    // }
                    $linkHref = $zone->link;
                    $display = $zone->title;
                    if (empty($linkHref) && !empty($zone->page)) {
                        $linkHref = url('page/' . ($zone->page->slug ?? $zone->page->id));
                        $display = $zone->title;
                    } elseif (empty($linkHref) && !empty($zone->route_name)) {
                        try {
                            $linkHref = route($zone->route_name);
                            $display = $zone->title;
                        } catch (\Exception $e) {
                            $linkHref = '#';
                            $display = $zone->title;
                        }
                    }
                ?>
                <div>
                    <a href="<?php echo e($linkHref ?? '#'); ?>" class="cat-card wow fadeInUp" data-wow-delay=".1s">
                        <div class="box-icon">
                            <?php if(!empty($zone->icon_url)): ?>
                                <img src="<?php echo e(asset('uploads/student-zone/' . $zone->icon_url)); ?>" alt="icon">
                            <?php else: ?>
                                <img src="<?php echo e(asset('dist/images/homepage/st-zone-' . ($loop->index + 1) . '.png')); ?>" alt="icon">
                            <?php endif; ?>
                        </div>
                        <div class="card-content">
                            <h3 class="box-title"><?php echo e($display); ?></h3>
                        </div>
                    </a>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>
    </div>
        <div class="cat-shape shape-mockup jump" data-bottom="15%" data-left="10%">
            <img src="<?php echo e(asset('dist/img/shape/cat-3-1.png')); ?>" alt="CUST">
        </div>
        <div class="shape-mockup" data-bottom="0%" data-right="0%">
            <img src="<?php echo e(asset('dist/img/shape/feature-shep-2-home-1.png')); ?>" alt="CUST">
        </div>
    </section>
<?php /**PATH D:\office_project\cust\resources\views/web/custom/sections/student-portal.blade.php ENDPATH**/ ?>