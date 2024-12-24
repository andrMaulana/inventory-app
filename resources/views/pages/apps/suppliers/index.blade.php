@extends('layouts.apps.master', ['title' => 'Data Supplier'])


@section('content')
    <x-container>
        <div class="col-12">
            @can('suppliers-create')
                <x-button
                    title="Tambah Data Supplier"
                    type="create"
                    :url="route('apps.suppliers.create')"
                />
            @endcan
            <x-card-action title="Daftar Supplier" url="{{ route('apps.categories.index') }}">
                <x-table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Supplier</th>
                            <th>Telp Supplier</th>
                            <th>Alamat Supplier</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($suppliers as $i => $supplier)
                            <tr>
                                <td>{{ $i + $suppliers->firstItem() }}</td>
                                <td>
                                    {{ $supplier->name }}
                                </td>
                                <td>
                                    {{ $supplier->telp }}
                                </td>
                                <td>
                                    {{ $supplier->address }}
                                </td>
                                <td>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </x-table>
            </x-card-action>
            <div class="d-flex justify-content-end">{{ $suppliers->links() }}</div>
        </div>
    </x-container>
@endsection
