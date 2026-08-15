<style>
    /* Hero Section Responsive Optimization */
    @media (max-width: 767px) {
        #hero .swiper-slide {
            height: auto !important;
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 120px 0 60px 0;
        }
        .hero-style1 {
            height: auto !important;
            padding: 0 !important;
            flex-direction: column;
            justify-content: center;
        }
        .hero-style1 .hero-title {
            font-size: 30px !important;
            line-height: 1.25 !important;
            margin-bottom: 15px !important;
            text-align: center;
        }
        .hero-style1 .hero-text {
            font-size: 14px !important;
            line-height: 1.6 !important;
            margin-bottom: 25px !important;
            text-align: center;
        }
        .hero-style1 .btn-wrap .th-btn {
            padding: 10px 18px !important;
            font-size: 14px !important;
        }
        .hero-style1 .hero-video {
            margin-left: 0 !important;
            margin-top: 30px !important;
            padding-left: 0 !important;
            display: flex;
            justify-content: center;
            width: 100%;
        }
        .hero-style1 .video-play-btn {
            width: 48px !important;
            height: 48px !important;
            line-height: 48px !important;
            font-size: 14px !important;
        }
    }

    @media (max-width: 575px) {
        .hero-style1 .hero-title {
            font-size: 24px !important;
            line-height: 1.3 !important;
        }
        .hero-style1 .btn-wrap {
            flex-direction: row !important;
            flex-wrap: wrap !important;
            justify-content: center !important;
            gap: 10px !important;
            width: 100%;
        }
        .hero-style1 .btn-wrap .th-btn {
            width: auto !important;
            padding: 10px 18px !important;
            font-size: 13px !important;
        }
    }
</style>

<div class="th-hero-wrapper hero-1" id="hero">
    <div class="swiper th-slider" id="heroSlide" data-slider-options='{"effect":"fade"}'>
        <div class="swiper-wrapper">

            <?php
                $heroSliders = $sliders ?? collect();
            ?>

            <?php if($heroSliders->isNotEmpty()): ?>
                <?php $__currentLoopData = $heroSliders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="swiper-slide">
                        <div class="hero-inner">
                            <div class="th-hero-bg"
                                 data-bg-src="<?php echo e(asset('uploads/slider/' . ($slider->attach ?? ''))); ?>">
                            </div>

                            <div class="container th-container2">
                                <div class="hero-style1">
                                    <div class="hero-text-wrap">

                                        <h1 class="hero-title text-white"
                                            data-ani="slideinup"
                                            data-ani-delay="0.3s">
                                            <?php echo e($slider->title ?? ''); ?>

                                        </h1>

                                        <p class="hero-text text-white"
                                           data-ani="slideinup"
                                           data-ani-delay="0.5s">
                                            <?php echo strip_tags($slider->sub_title ?? '', '<b><u><i><br>'); ?>

                                        </p>

                                        <div class="btn-wrap justify-content-center justify-content-lg-start"
                                             data-ani="slideinup"
                                             data-ani-delay="0.8s">

                                            <?php
                                                $primaryButtonUrl = $slider->button_link ?? '';
                                                if (!empty($slider->page_id)) {
                                                    $primaryPage = \App\Models\Web\Page::find($slider->page_id);
                                                    if ($primaryPage) {
                                                        $primaryButtonUrl = route('page.single', $primaryPage->slug);
                                                    }
                                                } elseif (!empty($slider->route_name)) {
                                                    try {
                                                        $primaryButtonUrl = route($slider->route_name);
                                                    } catch (\Exception $e) {
                                                        $primaryButtonUrl = $slider->button_link ?? '';
                                                    }
                                                }

                                                $secondaryButtonUrl = $slider->button_link_2 ?? '';
                                                if (!empty($slider->page_id_2)) {
                                                    $secondaryPage = \App\Models\Web\Page::find($slider->page_id_2);
                                                    if ($secondaryPage) {
                                                        $secondaryButtonUrl = route('page.single', $secondaryPage->slug);
                                                    }
                                                } elseif (!empty($slider->route_name_2)) {
                                                    try {
                                                        $secondaryButtonUrl = route($slider->route_name_2);
                                                    } catch (\Exception $e) {
                                                        $secondaryButtonUrl = $slider->button_link_2 ?? '';
                                                    }
                                                }
                                            ?>

                                            <?php if(!empty($primaryButtonUrl) || !empty($secondaryButtonUrl)): ?>
                                                <?php if(!empty($primaryButtonUrl)): ?>
                                                    <a href="<?php echo e($primaryButtonUrl); ?>"
                                                       class="th-btn white-hover th-icon">
                                                        <?php echo e($slider->button_text ?? 'Admission'); ?>

                                                    </a>
                                                <?php endif; ?>

                                                <?php if(!empty($secondaryButtonUrl)): ?>
                                                    <a href="<?php echo e($secondaryButtonUrl); ?>"
                                                       class="th-btn style-border1 th-icon white-hover">
                                                        <?php echo e($slider->button_text_2 ?? 'View Program'); ?>

                                                    </a>
                                                <?php endif; ?>
                                            
                                           <?php endif; ?> 
                                        </div>

                                    </div>

                                    <div class="hero-video text-center ms-xl-5 ps-xl-5"
                                         data-ani="fadeinright"
                                         data-ani-delay="0.9s">

                                        
                                       <?php if(isset($slider->video_url)): ?>
                                         <a href="<?php echo e($slider->video_url); ?>"
                                        class="video-play-btn popup-video">
                                            <i class="fa-sharp fa-solid fa-play"></i>
                                        </a>
                                       <?php endif; ?>
                                    
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <div class="swiper-slide">
                    <div class="hero-inner text-center text-white">
                        <h2>No sliders available</h2>
                    </div>
                </div>
            <?php endif; ?>

        </div>

        <div class="slider-pagination"></div>
    </div>
</div><?php /**PATH D:\office_project\cust\resources\views/web/custom/sections/hero.blade.php ENDPATH**/ ?>