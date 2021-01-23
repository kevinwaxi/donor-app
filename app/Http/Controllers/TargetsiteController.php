<?php

namespace App\Http\Controllers;

use App\Models\Targetsite;
use Illuminate\Http\Request;

class TargetsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        return Targetsite::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //validate inputs
        $this->validate($request, [
            'site_name' => 'required|unique:targetsites',
            'coordinates' => 'required',
            'location' => 'required',
            'desc' => 'required',

        ]);
        return Targetsite::create([
            'site_name' =>$request->site_name,
            'coordinates' =>$request->coordinates,
            'location' =>$request->location,
            'site_image' =>$request->site_image,
            'desc'=>$request->desc,
        ]);
        //input function
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Targetsite  $targetsite
     * @return \Illuminate\Http\Response
     */
    public function show(Targetsite $targetsite)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Targetsite  $targetsite
     * @return \Illuminate\Http\Response
     */
    public function edit(Targetsite $targetsite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Targetsite  $targetsite
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Targetsite $targetsite)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Targetsite  $targetsite
     * @return \Illuminate\Http\Response
     */
    public function destroy(Targetsite $targetsite)
    {
        //
    }
}
