<div id="login-form" class="popup-login-register mfp-hide">
	<div class="th-login-form">
		<h3 class="box-title mb-30"><?php echo e(__('auth_login_title')); ?></h3>
		<form action="<?php echo e(url('/admin/login')); ?>" method="POST">
			<?php echo csrf_field(); ?>
			<div class="row">
				<div class="form-group col-12">
					<label><?php echo e(__('field_email')); ?></label>
					<input
						type="email"
						class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
						name="email"
						value="<?php echo e(old('email')); ?>"
						required
						autofocus
					/>
					<?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
						<small class="text-danger d-block mt-1"><?php echo e($message); ?></small>
					<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
				</div>
				<div class="form-group col-12">
					<label><?php echo e(__('field_password')); ?></label>
					<input
						type="password"
						class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
						name="password"
						required
					/>
					<?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
						<small class="text-danger d-block mt-1"><?php echo e($message); ?></small>
					<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
				</div>
				<div class="form-group col-12">
					<div class="form-check">
						<input type="checkbox" class="form-check-input" name="remember" id="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>>
						<label class="form-check-label" for="remember">
							<?php echo e(__('field_remember')); ?>

						</label>
					</div>
				</div>
				<div class="form-btn mb-20 col-12">
					<button type="submit" class="th-btn btn-fw th-radius2"><?php echo e(__('field_login')); ?></button>
				</div>
			</div>
		</form>
	</div>
</div><?php /**PATH D:\office_project\cust\resources\views/web/custom/components/login-modal.blade.php ENDPATH**/ ?>