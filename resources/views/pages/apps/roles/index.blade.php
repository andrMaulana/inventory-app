@extends('layouts.apps.master', ['title' => 'Data Role'])

@section('content')
    <x-container>
        <div class="col-12">
            @can('roles-create')
                <x-button
                    title="Tambah Data Role"
                    type="create"
                    :url="route('apps.roles.create')"
                />
            @endcan
            <x-card-action title="Daftar Role" url="{{ route('apps.roles.index') }}">
                <x-table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Role</th>
                            <th>Permissions</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $i => $role)
                            <tr>
                                <td>{{ $i + $roles->firstItem() }}</td>
                                <td width="150px">{{ $role->name }}</td>
                                <td>
                                    @foreach ($role->permissions as $permission)
                                        <span class="btn btn-sm bg-teal text-white">{{ $permission->name }}</span>
                                    @endforeach
                                </td>
                                <td></td>
                            </tr>
                        @endforeach
                    </tbody>
                </x-table>
            </x-card-action>
            <div class="d-flex justify-content-end">{{ $roles->links() }}</div>
        </div>
    </x-container>
@endsection
