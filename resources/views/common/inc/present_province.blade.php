@php
$show_province = true;
$show_district = true;
if (Request::is('application*') || Request::is('admin/application*')) {
    $field_prov = \App\Models\Field::field('application_province');
    $field_dist = \App\Models\Field::field('application_district');
    $show_province = $field_prov ? ($field_prov->status == 1) : true;
    $show_district = $field_dist ? ($field_dist->status == 1) : true;
}
@endphp

@if($show_province)
<div class="form-group col-md-12">
  <label for="present_province">{{ __('field_province') }}</label>
  <select class="form-control" name="present_province" id="present_province">
    <option>{{ __('select') }}</option>
    @foreach( $provinces as $province )
    <option value="{{ $province->id }}" @isset($row) {{ $row->present_province == $province->id ? 'selected' : '' }} @endisset>{{ $province->title }}</option>
    @endforeach
  </select>

  <div class="invalid-feedback">
  {{ __('required_field') }} {{ __('field_province') }}
  </div>
</div>
@endif

@if($show_district)
<div class="form-group col-md-12">
  <label for="present_district">{{ __('field_district') }}</label>
  <select class="form-control" name="present_district" id="present_district">
    <option>{{ __('select') }}</option>
    @isset($row)
    @foreach($present_districts as $district)
    <option value="{{ $district->id }}" {{ $row->present_district == $district->id ? 'selected' : '' }}>{{ $district->title }}</option>
    @endforeach
    @endisset
  </select>

  <div class="invalid-feedback">
  {{ __('required_field') }} {{ __('field_district') }}
  </div>
</div>
@endif


@if($show_province && $show_district)
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
          url: "{{ route('filter-district') }}",
          data:{
            _token:$('input[name=_token]').val(),
            province:$(this).val()
          },
          success:function(response){
              // var jsonData=JSON.parse(response);
              $('option', presentDistrict).remove();
              $('#present_district').append('<option value="">{{ __("select") }}</option>');
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
@endif
