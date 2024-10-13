<table class="table align-items-center mb-0 table-striped" id="dataTable">
    <thead class="thead-dark">
    <tr>
        <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">
            #
        </th>
        <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">
            Author
        </th>
        <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center ps-2">
            Function
        </th>
        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder text-center">
            Status
        </th>
        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder text-center">
            Employed
        </th>
        <th class="text-secondary text-center"></th>
    </tr>
    </thead>
    <tbody>
    @foreach ($models as $model)
        <tr>
            <td class="align-middle text-center text-sm">
                {{ $loop->iteration }}
            </td>
            <td>
                <div class="d-flex px-2 py-1">
                    <div>
                        <img src="{{ asset('UI/assets/v1/img/team-2.jpg') }}"
                             class="avatar avatar-sm me-3 border-radius-lg" alt="user1"/>
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
                <div class="d-flex align-items-center">
                    @can('update-user')
                        <div class="me-3">
                            <x-table.edit-btn :label="__('messages.table.actions.edit')"
                                              :href="route('users.edit', ['user' => $model])"/>
                        </div>
                    @endcan
                    @can('delete-user')
                        <div>
                            <x-table.delete-btn :label="__('messages.table.actions.delete')" :id="$model->id"
                                                :action="route('users.destroy', $model)"
                                                :redirect="route('users.index')"/>
                        </div>
                    @endcan
                </div>
            </td>
        </tr>
    @endforeach

    </tbody>
</table>
