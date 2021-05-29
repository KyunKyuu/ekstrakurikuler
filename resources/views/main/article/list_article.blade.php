@extends('templates.dashboard')

@section('main')

<div class="row">
    <div class="col-12">
      <div class="card mb-0">
        <div class="card-body">
          <ul class="nav nav-pills" id="dataArticle">
            <li class="nav-item">
              <a data-value="all" class="nav-link active" href="#">All <span class="badge badge-white" id="allCount">-</span></a>
            </li>
            <li class="nav-item">
              <a data-value="100" class="nav-link" href="#">Draft <span class="badge badge-secondary" id="draftCount">-</span></a>
            </li>
            <li class="nav-item">
              <a data-value="200" class="nav-link" href="#">Published <span class="badge badge-success" id="publishedCount">-</span></a>
            </li>
            <li class="nav-item">
              <a data-value="300" class="nav-link" href="#">Suspended <span class="badge badge-warning " id="suspendedCount">-</span></a>
            </li>
            <li class="nav-item">
                <a data-value="400" class="nav-link" href="#">Block <span class="badge badge-danger" id="blockCount">-</span></a>
            </li>
            <li class="nav-item">
                <a data-value="500" class="nav-link" href="#">Error <span class="badge badge-danger" id="errorCount">-</span></a>
            </li>
            @if (auth()->user()->role_id == 1)
                {{-- <li class="nav-item">
                    <a data-value="trash" class="nav-link" href="#">Trash <span class="badge badge-danger" id="trashedCount">-</span></a>
                </li> --}}
            @endif
            <li class="nav-item ml-auto">
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#insertArticle"><i class="fas fa-plus"></i> Add New</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <div class="row mt-4">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>All Posts</h4>
        </div>
        <div class="card-body">

          <div class="table-responsive">
            <table class="table table-striped" id="table">
                <thead>
                    <tr>
                        <th style="width: 10px;">
                          <div class="custom-checkbox custom-checkbox-table custom-control">
                            <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad" class="custom-control-input" id="checkbox-all">
                            <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                          </div>
                        </th>
                        <th>Title</th>
                        <th>Eskul</th>
                        <th>Category</th>
                        <th style="width: 20px">Author</th>
                        <th style="width: 100px">Created At</th>
                        <th style="width: 20px">Status</th>
                      </tr>
                </thead>
              <tbody>

            </tbody></table>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  </div>
  </div>

  <!-- Modal Insert Article -->
    <div class="modal fade" id="insertArticle" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="insertArticleLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom pb-4">
            <h5 class="modal-title" id="insertArticleLabel">Insert Article</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" novalidate id="insert">
                    <div class="form-group row">
                        <img class="img-fluid " src="" style="max-height: 150px;width:480px;" id="image-preview">
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Thumbnail</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control image-input-preview" data-id="image-preview"  name="image" required="">
                                <div class="invalid-feedback">
                                    What's Image article?
                                </div>
                            </div>
                        </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Title</label>
                        <div class="col-sm-9">
                          <textarea name="title" id="title" cols="30" rows="10" class="form-control" style="min-height: 70px;" required></textarea>
                          <div class="invalid-feedback">
                            What's title article?
                          </div>
                        </div>
                      </div>
                     <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Eskul</label>
                           <div class="col-sm-9">
                        <select required name="eskul_id" class="form-control">
                              <option selected disabled>== Berita Eskul ==</option>
                              @foreach ($data['eskul'] as $eskul)
                                <option value="{{$eskul->id}}">{{$eskul->name}}</option>
                              @endforeach
                          </select>
                        <div class="invalid-feedback">
                          Please fill in the Eskul ID
                        </div>
                      </div>
                      </div>  
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Category</label>
                        <div class="col-sm-9">
                          <select name="category[]" id="category" class="form-control" required multiple="multiple">
                              @foreach ($data['category'] as $category)
                                  <option value="{{$category->id}}">{{$category->name}}</option>
                              @endforeach
                          </select>
                          <div class="invalid-feedback">
                            What's category article?
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer ml-3">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
        </div>
        </div>
    </div>


  <!-- Modal update Article -->
    <div class="modal fade" id="updateArticle" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="updateArticleLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom pb-4">
            <h5 class="modal-title" id="updateArticleLabel">Update Article</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" novalidate id="update">
                    <div class="form-group row">
                        <img class="img-fluid " src="" style="max-height: 150px;width:480px;" id="update-preview">
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Thumbnail</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control image-input-preview" data-id="update-preview"  name="image">
                            </div>
                        </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Title</label>
                        <div class="col-sm-9">
                          <textarea name="title" cols="30" rows="10" class="form-control" style="min-height: 70px;" ></textarea>
                        </div>
                      </div>

                        <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Eskul</label>
                           <div class="col-sm-9">
                        <select required name="eskul_id" class="form-control">
                              <option selected disabled>== Berita Eskul ==</option>
                              @foreach ($data['eskul'] as $eskul)
                                <option value="{{$eskul->id}}">{{$eskul->name}}</option>
                              @endforeach
                          </select>
                        <div class="invalid-feedback">
                          Please fill in the Eskul ID
                        </div>
                      </div>
                      </div> 

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Category</label>
                        <div class="col-sm-9">
                          <select name="category[]" class="form-control"  multiple="multiple">
                              @foreach ($data['category'] as $category)
                                  <option value="{{$category->id}}">{{$category->name}}</option>
                              @endforeach
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer ml-3">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
        </div>
        </div>
    </div>


  <!-- Modal Status Article -->
    <div class="modal fade" id="statusArticle" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="statusArticleLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom pb-4">
            <h5 class="modal-title" id="statusArticleLabel">Status Article</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" novalidate id="status">
                    <div class="form-group row">
                        <div class="col-md-3"><label for="">Status</label></div>
                        <div class="col-md-9">
                            <select name="status" id="StatusArticle" class="text-capitalize form-control">
                                @foreach ($data['status'] as $val)
                                    <option class="text-capitalize" value="{{$val['id']}}">{{$val['value']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" id="addedInput">

                    </div>
                    <div class="form-group row" id="addedInputSuspended">

                    </div>
                    <div class="modal-footer ml-3">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                    </div>
                </form>
        </div>
        </div>
    </div>

@endsection
