@extends('templates.dashboard')

@section('main')

        <div class="row">
          <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Master Data Section</h4>
                <div class="ml-auto">
                    <a href="/api/v1/user/export" class="btn btn-success rounded"><i class="fas fa-download"></i> Export</a>
                    <a href="#" class="btn btn-primary rounded" id="modalInsert"><i class="fas fa-plus"></i> Tambah</a>
                    <a href="#" class="btn btn-danger rounded"><i class="far fa-trash-alt"></i> Hapus</a>
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
                            <th>Username</th>
                            <th>Role</th>
                            <th>Email</th>
                            <th>Verifikasi</th>
                            <th>Status</th>
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
    </section>
  </div>


  {{-- !NOTE Data Modal here  --}}

  <!-- Modal Insert User -->
    <div class="modal fade" id="insertUser" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="insertUserLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom pb-4">
            <h5 class="modal-title" id="insertUserLabel">Insert User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" novalidate>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">User Name</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" name="name" required="">
                          <div class="invalid-feedback">
                            What's User name?
                          </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">User Password</label>
                        <div class="col-sm-9">
                          <input type="password" class="form-control" name="passwd" required="">
                          <div class="invalid-feedback">
                            What's User password?
                          </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">User Email</label>
                        <div class="col-sm-9">
                          <input type="email" class="form-control" name="email" required="">
                          <div class="invalid-feedback">
                            What's User email?
                          </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">User Role</label>
                        <div class="col-sm-9">
                          <select name="role_id" class="form-control" required>
                              <option disabled selected>== Pilih Role ===</option>
                              @foreach ($roles as $role)
                                <option value="{{$role->id}}">{{$role->name}} ({{$role->id_role}})</option>
                              @endforeach
                          </select>
                          <div class="invalid-feedback">
                            What's User role?
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



@endsection
