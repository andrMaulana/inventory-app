@extends('layouts.apps.master', ['title' => 'Ubah Data Produk'])

@section('content')
    <x-container>
        <div class="col-12">
            <form action="{{ route('apps.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <x-card title="Ubah Data Produk" class="card-body">
                    <x-input
                        title="Nama Produk"
                        name="name"
                        type="text"
                        placeholder="Masukan nama produk"
                        :value="$product->name"
                    />
                    <div class="row">
                        <div class="col-6">
                            <x-input
                                title="Gambar Produk"
                                name="image"
                                type="file"
                            />
                        </div>
                        <div class="col-6">
                            <x-input
                                title="Satuan Produk"
                                name="unit"
                                type="text"
                                placeholder="Masukan satuan produk"
                                :value="$product->unit"
                            />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <x-select title="Kategori Produk" name="category_id">
                                    <option selected disabled>Pilih Kategori Produk</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected($category->id === $product->category_id)>{{ $category->name }}</option>
                                @endforeach
                            </x-select>
                        </div>
                        <div class="col-6">
                            <x-select title="Supplier Produk" name="supplier_id">
                                <option selected disabled>Pilih Supplier Produk</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" @selected($supplier->id === $product->supplier_id)>{{ $supplier->name }}</option>
                            @endforeach
                        </x-select>
                        </div>
                    </div>
                    <x-textarea
                        title="Deskripsi Produk"
                        name="description"
                        placeholder="Masukan deskripsi produk">{{ $product->description }}</x-textarea>
                    <x-button title="Simpan" type="save"/>
                </x-card>
            </form>
        </div>
    </x-container>
@endsection
