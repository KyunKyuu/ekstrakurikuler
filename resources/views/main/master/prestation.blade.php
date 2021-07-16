@extends('templates.dashboard')

@section('main')

        <div class="row">
          <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Data Prestation</h4>
                <div class="ml-auto">
                <a href="/api/v1/prestation/export" class="btn btn-success rounded"><i class="fas fa-download"></i> Export</a>
                    <a href="#" class="btn btn-primary rounded" data-target="#insertPrestation" data-toggle="modal"><i class="fas fa-plus"></i> Tambah</a>
                    <a href="#" class="btn btn-danger rounded" id="deleteArray"><i class="far fa-trash-alt"></i> Hapus</a>
                </div>
              </div>
              <div class="card-body p-3">
                <div class="table-responsive">
                  <table class="table table-striped" id="table">
                    <thead>
                        <tr>
                            <th width="10px">
                                <div class="custom-checkbox custom-control">
                                <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad" class="custom-control-input" id="checkbox-all">
                                <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                                </div>
                            </th>
                            <th>Name Prestation</th>
                            <th>Image</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th width="70px">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>
  </div>
  </div>


  {{-- !NOTE Data Modal here  --}}

    <!-- Modal Insert -->
    <div class="modal fade" id="insertPrestation" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="insertPrestationLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom pb-4">
            <h5 class="modal-title" id="insertPrestationLabel">Insert Prestation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" novalidate id="insert">
                      <div class="form-group row">
                        <div class="form-group col-12">
                        <label>Prestation Name</label>
                          <input type="text" class="form-control" name="name" required="">
                          <div class="invalid-feedback">
                            What's Prestation name?
                          </div>
                        </div>
                      </div>


                         <div class="form-group row">
                          <div class="form-group col-md-6 col-12">
                        <label>Thumbnail</label>
                         <input type="file" class="form-control image-input-preview"  value="" name="image" placeholder="Image" data-id="img-thumbnail">
                      </div>
                      <div class="form-group col-md-6 col-12">
                          <img src="" id="img-thumbnail" alt="" class="img-fluid" style="max-width: 150px"><br>

                    </div>
                          <div class="invalid-feedback">
                            What's image Prestation?
                      </div>
                        </div>

                    <div class="form-group row">
                      <div class="form-group col-12">
                        <label>Content Prestation</label>
                        <textarea class="form-control use-ckeditor" name="content" placeholder="content Prestation">

                        </textarea>

                      </div>
                       <div class="invalid-feedback">
                            What's content Prestation?
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



    <!-- Modal Update -->
    <div class="modal fade" id="updatePrestation" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="updatePrestationLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom pb-4">
            <h5 class="modal-title" id="updatePrestationLabel">update Prestation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" novalidate id="update">
                      <div class="form-group row">
                        <div class="form-group col-12">
                        <label>Prestation Name</label>
                          <input type="text" class="form-control" name="name" required="">
                          <div class="invalid-feedback">
                            What's Prestation name?
                          </div>
                        </div>
                      </div>
                         <div class="form-group row">
                          <div class="form-group col-md-6 col-12">
                        <label>Thumbnail</label>
                         <input type="file" class="form-control image-input-preview"  value="" name="image" placeholder="Prestation" data-id="img-thumbnail">
                      </div>
                      <div class="form-group col-md-6 col-12">
                          <img src="/public_file/assets/img/news/img08.jpg" id="img-thumbnail" alt="" class="img-fluid" style="max-width: 150px"><br>

                    </div>
                          <div class="invalid-feedback">
                            What's image Prestation?
                      </div>
                        </div>

                    <div class="form-group row">
                      <div class="form-group col-12">
                        <label>Content Prestation</label>
                        <textarea class="form-control use-ckeditor" name="content" placeholder="content Prestation">

                        </textarea>

                      </div>
                       <div class="invalid-feedback">
                            What's content Prestation?
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

@endsection
