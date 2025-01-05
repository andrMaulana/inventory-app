@extends('layouts.apps.master', ['title' => 'Data Permintaan Produk'])

@section('content')
    <x-container>
        <div class="col-12">
            @if(auth()->user()->can('orders-create') && auth()->user()->can('orders-users'))
                <x-button
                    title="Tambah Permintaan Produk"
                    type="modal-create"
                />
                <x-modal
                    title="Tambah Permintaan Produk"
                >
                    <form action='{{ route('apps.orders.store') }}' method="POST">
                        @csrf
                        <x-select title="Pilih Produk" name="product_id">
                                <option selected disabled>Pilih Produk</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </x-select>
                        <x-input title="Jumlah Permintaan" name="quantity" type="number" value="0" min="0"/>
                        <x-button title="Simpan" type="save"/>
                    </form>
                </x-modal>
            @endif
            <x-card title="Daftar Permintaan Produk">
                <x-table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Gambar</th>
                            <th>Nama Produk</th>
                            <th>Kuantitas</th>
                            <th>Satuan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $i => $order)
                            <tr>
                                <td>{{ $i + $orders->firstItem() }}</td>
                                <td>
                                    <span class="avatar rounded avatar-lg" style="background-image: url({{ $order->product->image }})"></span>
                                </td>
                                <td>
                                    {{ $order->product->name }}
                                    <div>
                                        <small class="text-secondary">{{ $order->product->category->name }}</small>
                                    </div>
                                </td>
                                <td>{{ $order->quantity }}</td>
                                <td>{{ $order->product->unit }}</td>
                                <td>{{ $order->status }}</td>
                                <td>
                                    @if(auth()->user()->can('orders-users') && $order->status == \App\Enums\OrderStatus::Pending)
                                        @can('orders-update')
                                            <x-button
                                                title="Ubah Data"
                                                type="modal"
                                                :id="$order->id"
                                            />
                                            <x-modal
                                                title="Ubah Permintaan Produk"
                                                :id="$order->id"
                                            >
                                                <form action='{{ route('apps.orders.update', $order->id) }}' method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <x-select title="Pilih Produk" name="product_id">
                                                        @foreach ($products as $product)
                                                            <option value="{{ $product->id }}" @selected($product->id === $order->product_id)>{{ $product->name }}</option>
                                                        @endforeach
                                                    </x-select>
                                                    <x-input title="Jumlah Permintaan" name="quantity" type="number" :value="$order->quantity" min="0"/>
                                                    <x-button title="Simpan" type="save"/>
                                                </form>
                                            </x-modal>
                                        @endcan
                                        @can('orders-delete')
                                            <x-button
                                                title="Hapus Data"
                                                type="delete"
                                                :id="$order->id"
                                                :url="route('apps.orders.destroy', $order->id)"
                                            />
                                        @endcan
                                    @elseif(auth()->user()->can('orders-admin') && $order->status == \App\Enums\OrderStatus::Pending)
                                        <form action="{{ route('apps.orders.update', $order->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <x-button title="Konfirmasi Permintaan" type="save" class="btn-sm btn-dark"/>
                                        </form>
                                    @elseif(auth()->user()->can('orders-admin') && $order->status == \App\Enums\OrderStatus::Verified)
                                        <x-button
                                            title="Tambahkan Permintaan"
                                            type="modal"
                                            :id="$order->id"
                                        />
                                        <x-modal
                                            title="Tambahkan Permintaan Produk"
                                            :id="$order->id"
                                        >
                                            <form action='{{ route('apps.orders.update', $order->id) }}' method="POST">
                                                @csrf
                                                @method('PUT')
                                                <x-input title="Nama Produk" :value="$order->product->name" readonly/>
                                                <x-input title="Stok Produk" :value="$order->product->stock->stock" type="number" readonly/>
                                                <x-input title="Jumlah Permintaan" name="quantity" type="number" :value="$order->quantity" min="0"/>
                                                <x-button title="Simpan" type="save"/>
                                            </form>
                                        </x-modal>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </x-table>
            </x-card>
            <div class="d-flex justify-content-end">{{ $orders->links() }}</div>
        </div>
    </x-container>
@endsection
