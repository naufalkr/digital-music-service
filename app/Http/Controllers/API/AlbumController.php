<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AlbumResource;
use App\Models\Album;
use App\Services\SpotifyService; // Pastikan ini diimpor
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AlbumController extends Controller
{
    protected $spotify;

    public function __construct(SpotifyService $spotify)
    {
        $this->spotify = $spotify;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $albums = Album::latest()->get();
        return response()->json([
            'data' => AlbumResource::collection($albums),
            'message' => 'Fetch all albums',
            'success' => true
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validasi input ID Album Spotify
        $validator = Validator::make($request->all(), [
            'spotify_album_id' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        // Ambil data album dari Spotify API berdasarkan ID
        $spotifyAlbum = $this->spotify->getAlbumById($request->spotify_album_id);

        // Simpan data album ke dalam database
        $album = Album::create([
            'nama' => $spotifyAlbum['name'],
            'release_date' => $spotifyAlbum['release_date'],
            'image_url' => $spotifyAlbum['images'][0]['url'] ?? null,
        ]);

        return response()->json([
            'data' => new AlbumResource($album),
            'message' => 'Album created successfully.',
            'success' => true
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Album $album)
    {
        return response()->json([
            'data' => new AlbumResource($album),
            'message' => 'Data album found',
            'success' => true
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Album $album
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Album $album)
    {
        // Validasi input ID Album Spotify
        $validator = Validator::make($request->all(), [
            'spotify_album_id' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        // Ambil data album dari Spotify API berdasarkan ID
        $spotifyAlbum = $this->spotify->getAlbumById($request->spotify_album_id);

        // Update data album di dalam database
        $album->update([
            'nama' => $spotifyAlbum['name'],
            'release_date' => $spotifyAlbum['release_date'],
            'image_url' => $spotifyAlbum['images'][0]['url'] ?? null,
        ]);

        return response()->json([
            'data' => new AlbumResource($album),
            'message' => 'Album updated successfully',
            'success' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Album $album)
    {
        $album->delete();

        return response()->json([
            'data' => [],
            'message' => 'Album deleted successfully',
            'success' => true
        ]);
    }
}
