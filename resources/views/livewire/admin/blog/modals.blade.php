<div wire:ignore.self class="modal fade" id="pageModal" tabindex="-1" role="dialog" aria-labelledby="pageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
    <div class="modal-content card" wire:ignore.self class="modal fade">
      <div class="modal-header card-header">
        <h5 class="modal-title" id="pageModalLabel">@if($recordId == 0) Create @else Update @endif {{$curPage}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="card-body">
        <div class="modal-body">
          <div class="">
            <div class="row clearfix">
              <div class="col-md-6 col-sm-12">
                <div class="form-group">
                  <label><b> Title</b></label>
                  <input type="hidden" wire:model.lazy="recordId">
                  <input wire:keydown="updateSlag" wire:model="title" type="text" class="form-control">
                  @error('title') <span class="error text-danger err_margin">{{ $message }}</span> @enderror
                </div>
              </div>
              <div class="col-md-6 col-sm-12">
                <div class="form-group">
                  <label><b> Slug</b></label>
                  <input wire:model="slug" type="text" class="form-control">
                  @error('slug') <span class="error text-danger err_margin">{{ $message }}</span> @enderror
                </div>
              </div>
              <div class="col-md-6 col-sm-12">
                <div class="form-group">
                  <label><b> Subtitle</b></label>
                  <input wire:model.lazy="subtitle" type="text" class="form-control">
                  @error('subtitle') <span class="error text-danger err_margin">{{ $message }}</span> @enderror
                </div>
              </div>
              <div class="col-md-6 col-sm-12">
                <div class="form-group">
                  <label><b> Seo title</b></label>
                  <input wire:model.lazy="seo_title" type="text" class="form-control">
                  @error('seo_title') <span class="error text-danger err_margin">{{ $message }}</span> @enderror
                </div>
              </div>
              <div class="col-md-3 col-sm-12">
                <label><b> Category</b></label>
                <select wire:model.lazy="category_id" class="form-control show-tick">
                  <option selected>-- category --</option>
                  @forelse($categories as $category)
                  <option value="{{$category['id']}}">{{$category['name']}}</option>
                  @empty
                  <option>-no record found-</option>
                  @endforelse
                </select>
                @error('category_id') <span class="error text-danger err_margin">{{ $message }}</span> @enderror
              </div>
              <div class="form-group col-md-6 col-sm-12">
                <label><b>Image</b></label>
                <div class="custom-file">
                  <input wire:model.lazy="image_thumbnail" type="file" class="form-control custom-file-input" id="customFile" onchange="loadFile(event)">
                  <label class="custom-file-label" for="customFile">Choose file</label>
                </div>
                @error('image_thumbnail') <span class="error text-danger err_margin">{{ $message }}</span> @enderror
              </div>
              <div class="form-group col-md-3 col-sm-12 mt-1">
                @if ($image_thumbnail)
                <img class="preview_image" id="preview_image" src="{{ $image_thumbnail->temporaryUrl() }}">
                @elseif($recordId > 0)
                <img class="preview_image" src="{{ $image }}">
                @endif
              </div>
              <div class="form-group col-sm-12" wire:ignore>
                <label for="">Tags</label>
                <div class="bs-example" wire:ignore.self>
                  <input wire:ignore type="hidden" wire:model.lazy="tags">
                  <input type="text" class="form-control" data-role="tagsinput" id="tagPlaces">
                </div>
              </div>
              <div class="form-group col-sm-12">
                @error('tags') <span class="error text-danger err_margin">{{ $message }}</span> @enderror
              </div>
              <div class="col-sm-12">
                <div class="form-group mt-3">
                  <label><b> Meta description</b></label>
                  <textarea wire:model.lazy="meta_description" rows="2" class="form-control no-resize" placeholder="Please type what you want..."></textarea>
                  @error('meta_description') <span class="error text-danger err_margin">{{ $message }}</span> @enderror
                </div>
              </div>
              <div style="width: 99%;" class="" wire:ignore>
                <div class="form-group mt-3" wire:ignore>
                  <label><b> Blog Content</b></label>
                  <textarea wire:ignore.self wire:model.lazy="blog_body" class="form-control required" name="blog_body" id="blog_body"></textarea>
                </div>
                <div>
                  @error('blog_body') <span class="error text-danger err_margin">{{ $message }}</span> @enderror
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer card-header">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" wire:click.prevent="submit">@if($recordId == 0) Submit @else Update @endif</button>
        </div>
      </div>
    </div>
  </div>
</div>

<div wire:ignore.self class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="pageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
    <div class="modal-content card" wire:ignore.self class="modal fade">
      <div class="modal-header card-header">
        <h5 class="modal-title card-title" id="pageModalLabel">{{$curPage}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!--  -->
        @if(isset($modalData) && $modalData != null)
        <div class="container-fluid">
          <div class="row clearfix">
            <div class="col-lg-4 col-md-12">
              @if($blog_image??true)
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">{{$curPage}} Image</h3>
                </div>
                <div class="card-body">
                  <img class="rounded w-100" src="{{$modalData->image_thumbnail ?? ''}}" alt="">
                </div>
              </div>
              @endif
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">{{$curPage}} Detail</h3>
                </div>
                <div class="card-body">
                  <ul class="list-group">
                    <li class="list-group-item">
                      <small class="text-muted">Title: </small>
                      <p class="mb-0">{{$modalData->title ?? '-'}}</p>
                    </li>
                    <li class="list-group-item">
                      <small class="text-muted">Slug: </small>
                      <p class="mb-0">{{$modalData->slug ?? '-'}}</p>
                    </li>
                    <li class="list-group-item">
                      <small class="text-muted">Subtitle: </small>
                      <p class="mb-0">{{$modalData->subtitle ?? '-'}}</p>
                    </li>
                    <li class="list-group-item">
                      <small class="text-muted">Seo title: </small>
                      <p class="mb-0">{{$modalData->blogcontent->seo_title ?? '-'}}</p>
                    </li>
                    <li class="list-group-item">
                      <small class="text-muted">Category: </small>
                      <p class="mb-0">{{$modalData->category->name ?? '-'}}</p>
                    </li>
                    <li class="list-group-item">
                      <small class="text-muted">Meta description: </small>
                      <p class="mb-0">{{$modalData->blogcontent->meta_description ?? '-'}}</p>
                    </li>
                    <li class="list-group-item">
                      <small class="text-muted">Created By: </small>
                      <p class="mb-0">{{$modalData->user->fullname ?? '-'}}</p>
                    </li>
                    <li class="list-group-item">
                      <small class="text-muted">Created On: </small>
                      <p class="mb-0">{{$modalData->created_at ?? '-'}}</p>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Tags</h3>
                </div>
                <div class="card-body">
                  @forelse($modalData->blogcontent->tags as $tag)
                  <div class="chip mt-2">
                    <i class="fa fa-hashtag"></i>{{$tag}}
                  </div>
                  @empty
                  <small>No Tags</small>
                  @endforelse
                </div>
              </div>
            </div>
            <div class="col-lg-8 col-md-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Blog Content</h3>
                </div>
                <div class="card-body" style="max-height: 800px; overflow:scroll">
                  {!!$modalData->blogcontent->blog_body!!}
                </div>
              </div>
            </div>
          </div>
        </div>
        @endif

        <!--  -->
      </div>
      <div class="modal-footer card-header">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<button type="button" class="btn btn-primary AddModalBtn" wire:click="viewAddModal()"><i class="fa fa-plus fa2"></i></button>

@push('css')
<link rel="stylesheet" href="{{asset('plugins/tag-input/taginput.css')}}" />
<style>
  .ck-editor__editable {
    min-height: 200px !important;
    max-width: 100% !important;
  }

  .preview_image {
    height: 70px;
  }

  .bootstrap-tagsinput {
    width: 100%;
  }

  .bootstrap-tagsinput .tag {
    margin-right: 2px;
    color: #ffffff;
    background-color: #e74c3e;
    padding: 2px 4px;
    border-radius: 3px;

  }
</style>
@endpush
@push('script')
<script src="{{asset('assets/js/ckeditor.js')}}"></script>
<script src="{{asset('plugins/tag-input/taginput.js')}}"></script>
<script>
  let modaleditor;
  ClassicEditor
    .create(document.querySelector('#blog_body'), {
      ckfinder: {
        uploadUrl: '{{route("ck-image-upload")}}',

      }
    })
    .then(editor => {
      modaleditor = editor;
      editor.model.document.on('change:data', () => {
        @this.set('blog_body', editor.getData());
      })
    })
    .catch(error => {
      console.error(error);
    });


  $('#tagPlaces').on('itemAdded', function(event) {
    let tagVal = $("#tagPlaces").val();
    @this.set('tags', tagVal);
  });

  $('#tagPlaces').on('itemRemoved', function(event) {
    let tagVal = $("#tagPlaces").val();
    @this.set('tags', tagVal);
  });

  window.addEventListener('addUpdateModal', event => {
    let recordId = @this.get('recordId');
    if (recordId > 0) {
      @this.get('tagsArr').map(function(val) {
        $("#tagPlaces").tagsinput('add', val);
      });
      modaleditor.setData(@this.get('blog_body'));
    } else {
      $("#tagPlaces").tagsinput('removeAll');
      $('#preview_image').attr('src', "").hide();
      modaleditor.setData('');
    }
    $("#pageModal").modal('show');
  })
</script>
@endpush