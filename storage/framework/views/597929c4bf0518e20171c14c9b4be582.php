<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        
         <?php echo $__env->make('admin.layouts.common.header_script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

         <style type="text/css" media="screen">
             h3 {
                font-size: 18px;
             }
             .auth-logo {
                position: absolute;
                left: 40px;
                top: 15px;
                overflow: hidden;
                z-index: 20 !important;
             }
             .auth-logo img {
                max-height: 100px;
                max-width: 100px;
             }

             /* Modern Premium Background styling - Light Version */
             .auth-wrapper {
                 background: radial-gradient(circle at 50% 50%, #f9fafb 0%, #f3f4f6 100%) !important;
                 position: relative;
                 overflow: hidden;
             }
             
             /* Custom floating glowing circles */
             .auth-bg-circle {
                 position: absolute;
                 border-radius: 50%;
                 filter: blur(120px);
                 opacity: 0.22;
                 z-index: 1;
                 pointer-events: none;
             }
             .auth-bg-circle-1 {
                 width: 500px;
                 height: 500px;
                 background: #80deea; /* Light Sky Blue */
                 top: -15%;
                 left: -10%;
             }
             .auth-bg-circle-2 {
                 width: 600px;
                 height: 600px;
                 background: #b39ddb; /* Soft Lavender */
                 bottom: -20%;
                 right: -10%;
             }
             .auth-bg-circle-3 {
                 width: 400px;
                 height: 400px;
                 background: #ffab91; /* Pastel Peach */
                 top: 30%;
                 right: 15%;
                 opacity: 0.15;
             }
             
             .auth-content {
                 z-index: 10 !important;
             }
             
             /* Clean up the default shapes */
             .auth-wrapper .auth-bg {
                 display: none !important;
             }

             /* Make the card stand out with premium styling */
             .auth-wrapper .card {
                 background: #ffffff !important;
                 border-radius: 24px !important;
                 border: 1px solid rgba(226, 232, 240, 0.8) !important;
                 box-shadow: 0 20px 40px rgba(148, 163, 184, 0.12) !important;
                 overflow: hidden;
             }
             
             .auth-wrapper .card-body {
                 padding: 50px 40px !important;
             }
             
             .auth-wrapper .auth-icon {
                 display: inline-block;
                 padding: 18px;
                 background: rgba(4, 169, 245, 0.08);
                 border-radius: 50%;
                 color: #04a9f5;
                 margin-bottom: 25px;
             }
             
             .auth-wrapper .auth-icon i {
                 font-size: 32px;
             }

             /* Form fields visibility improvements */
             .auth-wrapper h3 {
                 color: #0f172a !important;
                 font-weight: 700 !important;
             }
             .auth-wrapper p, .auth-wrapper label, .auth-wrapper .form-check-label {
                 color: #334155 !important;
                 font-weight: 500 !important;
                 text-align: left !important;
                 display: block;
             }
             .auth-wrapper .form-control {
                 background: #ffffff !important;
                 color: #0f172a !important;
                 border: 1px solid #94a3b8 !important; /* Highly visible slate border */
                 border-radius: 10px !important;
                 padding: 12px 16px !important;
                 height: auto !important;
                 font-size: 14px !important;
                 transition: all 0.2s ease-in-out !important;
             }
             .auth-wrapper .form-control:focus {
                 border-color: #04a9f5 !important;
                 box-shadow: 0 0 0 3px rgba(4, 169, 245, 0.15) !important;
             }
             .auth-wrapper .btn-primary {
                 background: #04a9f5 !important;
                 border-color: #04a9f5 !important;
                 border-radius: 10px !important;
                 padding: 12px 25px !important;
                 font-weight: 600 !important;
                 font-size: 15px !important;
                 width: 100% !important;
                 box-shadow: 0 4px 12px rgba(4, 169, 245, 0.2) !important;
                 transition: all 0.2s ease-in-out !important;
             }
             .auth-wrapper .btn-primary:hover {
                 background: #038fcf !important;
                 border-color: #038fcf !important;
                 box-shadow: 0 6px 16px rgba(4, 169, 245, 0.3) !important;
             }
             .auth-wrapper .invalid-feedback {
                 color: #ef4444 !important;
                 font-weight: 500 !important;
                 margin-top: 5px !important;
             }
             .auth-wrapper .text-muted, .auth-wrapper .text-muted a {
                 color: #64748b !important;
             }
             .auth-wrapper .text-muted a:hover {
                 color: #04a9f5 !important;
             }

             @media screen and (max-width: 767px) {
                .auth-logo img {
                    max-height: 70px;
                }
                .auth-logo {
                    left: 20px;
                    top: 10px;
                }
                .auth-wrapper .card-body {
                    padding: 35px 25px !important;
                }
             }
         </style>

    </head>
    <body>

        <div class="auth-wrapper">
            <!-- Custom neon glowing background elements -->
            <div class="auth-bg-circle auth-bg-circle-1"></div>
            <div class="auth-bg-circle auth-bg-circle-2"></div>
            <div class="auth-bg-circle auth-bg-circle-3"></div>

            <?php if(isset($setting)): ?>
            <?php if(is_file('uploads/setting/'.$setting->logo_path) || is_file('public/uploads/setting/'.$setting->logo_path)): ?>
            <a href="#" class="auth-logo">
                <img src="<?php echo e(asset('uploads/setting/'.$setting->logo_path)); ?>" alt="logo">
            </a>
            <?php endif; ?>
            <?php endif; ?>
            
            <div class="auth-content">
                <div class="auth-bg">
                    <span class="r"></span>
                    <span class="r s"></span>
                    <span class="r s"></span>
                    <span class="r"></span>
                </div>

                <!-- Start Content-->
                <?php echo $__env->yieldContent('content'); ?>
                <!-- End Content-->
                
            </div>
        </div>

        <?php echo $__env->make('admin.layouts.common.footer_script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </body>
</html><?php /**PATH D:\office_project\cust\resources\views/auth/layouts/master.blade.php ENDPATH**/ ?>