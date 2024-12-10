<h1>Liquidation Report</h1>
<h2>Event: {{ $event->eventType }}</h2>
<h3>Date: {{ $date_today }}</h3>

<div class="report-summary">
    <table class="summary-table">
        <tr>
            <th>Total Event Budget</th>
            <td>{{ number_format($total_event_budget, 2) }}</td>
        </tr>
        <tr>
            <th>Total Expense</th>
            <td>{{ number_format($total_expense, 2) }}</td>
        </tr>
        <tr>
            <th>Total Refunded</th>
            <td>{{ number_format($total_refunded, 2) }}</td>
        </tr>
        <tr>
            <th>Total to be Reimbursed</th>
            <td>{{ number_format($total_to_be_reimbursed, 2) }}</td>
        </tr>
    </table>
</div>
