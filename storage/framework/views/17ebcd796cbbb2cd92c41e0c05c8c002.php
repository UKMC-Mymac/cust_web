
<div class="<?php echo e($breadcrumbThemeClass ?? 'non-hero2'); ?>">
	<style>
		.non-hero2 .breadcumb-wrapper .breadcumb-content .breadcumb-title {
			color: var(--smoke-color);
		}
		.breadcumb-wrapper .breadcumb-content {
			padding: 110px 0 40px !important;
		}
		@media (min-width: 576px) {
			.breadcumb-wrapper .breadcumb-content {
				padding: 130px 0 50px !important;
			}
		}
		@media (min-width: 992px) {
			.breadcumb-wrapper .breadcumb-content {
				padding: 210px 0 70px !important;
			}
		}
		@media (min-width: 1200px) {
			.breadcumb-wrapper .breadcumb-content {
				padding: 220px 0 80px !important;
			}
		}
	</style>
	<div class="breadcumb-wrapper position-relative" data-bg-src="/dist/images/background/breadcumbg.png">
		<div class="container-fluid th-container4">
			<div class="row">
				<div class="col">
					<div class="breadcumb-content d-flex flex-column align-items-center">
						<h1 class="breadcumb-title"><?php echo e(\Illuminate\Support\Str::limit($title ?? 'Page', 90)); ?></h1>
						<ul class="breadcumb-menu">
							<li><a href="<?php echo e(route('home')); ?>">Home</a></li>
							<?php $__currentLoopData = $breadcrumbs ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $breadcrumb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<?php if(!$loop->last): ?>
									<li><a href="<?php echo e($breadcrumb['url']); ?>"><?php echo e($breadcrumb['label']); ?></a></li>
								<?php else: ?>
									<li><?php echo e(\Illuminate\Support\Str::limit($breadcrumb['label'], 90)); ?></li>
								<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div><?php /**PATH D:\office_project\cust\resources\views/web/custom/components/breadcrumb.blade.php ENDPATH**/ ?>