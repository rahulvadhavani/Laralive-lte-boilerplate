<?php

namespace App\Http\Livewire\Admin;

use App\Models\StaticPage as ModelsStaticPage;
use Livewire\Component;

class StaticPage extends Component
{
    public $title, $slug, $content_data = '';
    public $page = 'Static Page';

    public function mount()
    {
        $this->slug = request()->slug;
        $this->title = ModelsStaticPage::PAGES[$this->slug];
        $arr = array_keys(ModelsStaticPage::PAGES);
        if (!in_array($this->slug, $arr)) {
            abort('404');
        }
        $page = ModelsStaticPage::where('slug', $this->slug)->first();
        if ($page) {
            $this->title = $page->title;
            $this->content_data = $page->content_data;
        }
    }
    public function render()
    {
        return view('livewire.admin.static-page');
    }

    protected $rules = [
        'slug' => 'required|max:50|in:about-us,terms-condition,privacy-policy',
        'content_data' =>  'required|min:3',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function saveData()
    {
        $validatedData = $this->validate();
        try {
            $validatedData['title'] = ModelsStaticPage::PAGES[$this->slug];
            ModelsStaticPage::updateOrCreate(['slug' => $validatedData['slug']], $validatedData);
            $res = success($validatedData['title'] . ' updated successfully.');
        } catch (\Throwable $th) {
            $res = error('Something went wrong!!');
            $this->dispatchBrowserEvent('alert', $res);
        }
        $this->dispatchBrowserEvent('alert', $res);
    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
