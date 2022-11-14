<?php

namespace App\Http\Livewire\Admin\Blog;

use App\Models\Category;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class Table extends DataTableComponent
{

    public $name, $categories, $category_id;
    public $curPage = 'Blogs';
    public $recordId = 0;
    public bool $responsive = true;
    protected $listeners = ['deleteRecrod', 'refresh'];
    public array $bulkActions = [
        'deleteSelected' => 'Delete',
    ];
    public bool $singleColumnSorting = true;

    public function columns(): array
    {
        return [
            Column::make('Title')
                ->sortable()
                ->searchable(),
            Column::make('Category', 'category.name')
                ->searchable()
                ->sortable(function (Builder $query, $direction) {
                    return $query->orderBy(Category::select('name')->whereColumn('blogs.category_id', 'categories.id'), $direction);
                }),
            Column::make('User', 'user.full_name')
                // ->searchable()
                ->sortable(function (Builder $query, $direction) {
                    return $query->orderBy(User::select('first_name')->whereColumn('blogs.user_id', 'users.first_name'), $direction);
                }),
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
                    $component = "admin.blog.blogs";
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
        $Blog = Blog::where('id', $id)->first();
        if ($Blog == null) {
            $res = error('Blog not found.');
        } else {
            $res = success('Blog deleted successfully.');
            $Blog->delete();
        }
        $this->dispatchBrowserEvent('alert', $res);
    }

    public function deleteSelected()
    {
        $res = error('Please select row');
        if ($this->selectedRowsQuery->count() > 0) {
            $this->selectedRowsQuery->delete();
            $res = success('Blogs deleted successfully.');
        }
        $this->dispatchBrowserEvent('alert', $res);
    }

    public function updateStatus($id)
    {
        $Blog = Blog::where('id', $id)->first();
        $Blog->update(['status' => !$Blog->status]);
        $res = success('Blog status changed successfully.');
        $this->dispatchBrowserEvent('alert', $res);
    }

    public function query(): Builder
    {
        return Blog::with([
            'category' => function ($query) {
                $query->select('id', 'name');
            },
            'user' => function ($query) {
                $query->select('id', 'first_name', 'last_name');
            },
        ])
            ->select('*')
            ->latest();
    }

    public function refresh()
    {
        $this->emit('refreshDatatable');
    }
}
