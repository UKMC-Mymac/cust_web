@php
    $inputName = $name ?? 'file';
    $inputLabel = $label ?? 'File';
    $inputFile = $file ?? null;
    $inputPath = $path ?? 'student';
    $isRequired = ! empty($required);
@endphp
<div class="form-group col-md-6">
    <label for="{{ $inputName }}">{{ $inputLabel }}</label>
    <input type="file" class="form-control" name="{{ $inputName }}" id="{{ $inputName }}" @if($isRequired) required @endif>

    @if(!empty($inputFile) && is_file('uploads/'.$inputPath.'/'.$inputFile))
        @php
            $fileUrl = asset('uploads/'.$inputPath.'/'.$inputFile);
            $ext = strtolower(pathinfo($inputFile, PATHINFO_EXTENSION));
            $isImageFile = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
        @endphp
        <div class="mt-2 p-2 border rounded bg-light">
            <small class="text-muted d-block mb-1">Current file:</small>
            <a href="{{ $fileUrl }}" target="_blank" class="text-decoration-none">
                @if($isImageFile)
                    <img src="{{ $fileUrl }}" alt="{{ $inputLabel }}" class="img-fluid" style="max-width: 120px; max-height: 120px; border: 1px solid #e5e9f0;">
                @elseif($ext === 'pdf')
                    <span class="badge badge-danger p-2"><i class="fas fa-file-pdf"></i> View PDF</span>
                @elseif(in_array($ext, ['doc', 'docx']))
                    <span class="badge badge-primary p-2"><i class="fas fa-file-word"></i> View Document</span>
                @else
                    <span class="badge badge-secondary p-2"><i class="fas fa-file-alt"></i> View {{ strtoupper($ext) }} File</span>
                @endif
            </a>
        </div>
    @endif
</div>
