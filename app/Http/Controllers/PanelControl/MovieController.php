<?php

namespace App\Http\Controllers\PanelControl;

use App\Http\Controllers\Controller;
use App\Services\MovieService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class MovieController extends Controller
{
    protected $movieService;

    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    public function index(Request $request)
    {
        try {
            $query = $request->get('q', '');
            $page = $request->get('page', '');

            if (empty($query)) {
                if ($request->ajax()) {
                    return response()->json([
                        'movies' => [],
                        'total' => 0,
                        'error' => null
                    ]);
                }
            }

            $result = $this->movieService->search($query, $page);

            if ($request->ajax()) {
                return response()->json($result);
            }

            return view('panel_control.movie', [
                'movies' => $result['movies'],
                'error' => $result['error'],
                'favorites' => Session::get('favorites', [])
            ]);
        } catch (\Throwable $th) {
            Log::error("Failed to load movies", [
                'line' => $th->getLine(),
                'file' => $th->getFile(),
                'message' => $th->getMessage()
            ]);

            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat film.');
        }
    }

    public function detail(Request $request, $imdbID)
    {
        try {
            $result = $this->movieService->detail($imdbID);

            return view('panel_control.movie_detail', [
                'movie' => $result['movie'],
                'error' => $result['error']
            ]);
        } catch (\Throwable $th) {
            Log::error("Failed to load movie detail", [
                'line' => $th->getLine(),
                'file' => $th->getFile(),
                'message' => $th->getMessage()
            ]);

            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat detail film.');
        }
    }

    public function addFavorite(Request $request)
    {
        try {
            $movie = [
                'imdbID' => $request->imdbID,
                'title' => $request->title,
                'poster' => $request->poster,
                'year' => $request->year,
                'type' => $request->type,
            ];

            $favorites = Session::get('favorites', []);
            $favorites[$request->imdbID] = $movie;
            Session::put('favorites', $favorites);

            return response()->json(['status' => 'added', 'message' => 'Film ditambahkan ke favorit']);
        } catch (\Throwable $th) {
            Log::error("Failed to add favorite", [
                'line' => $th->getLine(),
                'file' => $th->getFile(),
                'message' => $th->getMessage()
            ]);

            return response()->json(['status' => 'error', 'message' => $th->getMessage()], 500);
        }
    }

    public function removeFavorite(Request $request)
    {
        try {
            $favorites = Session::get('favorites', []);
            unset($favorites[$request->imdbID]);
            Session::put('favorites', $favorites);

            return response()->json(['status' => 'removed', 'message' => 'Film dihapus dari favorit']);
        } catch (\Throwable $th) {
            Log::error("Failed to remove favorite", [
                'line' => $th->getLine(),
                'file' => $th->getFile(),
                'message' => $th->getMessage()
            ]);

            return response()->json(['status' => 'error', 'message' => $th->getMessage()], 500);
        }
    }
}
