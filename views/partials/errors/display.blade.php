@if (isset($errors) && $errors->count())
    <div class="container">
        <div class="alert-error sticky island">
            <ul class="validation-errors">
                @foreach ($errors->all() as $field => $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif