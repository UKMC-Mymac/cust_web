<section id="campus_life" class="campus overflow-hidden space">
    <div class="campus-shape jump shape-mockup d-none d-xxl-block" data-bottom="22%" data-right="5%">
        <img src="<?php echo e(asset('dist/img/shape/campus-1-1.png')); ?>" alt="shape">
    </div>

    <div class="container">
        <div class="row justify-content-lg-between justify-content-center align-items-center">
            <?php if(isset($contentSections['campus_life'])): ?>
                <?php
                    $section = $contentSections['campus_life'];
                ?>

                <div class="col-lg-8 col-12">
                    <div class="title-area text-center text-lg-start">
                        <span class="sub-title text-anim"><?php echo e($section->subtitle); ?></span>
                        <h2 class="sec-title text-anim2"><?php echo e($section->title); ?></h2>
                    </div>
                </div>
            <?php endif; ?>

            <div class="col-auto align-self-end">
                <div class="sec-btn">
                    <a href="<?php echo e(route('campus-life')); ?>" class="th-btn style-border1 th-icon wow fadeInUp" data-wow-delay=".2s">
                        Explore All
                    </a>
                </div>
            </div>
        </div>

        <div class="slider-area">
            <div class="swiper th-slider has-shadow" id="campusLifeSlider"
                data-slider-options='{
                    "spaceBetween":24,
                    "autoHeight":true,
                    "autoplay":{
                        "delay":5000,
                        "disableOnInteraction":false
                    },
                    "pagination":{
                        "el":".campus-pag",
                        "type":"bullets",
                        "clickable":true
                    },
                    "breakpoints":{
                        "0":{
                            "slidesPerView":1
                        },
                        "576":{
                            "slidesPerView":1
                        },
                        "768":{
                            "slidesPerView":2
                        },
                        "992":{
                            "slidesPerView":2
                        },
                        "1200":{
                            "slidesPerView":3
                        },
                        "1400":{
                            "slidesPerView":3,
                            "spaceBetween":24
                        }
                    }
                }'>

                <div class="swiper-wrapper">
                    <?php $__currentLoopData = $campus_lifes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $campusLife): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="swiper-slide">
                            <div class="campus-card h-100 wow fadeInUp" data-wow-delay=".2s">
                                <div class="campus-img global-img">
                                    <img src="<?php echo e(asset('uploads/campus-life/' . $campusLife->attach)); ?>"
                                        alt="<?php echo e($campusLife->title); ?>"
                                        class="img-1">
                                </div>

                                <div class="campus-content">
                                    <h3 class="box-title">
                                        <a href="<?php echo e(route('campus-life.single', ['slug' => $campusLife->slug])); ?>">
                                            <?php echo e($campusLife->title); ?>

                                        </a>
                                    </h3>

                                    <p class="box-text">
                                        <?php echo e($campusLife->feature_text); ?>

                                    </p>
                                </div>

                                <a href="<?php echo e(route('campus-life.single', ['slug' => $campusLife->slug])); ?>"
                                    class="th-btn style-border1 th-icon">
                                    <?php echo e($campusLife->button_text); ?>

                                </a>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="campus-pag d-flex justify-content-center gap-2 pt-4"></div>
            </div>
        </div>
    </div>
</section><?php /**PATH D:\office_project\cust\resources\views/web/custom/sections/campus-life.blade.php ENDPATH**/ ?>