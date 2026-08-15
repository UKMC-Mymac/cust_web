<?php $__env->startSection('title','Contact Us'); ?>
<?php $__env->startSection('content'); ?>

<section class="py-5 bg-light">
    <div class="container">

        <?php if(!empty($contact)): ?>

            <div class="row g-5">

                <!-- Contact Information -->
                <div class="col-lg-6">

                    <div class="bg-white rounded-4 shadow-sm p-5 h-100">

                        <!-- Title -->
                        <h2 class="fw-bold text-dark mb-4">
                            <?php echo e($contact->title); ?>

                        </h2>

                        <?php if(!empty($contact->subtitle)): ?>
                            <p class="text-muted mb-4">
                                <?php echo e($contact->subtitle); ?>

                            </p>
                        <?php endif; ?>

                        <!-- Contact Details -->
                        <div class="d-flex flex-column gap-4">

                            <!-- Email -->
                            <div class="d-flex align-items-start gap-3">
                                <div class="bg-danger-subtle rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                     style="width: 50px; height: 50px;">
                                    <i class="fa-solid fa-envelope text-danger"></i>
                                </div>
                                <div>
                                    <h6 class="fw-semibold text-dark mb-1"><?php echo e(__('Email')); ?></h6>
                                    <a href="mailto:<?php echo e($contact->email); ?>" class="text-danger text-decoration-none">
                                        <?php echo e($contact->email); ?>

                                    </a>
                                </div>
                            </div>

                            <!-- Phone -->
                            <?php if(!empty($contact->phone)): ?>
                                <div class="d-flex align-items-start gap-3">
                                    <div class="bg-danger-subtle rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                         style="width: 50px; height: 50px;">
                                        <i class="fa-solid fa-phone text-danger"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-semibold text-dark mb-1"><?php echo e(__('Phone')); ?></h6>
                                        <a href="tel:<?php echo e($contact->phone); ?>" class="text-danger text-decoration-none">
                                            <?php echo e($contact->phone); ?>

                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>
                           
                                <!-- Website -->
                            <?php if(!empty($contact->website)): ?>
                                <div class="d-flex align-items-start gap-3">
                                    <div class="bg-danger-subtle rounded-circle d-flex align-items-center justify-content-center    flex-shrink-0"
                                         style="width: 50px; height: 50px;">
                                        <i class="fa-solid fa-globe text-danger"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-semibold text-dark mb-1"><?php echo e(__('Website')); ?></h6>
                                        <a href="<?php echo e($contact->website); ?>" target="_blank" rel="noopener" class="text-danger text-decoration-none">
                                            <?php echo e($contact->website); ?>

                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <!-- Address -->
                            <?php if(!empty($contact->address)): ?>
                                <div class="d-flex align-items-start gap-3">
                                    <div class="bg-danger-subtle rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                         style="width: 50px; height: 50px;">
                                        <i class="fa-solid fa-location-dot text-danger"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-semibold text-dark mb-1"><?php echo e(__('Address')); ?></h6>
                                        <p class="text-muted mb-0">
                                            <?php echo e($contact->address); ?>

                                        </p>
                                    </div>
                                </div>
                            <?php endif; ?>

                        </div>

                    </div>

                </div>

                  <div class="col-lg-6 mx-auto">

                    <div class="bg-white rounded-4 shadow-sm p-5">

                        <?php echo $__env->make('web.student.inc.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                        <h3 class="fw-bold text-dark mb-4">
                            <?php echo e(__('Send us a Message')); ?>

                        </h3>

                        <form method="POST" action="<?php echo e(route('contact.store')); ?>" class="needs-validation" novalidate>
                            <?php echo csrf_field(); ?>

                            <div class="row g-3">

                                <div class="col-md-6">
                                    <label for="name" class="form-label fw-semibold"><?php echo e(__('Full Name')); ?> <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="name" 
                                           name="name" 
                                           value="<?php echo e(old('name')); ?>" 
                                           required>
                                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="col-md-6">
                                    <label for="email" class="form-label fw-semibold"><?php echo e(__('Email')); ?> <span class="text-danger">*</span></label>
                                    <input type="email" 
                                           class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="email" 
                                           name="email" 
                                           value="<?php echo e(old('email')); ?>" 
                                           required>
                                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                
                                <?php
                                $subjects = [
                                    'General Inquiry',
                                    'Technical Support',
                                    'Website Issue',
                                    'Admission Information',
                                    'Academic Information',
                                    'Complaint',
                                    'Feedback',
                                    'Other',
                                ];
                                ?>

                                <select class="form-select <?php $__errorArgs = ['subject'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        id="subject"
                                        name="subject"
                                        required>
                                    <option value="">Select a Subject</option>

                                    <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($subject); ?>"
                                            <?php echo e(old('subject') == $subject ? 'selected' : ''); ?>>
                                            <?php echo e($subject); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

                                <div class="col-md-12">
                                    <label for="phone" class="form-label fw-semibold"><?php echo e(__('Phone')); ?></label>
                                    <input type="tel" 
                                           class="form-control <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="phone" 
                                           name="phone" 
                                           value="<?php echo e(old('phone')); ?>">
                                    <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="col-12">
                                    <label for="message" class="form-label fw-semibold"><?php echo e(__('Message')); ?> <span class="text-danger">*</span></label>
                                    <textarea class="form-control <?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                              id="message" 
                                              name="message" 
                                              rows="5" 
                                              required><?php echo e(old('message')); ?></textarea>
                                    <?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-danger btn-lg w-100">
                                        <i class="fa-solid fa-paper-plane me-2"></i>
                                        <?php echo e(__('Send Message')); ?>

                                    </button>
                                </div>

                            </div>

                        </form>

                    </div>

                </div>

            </div>
           <?php if(isset($contact->description)): ?>
                  <div class="row mt-5">

                    <div class="col-12 bg-white rounded-4 shadow-sm p-5">
                        <?php
                                $content = $contact->description;
                                if (!empty($content)) {
                                    $content = preg_replace_callback(
                                        '/(src\s*=\s*)(["\']?)(.*?)uploads\/([^"\'>\s]+)(["\']?)/i',
                                        function ($m) {
                                            return $m[1] . '"' . asset('uploads/' . $m[4]) . '"';
                                        },
                                        $content
                                    );
                                }
                            ?>
                            <?php echo $content; ?>

                    </div>

            </div>
           <?php endif; ?>
         


            <!-- Contact Form -->
            <div class="row mt-5">

                <!-- Map or Additional Info -->
                <div class="col-lg-12">

                    <?php if(!empty($contact->map_link)): ?>
                        <div class="bg-white rounded-4 shadow-sm overflow-hidden h-100">
                            <iframe src="<?php echo e($contact->map_link); ?>" 
                                    width="100%" 
                                    height="500" 
                                    style="border:0; border-radius: 1rem;" 
                                    allowfullscreen="" 
                                    loading="lazy" 
                                    referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                    <?php else: ?>
                        <div class="bg-white rounded-4 shadow-sm p-5 h-100 d-flex align-items-center justify-content-center text-center">
                            <div>
                                <i class="fa-solid fa-map fa-4x text-muted mb-3 d-block"></i>
                                <h5 class="text-muted"><?php echo e(__('Map Location')); ?></h5>
                                <p class="text-muted small">Map will be displayed when available.</p>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>

            </div>

        <?php else: ?>

            <div class="row">
                <div class="col-12">
                    <div class="alert alert-light border text-center py-5">
                        <i class="fa-solid fa-inbox fa-3x text-muted mb-3 d-block"></i>
                        <h5 class="text-muted mb-2"><?php echo e(__('No contact information available.')); ?></h5>
                        <p class="text-muted mb-0">Please try again later.</p>
                    </div>
                </div>
            </div>

        <?php endif; ?>

    </div>
</section>

<style>
    .contact-description {
        font-size: 1.0625rem;
        color: #555;
    }

    .contact-description h1,
    .contact-description h2,
    .contact-description h3,
    .contact-description h4,
    .contact-description h5,
    .contact-description h6 {
        font-weight: 600;
        color: #222;
        margin-top: 1rem;
        margin-bottom: 0.75rem;
    }

    .contact-description p {
        margin-bottom: 1rem;
    }

    .contact-description a {
        color: #dc3545;
        text-decoration: none;
    }

    .contact-description a:hover {
        text-decoration: underline;
    }
</style>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.custom.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\office_project\cust\resources\views/web/contact.blade.php ENDPATH**/ ?>