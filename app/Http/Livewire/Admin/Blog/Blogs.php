<?php

namespace App\Http\Livewire\Admin\Blog;

use Livewire\Component;
use App\Models\Category;
use App\Models\Blog;
use Livewire\WithFileUploads;


class Blogs extends Component
{
    use WithFileUploads;
    public $page = 'Blogs';
    public function render()
    {
        return view('livewire.admin.blog.blogs');
    }

    public $title, $slug, $category_id, $subtitle, $image_thumbnail, $status,
        $blog_id, $seo_title, $meta_description, $tags, $blog_body,
        $modalData, $modalStatus, $categories, $image, $tagsArr;

    public $curPage = 'Blog';
    public $recordId = 0;

    public function mount()
    {
        $this->categories = Category::getCategories();
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
        $customRule = $this->recordId == 0 ? 'required' : 'required|exists:blogs,id';
        $arr = [
            'recordId' => $customRule,
            'title' => 'required|max:255',
            'slug' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'subtitle' => 'nullable|max:5000',
            'image_thumbnail' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'seo_title' => 'nullable|max:255',
            'meta_description' => 'nullable|max:255',
            'tags' => 'required',
            'blog_body' => 'required',
        ];
        return $arr;
    }

    protected $listeners = ['view', 'edit'];


    public function view($id)
    {
        $blog = Blog::with([
            'blogcontent' => function ($query) {
                $query->select('id', 'blog_id', 'seo_title', 'meta_description', 'blog_body', 'tags');
            },
            'user' => function ($query) {
                $query->select('id', 'first_name', 'last_name', 'image');
            },
            'category' => function ($query) {
                $query->select('id', 'name', 'alias');
            }
        ])->where('id', $id)
            ->select('id', 'category_id', 'user_id', 'title', 'slug', 'subtitle', 'image_thumbnail', 'status', 'created_at')
            ->first();
        if ($blog == null) {
            $this->dispatchBrowserEvent('alert', error('Blog not found'));
            return;
        }
        $this->modalData = $blog;
        $this->modalStatus = $blog->status;
        $this->dispatchBrowserEvent('viewModal');
    }

    public function edit($id)
    {
        $blog = Blog::with('blogcontent')->where('id', $id)->select('*')->first();
        if ($blog == null) {
            $this->dispatchBrowserEvent('alert', error('Blog not found'));
            return;
        }
        $this->recordId = $id;
        $this->title = $blog->title;
        $this->slug = $blog->slug;
        $this->category_id = $blog->category_id;
        $this->subtitle = $blog->subtitle;
        $this->image = $blog->image_thumbnail;
        $this->seo_title = $blog->blogcontent->seo_title;
        $this->meta_description = $blog->blogcontent->meta_description;
        $this->tagsArr = $blog->blogcontent->tags;
        $this->tags = implode(',', $blog->blogcontent->tags);
        $this->blog_body = $blog->blogcontent->blog_body;
        $this->dispatchBrowserEvent('addUpdateModal');
    }


    public function viewAddModal()
    {
        $this->recordId = 0;
        $this->name = '';
        $this->reset(['blog_body', 'tags', 'meta_description', 'seo_title', 'image_thumbnail', 'subtitle', 'category_id', 'slug', 'title']);
        $this->dispatchBrowserEvent('addUpdateModal');
    }

    public function submit()
    {
        $param = $this->validate();
        $user_id = auth()->user()->id;
        $param['user_id'] = $user_id;
        if ($param['image_thumbnail'] == null) {
            unset($param['image_thumbnail']);
        }
        $blog = Blog::where('id', $param['recordId'])->first();
        $param = (object) $param;
        $blogContent = ['blog_body' => $param->blog_body, 'meta_description' => $param->meta_description, 'seo_title' => $param->seo_title, 'tags' => $param->tags];
        if ($blog) {
            if (isset($param->image_thumbnail) && $param->image_thumbnail != null) {
                $img = basename($blog->image_thumbnail);
                $param->image_thumbnail = $this->image_thumbnail->storeAs('blogs/image_thumbnail', $img, 'userPublic');
            }
            $blogContent['blog_id'] = $blog->id;
            $blog->update((array) $param);
            $blog->blogContent->create($blogContent);
        } else {
            if ($param->image_thumbnail != null) {
                $param->image_thumbnail = $this->image_thumbnail->store('blogs/image_thumbnail', 'userPublic');
            }
            $param->status = 1;
            $blog = Blog::create((array)$param);
            $blogContent['blog_id'] = $blog->id;
            $blog->blogContent()->create($blogContent);
        }
        $res = $param->recordId != 0 ? success('Blog Updated successfully.') : success('Blog added successfully.');
        $this->dispatchBrowserEvent('close-modal');
        $this->refreshData();
        $this->recordId = 0;
        $this->category_id = null;
        $this->categories = Category::getCategories();
        $this->reset(['blog_body', 'tags', 'meta_description', 'seo_title', 'image_thumbnail', 'subtitle', 'category_id', 'slug', 'title']);
        $this->dispatchBrowserEvent('alert', $res);
    }

    public function updateSlag()
    {
        $this->slug = \Str::slug($this->title);
    }

    public function refreshData()
    {
        $this->emit('refresh');
    }
}
