<?php

namespace App\Http\Controllers;

use App\Services\ScheduleAggregator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DailyVisitorGraphController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Factory|View|\Illuminate\View\View
     */
    public function index(Request $request): Factory|View|\Illuminate\View\View
    {
        $start_date = $request->get('start_date', now()->toDateString());
        $end_date = $request->get('end_date', now()->addDays(7)->toDateString());

        $visitor_counts = ScheduleAggregator::dateWiseScheduleCount($start_date, $end_date);

        $dates = collect($visitor_counts)->pluck('date')->map(fn($date) => date('jS F', strtotime($date)))->toArray();
        $number_of_visitors = collect($visitor_counts)->pluck('visitor_count')->toArray();

        return view('pages.date-wise-visitor-graph', compact('dates', 'number_of_visitors'));
    }
}
