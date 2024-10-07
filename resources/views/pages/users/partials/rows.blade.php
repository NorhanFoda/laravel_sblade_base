@foreach ($models as $model)
<tr>
    <td>
        <div class="d-flex px-2 py-1">
            <div>
                <img src="{{asset('UI/assets/v1/img/team-2.jpg')}}" class="avatar avatar-sm me-3 border-radius-lg" alt="user1" />
            </div>
            <div class="d-flex flex-column justify-content-center">
                <h6 class="mb-0 text-sm">{{ $model->name }}</h6>
                <p class="text-xs text-secondary mb-0">
                    {{ $model->email }}
                </p>
            </div>
        </div>
    </td>
    <td>
        <p class="text-xs font-weight-bold mb-0">Manager</p>
        <p class="text-xs text-secondary mb-0">
            Organization
        </p>
    </td>
    <td class="align-middle text-center text-sm">
        <span class="badge badge-sm bg-gradient-success">Online</span>
    </td>
    <td class="align-middle text-center">
        <span class="text-secondary text-xs font-weight-bold">23/04/18</span>
    </td>
    <td class="align-middle">
        <a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip"
            data-original-title="Edit user">
            Edit
        </a>
    </td>
</tr>
@endforeach
