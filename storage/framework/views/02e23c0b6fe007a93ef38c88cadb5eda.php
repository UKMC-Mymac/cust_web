<meta charset="utf-8">
<!-- Mobile Specific Metas -->
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php if(isset($setting)): ?>
<title><?php echo $__env->yieldContent('title'); ?> | <?php echo e($setting->meta_title ?? $setting->title ?? ''); ?></title>
<meta name="description" content="<?php echo str_limit(strip_tags($setting->meta_description ?? ''), 160, ' ...'); ?>">
<meta name="keywords" content="<?php echo strip_tags($setting->meta_keywords ?? ''); ?>">
<?php else: ?>
<title><?php echo $__env->yieldContent('title'); ?></title>
<meta name="description" content="Website for Central University of Science and Technology">
<meta name="keywords" content="Central University of Science and Technology">
<?php endif; ?>
<meta name="robots" content="INDEX,FOLLOW">
<meta name="author" content="<?php echo e($setting->author ?? 'Mishel, Mahir'); ?>">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta property="og:title" content="<?php echo e($setting->title ?? 'Central University of Science and Technology'); ?>" />
<meta property="og:description" content="<?php echo str_limit(strip_tags($setting->meta_description ?? 'Central University of Science and Technology'), 160, ' ...'); ?>" />
<meta property="og:url" content="<?php echo e(url('/')); ?>" />
<meta property="og:site_name" content="<?php echo e($setting->title ?? 'Central University of Science and Technology'); ?>" />
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:site" content="<?php echo '@'.str_replace(' ', '', $setting->title ?? 'CUST'); ?>" />
<meta name="twitter:title" content="<?php echo e($setting->title ?? 'Central University of Science and Technology'); ?>" />
<meta name="twitter:description" content="<?php echo str_limit(strip_tags($setting->meta_description ?? 'Central University of Science and Technology'), 160, ' ...'); ?>" />

<link rel="icon" type="image/png" href="<?php echo e(isset($setting->favicon_path) ? asset('/uploads/setting/'.$setting->favicon_path) : asset('dist/images/favicon-180x180.png')); ?>">
<link rel="apple-touch-icon" sizes="180x180" href="<?php echo e(isset($setting->favicon_path) ? asset('/uploads/setting/'.$setting->favicon_path) : asset('dist/images/apple-icon-180x180.png')); ?>">

<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;500;600;700&family=Saira+Condensed:wght@300;400&family=Saira+Extra+Condensed&display=swap" rel="stylesheet">

<!-- All CSS File -->
<link rel="stylesheet" href="<?php echo e(asset('dist/css/vendor/bootstrap.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('dist/css/fontawesome.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('dist/css/vendor/magnific-popup.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('dist/css/vendor/swiper-bundle.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('dist/css/vendor/template-style.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('dist/css/style.min.css')); ?>">

<?php echo $__env->yieldContent('social_meta_tags'); ?>
<?php /**PATH D:\office_project\cust\resources\views/web/custom/components/head-meta.blade.php ENDPATH**/ ?>