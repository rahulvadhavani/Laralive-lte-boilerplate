<?php

namespace App\Http\Livewire\Admin\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;


class Table extends DataTableComponent
{
    public $curPage = 'User';
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
    }


    public function columns(): array
    {
        return [
            Column::make('FirstName')
                ->sortable()
                ->searchable(),
            Column::make('LastName')
                ->sortable()
                ->searchable(),
            Column::make('Email')
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
                    $component = "admin.user.users";
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
        $model = User::where('id', $id)->first();
        if ($model == null) {
            $res = error("{$this->curPage} not found.");
        } else {
            $res = success("{$this->curPage} deleted successfully.");
            $model->delete();
        }
        $this->dispatchBrowserEvent('alert', $res);
    }

    public function deleteSelected()
    {
        $res = error('Please select row');
        if ($this->selectedRowsQuery->count() > 0) {
            $this->selectedRowsQuery->delete();
            $res = success("{$this->curPage} deleted successfully.");
        }
        $this->dispatchBrowserEvent('alert', $res);
    }

    public function updateStatus($id)
    {
        $model = User::userRole()->where('id', $id)->first();
        if ($model == null) {
            $this->dispatchBrowserEvent('alert', error('Record not found.'));
            return;
        }
        $model->update(['status' => !$model->status]);
        $res = success("{$this->curPage} status changed successfully.");
        $this->dispatchBrowserEvent('alert', $res);
    }

    public function query(): Builder
    {
        return User::UserRole()
        ->select('id', 'first_name', 'last_name', 'email', 'image', 'created_at', 'status')
        ->when(empty($this->sorts),function($query){
            $query->latest();
        });
    }
    
    public function refresh()
    {
        $this->emit('refreshDatatable');
    }
}
