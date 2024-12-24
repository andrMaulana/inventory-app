@extends('layouts.apps.master', ['title' => 'Tambah Data Supplier'])

@section('content')
    <x-container>
        <div class="col-12">
            <form action="{{ route('apps.suppliers.store') }}" method="POST">
                @csrf
                <x-card title="Tambah Data Supplier" class="card-body">
                    <x-input
                        title="Nama Supplier"
                        name="name"
                        type="text"
                        placeholder="Masukan nama supplier"
                        value="{{ old('name') }}"
                    />
                    <x-input
                        title="Telp Supplier"
                        name="telp"
                        type="number"
                        placeholder="Masukan telp supplier"
                        value="{{ old('telp') }}"
                    />
                    <x-textarea
                        title="Alamat Supplier"
                        name="address"
                        placeholder="Masukan alamat supplier">{{ old('address') }}</x-textarea>
                    <x-button title="Simpan" type="save"/>
                </x-card>
            </form>
        </div>
    </x-container>
@endsection
