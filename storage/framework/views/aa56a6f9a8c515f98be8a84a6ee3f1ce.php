<?php $__env->startSection('title', 'Home'); ?>

<?php $__env->startSection('meta_description', 'Central University of Science and Technology - A modern institution committed to transforming knowledge into employability and shaping the leaders of tomorrow.'); ?>

<?php $__env->startSection('meta_keywords', 'CUST, University, Education, Admission, Programs, Academics'); ?>

<?php $__env->startSection('content'); ?>
    <?php if(!isset($setting->web_sections['hero']) || $setting->web_sections['hero'] == 1): ?>
        <?php echo $__env->make('web.custom.sections.hero', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>

    <?php if(!isset($setting->web_sections['academics']) || $setting->web_sections['academics'] == 1): ?>
        <?php echo $__env->make('web.custom.sections.academics', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>

    <?php if(!isset($setting->web_sections['why-choose-us']) || $setting->web_sections['why-choose-us'] == 1): ?>
        <?php echo $__env->make('web.custom.sections.why-choose-us', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>

    <?php if(!isset($setting->web_sections['campus-life']) || $setting->web_sections['campus-life'] == 1): ?>
        <?php echo $__env->make('web.custom.sections.campus-life', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>

    <?php if(!isset($setting->web_sections['clubs']) || $setting->web_sections['clubs'] == 1): ?>
        <?php echo $__env->make('web.custom.sections.clubs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>

    <?php if(!isset($setting->web_sections['testimonials']) || $setting->web_sections['testimonials'] == 1): ?>
        <?php echo $__env->make('web.custom.sections.testimonials', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>

    <?php if(!isset($setting->web_sections['student-zone']) || $setting->web_sections['student-zone'] == 1): ?>
        <?php echo $__env->make('web.custom.sections.student-portal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>

    <?php if(!isset($setting->web_sections['news-and-events']) || $setting->web_sections['news-and-events'] == 1): ?>
        <?php echo $__env->make('web.custom.sections.events', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>

    <?php if(!isset($setting->web_sections['apply']) || $setting->web_sections['apply'] == 1): ?>
        <?php echo $__env->make('web.custom.sections.apply', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>

    <?php if(!isset($setting->web_sections['faq']) || $setting->web_sections['faq'] == 1): ?>
        <?php echo $__env->make('web.custom.sections.faq', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.custom.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\office_project\cust\resources\views/web/custom/index.blade.php ENDPATH**/ ?>