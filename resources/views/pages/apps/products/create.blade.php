@extends('layouts.apps.master', ['title' => 'Tambah Data Produk'])

@section('content')
    <x-container>
        <div class="col-12">
            <form action="{{ route('apps.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <x-card title="Tambah Data Produk" class="card-body">
                    <x-input
                        title="Nama Produk"
                        name="name"
                        type="text"
                        placeholder="Masukan nama produk"
                        value="{{ old('name') }}"
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
                                value="{{ old('unit') }}"
                            />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <x-select title="Kategori Produk" name="category_id">
                                    <option selected disabled>Pilih Kategori Produk</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </x-select>
                        </div>
                        <div class="col-6">
                            <x-select title="Supplier Produk" name="supplier_id">
                                <option selected disabled>Pilih Supplier Produk</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                            @endforeach
                        </x-select>
                        </div>
                    </div>
                    <x-textarea
                        title="Deskripsi Produk"
                        name="description"
                        placeholder="Masukan deskripsi produk">{{ old('description') }}</x-textarea>
                    <x-button title="Simpan" type="save"/>
                </x-card>
            </form>
        </div>
    </x-container>
@endsection
