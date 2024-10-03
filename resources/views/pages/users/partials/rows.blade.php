@foreach ($models as $model)
    <tr>
        <td>{{$model->name}}</td>
        <td>{{$model->email}}</td>
    </tr>
@endforeach
