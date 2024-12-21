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
                                    <x-button
                                        title="Ubah Role"
                                        type="modal"
                                        :id="$user->id"
                                    />
                                    <x-modal
                                        title="Ubah Role"
                                        :id="$user->id"
                                    >
                                        <form action="{{ route('apps.users.update', $user->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <x-input
                                                title="Nama"
                                                name="name"
                                                type="text"
                                                :value="$user->name"
                                                disabled
                                            />
                                            <x-input
                                                title="Email"
                                                name="name"
                                                type="email"
                                                :value="$user->email"
                                                disabled
                                            />
                                            <x-select-group title="Roles">
                                                @foreach ($roles as $role)
                                                    <label class="form-selectgroup-item">
                                                        <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                                                            class="form-selectgroup-input" @checked($user->roles->find($role->id))>
                                                        <span class="form-selectgroup-label">
                                                            {{ $role->name }}
                                                        </span>
                                                    </label>
                                                @endforeach
                                            </x-select-group>
                                            <x-button title="Simpan" type="save"/>
                                        </form>
                                    </x-modal>
                                    <x-button
                                        title="Hapus Data"
                                        type="delete"
                                        :id="$user->id"
                                        :url="route('apps.users.destroy', $user->id)"
                                    />
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
