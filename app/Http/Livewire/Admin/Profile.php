<?php

namespace App\Http\Livewire\Admin;

use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;

class Profile extends Component
{
    use WithFileUploads;
    public $page = 'Profile';
    public $activeTab = 'profile';
    public $first_name, $last_name, $email, $password, $password_confirmation, $old_password = '';
    public $support_email, $contact, $address, $instagram, $linkedin, $twitter, $facebook, $logo_image, $logo_image_url = '';
    public $fileTitle, $fileName, $image, $userimage;

    protected function rules()
    {
        $rules = [
            'first_name' => ['required', 'min:2', 'max:100'],
            'last_name' => ['required', 'min:2', 'max:100'],
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif', 'max:1024'],
        ];
        return $rules;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function setTab($tab = 'profile')
    {
        $this->activeTab = $tab;
    }

    public function submit()
    {
        $validatedData = $this->validate();
        $user = \App\Models\User::where('id', auth()->user()->id)->first();
        unset($validatedData['image'], $validatedData['password'], $validatedData['password_confirmation'], $validatedData['old_password']);
        if ($this->image != '') {
            $validatedData['image'] = $this->image->store('users', ['disk' => 'userPublic']);
            $oldImg = $user->getRawOriginal('image');
            $this->unlinkImg($oldImg);
        }
        $user->update($validatedData);
        $res = success('Profile Updated successfully.');
        $this->dispatchBrowserEvent('alert', $res);
    }

    public function updatePassword()
    {
        $validatedData = $this->validate([
            'old_password' => ['required', function ($attribute, $value, $fail) {
                if (!Hash::check($value, Auth::user()->password)) {
                    $fail("Old password didn't match");
                }
            }],
            'password' => ['required_with:old_password', 'confirmed']
        ]);
        $user = \App\Models\User::where('id', auth()->user()->id)->first();
        $validatedData['password'] = Hash::make($validatedData['password']);
        $user->update($validatedData);
        $this->reset(['password', 'password_confirmation', 'old_password']);
        $res = success('Password reset successfully.');
        $this->dispatchBrowserEvent('alert', $res);
    }

    // 

    public function saveSetting()
    {
        $validatedData = $this->validate([
            'support_email' => 'required|email|max:100',
            'contact' => 'required|min:10|max:15',
            'address' => 'required',
            'instagram' => 'nullable|url',
            'twitter' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'facebook' => 'nullable|url',
            'logo_image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);
        foreach ($validatedData as $key => $value) {
            if ($value != '') {
                if ($key == 'logo_image' && !empty($validatedData['logo_image'])) {
                    $value = $this->logo_image->store('home/logo_image', 'userPublic');
                }
                Setting::updateOrCreate(['key' => $key], ['key' => $key, 'value' => $value]);
            }
        }
        Cache::forget('app_setting');
        Cache::rememberForever('app_setting', function () {
            return collect(Setting::get());
        });
        $res = success('Settings Updated successfully.');
        $this->dispatchBrowserEvent('alert', $res);
    }

    public function mountSetting()
    {
        $Settings = Setting::where('status', 1)->get()->pluck('value', 'key')->toArray();
        $this->support_email = $Settings['support_email'] ?? "";
        $this->contact = $Settings['contact'] ?? "";
        $this->address = $Settings['address'] ?? "";
        $this->linkedin = $Settings['linkedin'] ?? "";
        $this->twitter = $Settings['twitter'] ?? "";
        $this->instagram = $Settings['instagram'] ?? "";
        $this->facebook = $Settings['facebook'] ?? "";
        $this->logo_image_url = (isset($Settings['logo_image']) && $Settings['logo_image'] != "") ? asset('uploads/' . $Settings['logo_image']) : asset('assets/images/logo.png');
    }
    // 

    public function unlinkImg($img)
    {
        if (File::exists(public_path('uploads/users/' . $img))) {
            File::delete(public_path('uploads/users/' . $img));
        }
    }

    public function mount()
    {
        $user = \App\Models\User::where('id', auth()->user()->id)->first();
        $this->email = $user->email;
        $this->last_name = $user->last_name;
        $this->first_name = $user->first_name;
        $this->userimage = $user->image;
        $this->mountSetting();
    }

    public function render()
    {
        return view('livewire.admin.profile');
    }
}
