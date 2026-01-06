<table>
    <thead>
        <tr>
            @foreach($columns as $column)
                <th>{{ $column['title'] }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($records as $record)
            <tr>
                @foreach($columns as $column)
                    <td>
                        @if(isset($column['type']) && $column['type'] === 'eval')
                            {{ eval('return ' . $column['value'] . ';') }}
                        @else
                            {{ $record->{$column['value']} ?? '' }}
                        @endif
                    </td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
