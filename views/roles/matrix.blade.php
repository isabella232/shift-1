<div class="row">
    <table>
        <thead>
            <tr>
                <th rowspan="2">Permission</th>
                <th colspan="3" class="center">Create</th>
                <th colspan="3" class="center">View</th>
                <th colspan="3" class="center">Update</th>
                <th colspan="3" class="center delete">Delete</th>
            </tr>
            <tr>
                <th class="action">Deny</th>
                <th class="action">Inherit</th>
                <th class="action">Allow</th>
                <th class="action">Deny</th>
                <th class="action">Inherit</th>
                <th class="action">Allow</th>
                <th class="action">Deny</th>
                <th class="action">Inherit</th>
                <th class="action">Allow</th>
                <th class="action">Deny</th>
                <th class="action">Inherit</th>
                <th class="action">Allow</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($resources as $resource => $name)
                <?php $i = isset($i) ? $i + 1 : 0; ?>
                <tr @if ($i % 2 == 1) class="even"@endif>
                    <td>{{ $name }}</td>
                    {{ HTML::permission($role, $resource, 'create') }}
                    {{ HTML::permission($role, $resource, 'view') }}
                    {{ HTML::permission($role, $resource, 'update') }}
                    {{ HTML::permission($role, $resource, 'delete') }}
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
