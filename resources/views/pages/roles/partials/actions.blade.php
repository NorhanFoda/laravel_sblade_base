<div class="d-flex align-items-center">
    @can('read-role')
        <div class="me-3">
            <x-table.edit-btn :label="__('app.table.actions.view')" :href="route('roles.show', ['role' => $model])" />
        </div>
    @endcan
    @can('update-role')
        <div class="me-3">
            <x-table.edit-btn :label="__('app.table.actions.edit')" :href="route('roles.edit', ['role' => $model])" />
        </div>    
    @endcan
    @can('delete-role')
        <div>
            <x-table.delete-btn :label="__('app.table.actions.delete')" :id="$model->id" :action="route('roles.destroy', $model)"
                :redirect="route('roles.index')" />
        </div>
    @endcan
</div>
