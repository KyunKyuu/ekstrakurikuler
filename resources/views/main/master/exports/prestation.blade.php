<html>
<table>
    <thead>
    <tr>
        <th>Name</th>
        <th>Content</th>
        <th>Created At</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $prestasion)
        <tr>
            <td>{{ $prestasion->name }}</td>
            <td>{!! $prestasion->content !!}</td>
            <td>{{ $prestasion->created_at }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</html>