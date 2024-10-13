<table class="table align-items-center mb-0 table-striped" id="dataTable">
    <thead class="thead-dark">
    <tr>
        <th class="text-uppercase text-secondary font-weight-bolder text-center">
           #
        </th>
        <th class="text-uppercase text-secondary font-weight-bolder ps-2 text-center">
            {{ __('messages.table.header.role') }}
        </th>
        <th class="text-secondary text-center"></th>
    </tr>
    </thead>
    <tbody>
    @foreach ($models as $model)
        <tr>
            <td class="align-middle text-center">
                <span class="text-secondary font-weight-bold">{{ $loop->iteration }}</span>
            </td>
            <td class="align-middle text-center">
                <span class="text-secondary font-weight-bold">{{ $model->name }}</span>
            </td>
            <td class="align-middle">
                <div class="d-flex align-items-center">
                    @can('read-role')
                        <div class="me-3">
                            <x-table.edit-btn :label="__('messages.table.actions.view')"
                                              :href="route('roles.show', ['role' => $model])"/>
                        </div>
                    @endcan
                    @can('update-role')
                        <div class="me-3">
                            <x-table.edit-btn :label="__('messages.table.actions.edit')"
                                              :href="route('roles.edit', ['role' => $model])"/>
                        </div>
                    @endcan
                    @can('delete-role')
                        <div>
                            <x-table.delete-btn :label="__('messages.table.actions.delete')" :id="$model->id"
                                                :action="route('roles.destroy', $model)"
                                                :redirect="route('roles.index')"/>
                        </div>
                    @endcan
                </div>

            </td>
        </tr>
    @endforeach

    </tbody>
</table>
