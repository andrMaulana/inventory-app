@extends('layouts.apps.master', ['title' => 'Ubah Data Kategori'])

@section('content')
    <x-container>
        <div class="col-12">
            <form action="{{ route('apps.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <x-card title="Ubah Data Kategori" class="card-body">
                    <x-input
                        title="Nama Kategori"
                        name="name"
                        type="text"
                        placeholder="Masukan nama kategori"
                        :value="$category->name"
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
