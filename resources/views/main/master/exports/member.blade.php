<html>
<table>
    <thead>
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Division</th>
        <th>Class Majors</th>
        <th>Created At</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $member)
        <tr>
            <td>{{ $member->name }}</td>
            <td>{{ $member->user->email }}</td>
            <td>{{ $member->division->name }}</td>
            <td>{{ $member->class}} {{$member->majors}}</td>
            <td>{{ $member->created_at }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</html>