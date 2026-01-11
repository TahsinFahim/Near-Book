<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Str;

class DataTable extends Component
{
    public string $tableId;
    public string $title;
    public string $ajaxRoute;
    public array $columns;
    public bool $showHeader;
    public bool $showAddButton;
    public string $addButtonText;
    public string $addButtonAction;
    public int $pageLength;
    public array $lengthMenu;
    public bool $showExportButtons;

    public function __construct(
        string $tableId,
        string $ajaxRoute,
        array $columns,
        string $title = '',
        bool $showHeader = true,
        bool $showAddButton = true,
        string $addButtonText = 'Add New',
        string $addButtonAction = '',
        int $pageLength = 10,
        array $lengthMenu = [10, 25, 50, 100],
        bool $showExportButtons = true
    ) {
        $this->tableId = $tableId;
        $this->title = $title;
        $this->ajaxRoute = $ajaxRoute;
        $this->columns = $columns;
        $this->showHeader = $showHeader;
        $this->showAddButton = $showAddButton;
        $this->addButtonText = $addButtonText;
        $this->addButtonAction = $addButtonAction;
        $this->pageLength = $pageLength;
        $this->lengthMenu = $lengthMenu;
        $this->showExportButtons = $showExportButtons;
    }

    public function render()
    {
        return view('components.data-table');
    }
}