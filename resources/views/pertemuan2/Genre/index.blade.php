@extends('layout.base')


@section('title', 'List Genre')

@section('content')

    <div class="card p-3">
        <div class="">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        </div>
        <div class="d-flex flex-column flex-md-row gap-2 mb-md-0 mb-2">
            <form action="{{ route('crud-genre.index') }}" method="GET" class="mr-md-2 mr-0 mb-2 mb-md-0 flex-grow-1">
                <div class="input-group ">
                    <input type="text" name="search" class="form-control" id="search" placeholder="nama genre"
                        value="{{ request()->get('search') }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </div>
                </div>
            </form>
            <div class="d-flex">
                {{ $data['genre']->appends(['search' => request()->get('search'), 'limit' => request()->get('limit')])->links() }}
                <div class="ml-2">
                    <a href="{{ route('crud-genre.create') }}" class="text-white">
                        <button class="btn btn-success">
                            Tambah Genre
                        </button>
                    </a>
                </div>
            </div>

        </div>
        <div class="overflow-auto">`
            <table id="genreTable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Nama Genre</th>
                        <th>Jumlah Buku</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data['genre'] as $genre)
                        <tr>
                            <td>
                                {{ $genre->id }}
                            </td>
                            <td>
                                <a href="{{ route('crud-genre.show', $genre->id) }}">
                                    {{ Str::limit($genre->nama, 20, '...') }}
                                </a>
                            </td>
                            <td>{{ count($genre->bukus) }}</td>
                            <td class="d-flex">
                                <a href="{{ route('crud-genre.edit', $genre->id) }}"
                                    class="btn btn-primary btn-sm mr-2">Edit</a>
                                <form class="border-0" action="{{ route('crud-genre.destroy', $genre->id) }}"
                                    method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No records found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#genreTable').DataTable({
                paging: true,
                searching: true,
                ordering: true
            });
        });
    </script>
@endpush
