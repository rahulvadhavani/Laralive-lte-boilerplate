<div>
    @livewire('admin.breadcrumb',['page' => $page])
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">{{$title}}</h3>
                        </div>
                        <div class="card-body">
                            <form wire:submit.prevent="saveData" class="form-horizontal">
                                <div>
                                    <input type="hidden" wire:model.lazy="slug">
                                    <div class="form-group row">
                                        <div class="w-100" wire:ignore>
                                            <div class="form-group mt-3" wire:ignore>
                                                <label><b>Content :</b><span class="text-danger">*</span></label>
                                                <textarea wire:ignore.self wire:model.lazy="content_data" class="form-contro" id="content_data">{{$content_data}}</textarea>
                                            </div>
                                        </div>
                                        <div>
                                            @error('content_data') <span class="error text-danger err_margin">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@push('css')
<style>
    .ck-editor__editable {
        min-height: 400px !important;
        max-width: 100% !important;
    }

    .preview_image {
        height: 70px;
    }
</style>
@endpush

@push('script')
<script src="{{asset('assets/js/ckeditor.js')}}"></script>
<script>
    let modaleditor;
    ClassicEditor
        .create(document.querySelector('#content_data'), {
            ckfinder: {
                uploadUrl: '{{route("ck-image-upload")}}',

            }
        })
        .then(editor => {
            modaleditor = editor;
            editor.model.document.on('change:data', () => {
                @this.set('content_data', editor.getData());
            })
        })
        .catch(error => {
            console.error(error);
        });
</script>
@endpush