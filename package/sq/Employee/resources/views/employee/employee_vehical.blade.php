<style>
    .vehical-container {
        margin-top: 1.75rem;
        overflow-x: auto;
        direction: rtl;
    }

    .vehical-table-wrapper {
        position: relative;
        overflow-x: auto;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        border-radius: 0.5rem;
    }

    .vehical-table {
        width: 100%;
        font-size: 0.875rem;
        text-align: right;
        color: #6b7280;
    }

    .vehical-thead {
        font-size: 0.75rem;
        color: #374151;
        text-transform: uppercase;
        background-color: #f9fafb;
    }

    .vehical-header-cell {
        padding: 0.75rem 1.5rem;
        border: 1px solid #4b5563;
    }

    .vehical-title {
        text-align: center;
        font-size: 2rem;
    }

    .vehical-row {
        background-color: white;
        border-bottom: 1px solid #e5e7eb;
    }

    .vehical-cell {
        padding: 1rem 1.5rem;
        border: 1px solid #4b5563;
    }

    .driver-link {
        color: #2563eb;
        font-size: 1.125rem;
    }

    .empty-message {
        padding: 1rem 1.5rem;
        border: 1px solid #4b5563;
        text-align: center;
        text-wrap: pretty;
    }
</style>

<div class="vehical-container">
    <div class="vehical-table-wrapper">
        <table class="vehical-table">
            <thead class="vehical-thead">
                <tr>
                    <th scope="col" class="vehical-header-cell vehical-title" colspan="7">
                        @lang('Employee Vehical Card')
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
                            @lang('Not Found')
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
