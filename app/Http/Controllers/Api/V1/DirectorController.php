<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Director;
use Illuminate\Http\Request;
use App\Filters\V1\DirectorsFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDirectorRequest;
use App\Http\Resources\V1\DirectorResource;
use App\Http\Requests\UpdateDirectorRequest;
use App\Http\Resources\V1\DirectorCollection;

class DirectorController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index(Request $request)
    {
        $filter = new DirectorsFilter();
        $filterItems = $filter->transform($request); //['column', 'operator', 'value']

        $includeFilms = $request->query('includeFilms');

        $directors = Director::where($filterItems);

        if ($includeFilms) {
            $directors = $directors->with('films');
        }

        return new DirectorCollection($directors->paginate()->appends($request->query()));


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
    public function store(StoreDirectorRequest $request)
    {
        return $request;
    }

    /**
     * Display the specified resource.
     */
    public function show(Director $director)
    {

        $includeMovies = request()->query('includeFilms');

        if ($includeMovies) {
            return new DirectorResource($director->loadMissing('films'));
        }

        return new DirectorResource($director);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Director $director)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDirectorRequest $request, Director $director)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Director $director)
    {
        //
    }
}
