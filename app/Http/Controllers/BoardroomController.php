<?php

namespace App\Http\Controllers;

use App\Models\Boardroom;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BoardroomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Boardroom[]|Collection
     */
    public function index()
    {
        return Boardroom::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $boardroom = new Boardroom();
        $boardroom->fill($request->all());
        $boardroom->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
