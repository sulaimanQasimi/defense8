<style>
    .gun-table {
        width: 100%;
        text-align: right;
        font-size: 0.875rem;
        color: #6b7280;
    }

    .gun-table-body {
        font-size: 0.75rem;
        color: #374151;
        text-transform: uppercase;
        background-color: #f9fafb;
    }

    .gun-table-header {
        padding: 0.75rem 1.5rem;
        font-size: 2.25rem;
        text-align: center;
    }

    .gun-table-th {
        padding: 0.25rem 1.5rem;
        font-size: 1.5rem;
    }

    .gun-table-row {
        border: 1px solid #4b5563;
    }

    .gun-table-cell {
        padding: 0.25rem 1.5rem;
        font-size: 1.5rem;
    }
</style>

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
        @foreach ($employee->gun_card as $gun)
        <tr class="gun-table-row">
            <td class="gun-table-cell">
                {{ $gun?->gun_type }}
            </td>
            <td class="gun-table-cell">
                {{ $gun?->gun_no }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
