@extends('layouts.app')

@section('title', 'Program Prioritas')

@section('content')
    <header class="page-heading">
        <p class="eyebrow">MOTOCARE / PROGRAM PERAWATAN</p>
        <h1>Program Prioritas</h1>
        <p>Catat dan kelola rencana perawatan motor dalam satu tempat.</p>
    </header>

    @if (session('status'))
        <div class="notice success" role="status">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="notice error" role="alert">
            <p>Periksa kembali data yang kamu masukkan:</p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="panel create-panel" aria-labelledby="create-heading">
        <div class="panel-heading">
            <div>
                <p class="eyebrow">TAMBAH DATA</p>
                <h2 id="create-heading">Buat program baru</h2>
            </div>
        </div>

        <form action="{{ route('programs.store') }}" method="POST" class="program-form">
            @csrf
            <label>
                Nama program
                <input type="text" name="nama" value="{{ old('nama') }}" maxlength="120" required>
            </label>
            <label>
                Deskripsi
                <textarea name="deskripsi" rows="3" maxlength="2000" required>{{ old('deskripsi') }}</textarea>
            </label>
            <button class="button button-primary" type="submit">Simpan program</button>
        </form>
    </section>

    <section class="program-section" aria-labelledby="program-list-heading">
        <div class="section-heading">
            <div>
                <p class="eyebrow">DATA TERSIMPAN</p>
                <h2 id="program-list-heading">Daftar program</h2>
            </div>
            <span class="count">{{ $programs->count() }} program</span>
        </div>

        @forelse ($programs as $program)
            <article class="program-card">
                <div class="program-copy">
                    <h3>{{ $program->nama }}</h3>
                    <p>{{ $program->deskripsi }}</p>
                    <small>Diperbarui {{ $program->updated_at->format('d M Y, H:i') }}</small>
                </div>
                <div class="card-actions">
                    <a class="button button-secondary" href="{{ route('programs.edit', $program) }}">Ubah</a>
                    <form action="{{ route('programs.destroy', $program) }}" method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus program ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="button button-danger" type="submit">Hapus</button>
                    </form>
                </div>
            </article>
        @empty
            <div class="empty-state">
                <h3>Belum ada program</h3>
                <p>Tambahkan program pertama menggunakan formulir di atas.</p>
            </div>
        @endforelse
    </section>
@endsection
