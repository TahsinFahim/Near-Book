@extends('layouts.app')
@section('title', 'Nearbooks | Banners')

@section('content')

<div id="main-content" class="transition-all duration-300">
    <x-data-table
        table-id="banner-table"
        title="Banner Management"
        ajax-route="{{ route('banners.data') }}"
        add-button-text="Add Banner"
        add-button-action="openAddModal(bannerCrud)"
        :columns="[
            ['data' => 'DT_RowIndex', 'title' => '#', 'orderable' => false, 'searchable' => false],
            ['data' => 'image', 'title' => 'Image', 'orderable' => false, 'searchable' => false],
            ['data' => 'title', 'title' => 'Title'],
            ['data' => 'subtitle', 'title' => 'Subtitle'],
            ['data' => 'link', 'title' => 'Link'],
            ['data' => 'status', 'title' => 'Status', 'orderable' => false, 'searchable' => false],
            ['data' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false],
        ]"
    />
</div>

@endsection

@push('scripts')
<script>
const bannerCrud = {
    title: 'Add Banner',
    editTitle: 'Edit Banner',
    url: "{{ url('banners') }}",
    table: '#banner-table',
    fields: [
        { name: 'title', label: 'Title', type: 'text' },
        { name: 'subtitle', label: 'Subtitle', type: 'text' },
        { name: 'link', label: 'Link', type: 'text' },
        {
            name: 'image_path',
            label: 'Banner Image',
            type: 'file',
            
        },
        {
                name: 'is_active',
                label: 'Status',
                type: 'select',
                options: [{
                        value: 1,
                        label: 'Active'
                    },
                    {
                        value: 0,
                        label: 'Inactive'
                    }
                ]
            },
    ]
};
</script>
@endpush
