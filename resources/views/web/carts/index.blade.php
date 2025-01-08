@extends('layouts.web.master', ['title' => 'Keranjang'])

@section('content')
    <x-web.container>
        <x-web.grid class="lg:grid-cols-12 gap-6">
            <div class="col-span-12 lg:col-span-8">
                <x-web.cart-table :carts=$carts :grandQuantity=$grandQuantity />
            </div>
            <div class="col-span-12 lg:col-span-4">
                <x-web.cart-form :carts=$carts />
            </div>
        </x-web.grid>
    </x-web.container>
@endsection
