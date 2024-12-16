@extends('layouts.apps.master', ['title' => 'Data Permissions'])

@section('content')
    <x-container>
        <div class="col-12 {{ auth()->user()->can('permissions-create') ? 'col-lg-8' : 'col-lg-12' }}">
            <x-card-action title="Daftar Permission" url="{{ route('apps.permissions.index') }}">
                <x-table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Permission</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permissions as $i => $permission)
                            <tr>
                                <td>{{ $i + $permissions->firstItem() }}</td>
                                <td>{{ $permission->name }}</td>
                                <td>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </x-table>
            </x-card-action>
            <div class="d-flex justify-content-end">{{ $permissions->links() }}</div>
        </div>
        @can('permissions-create')
            <div class="col-12 col-lg-4">
                <form action="{{ route('apps.permissions.store') }}" method="POST">
                    @csrf
                    <x-card title="Tambah Data Permission" class="card-body">
                        <x-input
                            title="Nama Permission"
                            name="name" type="text"
                            placeholder="Masukan nama permission"
                            value="{{ old('name') }}"
                        />
                        <x-button title="Simpan" type="save"/>
                    </x-card>
                </form>
            </div>
        @endcan
    </x-container>
@endsection
