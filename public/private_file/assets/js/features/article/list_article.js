$(document).ready(function() {
    const data = [
        {data:'check', name:'check', orderable:false, searchable:false},
        {data:'title', name:'title'},
        {data:'eskul_id', name:'eskul_id'},
        {data:'category', name:'category'},
        {data:'author', name:'author'},
        {data:'created_at', name:'created_at'},
        {data:'status', name:'status', className:'text-center'},
    ];

    Table({table:'#table', data:data, url:'/api/v1/features/article/get', parm:{id:'all'}});
    getAll();

    $('#category').select2()

    $('#dataArticle .nav-link').on('click', function(e) {
        $('.nav-link').removeClass('active')
        $(this).addClass('active')
        let parm = $(this).data('value')
        Table({table:'#table', data:data, url:'/api/v1/features/article/get', parm:{id:parm}});
    })

    $('#insert').on('submit', function(e) {
        e.preventDefault()
        $.ajax({
            url:'/api/v1/features/article/insert',
            type:'POST',
            headers:{
                'X-CSRF-TOKEN':csrftoken
            },
            data:new FormData(this),
            processData:false,
            contentType:false,
            success:res=>{
                RefreshTable('table');
                SweetAlert(res)
            },
            error:err=>{
                SweetAlert({message:err.responseJSON.message, status:err.status == 500 ? 'error' :'warning'})
            }
        })
    })

    $('#table').on('click', '#Edit', function(e) {
        e.preventDefault()
        let id = $(this).data('id')
        $.ajax({
            url:'/api/v1/features/article/get_first',
            data:{
                id:id
            },
            success:res=>{
                let category = []
                res.data.category.forEach(value=>{
                    category.push(value.category_id);
                })
                $('#updateArticle').modal('show')
                $('#updateArticle textarea[name="title"]').val(res.data.article.title)
                $('#updateArticle textarea[name="title"]').attr('data-id',res.data.article.id)
                $('#updateArticle img').attr('src', '/storage/' +res.data.article.thumbnail)
                $('#updateArticle select[name="eskul_id"] option[value="'+res.data.article.eskul_id+'"]').attr('selected', true);
                $('#updateArticle select[name="category[]"]').val(category)
                $('#updateArticle select[name="category[]"]').select2()
            },
            error:err=>{
                SweetAlert(err.responseJSON)
            }
        })
    })

    $('#table').on('click', '#Delete', function(e) {
        e.preventDefault()
        let id = $(this).data('id')
        $.ajax({
            url:'/api/v1/features/article/delete',
            data:{
                id:id
            },
            type:'DELETE',
            headers:{
                'X-CSRF-TOKEN' : csrftoken
            },
            success:res=>{
                RefreshTable('table')
                SweetAlert(res)
            },
            error:err=>{
                SweetAlert(err.responseJSON)
            }
        })
    })

    $('#updateArticle select[name="category[]"').on("select2:unselect", function (e) {
        let id = $('#updateArticle textarea[name="title"]').data('id')
        let category_id = e.params.data.id
        $.ajax({
            url: '/api/v1/features/article/category',
            data:{
                blog_id:id,
                category_id:category_id,
                type:'unselect'
            },
            type:'POST',
            headers:{
                'X-CSRF-TOKEN' : csrftoken
            },
            success:res=>{
                RefreshTable('table');
            },
            error:err=>console.log(err.responseJSON)
        })
    });

    $('#updateArticle select[name="category[]"').on("select2:select", function (e) {
        let id = $('#updateArticle textarea[name="title"]').data('id')
        let category_id = e.params.data.id
        $.ajax({
            url: '/api/v1/features/article/category',
            data:{
                blog_id:id,
                category_id:category_id,
                type:'select'
            },
            type:'POST',
            headers:{
                'X-CSRF-TOKEN' : csrftoken
            },
            success:res=>{
                RefreshTable('table');
            },
            error:err=>console.log(err.responseJSON)
        })
    });

    $('#update').on('submit', function(e) {
        e.preventDefault()
        let data = new FormData(this)
        data.append('id', $('#updateArticle textarea[name="title"]').data('id'));
        $.ajax({
            url:'/api/v1/features/article/update',
            data:data,
            processData:false,
            contentType:false,
            headers:{
                'X-CSRF-TOKEN' : csrftoken
            },
            type:'POST',
            success:res=>{
                RefreshTable('table')
                SweetAlert(res)
            },
            error:err=>console.log(res.responseJSON)
        })
    })

    $('#table').on('click', '#Status', function(e) {
        e.preventDefault()
        let id = $(this).data('id')
        $.ajax({
            url:'/api/v1/features/article/get_first',
            data:{
                id:id
            },
            success:res=>{
                $(`#statusArticle select[name="status"] option`).attr('selected', false)
                $('#statusArticle').modal('show')
                $(`#statusArticle select[name="status"] option[value="${res.data.article.status}"]`).attr('selected', true)
                $('#statusArticle select[name="status"]').attr('data-id', id);
                if (res.data.article.status == 300) {
                    $('#addedInput').html(` <div class="col-md-3"><label for="">Deskripsi</label></div>
                    <div class="col-md-9">
                        <textarea name="description" id="DeskripsiArtikel" value="${res.data.suspend.description}" class="form-control" cols="30" rows="10">${res.data.suspend.description}</textarea>
                    </div>`);
                    $('#addedInputSuspended').html(` <div class="col-md-3"><label for="">End Suspended</label></div>
                        <div class="col-md-9">
                            <input type="date" name="suspended" id="endSuspended" class="form-control datetimepicker" value="${res.data.suspend.suspended}">
                    </div>`);
                }else if (res.data.article.status > 300) {
                    $('#addedInput').html(` <div class="col-md-3"><label for="">Deskripsi</label></div>
                    <div class="col-md-9">
                        <textarea name="description" id="DeskripsiArtikel" value="${res.data.suspend.description}" class="form-control" cols="30" rows="10">${res.data.suspend.description}</textarea>
                    </div>`);
                    $('#addedInputSuspended').html('')
                }else{
                    $('#addedInput').html('')
                    $('#addedInputSuspended').html('')
                }
            },
            error:err=>{
                SweetAlert(err.responseJSON)
            }
        })
    })

    $('#statusArticle select[name="status"]').on('change', function() {
        if($(this).val() == 300){
            $('#addedInput').html(` <div class="col-md-3"><label for="">Deskripsi</label></div>
            <div class="col-md-9">
                <textarea name="description" id="DeskripsiArtikel" class="form-control" cols="30" rows="10"></textarea>
            </div>`);
            $('#addedInputSuspended').html(` <div class="col-md-3"><label for="">End Suspended</label></div>
                <div class="col-md-9">
                    <input type="date" name="suspended" id="endSuspended" class="form-control datetimepicker">
            </div>`);
        }else if ($(this).val() > 300) {
            $('#addedInput').html(` <div class="col-md-3"><label for="">Deskripsi</label></div>
            <div class="col-md-9">
                <textarea name="description" id="DeskripsiArtikel" class="form-control" cols="30" rows="10"></textarea>
            </div>`);
            $('#addedInputSuspended').html('')
        }else{
            $('#addedInput').html('')
            $('#addedInputSuspended').html('')
        }
    })

    $('#status').on('submit', function(e) {
        e.preventDefault()
        let data = new FormData(this)
        data.append('blog_id', $('#statusArticle select[name="status"]').data('id'))
        $.ajax({
            url:'/api/v1/features/article/suspended',
            data:data,
            processData:false,
            contentType:false,
            headers:{
                'X-CSRF-TOKEN' : csrftoken
            },
            type:'POST',
            success:res=>{
                RefreshTable('table')
                SweetAlert(res)
            },
            error:err=>{
                SweetAlert(res.responseJSON)
            }
        })
    })



})

function getAll(){
    $.ajax({
        url:'/api/v1/features/article/get_all',
        success:res=>{
            $('#dataArticle #allCount').html(res.data[0].all)
            $('#dataArticle #draftCount').html(res.data[1].draft)
            $('#dataArticle #publishedCount').html(res.data[2].published)
            $('#dataArticle #suspendedCount').html(res.data[3].suspended)
            $('#dataArticle #blockCount').html(res.data[4].block)
            $('#dataArticle #errorCount').html(res.data[5].error)
            $('#dataArticle #trashedCount').html(res.data[6].trashed)
        },
        error:err=>console.log(err)
    })
}
