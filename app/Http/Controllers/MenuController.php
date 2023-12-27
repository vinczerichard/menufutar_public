<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\MenuType;
use App\Models\Company;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (session()->has('location')) {

            $companylastday = Company::findOrFail(1)->changeday;
            $companylasthour = Company::findOrFail(1)->changehour;
            $thisfriday = Carbon::now();
            $thisfriday->setTimezone('Europe/Stockholm');
            $thisfriday->startOfWeek();
            $thisfriday->addDays($companylastday)->addHour($companylasthour);

            $firstday = Carbon::now();
            $firstday->setTimezone('Europe/Stockholm');
            $firstday->startOfWeek();

            $now = Carbon::now();
            $now->setTimezone('Europe/Stockholm');

            if ($now < $thisfriday) {
                $vizsg = "Még rendelhető";
                $firstday->addDays(7);
            } else {
                $vizsg = "Már nem rendelhető";
                $firstday->addDays(14);
                $thisfriday->addDays(7);
            }

            $firstday = $firstday->format('Y-m-d');
            $thisfriday = $thisfriday->format('Y-m-d H:i');

            $orderdate = "2023-11-23";

            $data = Menu::whereNull('location')->where('delivery_date', '>=', date("Y-m-d"))->where('visible', 1)->where('orderable', 1)
                ->orWhere(function ($query) {
                    $query->where('location', '=', session()->get('location'))->where('delivery_date', '>=', date("Y-m-d"));
                })->orderBy('delivery_date')->get();

            foreach ($data as $d) {
                if ($d->delivery_date >= $firstday) {
                    $d->noworderable = 1;
                } else {
                    $d->noworderable = 0;
                }
            }


            $dates = Menu::whereNull('location')->where('delivery_date', '>=', date("Y-m-d"))->where('visible', 1)->where('orderable', 1)
                ->orWhere(function ($query) {
                    $query->where('location', session()->get('location'))->where('delivery_date', '>=', date("Y-m-d"));
                })->orderBy('delivery_date')->distinct()->get(['delivery_date']);

            foreach ($dates as $date) {

                $daynames = [
                    0 => 'Vasárnap',
                    1 => 'Hétfő',
                    2 => 'Kedd',
                    3 => 'Szerda',
                    4 => 'Csütörtök',
                    5 => 'Péntek',
                    6 => 'Szombat',
                ];

                $thisdate = new Carbon($date->delivery_date);
                $dayname = $thisdate->dayOfWeek;
                $date->dayname = $daynames[$dayname];
                if ($date->delivery_date >= $firstday) {
                    $date->status = 1;
                } else {
                    $date->status = 0;
                }
            }

            $types = Menu::whereNull('location')->where('delivery_date', '>=', date("Y-m-d"))->where('visible', 1)->where('orderable', 1)
                ->orWhere(function ($query) {
                    $query->where('location', session()->get('location'))->where('delivery_date', '>=', date("Y-m-d"));
                })->orderBy('menu_type', 'DESC')->distinct()->get(['menu_type']);

            $success = true;
        } else {
            $success = false;
        }



        return response()->json([
            'data' => $data,
            'dates' => $dates,
            'types' => $types,
            'firstday' => $firstday,
            'success' => $success,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        //
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
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        //
    }
}
