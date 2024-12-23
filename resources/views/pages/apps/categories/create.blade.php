@extends('layouts.apps.master', ['title' => 'Tambah Data Kategori'])

@section('content')
    <x-container>
        <div class="col-12">
            <form action="{{ route('apps.categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <x-card title="Tambah Data Kategori" class="card-body">
                    <x-input
                        title="Nama Kategori"
                        name="name"
                        type="text"
                        placeholder="Masukan nama kategori"
                        value="{{ old('name') }}"
                    />
                    <x-input
                        title="Gambar Kategori"
                        name="image"
                        type="file"
                    />
                    <x-button title="Simpan" type="save"/>
                </x-card>
            </form>
        </div>
    </x-container>
@endsection
