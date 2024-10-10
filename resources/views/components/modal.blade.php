<div class="modal fade" id="{{$modalId}}" tabindex="-1" role="dialog" aria-labelledby="{{$areaLabelId ?? 'exampleModelLabel'}}"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{$areaLabelId ?? 'exampleModelLabel'}}}}">{{$modalHeader ?? ''}}</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                {{$modalBody ?? ''}}
            </div>
            <div class="modal-footer">
                {{$modalFooter ?? ''}}
            </div>
        </div>
    </div>
</div>