<style>
    .vehical-container {
        margin-top: 2.5rem;
        overflow-x: auto;
        direction: rtl;
    }

    .vehical-table-wrapper {
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.2),
                    0 8px 10px -6px rgba(59, 130, 246, 0.1);
        border-radius: 0.75rem;
        background: linear-gradient(145deg, #f0f4ff, #ffffff);
        padding: 1.5rem;
        transition: transform 0.3s ease;
    }

    .vehical-table-wrapper:hover {
        transform: translateY(-3px);
    }

    .vehical-table {
        width: 100%;
        font-size: 1rem;
        text-align: right;
        color: #1f2937;
        border-collapse: collapse;
        border: 2px solid #d1d5db;
        border-radius: 0.5rem;
        overflow: hidden;
    }

    .vehical-thead {
        color: #374151;
        background-color: #f9fafb;
    }

    .vehical-header-cell {
        padding: 0.75rem 1.5rem;
        border: 1px solid #e5e7eb;
        background-color: #eef2ff;
        color: #4338ca;
        font-size: 1.1rem;
    }

    .vehical-title {
        text-align: center;
        font-size: 2rem;
        background: linear-gradient(to right, #4f46e5, #6366f1);
        color: white;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
        padding: 1rem 0;
    }

    .vehical-row {
        background-color: white;
        border-bottom: 1px solid #e5e7eb;
        transition: background-color 0.2s ease;
    }

    .vehical-row:hover {
        background-color: #f3f4f6;
    }

    .vehical-cell {
        padding: 1rem 1.5rem;
        border: 1px solid #e5e7eb;
        font-size: 1.1rem;
    }

    .driver-link {
        color: #4f46e5;
        font-size: 1.1rem;
        text-decoration: none;
        font-weight: 500;
        position: relative;
        transition: color 0.2s ease;
    }

    .driver-link:hover {
        color: #4338ca;
        text-decoration: underline;
    }

    .empty-message {
        padding: 2rem 1.5rem;
        border: 1px solid #e5e7eb;
        text-align: center;
        color: #6b7280;
        font-style: italic;
        font-size: 1.25rem;
        background-color: #f9fafb;
    }

    /* Add a subtle icon to the table title */
    .title-wrapper {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .title-wrapper::before {
        content: "🚗";
        margin-right: 0.75rem;
        font-size: 1.75rem;
    }
</style>

<div class="vehical-container">
    <div class="vehical-table-wrapper">
        <table class="vehical-table">
            <thead class="vehical-thead">
                <tr>
                    <th scope="col" class="vehical-header-cell vehical-title" colspan="7">
                        <div class="title-wrapper">
                            @lang('Employee Vehical Card')
                        </div>
                    </th>
                </tr>
                <tr>
                    <th scope="col" class="vehical-header-cell">
                        @lang('Vehical Palete')
                    </th>
                    <th scope="col" class="vehical-header-cell">
                        @lang('Vehical Colour')
                    </th>
                    <th scope="col" class="vehical-header-cell">
                        @lang('Vehical Chassis')
                    </th>
                    <th scope="col" class="vehical-header-cell">
                        @lang('Vehical Model')
                    </th>
                    <th scope="col" class="vehical-header-cell">
                        @lang('Driver')
                    </th>
                    <th scope="col" class="vehical-header-cell">
                        @lang('Remark')
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($employee->employee_vehical_card as $vehical)
                    <tr tabindex="0" class="vehical-row">
                        <td class="vehical-cell">
                            {{ $vehical?->vehical_palete }}
                        </td>
                        <td class="vehical-cell">
                            {{ $vehical?->vehical_colour }}
                        </td>
                        <td class="vehical-cell">
                            {{ $vehical?->vehical_chassis }}
                        </td>
                        <td class="vehical-cell">
                            {{ $vehical?->vehical_model }}
                        </td>
                        <td class="vehical-cell">
                            <a href="{{ route('sqemployee.employee.check.card', ['code' => $vehical->driver?->registare_no]) }}"
                                class="driver-link">{{ $vehical->driver?->full_name }}</a>
                        </td>
                        <td class="vehical-cell">
                            {!! $vehical?->remark !!}
                        </td>
                    </tr>
                @empty
                    <tr class="vehical-row">
                        <td class="empty-message" colspan="7">
                            @lang('No vehicle records found')
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
