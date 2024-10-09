<div class="d-flex align-items-center">
    @can('update-user')
        <div class="me-3">
            <x-table.edit-btn :label="__('app.table.actions.edit')" :href="route('users.edit', ['user' => $model])" />
        </div>
    @endcan
    @can('delete-user')
        <div>
            <x-table.delete-btn :label="__('app.table.actions.delete')" :id="$model->id" :action="route('users.destroy', $model)" :redirect="route('users.index')" />
        </div>
    @endcan
</div>
