<div class="container">
    {!! Form::model($role, ['route' => $role->id ? ['roles.update', $role->slug] : 'roles.create', 'method' => $role->id ? 'put' : 'post', 'class' => 'vertical']) !!}
        <div class="row">
            <div class="column-half roles-left-column">
                <div class="control">
                    <div class="control-label">
                        {!! Form::label('name', trans('shift::roles.form.name.label')) !!}
                    </div>
                    <div class="control-field">
                        {!! Multilingual::text('name', $role) !!}
                        <div class="help-text">{!! trans('shift::roles.form.name.hint') !!}</div>
                    </div>
                </div>

                <div class="control">
                    <div class="control-field">
                        <ul class="vertical">
                            <li>
                                {!! Form::checkbox('default', true, null, ['id' => 'default']) !!}
                                {!! Form::label('default', trans('shift::roles.form.default.label'), ['for' => 'default']) !!}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="column-half roles-right-column">
                {!! HTML::permissionsMatrix($role) !!}
            </div>
        </div>
        <div class="form-actions">
            <input type="submit" class="button primary" value="{!! trans('shift::buttons.saveNext') !!}">
        </div>
    {!!Form::close()!!}
</div>
