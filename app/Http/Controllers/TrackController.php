<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTrack;
use App\Track;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrackController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tracks = Track::where('user_id', Auth::user()->id)->whereDate('start', Carbon::today())->get();
        return $tracks;
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(StoreTrack $request)
    {
        $request->merge(['user_id' => $request->user()->id]);
        if (!$request->total) {
            $request->merge(['total' => 1]);
        }
        $inputs = array_filter($request->except(['date', 'activated', 'tempTotal']));

        /** @var Track $track */
        if ($track = Track::find($request->id)) {

            $track->update($inputs);
            $track->save();
        }else{
            $track = Track::create($inputs);
        }

        return $track;
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        Track::destroy($id);
        return $id;
    }
}
