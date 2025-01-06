@extends('layouts.apps.master', ['title' => 'Data Laporan'])

@section('content')
    <x-container>
        <div class="col-12">
            <x-card title="Filter Laporan" class="card-body">
                <form action="{{ route('apps.reports.filter') }}" method="GET">
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label">Pilih Nama Produk</label>
                                <select class="form-select @error('product') is-invalid @enderror" name="product">
                                    <option selected disabled>Pilih Nama Produk</option>
                                    <option value="all" @selected(Request::get('product') == 'all')>Semua Produk</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}" @selected(Request::get('product') == $product->id)>
                                            {{ $product->name }}</option>
                                    @endforeach
                                </select>
                                @error('product')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <x-input title="Tanggal Awal" type="date" name="from_date"
                                value="{{ $from_date ?? old('from_date') }}" min="{{ $min_date }}"
                                max="{{ $max_date }}" />
                        </div>
                        <div class="col-6">
                            <x-input title="Tanggal Akhir" type="date" name="to_date"
                                value="{{ $to_date ?? old('to_date') }}" min="{{ $min_date }}"
                                max="{{ $max_date }}" />
                        </div>
                    </div>
                    <x-button type="save" title="Tampilkan Laporan" class="btn-dark" />
                    <a href="{{ route('apps.reports.index') }}" class="btn btn-danger">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-refresh">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4" />
                            <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" />
                        </svg>
                        Reset Filter Laporan
                    </a>
                </form>
            </x-card>
            @isset($from_date, $to_date)
                <div class="d-flex justify-content-end">
                    <a href="{{ route('apps.reports.download', [Request::get('product'), $from_date, $to_date]) }}"
                        class="mb-3 btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-download">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                            <path d="M7 11l5 5l5 -5" />
                            <path d="M12 4l0 12" />
                        </svg>
                        Cetak Laporan
                    </a>
                </div>
                <x-card title="Data Laporan">
                    <x-table>
                        <thead>
                            <tr>
                                <th width="10px" class="text-center">#</th>
                                <th>Nama Produk</th>
                                <th class="text-center">Tanggal Transaksi</th>
                                <th class="text-center">Jenis Transaksi</th>
                                <th class="text-center">Kuantitas</th>
                                <th class="text-center">Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total_quantity = [];
                                $total_stock = [];
                            @endphp
                            @forelse ($reports as $key => $report)
                                <tr>
                                    <td class="text-center">{{ $key + 1 }}</td>
                                    <td>{{ $report->name }}</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">Stok awal</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">
                                        {{ count($first_stock) > 0 ? $first_stock[$report->id]['stok'] : 0 }}
                                    </td>
                                </tr>
                                @php
                                    $total_quantity[$report->product_id] = 0;
                                    $total_stock[$report->product_id] = count($first_stock) > 0 ? $first_stock[$report->id]['stok'] : 0;
                                @endphp
                                @foreach ($report->stocks as $index => $stock)
                                    @php
                                        $stock->type == 'in'
                                            ? ($total_quantity[$report->product_id] += $stock->quantity)
                                            : ($total_quantity[$report->product_id] -= $stock->quantity);

                                        $stock->type == 'in'
                                            ? ($total_stock[$report->product_id] += $stock->quantity)
                                            : ($total_stock[$report->product_id] -= $stock->quantity);
                                    @endphp
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td class="text-center">{{$stock->created_at->format('d-m-Y')}}</td>
                                            <td class="text-center">{{ ucfirst($stock->type) }}</td>
                                            <td class="text-center {{ $stock->type == 'in' ? 'text-teal' : 'text-danger' }}">{{ $stock->quantity }}</td>
                                            <td class="text-center">{{ $total_stock[$report->product_id] }}</td>
                                        </tr>
                                @endforeach
                                <tr style="background-color: #FAFAFB ">
                                    <td colspan="4"><b>Total Kuantitas</b></td>
                                    <td></td>
                                    <td class="text-center">{{ $total_stock[$report->product_id] }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-danger">Data transaksi tidak ditemukan....</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </x-table>
                </x-card>
            @endisset
        </div>
    </x-container>
@endsection
