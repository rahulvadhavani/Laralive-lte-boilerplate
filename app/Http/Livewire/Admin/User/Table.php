<?php

namespace App\Http\Livewire\Admin\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\ImageColumn;


class Table extends DataTableComponent
{
    public $curPage = 'User';
    public bool $responsive = true;
    protected $listeners = ['deleteRecrod', 'refresh','delete'];
    public array $bulkActions = [
        'deleteSelected' => 'Delete',
    ];
   


    public function mount()
    {
        $this->resetPage();
        $this->clearSorts();
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setColumnSelectStatus(false);
        $this->setSingleSortingStatus(false);
    }


    public function columns(): array
    {
        return [
            Column::make('ID','id')
                ->hideIf(true),
            ImageColumn::make('Avatar','image')
            ->location(
                fn($row) => $row->image
            )->attributes(fn($row) => [
                'class' => 'img-circle img-bordered-sm',
                'alt' => $row->first_name . ' Avatar',
                'width' => 30,
                'height' => 30
            ]),
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
            Column::make('Status','status')
                ->sortable()
                ->format(function ($value, $row) {
                    $statusActive = $value == 1 ? 'checked' : '';
                    $switchId = "customSwitch" . $row->id;
                    return '<div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input"' . $statusActive . ' id="' . $switchId . '" wire:click="updateStatus(' . $row->id . ',' . $value . ')">
                    <label class="custom-control-label" for="' . $switchId . '"></label>
                    </div>';
                })
                ->html(),
             Column::make('Actions')
                ->label(
                    function($row, Column $column){
                        $row = (object)['id' => $row->id];
                        $action = ['show', 'edit', 'delete'];
                        $component = "admin.user.users";
                        return view('livewire.admin.common.actions', compact('row', 'action', 'component'));
                    }
                )
                ->unclickable(),
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
        if ($this->getSelectedCount() > 0) {
            User::userRole()->whereIn('id', $this->getSelected())->delete();
            $this->clearSelected();
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

    public function builder(): Builder
    {
        return User::select('id','last_name', 'email', 'image', 'created_at', 'status')
        ->when(empty($this->sorts),function($query){
            $query->latest();
        });
    }
    
    public function refresh()
    {
        $this->emit('refreshDatatable');
    }
}