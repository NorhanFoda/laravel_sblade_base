<div class="row">
    <div class="col-md-6 mb-3 bm-3">
        <x-form.input label="Name" name="name" type="text"
            value="{{ isset($model) ? $model->name : null }}" :required="true" :errors="$errors" />
    </div>
    <div class="col-md-6 mb-3 bm-3">
        <x-form.input label="Email" name="email" type="email"
            value="{{ isset($model) ? $model->email : null }}" :required="true" :errors="$errors" />
    </div>
    <div class="col-md-6 mb-3 bm-3">
        <x-form.input label="Password" name="password" type="password" :required="true"
            :errors="$errors" />
    </div>
    <div class="col-md-6 mb-3 bm-3">
        <x-form.input label="Password Confirmation" name="password_confirmation" type="password"
            :required="true" :errors="$errors" />
    </div>
    <div class="col-md-6 mb-3 bm-3">
        <x-form.select name="role_id" :options="$data['roles']" :required="true" :errors="$errors" 
        :selected="isset($model) ? $model->role_id : null"/>
    </div>
</div>