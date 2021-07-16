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
    @foreach($data as $eskul)
        <tr>
            <td>{{$eskul->name }}</td>

            <td>{!! $eskul->content !!}</td>
            
            <td>{{$eskul->created_at }}</td>
          
        </tr>
    @endforeach
    </tbody>
</table>
</html>