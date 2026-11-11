@extends('layouts.app')

@section('title', 'Ubah Program')

@section('content')
    <header class="page-heading">
        <p class="eyebrow">MOTOCARE / PROGRAM PERAWATAN</p>
        <h1>Ubah program</h1>
        <p>Perbarui nama atau deskripsi program perawatan.</p>
    </header>

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

    <section class="panel">
        <form action="{{ route('programs.update', $program) }}" method="POST" class="program-form">
            @csrf
            @method('PUT')
            <label>
                Nama program
                <input type="text" name="nama" value="{{ old('nama', $program->nama) }}" maxlength="120" required>
            </label>
            <label>
                Deskripsi
                <textarea name="deskripsi" rows="5" maxlength="2000" required>{{ old('deskripsi', $program->deskripsi) }}</textarea>
            </label>
            <div class="form-actions">
                <button class="button button-primary" type="submit">Simpan perubahan</button>
                <a class="button button-secondary" href="{{ route('programs.index') }}">Batal</a>
            </div>
        </form>
    </section>
@endsection
