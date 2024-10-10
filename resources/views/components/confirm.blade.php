<div class="col-md-4">
    <div class="modal fade" id="modal-notification-{{$id}}" tabindex="-1" role="dialog" aria-labelledby="modal-notification-{{$id}}" aria-hidden="true">
      <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h6 class="modal-title font-weight-normal" id="modal-title-notification">{{__('messages.notification.header')}}</h6>
            <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="py-3 text-center">
                <i class="fa fa-bell fa-2x" aria-hidden="true"></i>
              <h4 class="text-gradient text-danger mt-4"> {{ $title ?? 'You should read this!' }} </h4>
              <p>{{ $content }}</p>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" id="confirmDelete-{{ $id }}" class="btn btn-block btn-light">
                {{ $confirmText ?? 'Ok, Got it' }}</button>
            <button type="button" class="btn btn-link text-danger ml-auto" data-bs-dismiss="modal">{{ $closeText ?? 'Close' }}</button>
          </div>
        </div>
      </div>
    </div>
  </div>