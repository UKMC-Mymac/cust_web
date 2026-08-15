<?php
$show_province = true;
$show_district = true;
if (Request::is('application*') || Request::is('admin/application*')) {
    $field_prov = \App\Models\Field::field('application_province');
    $field_dist = \App\Models\Field::field('application_district');
    $show_province = $field_prov ? ($field_prov->status == 1) : true;
    $show_district = $field_dist ? ($field_dist->status == 1) : true;
}
?>

<?php if($show_province): ?>
<div class="form-group col-md-12">
  <label for="present_province"><?php echo e(__('field_province')); ?></label>
  <select class="form-control" name="present_province" id="present_province">
    <option><?php echo e(__('select')); ?></option>
    <?php $__currentLoopData = $provinces; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $province): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <option value="<?php echo e($province->id); ?>" <?php if(isset($row)): ?> <?php echo e($row->present_province == $province->id ? 'selected' : ''); ?> <?php endif; ?>><?php echo e($province->title); ?></option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </select>

  <div class="invalid-feedback">
  <?php echo e(__('required_field')); ?> <?php echo e(__('field_province')); ?>

  </div>
</div>
<?php endif; ?>

<?php if($show_district): ?>
<div class="form-group col-md-12">
  <label for="present_district"><?php echo e(__('field_district')); ?></label>
  <select class="form-control" name="present_district" id="present_district">
    <option><?php echo e(__('select')); ?></option>
    <?php if(isset($row)): ?>
    <?php $__currentLoopData = $present_districts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $district): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <option value="<?php echo e($district->id); ?>" <?php echo e($row->present_district == $district->id ? 'selected' : ''); ?>><?php echo e($district->title); ?></option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
  </select>

  <div class="invalid-feedback">
  <?php echo e(__('required_field')); ?> <?php echo e(__('field_district')); ?>

  </div>
</div>
<?php endif; ?>


<?php if($show_province && $show_district): ?>
<script type="text/javascript">
"use strict";
document.addEventListener("DOMContentLoaded", function() {
    $("#present_province").on('change',function(e){
        e.preventDefault();
        var presentDistrict=$("#present_district");
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        $.ajax({
          type:'POST',
          url: "<?php echo e(route('filter-district')); ?>",
          data:{
            _token:$('input[name=_token]').val(),
            province:$(this).val()
          },
          success:function(response){
              // var jsonData=JSON.parse(response);
              $('option', presentDistrict).remove();
              $('#present_district').append('<option value=""><?php echo e(__("select")); ?></option>');
              $.each(response, function(){
                $('<option/>', {
                  'value': this.id,
                  'text': this.title
                }).appendTo('#present_district');
              });
            }

        });
    });
});
</script>
<?php endif; ?>
<?php /**PATH D:\office_project\cust\resources\views/common/inc/present_province.blade.php ENDPATH**/ ?>