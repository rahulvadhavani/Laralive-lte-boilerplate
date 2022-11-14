<div wire:ignore.self class="modal fade" id="pageModal" tabindex="-1" role="dialog" aria-labelledby="pageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
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
            <div class="col-md-12 col-sm-12">
              <div class="form-group">
                <label> {{$curPage}}</label>
                <input type="hidden" wire:model.lazy="recordId">
                <input type="text" wire:model.lazy="name" placeholder="name" class="form-control dark-from">
                @error('name') <span class="error text-danger err_margin">{{ $message }}</span> @enderror
                @error('recordId') <span class="error text-danger err_margin">{{ $message }}</span> @enderror
              </div>
            </div>
          </div>
      </div>
      <div class="modal-footer card-header">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">@if($recordId == 0) Submit @else Update @endif</button>
      </div>
      </form>
    </div>
  </div>
</div>

<div wire:ignore.self class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="pageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content card" wire:ignore.self class="modal fade">
      <div class="modal-header card-header">
        <h5 class="modal-title card-title" id="pageModalLabel">{{$curPage}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row clearfix">
          @if(isset($modalData) && $modalData != null)
          <div class="col-md-12 col-sm-12">
            <div class="form-group">
              <b>Name </b> :
              <label id="detail_name">{{$modalData->name}}</label>
            </div>
            <div class="form-group">
              <b>Alias </b> :
              <label id="detail_name">{{$modalData->alias}}</label>
            </div>
            <div class="form-group">
              <b>Created at </b> :
              <label id="detail_name">{{$modalData->created_at}}</label>
            </div>
            <div class="form-group">
              <b>Status </b> :
              <label id="detail_name">@if($modalData->status == 1 ) <span class="badge badge-success">Active</span> @else <span class="badge badge-danger">Inactive</span> @endif</label>
            </div>
          </div>
          @endif
        </div>
      </div>
      <div class="modal-footer card-header">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<button type="button" class="btn btn-primary AddModalBtn" wire:click="viewAddModal()"><i class="fa fa-plus fa2"></i></button>