@extends('layouts.apps.master', ['title' => 'Ubah Data Supplier'])

@section('content')
    <x-container>
        <div class="col-12">
            <form action="{{ route('apps.suppliers.update', $supplier->id) }}" method="POST">
                @csrf
                @method('PUT')
                <x-card title="Ubah Data Supplier" class="card-body">
                    <x-input
                        title="Nama Supplier"
                        name="name"
                        type="text"
                        placeholder="Masukan nama supplier"
                        :value="$supplier->name"
                    />
                    <x-input
                        title="Telp Supplier"
                        name="telp"
                        type="number"
                        placeholder="Masukan telp supplier"
                        :value="$supplier->telp"
                    />
                    <x-textarea
                        title="Alamat Supplier"
                        name="address"
                        placeholder="Masukan alamat supplier">{{ $supplier->address }}</x-textarea>
                    <x-button title="Simpan" type="save"/>
                </x-card>
            </form>
        </div>
    </x-container>
@endsection
