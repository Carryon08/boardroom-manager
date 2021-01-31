<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $reserved = $this->reservedSchedule($request);
        if($reserved)
        {
            return response(['status'=>0,'message'=>'Reserva ocupada'])->setStatusCode(Response::HTTP_ACCEPTED);
        }
        else
        {
            $reservation = new Reservation;
            $reservation->start_hour = $request->start_hour;
            $reservation->end_hour = $request->end_hour;
            $reservation->boardroom_id = $request->boardroom_id;
            $reservation->user_id = $request->user_id;
            $reservation->save();
//            if($reservation){
//                return (new ReservaResource($reservation))->response()->setStatusCode(Response::HTTP_CREATED);
//            }
        }
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

    private function reservedSchedule($request){
        $reserved = false;
        $start_reservation = Reservation::whereDate('created_at',Carbon::now()->format('Y-m-d'))
            ->where('boardroom_id',$request->ambiente_id)
            ->where('start_hour','<=',$request->hora_inicio)
            ->where('end_hour','>=',$request->hora_inicio)
            ->count();
        if($start_reservation > 0){
            $reserved = true;
        }

        $end_reservation = Reservation::whereDate('created_at',Carbon::now()->format('Y-m-d'))
            ->where('ambiente_id',$request->ambiente_id)
            ->where('hora_inicio','<=',$request->hora_fin)
            ->where('hora_fin','>=',$request->hora_fin)
            ->count();
        if($end_reservation > 0){
            $reserved = true;
        }

        $start_end_reservation = Reservation::whereDate('created_at',Carbon::now()->format('Y-m-d'))
            ->where('ambiente_id',$request->ambiente_id)
            ->where('hora_inicio','>=',$request->hora_inicio)
            ->where('hora_fin','<=',$request->hora_fin)
            ->count();
        if($start_end_reservation > 0){
            $reserved = true;
        }

        return $reserved;

    }
}
