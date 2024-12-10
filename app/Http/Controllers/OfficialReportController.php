<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Expense;
//use \PDF;
use Barryvdh\DomPDF\Facade\PDF; 
use Carbon\Carbon;
class OfficialReportController extends Controller
{
    public function index()
    {
        $events = Event::with('expenses')->get();
     //   dd($events);
        // Pass the events (with expenses) to the view
        return view('official.OfficialReport', compact('events'));
    }




    public function showLiquidationReport()
    {
        // Fetch events with their related expenses
        $events = Event::with('expenses')->get();

        // Initialize variables for summary calculations
        $total_event_budget = 0;
        $total_expense = 0;
        $total_refunded = 0;
        $total_to_be_reimbursed = 0;

        // Loop through each event and calculate the totals
        foreach ($events as $event) {
            $event_budget = $event->budget; // Event's budget
            $event_expenses = $event->expenses->sum('expense_amount'); // Sum up the event's expenses

            // Calculate the refunded and reimbursed amounts
            $amount_refunded = max(0, $event_expenses - $event_budget); // Refund if expenses exceed the budget
            $amount_to_be_reimbursed = max(0, $event_budget - $event_expenses); // Reimbursement if budget exceeds expenses

            // Accumulate the totals
            $total_event_budget += $event_budget;
            $total_expense += $event_expenses;
            $total_refunded += $amount_refunded;
            $total_to_be_reimbursed += $amount_to_be_reimbursed;
        }

        // Get the current date
        $date_today = Carbon::now()->format('F d, Y');

        // Return the view and pass the data
        return view('report.liquidation_report', compact(
            'events',
            'total_event_budget',
            'total_expense',
            'total_refunded',
            'total_to_be_reimbursed',
            'date_today'
        ));
    }


public function generateLiquidationReport(Event $event)
{
    // Initialize variables for summary calculations
    $total_event_budget = $event->budget;
    $total_expense = $event->expenses->sum('expense_amount');
    $total_refunded = max(0, $total_expense - $total_event_budget);
    $total_to_be_reimbursed = max(0, $total_event_budget - $total_expense);

    // Get the current date to include in the report
    $date_today = \Carbon\Carbon::now()->format('F d, Y');

    // Generate the PDF using the correct variable name
    $pdf = PDF::loadView('report.liquidation_report', [
        'event' => $event, // Pass the singular event
        'total_event_budget' => $total_event_budget,
        'total_expense' => $total_expense,
        'total_refunded' => $total_refunded,
        'total_to_be_reimbursed' => $total_to_be_reimbursed,
        'date_today' => $date_today,
    ]);

    // Return the PDF for download
    return $pdf->download('liquidation_report.pdf');
}


public function print(Request $request)
{
    // Validate the incoming request data
    $request->validate([
        'startMonth' => 'required|date_format:Y-m',
        'endMonth' => 'required|date_format:Y-m|after_or_equal:startMonth',
    ]);

    // Original inputs
    $startMonth = $request->input('startMonth');
    $endMonth = $request->input('endMonth');

    // Convert months to full dates
    $startDate = $startMonth . '-01';
    $endDate = $endMonth . '-31';

    // Fetch events where the event's date range overlaps with the selected date range
    $events = Event::where(function ($query) use ($startDate, $endDate) {
            $query->whereBetween('eventStartDate', [$startDate, $endDate])
                  ->orWhereBetween('eventEndDate', [$startDate, $endDate])
                  ->orWhere(function ($query) use ($startDate, $endDate) {
                      $query->where('eventStartDate', '<=', $startDate)
                            ->where('eventEndDate', '>=', $endDate);
                  });
        })
        ->with('expenses') // Load related expenses
        ->get();

    // Pass all variables to the view
    return view('events.print1', compact('events', 'startMonth', 'endMonth', 'startDate', 'endDate'));
}







/*
    public function generateLiquidationReport(Event $event)
    {
    // Initialize variables for summary calculations
    $total_event_budget = 0;
    $total_expense = 0;
    $total_refunded = 0;
    $total_to_be_reimbursed = 0;

    // Loop through each event and calculate the totals
    foreach ($events as $event) {
        // Assuming 'budget' is a field in the Event model
        $event_budget = $event->budget; // Get the event's budget
        
        // Sum up the expenses for the event
        $event_expenses = $event->expenses->sum('expense_amount'); 

        // Calculate amounts
        $amount_refunded = max(0, $event_expenses - $event_budget); // Amount refunded if expenses exceed budget
        $amount_to_be_reimbursed = max(0, $event_budget - $event_expenses); // Amount to be reimbursed if budget exceeds expenses

        // Accumulate total values for all events
        $total_event_budget += $event_budget;
        $total_expense += $event_expenses;
        $total_refunded += $amount_refunded;
        $total_to_be_reimbursed += $amount_to_be_reimbursed;
    }

    // Get the current date to include in the report
    $date_today = \Carbon\Carbon::now()->format('F d, Y');

    // Pass data to the PDF view
    $pdf = PDF::loadView('report.liquidation_report', [
        'events' => $events,
        'total_event_budget' => $total_event_budget,
        'total_expense' => $total_expense,
        'total_refunded' => $total_refunded,
        'total_to_be_reimbursed' => $total_to_be_reimbursed,
        'date_today' => $date_today
    ]);

    // Return the PDF file for download
    return $pdf->download('liquidation_report.pdf');
}
*/





}
