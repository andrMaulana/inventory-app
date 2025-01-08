@extends('layouts.web.master', ['title' => 'Produk'])

@section('content')
    @include('layouts.web.partials.hero')
    <x-web.container>
        <x-web.grid class="lg:grid-cols-12 gap-6">
            <div class="col-span-12">
                <x-web.header title="Daftar Produk" subtitle="Kumpulan data produk yang ada di gudang.."
                    url="{{ route('product.index') }}" />
                <x-web.grid class="md:grid-cols-4 gap-6 items-start">
                    @foreach ($products as $product)
                        <x-web.product-item :product=$product />
                    @endforeach
                </x-web.grid>
            </div>
        </x-web.grid>
    </x-web.container>
@endsection
