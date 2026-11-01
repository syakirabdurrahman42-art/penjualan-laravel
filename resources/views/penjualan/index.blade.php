@extends('layouts.app')

@section('title', 'Daftar Penjualan')

@section('content')
<div class="topbar">
    <div>
        <h1>Penjualan</h1>
        <p class="muted">Kelola transaksi penjualan sederhana.</p>
    </div>
    <a class="btn btn-primary" href="{{ route('penjualan.create') }}">+ Tambah Transaksi</a>
</div>

<div class="card">
    <div class="muted">Total omzet transaksi selesai</div>
    <div class="metric">Rp {{ number_format((float) $totalOmzet, 0, ',', '.') }}</div>
</div>

<div class="card">
    <form action="{{ route('penjualan.index') }}" method="GET" class="actions">
        <input type="text" name="q" value="{{ $search }}"
                placeholder="Cari kode, pelanggan, atau produk..." style="max-width: 320px;">

        <select name="status" style="max-width: 180px;">
            <option value="">Semua status</option>
            @foreach (['Selesai', 'Pending', 'Batal'] as $s)
                <option value="{{ $s }}" @selected($status === $s)>{{ $s }}</option>
            @endforeach
        </select>

        <button class="btn btn-primary" type="submit">Terapkan</button>
        <a class="btn" href="{{ route('penjualan.index') }}">Reset</a>
    </form>
</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Produk</th>
                <th>Total</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($penjualan as $item)
                <tr>
                    <td>{{ $item->kode_transaksi }}</td>
                    <td>{{ $item->tanggal->format('d/m/Y') }}</td>
                    <td>{{ $item->nama_pelanggan }}</td>
                    <td>{{ $item->nama_produk }}</td>
                    <td>Rp {{ number_format((float) $item->total, 0, ',', '.') }}</td>
                    <td><span class="badge badge-{{ strtolower($item->status) }}">{{ $item->status }}</span></td>
                    <td>
                        <div class="actions">
                            <a class="btn" href="{{ route('penjualan.show', $item) }}">Detail</a>
                            <a class="btn" href="{{ route('penjualan.edit', $item) }}">Edit</a>
                            <form
                                action="{{ route('penjualan.destroy', $item) }}"
                                method="POST"
                                onsubmit="return confirm('Hapus transaksi ini?')"
                            >
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="muted">Tidak ada transaksi yang sesuai.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection