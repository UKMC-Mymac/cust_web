<section class="faq-area-1 position-relative space overflow-hidden">
    <div class="faq-shape1 shape-mockup" data-top="0%" data-left="0%">
        <img src="<?php echo e(asset('dist/img/shape/feature-shep-home-1.png')); ?>" alt="shape">
    </div>
    <div class="faq-shape2 shape-mockup" data-bottom="0%" data-right="0%">
        <img src="<?php echo e(asset('dist/img/shape/feature-shep-2-home-1.png')); ?>" alt="shape">
    </div>
    <div class="faq-shape3 movingX shape-mockup" data-bottom="0%" data-right="2%">
        <img src="<?php echo e(asset('dist/img/shape/faq-1-1.png')); ?>" alt="shape">
    </div>
    <div class="ripple-shape d-none d-xl-block">
        <span class="ripple-1"></span>
        <span class="ripple-2"></span>
        <span class="ripple-3"></span>
        <span class="ripple-4"></span>
        <span class="ripple-5"></span>
    </div>
    <div class="container">
        <div class="row gy-30 gx-30 align-items-center justify-content-center">
            <div class="col-12">
                <div class="faq-content">
                    <div class="row justify-content-lg-between justify-content-center align-items-center mb-40">
                        <div class="col-lg-9 col-12">
                            <div class="faq-wrap">
                                <?php if(isset($contentSections['faq'])): ?>
                                    <?php
                                        $section = $contentSections['faq'];
                                    ?>
                                <div class="title-area mb-0">
                                    <span class="sub-title text-anim"><?php echo e($section->subtitle); ?></span>
                                    <h2 class="sec-title text-anim2"><?php echo e($section->title); ?></h2>
                                    <p class="box-text mt-20 wow fadeInUp" data-wow-delay=".3s">
                                        <?php echo e($section->description); ?>

                                    </p>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-3 col-12 text-center text-lg-end mb-40">
                            <a href="<?php echo e(route('faq')); ?>" class="th-btn style-border1 th-icon">Explore All</a>
                        </div>
                    </div>
                    <div class="faq-box">
                        <div class="faq-wrap1">
                            <div class="accordion" id="faqAccordion">

                                <?php $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="accordion-card wow fadeInUp" data-wow-delay=".<?php echo e($index + 1); ?>s">
                                    <div class="accordion-header" id="collapse-item-<?php echo e($index + 1); ?>">
                                        <button class="accordion-button <?php echo e($index === 0 ? '' : 'collapsed'); ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo e($index + 1); ?>" aria-expanded="<?php echo e($index === 0 ? 'true' : 'false'); ?>" aria-controls="collapse-<?php echo e($index + 1); ?>">
                                            <?php echo e($faq['title']); ?>

                                        </button>
                                    </div>
                                    <div id="collapse-<?php echo e($index + 1); ?>" class="accordion-collapse collapse <?php echo e($index === 0 ? 'show' : ''); ?>" aria-labelledby="collapse-item-<?php echo e($index + 1); ?>" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            <p class="faq-text"><?php echo e($faq['description']); ?></p>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php /**PATH D:\office_project\cust\resources\views/web/custom/sections/faq.blade.php ENDPATH**/ ?>