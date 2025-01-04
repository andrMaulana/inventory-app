@extends('layouts.apps.master', ['title' => 'Data Transaksi'])

@section('content')
    <x-container>
        <div class="col-12">
            <x-card-action title="Daftar Transaksi" url="{{ route('apps.transaction') }}">
                <x-table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Invoice</th>
                            <th>Customer</th>
                            <th>Tanggal</th>
                            <th class="text-center">Total Kuantitas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $key => $transaction)
                            <tr>
                                <td>{{ $key + $transactions->firstItem() }}</td>
                                <td>{{ $transaction->invoice }}</td>
                                <td>{{ $transaction->user->name }}</td>
                                <td>{{ $transaction->created_at->format('d-m-y H:i:s') }}</td>
                                <td class="text-center">{{ $transaction->total_quantity }}</td>
                                <td>
                                    <x-button type="modal" :id="$transaction->id" icon="true" class="btn-dark">
                                        <x-slot name="title">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-table-share">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M12 21h-7a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v8" />
                                                <path d="M3 10h18" />
                                                <path d="M10 3v18" />
                                                <path d="M16 22l5 -5" />
                                                <path d="M21 21.5v-4.5h-4.5" />
                                            </svg>
                                            Detail Transaksi
                                        </x-slot>
                                    </x-button>
                                    <x-modal title="Detail Transaksi" :id="$transaction->id" type="modal-lg">
                                        <table class="table table-vcenter table-bordered bg-white">
                                            <thead>
                                                <tr>
                                                    <td>#</td>
                                                    <td>Nama Produk</td>
                                                    <td class="text-center">Kuantitas</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $total_quantity = 0;
                                                @endphp
                                                @foreach ($transaction->details as $i => $detail)
                                                    <tr>
                                                        <td>{{ $i + 1 }}</td>
                                                        <td>{{ $detail->product->name }}</td>
                                                        <td class="text-center">{{ $detail->quantity }}</td>
                                                    </tr>
                                                    @php
                                                        $total_quantity += $detail->quantity;
                                                    @endphp
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="2">
                                                        Total
                                                    </td>
                                                    <td class="text-center">
                                                        {{ $total_quantity }}
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </x-modal>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </x-table>
            </x-card-action>
            <div class="d-flex justify-content-end">{{ $transactions->links() }}</div>
        </div>
    </x-container>
@endsection
