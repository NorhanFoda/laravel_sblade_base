@foreach ($models as $model)
<tr>
    <td class="align-middle text-center">
        <span class="text-secondary text-xs font-weight-bold">{{ $model->id }}</span>
    </td>
    <td class="align-middle text-center">
        <span class="text-secondary text-xs font-weight-bold">{{ $model->name }}</span>
    </td>
    <td class="align-middle">
        @include('pages.roles.partials.actions')
    </td>
</tr>
@endforeach
