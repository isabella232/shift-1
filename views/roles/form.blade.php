<div class="container">
    {{Form::model($role, ['action' => 'Tectonic\Shift\Controllers\RoleController@postStore', 'class' => 'vertical'])}}
        <div class="row">
            <div class="column-half">
                <div class="control">
                    <div class="control-label">
                        {{Form::label('name', trans('shift::roles.form.name.label'))}}
                    </div>
                    <div class="control-field">
                        {{Multilingual::text('name')}}
                        <div class="help-text">Enter the name of the role.</div>
                    </div>
                </div>

                <div class="control">
                    <div class="control-field">
                        <ul class="vertical">
                            <li>
                                {{Form::checkbox('default')}}
                                {{Form::label('default', 'Is this the default role for newly registered users?')}}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <input type="submit" class="button primary ng-isolate-scope ng-scope" value="Save + next" next-tab="">
            </div>
        </div>
    {{Form::close()}}
</div>
