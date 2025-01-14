@props(['title' => '', 'name' => ''])
<div class="mb-3">
    <div class="form-label">{{ $title }}</div>
    <select class="form-select @error($name) is-invalid @enderror" name="{{ $name }}" {{ $attributes }}>
        {{ $slot }}
    </select>

    @error($name)
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
