@extends('layouts.apps.master', ['title' => 'Data Kategori'])

@section('content')
    <x-container>
        <div class="col-12">
            @can('categories-create')
                <x-button
                    title="Tambah Data Kategori"
                    type="create"
                    :url="route('apps.categories.create')"
                />
            @endcan
            <x-card-action title="Daftar Kategori" url="{{ route('apps.categories.index') }}">
                <x-table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Gambar</th>
                            <th>Nama Kategori</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $i => $category)
                            <tr>
                                <td>{{ $i + $categories->firstItem() }}</td>
                                <td>
                                    <span class="avatar rounded avatar-md" style="background-image: url({{ $category->image }})"></span>
                                </td>
                                <td>{{ $category->name }}</td>
                                <td>
                                    @can('categories-delete')
                                        <x-button
                                            title="Hapus Data"
                                            type="delete"
                                            :id="$category->id"
                                            :url="route('apps.categories.destroy', $category->id)"
                                        />
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </x-table>
            </x-card-action>
            <div class="d-flex justify-content-end">{{ $categories->links() }}</div>
        </div>
    </x-container>
@endsection
