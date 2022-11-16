<div wire:ignore.self class="modal fade" id="pageModal" tabindex="-1" role="dialog" aria-labelledby="pageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content card" wire:ignore.self class="modal fade">
      <div class="modal-header card-header">
        <h5 class="modal-title card-title" id="pageModalLabel">@if($recordId == 0) Create @else Update @endif {{$curPage}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="card-body" wire:submit.prevent="submit" method="POST">
          <div class="row clearfix">
            @if($recordId > 0)
            <div class="form-group col-md-12">
              <div class="callout callout-info">
                <h5><i class="icon fas fa-info"></i> Note :</h5>
                <p>Leave <b>Password</b> and <b>Confirm Password</b> empty, if you are not going to change the password.</p>
              </div>
            </div>
            @endif
            <div class="col-md-6 col-sm-12">
              <div class="form-group">
                <label for="first_name">First Name <span class="text-danger">*</span></label>
                <input type="hidden" wire:model.lazy="recordId">
                <input id="first_name" wire:model.lazy="first_name" type="text" placeholder="First Name" class="form-control">
                @error('first_name') <span class="error text-danger err_margin">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col-md-6 col-sm-12">
              <div class="form-group">
                <label for="last_name">Last Name <span class="text-danger">*</span></label>
                <input id="last_name" wire:model.lazy="last_name" type="text" placeholder="Last Name" class="form-control">
                @error('last_name') <span class="error text-danger err_margin">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col-md-12 col-sm-12">
              <div class="form-group">
                <label for="email">Email <span class="text-danger">*</span></label>
                <input id="email" wire:model.lazy="email" type="text" placeholder="Email" class="form-control">
                @error('email') <span class="error text-danger err_margin">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col-md-6 col-sm-12">
              <div class="form-group">
                <label for="password">Password <span class="text-danger">*</span></label>
                <input id="password" wire:model.lazy="password" type="password" placeholder="Password" class="form-control">
                @error('password') <span class="error text-danger err_margin">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="col-md-6 col-sm-12">
              <div class="form-group">
                <label for="password_confirmation">Confirm Password <span class="text-danger">*</span></label>
                <input id="password_confirmation" wire:model.lazy="password_confirmation" type="password" placeholder="Confirm Password" class="form-control">
                @error('password_confirmation') <span class="error text-danger err_margin">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="form-group col-md-6 col-sm-12">
              <label>Image</label>
              <div class="custom-file">
                <input wire:model.lazy.lazy="image" type="file" class="form-control custom-file-input" id="customFile" onchange="loadFile(event)">
                <label class="custom-file-label" for="customFile">Choose file</label>
              </div>
              @error('image') <span class="error text-danger err_margin">{{ $message }}</span> @enderror
            </div>
            <div class="form-group col-md-3 col-sm-12 mt-1">
              @if ($image)
              <img class="preview_image" id="preview_image" src="{{ $image->temporaryUrl() }}">
              @elseif($recordId > 0)
              <img class="preview_image" src="{{ $myimage }}">
              @endif
            </div>
          </div>
      </div>
      <div class="modal-footer card-header">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" wire:loading.attr="disabled" wire:target="submit" class="btn btn-primary">@if($recordId == 0) Submit @else Update @endif <span  wire:loading wire:target="submit"><i class="fa-solid fa-circle-notch fa-spin"></i></span></button>
      </div>
      </form>
    </div>
  </div>
</div>

<div wire:ignore.self class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="pageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content card" wire:ignore.self class="modal fade">
      <div class="modal-header card-header">
        <h5 class="modal-title card-title" id="pageModalLabel">{{$curPage}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        @if(isset($modalData) && $modalData != null)
        <div class="card-body" id="modal_body_part">
          <div class="row">
            <div class="col-12">
              <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                  <div class="text-center">
                    <img id="info_image" class="profile-user-img img-fluid img-circle" src="{{$modalData->image}}" alt="User profile picture">
                  </div>
                  <h3 class="profile-username text-center" id="info_name">{{$modalData->email}}</h3>
                  <div class="row">
                    <div class="col-md-6">
                      <label class="col-form-label"><b>First Name</b></label><br>
                      <p>{{$modalData->first_name}}</p>
                    </div>
                    <div class="col-md-6">
                      <label class="col-form-label"><b>Last Name</b></label><br>
                      <p>{{$modalData->last_name}}</p>
                    </div>
                    <div class="col-md-6">
                      <label class="col-form-label"><b>Email</b></label><br>
                      <p>{{$modalData->email}}</p>
                    </div>
                    <div class="col-md-6">
                      <label class="col-form-label"><b>Created at</b></label><br>
                      <p>{{$modalData->created_at}}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        @endif
      </div>
      <div class="modal-footer card-header">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<button type="button" class="btn btn-primary AddModalBtn" wire:click="viewAddModal()"><i class="fa fa-plus fa2"></i></button>
@push('css')
<style>
  .preview_image {
    height: 70px;
  }
</style>
@endpush
@push('script')
<script>
  window.addEventListener('addUpdateModal', event => {
    let recordId = @this.get('recordId');
    $('#preview_image').attr('src', "").hide();
    $("#pageModal").modal('show');
  })
</script>
@endpush