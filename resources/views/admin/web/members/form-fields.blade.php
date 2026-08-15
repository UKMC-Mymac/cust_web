@php
    $formRow = $row ?? null;
@endphp



<div class="form-group col-md-12">
    <label for="serial_no">Serial No<span>*</span></label>
    <input type="number" class="form-control" name="serial_no" id="serial_no" value="{{ old('serial_no', optional($formRow)->serial_no ?? ($last_serial_no ?? '')) }}" required>
</div>

<div class="form-group col-md-12">
    <label for="name">{{ __('field_name') }} <span>*</span></label>
    <input type="text" class="form-control" name="name" id="name" value="{{ old('name', optional($formRow)->name) }}" required>

    <div class="invalid-feedback">
        {{ __('required_field') }} {{ __('field_name') }}
    </div>
</div>

<div class="form-group col-md-12">
    <label for="designation">{{ __('field_designation') }}</label>
    <input type="text" class="form-control" name="designation" id="designation" value="{{ old('designation', optional($formRow)->designation) }}" placeholder="{{ __('field_designation') }}">
</div>

<div class="form-group col-md-12">
    <label for="description">{{ __('field_description') }} <span>*</span></label>
    <p class="text-muted mb-2">Use the editor to prepare the full page content for this member.</p>
    <textarea class="form-control texteditor" name="description" id="description" rows="12" required>{{ old('description', optional($formRow)->description) }}</textarea>

    <div class="invalid-feedback">
        {{ __('required_field') }} {{ __('field_description') }}
    </div>
</div>

<div class="form-group col-md-4">
    <label for="status" class="form-label">{{ __('select_status') }}</label>
    <select class="form-control" name="status" id="status">
        <option value="1" @selected(old('status', optional($formRow)->status ?? 1) == 1)>{{ __('status_active') }}</option>
        <option value="0" @selected(old('status', optional($formRow)->status ?? 1) == 0)>{{ __('status_inactive') }}</option>
    </select>
</div>