@extends('layouts.apps.master', ['title' => 'Data Produk'])

@section('content')
    <x-container>
        <div class="col-12">
            @can('products-create')
                <x-button
                    title="Tambah Data Produk"
                    type="create"
                    :url="route('apps.products.create')"
                />
            @endcan
            <x-card-action title="Daftar Produk" url="{{ route('apps.products.index') }}">
                <x-table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Gambar</th>
                            <th>Nama Produk</th>
                            <th>Supplier</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $i => $product)
                            <tr>
                                <td>{{ $i + $products->firstItem() }}</td>
                                <td>
                                    <span class="avatar rounded avatar-lg" style="background-image: url({{ $product->image }})"></span>
                                </td>
                                <td>
                                    {{ $product->name }}
                                    <div>
                                        <small class="text-secondary">{{ $product->category->name }}</small>
                                    </div>
                                </td>
                                <td>
                                    @can('products-update')
                                        <x-button
                                            title="Ubah Data"
                                            type="edit"
                                            :url="route('apps.products.edit', $product->id)"
                                        />
                                    @endcan
                                    @can('products-delete')
                                        <x-button
                                            title="Hapus Data"
                                            type="delete"
                                            :id="$product->id"
                                            :url="route('apps.products.destroy', $product->id)"
                                        />
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </x-table>
            </x-card-action>
            <div class="d-flex justify-content-end">{{ $products->links() }}</div>
        </div>
    </x-container>
@endsection
