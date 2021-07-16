<html>
<table>
    <thead>
    <tr>
        <th>Name</th>
        <th>Work</th>
        <th>Study</th>
        <th>Place</th>
        <th>Created At</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $alumni)
        <tr>
            <td>{{ $alumni->name }}</td>
            <td>{{ $alumni->work }}</td>
            <td>{{ $alumni->study }}</td>
            <td>{{ $alumni->place }}</td>
            <td>{{ $alumni->created_at}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</html>