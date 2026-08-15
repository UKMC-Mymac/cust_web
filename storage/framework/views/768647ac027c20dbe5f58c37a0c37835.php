<footer class="footer-wrapper footer-default footer-overlay" data-bg-src="<?php echo e(asset('dist/img/bg/footer-bg-1.jpg')); ?>">
    <div class="container">
        <div class="widget-area">
            <div class="row justify-content-between">
                <div class="col-md-6 col-xl-auto">
                    <div class="widget footer-widget">
                        <div class="th-widget-about">
                            <?php if(isset($contentSections['footer_section'])): ?>
                            <h3 class="widget_title"><?php echo e($contentSections['footer_section']->title); ?></h3>
                            <p class="about-text">
                                <?php echo $contentSections['footer_section']->description; ?>

                            </p>
                            <?php endif; ?>
                            <div class="footer-info">
                             <?php if(isset($topbarSetting->address)): ?>
                                <a href="https://maps.app.goo.gl/Wd2UDYjrZ646zAvr9">
                                    <span class="footer-info-icon"><i class="fa-solid fa-location-dot"></i></span><?php echo e($topbarSetting->address); ?>

                                </a>
                            <?php endif; ?>
                                <?php if(isset($topbarSetting->email)): ?>
                                <a href=mailto:"<?php echo e($topbarSetting->email); ?>">
                                    <span class="footer-info-icon"><i class="fa-solid fa-envelope"></i></span><?php echo e($topbarSetting->email); ?>

                                </a>
                                <?php endif; ?>

                                <?php if(isset($topbarSetting->phone)): ?>
                                <a href="tel:<?php echo e($topbarSetting->phone); ?>">
                                    <span class="footer-info-icon"><i class="fa-solid fa-phone"></i></span><?php echo e($topbarSetting->phone); ?>

                                </a>
                                <?php endif; ?>
                            </div>
                        
                            <div class="th-social mt-4">
                                 <?php if(isset($socialSetting->facebook)): ?>
                                <a href="<?php echo e($socialSetting->facebook); ?>">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <?php endif; ?>
                                    <?php if(isset($socialSetting->youtube)): ?> 
                                <a href="<?php echo e($socialSetting->youtube); ?>">
                                    <i class="fa-brands fa-youtube"></i>
                                </a>
                                    <?php endif; ?>
                                        <?php if(isset($socialSetting->instagram)): ?>
                                <a href="<?php echo e($socialSetting->instagram); ?>">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                <?php endif; ?>
                                    <?php if(isset($socialSetting->twitter)): ?>
                                <a href="<?php echo e($socialSetting->twitter); ?> ">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <?php endif; ?>
                                    <?php if(isset($socialSetting->linkedin)): ?>
                                <a href="<?php echo e($socialSetting->linkedin); ?>">
                                    <i class="fa-brands fa-linkedin"></i>
                                </a>
                                <?php endif; ?>
                                    <?php if(isset($socialSetting->pinterest)): ?>
                                <a href="<?php echo e($socialSetting->pinterest); ?>">
                                    <i class="fa-brands fa-wikipedia-w"></i>
                                </a>
                                <?php endif; ?> 
                            </div>
                        </div>
                    </div>
                </div>
                <?php $__currentLoopData = $footerSections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-sm-6 col-xl-auto">
                    <div class="widget widget_nav_menu footer-widget">
                        <h3 class="widget_title"><?php echo e($section->title); ?></h3>
                        <div class="menu-all-pages-container">
                            <ul class="menu">
                                <?php $__currentLoopData = $section->links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $linkHref = $link->url;

                                    if (empty($linkHref) && !empty($link->page) && !empty($link->page->slug)) {
                                        $linkHref = route('page.single', $link->page->slug);
                                    } elseif (empty($linkHref) && !empty($link->route_name)) {
                                        try {
                                            $linkHref = route($link->route_name);
                                        } catch (Exception $e) {
                                            $linkHref = '#';
                                        }
                                    }

                                    $linkHref = $linkHref ?: '#';
                                ?>
                                <li><a href="<?php echo e($linkHref); ?>"><?php echo e($link->label); ?></a></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
    <div class="copyright-wrap z-index-common">
        <div class="container">
            <div class="row justify-content-center gy-3 align-items-center">
                <div class="col-lg-6">
                    <p class="copyright-text">
                        <i class="fal fa-copyright"></i> Copyright <?php echo e(date('Y')); ?> <a href="<?php echo e(isset($custom_urls['copyright_link']) ? $custom_urls['copyright_link']->resolved_url : '#'); ?>">CUST</a>. All Rights
                        Reserved.
                    </p>
                </div>
                <div class="col-lg-6 text-lg-end text-center">
                    <div class="footer-links">
                        <ul>
                            <li><a href="<?php echo e(isset($custom_urls['privacy_policy']) ? $custom_urls['privacy_policy']->resolved_url : '#'); ?>"><?php echo e(isset($custom_urls['privacy_policy']) ? $custom_urls['privacy_policy']->title : 'Privacy Policy'); ?></a></li>
                            <li><a href="<?php echo e(isset($custom_urls['terms_of_service']) ? $custom_urls['terms_of_service']->resolved_url : '#'); ?>"><?php echo e(isset($custom_urls['terms_of_service']) ? $custom_urls['terms_of_service']->title : 'Terms of services'); ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<?php /**PATH D:\office_project\cust\resources\views/web/custom/components/footer.blade.php ENDPATH**/ ?>