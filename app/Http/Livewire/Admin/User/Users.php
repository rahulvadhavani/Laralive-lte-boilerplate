<?php

namespace App\Http\Livewire\Admin\User;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Livewire\WithFileUploads;

class Users extends Component
{

    use WithFileUploads;
    public $page = 'Users';
    public $first_name,$created_at, $last_name, $image, $email, $modalStatus, $password, $password_confirmation, $myimage;
    public $curPage = 'User';
    public $recordId = 0;
    public function render()
    {
        return view('livewire.admin.user.users');
    }

    public function mount()
    {
    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }


    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    protected function rules()
    {
        $customRule = $this->recordId == 0 ? 'required' : 'required|exists:users,id';
        $rules = [
            'recordId' => $customRule,
            'email' => ['required', 'email', 'max:255'],
            'first_name' => ['required', 'min:2', 'max:100'],
            'last_name' => ['required', 'min:2', 'max:100'],
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif', 'max:1024'],
            'password' => ['required_if:recordId,=,0', 'nullable', 'min:6'],
            'password_confirmation' => ['required_if:recordId,=,0', 'nullable', 'same:password'],
        ];
        return $rules;
    }

    protected $listeners = ['view', 'edit'];


    public function view($id)
    {
        $model = User::userRole()->where('id', $id)->first();
        if ($model == null) {
            $this->dispatchBrowserEvent('alert', error('Record not found.'));
            return;
        }
        $this->recordId = $id;
        $this->first_name = $model->first_name;
        $this->last_name = $model->last_name;
        $this->email = $model->email;
        $this->myimage = $model->image;
        $this->modalStatus = $model->status;
        $this->created_at = $model->created_at;
        $this->dispatchBrowserEvent('viewModal');
    }

    public function edit($id)
    {
        $model = User::userRole()->where('id', $id)->first();
        if ($model == null) {
            $this->dispatchBrowserEvent('alert', error('Record not found.'));
            return;
        }
        $this->recordId = $id;
        $this->first_name = $model->first_name;
        $this->last_name = $model->last_name;
        $this->email = $model->email;
        $this->modalStatus = $model->modalStatus;
        $this->myimage = $model->image;
        $this->dispatchBrowserEvent('addUpdateModal');
    }


    public function viewAddModal()
    {
        $this->recordId = 0;
        $this->name = '';
        $this->reset(['first_name', 'last_name', 'image', 'email', 'modalStatus']);
        $this->dispatchBrowserEvent('addUpdateModal');
    }

    public function submit()
    {
        $validatedData = $this->validate();
        $user = User::UserRole()->where('id', $validatedData['recordId'])->first();
        unset($validatedData['password_confirmation']);
        if ($this->image != '') {
            $validatedData['image'] = $this->image->store('users', ['disk' => 'userPublic']);
            if ($user) {
                $oldImg = $user->getRawOriginal('image');
                $this->unlinkImg($oldImg);
            }
        }

        if ($user) {
            $user->update($validatedData);
            $res = success("{$this->curPage} updated successfully.");
        } else {
            User::create($validatedData);
            $res = success("{$this->curPage} User added successfully.");
        }
        $this->dispatchBrowserEvent('close-modal');
        $this->refreshData();
        $this->recordId = 0;
        $this->dispatchBrowserEvent('alert', $res);
    }

    public function refreshData()
    {
        $this->emit('refresh');
    }
}
