<?php

namespace App\Http\Controllers\FrontEnd;

use App\Enums\TableStatus;
use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Table;
use App\Rules\DateBetween;
use App\Rules\TimeBetween;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function stepOne(Request $request)
    {
        $reservation = $request->session()->get('reservation');
        $reservation_date_value = Carbon::parse($reservation->reservation_date)->format('Y-m-d\TH:i:s');
        $min_date = Carbon::today();
        $max_date = Carbon::now()->addWeek();
        return view('frontend.reservations.step-one', compact('reservation', 'min_date', 'max_date', 'reservation_date_value'));
    }

    public function storeStepOne(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required'],
            'phone_number' => ['required'],
            'reservation_date' => ['required', 'date', new DateBetween(), new TimeBetween()],
            'guest_number' => ['required'],
        ]);

        if(empty($request->session()->get('reservation')))
        {
            $reservation = new Reservation();
            $reservation->fill($validated);
            $request->session()->put('reservation', $reservation);
        } else {
            $reservation = $request->session()->get('reservation');
            $reservation->fill($validated);
            $request->session()->put('reservation', $reservation);
        }

        return to_route('reservations.step.two');
    }

    public function stepTwo(Request $request)
    {
        $reservation = $request->session()->get('reservation');
        $reservation_table_ids = Reservation::orderBy('reservation_date')->get()->filter(function($value) use($reservation){
            return Carbon::parse($value->reservation_date)->format('Y-m-d') == Carbon::parse($reservation->reservation_date)->format('Y-m-d');
        })->pluck('table_id');
        $tables = Table::where('status', TableStatus::Avaliable)
            ->where('guest_number', '>=' , $reservation->guest_number)
            ->whereNotIn('id', $reservation_table_ids)->get();
        return view('frontend.reservations.step-two', compact('reservation', 'tables'));
    }

    public function storeStepTwo(Request $request)
    {
        $validated = $request->validate([
            'table_id' => ['required'],
        ]);

        $reservation = $request->session()->get('reservation');
        $reservation->fill($validated);
        $reservation->save();
        $request->session()->forget('reservation');

        return to_route('thankyou');

    }


}
