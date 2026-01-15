@props([
'tableId',
'title' => '',
'ajaxRoute',
'columns' => [],
'showHeader' => true,
'showAddButton' => true,
'addButtonText' => 'Add New',
'addButtonAction' => '',
'pageLength' => 10,
'lengthMenu' => [10, 25, 50, 100],
'showExportButtons' => true,
'filters' => [
    [
        'name' => 'filter',
        'label' => 'Filter',
        'options' => [
            ['value' => '', 'label' => 'All'],
            ['value' => 'active', 'label' => 'Active'],
            ['value' => 'inactive', 'label' => 'Inactive'],
            ['value' => 'latest', 'label' => 'Latest'],
            ['value' => 'oldest', 'label' => 'Oldest'],
        ],
        'default' => ''
    ]
]
])

<div class="w-full">
    @if($showHeader)
    <div class="flex justify-between mb-4 flex-wrap gap-4">
        <h1 class="font-bold text-2xl">{{ $title }}</h1>

        <div class="flex items-center space-x-4 flex-wrap gap-3">

            {{-- Dynamic Filters --}}
            @if($filters && count($filters) > 0)
            <div class="flex items-center space-x-3 flex-wrap gap-3">
                @foreach($filters as $f)
                <div class="flex items-center">
                    <label for="filter-{{ $tableId }}-{{ $f['name'] }}"
                        class="mr-2 text-gray-700">
                        {{ $f['label'] }}:
                    </label>
                    <select
                        id="filter-{{ $tableId }}-{{ $f['name'] }}"
                        class="px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#003366] focus:border-transparent">
                        @foreach($f['options'] as $option)
                        <option value="{{ $option['value'] }}"
                            {{ ($f['default'] ?? '') == $option['value'] ? 'selected' : '' }}>
                            {{ $option['label'] }}
                        </option>
                        @endforeach
                    </select>
                </div>
                @endforeach
            </div>
            @endif

            {{-- Refresh Filters Button --}}
            <button
                type="button"
                id="refresh-{{ $tableId }}-filters"
                title="Reset Filters"
                class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition flex items-center gap-2">
                <i class="fa fa-rotate-right"></i>
                Refresh
            </button>

            {{-- Add Button --}}
            @if($showAddButton)
            <button onclick="{{ $addButtonAction }}"
                class="px-4 py-2 bg-[#003366] text-white rounded hover:bg-[#002244] transition">
                {{ $addButtonText }}
            </button>
            @endif
        </div>
    </div>
    @endif

    <table id="{{ $tableId }}" class="table w-full">
        <thead>
            <tr class="bg-[#003366] text-white">
                @foreach($columns as $column)
                <th>{{ $column['title'] }}</th>
                @endforeach
            </tr>
        </thead>
    </table>

    {{ $slot }}
</div>

@push('scripts')
<script>
$(document).ready(function () {

    const table = $('#{{ $tableId }}').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ $ajaxRoute }}",
            data: function (d) {
                @foreach($filters as $f)
                    d["{{ $f['name'] }}"] =
                        $('#filter-{{ $tableId }}-{{ $f['name'] }}').val();
                @endforeach
            }
        },
        pageLength: {{ $pageLength }},
        lengthMenu: @json($lengthMenu),
        dom: '<"flex justify-between items-center mb-4"lBf>rtip',
        @if($showExportButtons)
        buttons: [
            { extend: 'excel', text: '<i class="fa fa-file-excel"></i> Excel', className: 'px-3 py-2 bg-[#003366] text-white rounded' },
            { extend: 'pdf', text: '<i class="fa fa-file-pdf"></i> PDF', className: 'px-3 py-2 bg-[#003366] text-white rounded' },
            { extend: 'csv', text: '<i class="fa fa-file-csv"></i> CSV', className: 'px-3 py-2 bg-[#003366] text-white rounded' },
            { extend: 'print', text: '<i class="fa fa-print"></i> Print', className: 'px-3 py-2 bg-[#003366] text-white rounded' },
            { extend: 'colvis', text: '<i class="fa fa-columns"></i> Columns', className: 'px-3 py-2 bg-[#003366] text-white rounded' }
        ],
        @endif
        columns: @json($columns)
    });

    // Reload table on filter change
    @foreach($filters as $f)
    $('#filter-{{ $tableId }}-{{ $f['name'] }}').on('change', function () {
        table.ajax.reload();
    });
    @endforeach

    // Refresh / Reset Filters
    $('#refresh-{{ $tableId }}-filters').on('click', function () {

        @foreach($filters as $f)
            $('#filter-{{ $tableId }}-{{ $f['name'] }}')
                .val('{{ $f['default'] ?? '' }}');
        @endforeach

        table.ajax.reload();
    });

    // Global reload function
    window['reload{{ \Illuminate\Support\Str::studly($tableId) }}'] = function () {
        table.ajax.reload(null, false);
    };

});
</script>
@endpush
