@extends('layout.base')

@section('title', 'Edit Buku')

@push('styles')
    <link rel="stylesheet" href="/css/bootstrap-select.min.css">
@endpush

@section('content')
    <div class="card">
        <div class="card-body">
            <form id="updateForm" action="{{ route('crud-buku.update', $data['buku']->id) }}" method="POST">
                @csrf
                @method('PUT') <!-- Menandakan bahwa ini adalah request untuk update -->

                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                        name="title" value="{{ old('title', $data['buku']->title) }}" required>
                    @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="artist">Artist</label>
                            <input type="text" class="form-control @error('artist') is-invalid @enderror" id="artist"
                                name="artist" value="{{ old('artist', $data['buku']->artist) }}" required>
                            @error('artist')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="album">Album</label>
                            <input type="text" class="form-control @error('album') is-invalid @enderror"
                                id="album" name="album" value="{{ old('album', $data['buku']->album) }}"
                                required>
                            @error('album')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="year">Tahun Terbit</label>
                            <input type="number" class="form-control @error('year') is-invalid @enderror"
                                id="year" name="year"
                                value="{{ old('year', $data['buku']->year) }}">
                            @error('year')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="duration">Jumlah Halaman</label>
                            <input type="number" class="form-control @error('duration') is-invalid @enderror"
                                id="duration" name="duration"
                                value="{{ old('duration', $data['buku']->duration) }}">
                            @error('duration')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="music_company">MUSIC_COMPANY</label>
                            <input type="text" class="form-control @error('music_company') is-invalid @enderror" id="music_company"
                                name="music_company" value="{{ old('music_company', $data['buku']->music_company) }}" required>
                            @error('music_company')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="genre">Genre</label>
                            <select class="selectpicker w-100 @error('genre') is-invalid @enderror" id="genre"
                                name="genre[]" multiple>
                                @foreach ($data['genre'] as $k)
                                    <option value="{{ $k->id }}"
                                        {{ in_array($k->id, old('genre', $data['buku-genre'])) ? 'selected' : '' }}>
                                        {{ $k->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('genre')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- <div class="col-md-6">
                        <div class="form-group">
                            <label for="genre">Genre</label>
                            <input type="text" class="form-control @error('genre') is-invalid @enderror"
                                id="genre" name="genre" value="{{ old('genre', $data['buku']->genre) }}">
                            @error('genre')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div> --}}
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description', $data['buku']->description) }}</textarea>
                    @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>


            </form>
            <button id="submitBtn" type="submit" class="btn btn-primary">Update Buku</button>
            <a href="{{ route('crud-buku.index') }}" class="btn btn-warning">Kembali ke Daftar Buku</a>
            <a href="{{ route('crud-buku.show', $data['buku']->id) }}" class="btn btn-warning">
                Kembali ke Detail Buku</a>
            <form class="border-0" action="{{ route('crud-buku.destroy', $data['buku']->id) }}" method="POST"
                style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Hapus
                    Buku</button>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="/js/bootstrap-select.min.js"></script>
@endpush
@push('scripts')
    <script>
        document.getElementById('submitBtn').addEventListener('click', function() {
            document.getElementById('updateForm').submit();
        });
    </script>
@endpush
