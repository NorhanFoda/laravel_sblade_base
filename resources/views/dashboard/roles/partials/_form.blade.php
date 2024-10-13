<div class="row">
    <x-form.input 
        class="col-md-12" 
        label="Name" 
        name="name" 
        type="text"
        value="{{ isset($model) ? $model->name : null }}" 
        :required="true" 
        :errors="$errors"
        :disabled="request()->routeIs('roles.show')" />
    <x-roles.permissions-card :systemPermissions="$data['permissions']" :rolePermissions="isset($model) ? $model->permissions : null" />
</div>