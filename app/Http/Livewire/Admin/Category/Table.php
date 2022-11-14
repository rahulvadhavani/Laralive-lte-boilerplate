<?php

namespace App\Http\Livewire\Admin\Category;

use App\Models\Category;
use Illuminate\Contracts\Support\ValidatedData;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;


class Table extends DataTableComponent
{
    public $name, $categories;
    public $curPage = 'Category';
    public $recordId = 0;
    public bool $responsive = true;
    protected $listeners = ['deleteRecrod', 'refresh'];
    public array $bulkActions = [
        'deleteSelected' => 'Delete',
    ];
    public bool $singleColumnSorting = true;

    public function mount()
    {
        $this->resetAll();
        $this->categories = Category::getCategories();
    }


    public function columns(): array
    {
        return [
            Column::make('Name')
                ->sortable()
                ->searchable(),
            Column::make('Alias')
                ->sortable()
                ->searchable(),
            Column::make('Created_at')
                ->sortable(),
            Column::make('Status')
                ->sortable()
                ->format(function ($value, $column, $row) {
                    $statusActive = $value == 1 ? 'checked' : '';
                    $switchId = "customSwitch" . $row->id;
                    return '<div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input"' . $statusActive . ' id="' . $switchId . '" wire:click="updateStatus(' . $row->id . ',' . $value . ')">
                    <label class="custom-control-label" for="' . $switchId . '"></label>
                    </div>';
                })
                ->asHtml(),
            Column::make('Action')
                ->format(function ($value, $column, $row) {
                    $row = (object)['id' => $row->id];
                    $action = ['show', 'edit', 'delete'];
                    $component = "admin.category.category";
                    return view('livewire.admin.common.actions', compact('row', 'action', 'component'));
                }),
        ];
    }

    public function delete($id)
    {
        $this->dispatchBrowserEvent('viewDelete', ['id' => $id]);
    }

    public function deleteRecrod($id)
    {
        $category = Category::where('id', $id)->first();
        if ($category == null) {
            $res = error('Category not found.');
        } else {
            $res = success('Category deleted successfully.');
            $category->delete();
        }
        $this->dispatchBrowserEvent('alert', $res);
    }

    public function deleteSelected()
    {
        $res = error('Please select row');
        if ($this->selectedRowsQuery->count() > 0) {
            $this->selectedRowsQuery->delete();
            $res = success('Category deleted successfully.');
        }
        $this->dispatchBrowserEvent('alert', $res);
    }

    public function updateStatus($id)
    {
        $category = Category::where('id', $id)->select('id', 'name', 'alias', 'status', 'created_at')->first();
        $category->update(['status' => !$category->status]);
        $res = success('Category status changed successfully.');
        $this->dispatchBrowserEvent('alert', $res);
    }

    public function query(): Builder
    {
        return Category::select('id', 'name', 'alias', 'created_at', 'status')->latest();
    }

    public function refresh()
    {
        $this->emit('refreshDatatable');
    }
}
