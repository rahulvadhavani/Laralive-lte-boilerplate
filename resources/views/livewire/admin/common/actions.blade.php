@if(in_array('show',$action))
<button wire:click="$emitTo('{{$component}}', 'view',{{$row->id}})" title="View" class="btn btn-dark btn-sm">
    <i class="fas fa-eye"></i>
</button>
@endif
@if(in_array('edit',$action))
<button wire:click="$emitTo('{{$component}}', 'edit',{{$row->id}})" title="Edit" class="btn btn-dark btn-sm ">
    <i class="far fa-edit"></i>
</button>
@endif
@if(in_array('delete',$action))
<button wire:click="delete({{$row->id}})" title="Delete" class="btn btn-dark btn-sm">
    <i class="far fa-trash-alt"></i>
</button>
@endif