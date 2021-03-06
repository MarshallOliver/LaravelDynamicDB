<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Location;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('locations.index', ['locations' => Location::orderBy('long_name', 'asc')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('locations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validatedRequest = $request->validate([
            'short_name' => 'required|max:3',
            'long_name' => 'required',
            'address1' => 'required',
            'address2' => '',
            'city' => 'required',
            'state' => 'required|max:2',
            'zip_code' => 'required|numeric',

        ]);

        $location = new Location($validatedRequest);
        $location->save();

        return redirect('locations');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('locations.edit', ['location' => Location::with('databases')->findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $validatedRequest = $request->validate([
            'short_name' => 'required|max:3',
            'long_name' => 'required',
            'address1' => 'required',
            'address2' => '',
            'city' => 'required',
            'state' => 'required|max:2',
            'zip_code' => 'required',

        ]);

        $location = Location::findOrFail($id);
        
        $location->short_name = $validatedRequest['short_name'];
        $location->long_name = $validatedRequest['long_name'];
        $location->address1 = $validatedRequest['address1'];
        $location->address2 = $validatedRequest['address2'];
        $location->city = $validatedRequest['city'];
        $location->state = $validatedRequest['state'];
        $location->zip_code = $validatedRequest['zip_code'];

        $location->save();

        return redirect('locations');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Location::destroy($id);

        return redirect('locations');
    }
}
