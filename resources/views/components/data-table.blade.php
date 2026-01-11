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
    'showExportButtons' => true
])

<div class="w-full">
    @if($showHeader)
    <div class="flex justify-between mb-4">
        <h1 class="font-bold text-2xl">{{ $title }}</h1>
        @if($showAddButton)
        <button onclick="{{ $addButtonAction }}"
            class="px-4 py-2 bg-[#003366] text-white rounded">
            {{ $addButtonText }}
        </button>
        @endif
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
    $(document).ready(function() {
        var table = $('#{{ $tableId }}').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ $ajaxRoute }}",
            pageLength: {{ $pageLength }},
            lengthMenu: @json($lengthMenu),
            dom: '<"flex justify-between items-center mb-4"lBf>rtip',
            @if($showExportButtons)
            buttons: [
                {
                    extend: 'excel',
                    text: '<i class="fa fa-file-excel"></i> Excel',
                    className: 'px-3 py-2 bg-[#003366] text-white rounded'
                },
                {
                    extend: 'pdf',
                    text: '<i class="fa fa-file-pdf"></i> PDF',
                    className: 'px-3 py-2 bg-[#003366] text-white rounded'
                },
                {
                    extend: 'csv',
                    text: '<i class="fa fa-file-csv"></i> CSV',
                    className: 'px-3 py-2 bg-[#003366] text-white rounded'
                },
                {
                    extend: 'print',
                    text: '<i class="fa fa-print"></i> Print',
                    className: 'px-3 py-2 bg-[#003366] text-white rounded'
                }
            ],
            @endif
            columns: @json($columns)
        });

        // Reload function
        window['reload{{ \Illuminate\Support\Str::studly($tableId) }}'] = function() {
            table.ajax.reload(null, false);
        };
    });
</script>
@endpush