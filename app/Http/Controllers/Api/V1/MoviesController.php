<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Movies;
use Illuminate\Http\Request;
use App\Filters\V1\MoviesFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\MovieResource;
use App\Http\Requests\StoreMoviesRequest;
use App\Http\Requests\UpdateMoviesRequest;
use App\Http\Resources\V1\MovieCollection;

class MoviesController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index(Request $request)
    {
        $filter = new MoviesFilter();

        $filterItems = $filter->transform($request); //['column', 'operator', 'value']

        $includeDirectors = $request->query('includeDirectors');

        $movies = Movies::where($filterItems);

        if ($includeDirectors) {
            $movies = $movies->with('directors');
        }

        return new MovieCollection($movies->paginate()->appends($request->query()));


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMoviesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Movies $movies)
    {
        return new MovieResource($movies);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movies $movies)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMoviesRequest $request, Movies $movies)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movies $movies)
    {
        //
    }
}
