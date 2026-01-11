@extends('layouts.app')
@section('title', 'Menus')

@section('content')

<x-data-table
    table-id="menu-table"
    title="Menu Management"
    ajax-route="{{ route('menus.data') }}"
    add-button-text="Add Menu"
    add-button-action="openAddModal(menuCrud)"
    :columns="[
        ['data' => 'DT_RowIndex', 'title' => '#', 'orderable' => false, 'searchable' => false],
        ['data' => 'name', 'title' => 'Name'],
        ['data' => 'url', 'title' => 'URL'],
        ['data' => 'icon', 'title' => 'Icon'],
        ['data' => 'order_by', 'title' => 'Order'],
        ['data' => 'status', 'title' => 'Status', 'orderable' => false, 'searchable' => false],
        ['data' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false],
    ]"
/>



@endsection

@push('scripts')
<script>
const menuCrud = {
    title: 'Add Menu',
    editTitle: 'Edit Menu',
    url: "{{ url('menus') }}",
    table: '#menu-table',
    fields: [
        { name: 'name', label: 'Name', type: 'text', required: true },
        { name: 'url', label: 'URL', type: 'text' },
        { name: 'icon', label: 'Icon', type: 'text' },
        { name: 'order_by', label: 'Order', type: 'number' },
        {
            name: 'status',
            label: 'Status',
            type: 'select',
            options: [
                { value: 1, label: 'Active' },
                { value: 0, label: 'Inactive' }
            ]
        }
    ]
};
</script>
@endpush
