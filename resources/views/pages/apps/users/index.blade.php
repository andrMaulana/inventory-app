@extends('layouts.apps.master', ['title' => 'Data User'])

@section('content')
    <x-container>
        <div class="col-12">
            <x-card-action title="Daftar User" url="{{ route('apps.users.index') }}">
                <x-table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $i => $user)
                            <tr>
                                <td>{{ $i + $users->firstItem() }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @foreach ($user->roles as $role)
                                        <span class="btn btn-sm bg-teal text-white">{{ $role->name }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    @can('users-delete')
                                        <x-button
                                            title="Hapus Data"
                                            type="delete"
                                            :id="$user->id"
                                            :url="route('apps.users.destroy', $user->id)"
                                        />
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </x-table>
            </x-card-action>
            <div class="d-flex justify-content-end">{{ $users->links() }}</div>
        </div>
    </x-container>
@endsection
