@extends('templates.dashboard')


@section('main')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Data Test Member</h4>
                    <div class="ml-auto">
                        <a href="#" class="btn btn-primary rounded" data-target="#insertTest" data-toggle="modal"><i
                                class="fas fa-plus"></i> Tambah</a>
                        <a href="#" class="btn btn-danger rounded" id="deleteArray"><i class="far fa-trash-alt"></i>
                            Hapus</a>
                    </div>
                </div>
                <div class="card-body p-3">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table">
                            <thead>
                                <tr>
                                    <th width="10px">
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad"
                                                class="custom-control-input" id="checkbox-all">
                                            <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                                        </div>
                                    </th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Image</th>
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
    </section>


    {{-- MODAL --}}

    <!-- Modal Insert Test -->
    <div class="modal fade" id="insertTest" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="insertTestLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header border-bottom pb-4">
                    <h5 class="modal-title" id="insertTestLabel">Insert Test</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="needs-validation" novalidate id="insert">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Division</label>
                            <div class="col-sm-9">
                                <select required name="division_id" class="form-control">
                                    <option selected disabled>== pilih divisi ==</option>
                                    @foreach ($division as $data)
                                        <option value="{{ $data->id }}">{{ $data->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    What's Division?
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Nama Test</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="name" required="">
                                <div class="invalid-feedback">
                                    What's Test name?
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Nilai minimal test</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" name="value">
                            </div>
                        </div>
                        <div class="form-group mb-0 row">
                            <label class="col-sm-3 col-form-label">Deskripsi</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="deskripsi"></textarea>
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
