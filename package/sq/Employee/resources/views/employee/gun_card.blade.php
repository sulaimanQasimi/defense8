<style>
    .gun-card {
        margin-top: 2rem;
        background: linear-gradient(145deg, #f0f4ff, #ffffff);
        border-radius: 0.75rem;
        padding: 1.5rem;
        box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.2),
                    0 8px 10px -6px rgba(59, 130, 246, 0.1);
        transition: transform 0.3s ease;
    }

    .gun-card:hover {
        transform: translateY(-3px);
    }

    .gun-table {
        width: 100%;
        text-align: right;
        color: #374151;
        border-collapse: collapse;
        border: 2px solid #d1d5db;
        border-radius: 0.5rem;
        overflow: hidden;
    }

    .gun-table-body {
        color: #1f2937;
        background-color: #f9fafb;
    }

    .gun-table-header {
        padding: 1rem 1.5rem;
        font-size: 2.25rem;
        text-align: center;
        background: linear-gradient(to right, #4f46e5, #6366f1);
        color: white;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
    }

    .gun-table-th {
        padding: 0.75rem 1.5rem;
        font-size: 1.5rem;
        background-color: #eef2ff;
        color: #4338ca;
        border: 1px solid #e5e7eb;
    }

    .gun-table-row {
        border-bottom: 1px solid #e5e7eb;
        transition: background-color 0.2s ease;
    }

    .gun-table-row:hover {
        background-color: #f3f4f6;
    }

    .gun-table-cell {
        padding: 0.75rem 1.5rem;
        font-size: 1.5rem;
        border: 1px solid #e5e7eb;
        background-color: white;
    }

    .empty-gun-message {
        padding: 1.5rem;
        text-align: center;
        font-size: 1.25rem;
        color: #6b7280;
        font-style: italic;
    }
</style>

<div class="gun-card">
    <table class="gun-table">
        <tbody class="gun-table-body">
            <tr>
                <th colspan="2" class="gun-table-header">@lang('Gun Card')</th>
            </tr>
            <tr>
                <th scope="col" class="gun-table-th">
                    د وسلی دول:
                </th>
                <th scope="col" class="gun-table-th">
                    د وسلی شمیره:
                </th>
            </tr>
            @forelse ($employee->gun_card as $gun)
                <tr class="gun-table-row">
                    <td class="gun-table-cell">
                        {{ $gun?->gun_type }}
                    </td>
                    <td class="gun-table-cell">
                        {{ $gun?->gun_no }}
                    </td>
                </tr>
            @empty
                <tr class="gun-table-row">
                    <td colspan="2" class="empty-gun-message">
                        @lang('No gun records found')
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
