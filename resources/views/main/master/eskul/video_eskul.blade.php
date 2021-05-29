@extends('templates.dashboard')

@section('main')

        <div class="row mt-sm-4">
          <div class="col-12 col-md-12 col-lg-7">
            <div class="card">
                <div class="card-header">
                    <h4>Data Video Eskul</h4>
                    <div class="ml-auto">
                      <a href="#" class="btn btn-danger rounded" id="deleteArray"><i class="far fa-trash-alt"></i>Hapus</a>
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
                            <th>Eskul</th>
                            <th>Video</th>
                            <th width="70px">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
              </div>
            </div>
          </div>

           <div class="col-12 col-md-12 col-lg-5">
            <div class="card">
              <form id="insert" class="needs-validation" novalidate="" >
                <div class="card-header">
                  <h4>Add Video Eskul</h4>
                </div>
                <div class="card-body">
                    
                  <div class="row">
                      <div class="form-group col-md col-12">
                        <label>Eskul</label>
                          <select required name="eskul_id" class="form-control">
                              <option selected disabled>== Pilih Eskul==</option>
                              @foreach ($eskul as $data)
                                <option value="{{$data->id}}">{{$data->name}}</option>
                              @endforeach
                          </select>
                          <div class="invalid-feedback">
                            What's eskul ID?
                        </div>
                  </div>
                </div>
                <div class="row"> 
                  <div class="form-group col-md col-12">
                        <label>Url Video</label>
                          <input type="text" name="url" required class="form-control">
    
                          <div class="invalid-feedback">
                            What's video eskul url?
                        </div>
                  </div>
                 </div>
                
              </div>
             </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary" type="submit">Save Changes</button>
                </div>
            </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

@endsection
