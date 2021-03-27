$(document).ready(function() {
    const data = [
        {data:'check', name:'check', orderable:false, searchable:false},
        {data:'name', name:'name'},
        {data:'created_at', name:'created_at', searchable:false, orderable:false},
        {data:'btn', name:'btn', searchable:false, orderable:false},
    ];

    Table({table:'#table', data:data, url:'/api/v1/category/get'});

    $('#insert').on('submit', function(e) {
        e.preventDefault()
        $.ajax({
            url:'/api/v1/category/insert',
            data:new FormData(this),
            processData:false,
            contentType:false,
            type:'POST',
            headers:{
                'X-CSRF-TOKEN':csrftoken
            },
            success:res=>{
                RefreshTable('table');
                SweetAlert(res);
            },
            error:err=>console.log(err)
        })
    })

      $('#table').on('click', '#delete', function(e) {
        e.preventDefault()
        let id = $(this).data('value')
        $.ajax({
            url:'/api/v1/category/delete',
            data:{
                id:id
            },
            type:'DELETE',
            headers:{
                'X-CSRF-TOKEN':csrftoken
            },
            success:res=>{
                RefreshTable('table');
                SweetAlert(res);
            },
            error:err=>console.log(err)
        })
    })

     $('#update').on('submit', function(e) {
        e.preventDefault();
        let value = new FormData(this)
        value.append('id', $('#updateCategory input[name="name"]').data('id'));
        $.ajax({
            url:'/api/v1/category/update',
            data:value,
            type:'POST',
            contentType:false,
            processData:false,
            headers:{
                'X-CSRF-TOKEN' : csrftoken
            },
            success:res=>{
                SweetAlert(res)
                RefreshTable('table')
            },
            error:err=>console.log(err)
        })
    })

    $('#table').on('click', '#edit', function(e) {
        e.preventDefault();
        let id = $(this).data('value')
        $.ajax({
            url:'/api/v1/category/get',
            data:{
                id:id
            },
            success:res=>{
                $('#updateCategory').modal('show');
                $('#updateCategory input[name="name"]').val(res.data.name);
                $('#updateCategory input[name="name"]').data('id',res.data.id);
                
            },
            error:err=>console.log(err)
        })
    })

})
