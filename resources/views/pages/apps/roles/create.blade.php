@extends('layouts.apps.master', ['title' => 'Tambah Data Role'])

@section('content')
    <x-container>
        <div class="col-12">
            <form action="{{ route('apps.roles.create') }}" method="POST">
                @csrf
                <x-card title="Tambah Data Role" class="card-body">
                    <x-input
                        title="Nama Role"
                        name="name"
                        type="text"
                        placeholder="Masukan Nama Role"
                        value="{{ old('name') }}"
                        />

                    <x-select-group title="Permission">
                        @foreach ($permissions as $permission)
                            <label class="form-select-group-item">
                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" class="form-selectgroup-input">
                                <span class="form-selectgroup-label">
                                    {{ $permission->name }}
                                </span>
                            </label>
                        @endforeach
                    </x-select-group>
                    <x-button title="simpan" type="save" />
                </x-card>
            </form>
        </div>
    </x-container>
@endsection
