<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Film;
use Illuminate\Http\Request;
use App\Filters\V1\FilmsFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFilmRequest;
use App\Http\Resources\V1\FilmResource;
use App\Http\Requests\UpdateFilmRequest;
use App\Http\Resources\V1\FilmCollection;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $filter = new FilmsFilter();
        $filterItems = $filter->transform($request); //['column', 'operator', 'value']

        $films = Film::where($filterItems);

        return new FilmCollection($films->paginate()->appends($request->query()));
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
    public function store(StoreFilmRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Film $film)
    {
        return new FilmResource($film);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Film $film)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFilmRequest $request, Film $film)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Film $film)
    {
        //
    }
}
