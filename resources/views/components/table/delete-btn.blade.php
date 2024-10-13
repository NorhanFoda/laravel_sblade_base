<form method="POST" action="{{ $action ?? '#' }}" id="deleteForm-{{ $id }}" style="display: inline;" data-redirect="{{ $redirect }}">
    @csrf
    @method('DELETE')

    <div class="d-inline">
        <a href="#" 
            class="text-secondary font-weight-bold text-xs text-danger" 
            data-toggle="tooltip"
            data-original-title="Delete user"
            data-bs-toggle="modal"
            data-bs-target="#modal-notification-{{ $id }}">
            {{ $label ?? 'Delete' }}
        </a>
    </div>
</form>

<x-confirm
    :id="$id" 
    :title="__('confirm_modal.delete.title')"
    :content="__('confirm_modal.delete.message')"
    :formId="'deleteForm-'.$id"/>
