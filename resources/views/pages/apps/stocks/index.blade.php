@extends('layouts.apps.master', ['title' => 'Data Produk'])

@section('content')
    <x-container>
        <div class="col-12">
            <x-card-action title="Daftar Produk" url="{{ route('apps.stocks.index') }}">
                <x-table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Produk</th>
                            <th>Satuan</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $i => $product)
                            <tr>
                                <td>{{ $i + $products->firstItem() }}</td>
                                <td>
                                    {{ $product->name }}
                                    <div>
                                        <small class="text-secondary">{{ $product->category->name }}</small>
                                    </div>
                                </td>
                                <td>{{ $product->unit }}</td>
                                <td>{{ $product->stock->stock ?? 0 }}</td>
                                <td>
                                    @can('stocks-create')
                                        <x-button title="Tambah Stok" type="modal" :id="$product->id" />
                                        <x-modal title="Tambah Stok" :id="$product->id">
                                            <form action="{{ route('apps.stocks.store', $product->id) }}" method="POST">
                                                @csrf
                                                <x-input title="Jumlah Stok" name="quantity" type="number" value="0"
                                                    min="0" />
                                                <x-button title="Simpan" type="save" />
                                            </form>
                                        </x-modal>
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
