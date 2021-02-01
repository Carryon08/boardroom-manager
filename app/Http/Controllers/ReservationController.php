<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Reservation[]|Collection
     */
    public function index()
    {
        return Reservation::all();
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
        return Reservation::where('boardroom_id',$id)->get();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        Reservation::find($id)->delete();
    }

    private function reservedSchedule($request){
        $reserved = false;
        $start_reservation = Reservation::whereDate('created_at',Carbon::now()->format('Y-m-d'))
            ->where('boardroom_id',$request->boardroom_id)
            ->where('start_hour','<=',$request->start_hour)
            ->where('end_hour','>=',$request->start_hour)
            ->count();
        if($start_reservation > 0){
            $reserved = true;
        }

        $end_reservation = Reservation::whereDate('created_at',Carbon::now()->format('Y-m-d'))
            ->where('boardroom_id',$request->boardroom_id)
            ->where('start_hour','<=',$request->end_hour)
            ->where('end_hour','>=',$request->end_hour)
            ->count();
        if($end_reservation > 0){
            $reserved = true;
        }

        $start_end_reservation = Reservation::whereDate('created_at',Carbon::now()->format('Y-m-d'))
            ->where('boardroom_id',$request->boardroom_id)
            ->where('start_hour','>=',$request->start_hour)
            ->where('end_hour','<=',$request->end_hour)
            ->count();
        if($start_end_reservation > 0){
            $reserved = true;
        }

        $date = Carbon::now();
        if ($date->toTimeString() > $request->start_hour)
        {
            $reserved = true;
        }
        if ($request->end_hour < $request->start_hour)
        {
            $reserved = true;
        }

        return $reserved;

    }

    public function deleteReservations()
    {
        $reservations_ended = Reservation::whereDate('created_at',Carbon::now()->format('Y-m-d'))
            ->where('end_hour','<',Carbon::now()->toTimeString())
            ->delete();
        return $reservations_ended;
    }
}
