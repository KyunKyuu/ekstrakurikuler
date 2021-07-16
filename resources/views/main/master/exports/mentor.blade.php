<html>
<table>
    <thead>
    <tr>
        <th>Name</th>
        <th>Division</th>
        <th>Created At</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $mentor)
        <tr>
            <td>{{ $mentor->name }}</td>
            <td>{{ $mentor->eskul->name }}</td>
            <td>{{ $mentor->created_at }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</html>