@extends('layouts.apps.master', ['title' => 'Ubah Data Role'])

@section('content')
    <x-container>
        <div class="col-12">
            <form action="{{ route('apps.roles.update', $role->id) }}" method="POST">
                @csrf
                @method('PUT')
                <x-card title="Ubah Data Role" class="card-body">
                    <x-input
                        title="Nama Role"
                        name="name"
                        type="text"
                        placeholder="Masukan nama role"
                        :value="$role->name"
                    />
                    <x-select-group title="Permissions">
                        @foreach ($permissions as $permission)
                            <label class="form-selectgroup-item">
                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                    class="form-selectgroup-input" @checked($role->permissions->find($permission->id))>
                                <span class="form-selectgroup-label">
                                    {{ $permission->name }}
                                </span>
                            </label>
                        @endforeach
                    </x-select-group>
                    <x-button title="Simpan" type="save"/>
                </x-card>
            </form>
        </div>
    </x-container>
@endsection
