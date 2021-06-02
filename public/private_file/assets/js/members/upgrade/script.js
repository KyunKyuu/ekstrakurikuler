$(document).ready(function(){
    let idWizard = 'wizard-form-1'

    $('.wizard-step').on('click', function(e) {
        e.preventDefault()
        $('.wizard-step').removeClass('wizard-step-active');
        $(this).addClass('wizard-step-active');
        idWizard= $(this).data('id')

        $('.wizard-pane').hide()
        $(`#${idWizard}`).show()

    })

    $('.wizard-next').on('click', function(e) {
        e.preventDefault()
        idWizard= $(this).data('id')
        $('.wizard-step').removeClass('wizard-step-active')
        $(`.wizard-step[data-id="${idWizard}"]`).addClass('wizard-step-active');

        $('.wizard-pane').hide()
        $(`#${idWizard}`).show()
    })

    $('.wizard-previous').on('click', function(e) {
        e.preventDefault()
        idWizard= $(this).data('id')
        $('.wizard-step').removeClass('wizard-step-active')
        $(`.wizard-step[data-id="${idWizard}"]`).addClass('wizard-step-active');

        $('.wizard-pane').hide()
        $(`#${idWizard}`).show()
    })

    $('#wizard-form-2 input[type="radio"]').on('change', function() {
        let id = $(this).val()
        $.ajax({
            url:'/api/v1/eskul/get',
            data:{
                id:id
            },
            success:res=>{
                let data = res.data
                $('#divisionsPreview').html(`
                    <div class="col-md-4"></div>
                    <div class="col-md-8">
                        <img src="/storage/${data.image}" class="img-fluid" style="max-width:250px">
                        <p>${data.content}</p>
                    </div>
                `)
            },
            error:err=>{
                SweetAlert({status:'error', message:err.responseJSON.message})
            }
        })
    })

    $('#wizard-form-3 input[type="radio"]').on('change', function() {
        let id = $(this).val()
        if (id == 'smkn5') {
            $('#smkn5').html(`<div class="form-group row  align-items-center">
                    <label class="col-md-4 text-md-right text-left">
                        Kelas
                    </label>
                    <div class="col-md-8 col-lg-6">
                        <select required name="class" class="form-control">
                            <option selected disabled>== Kelas ==</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                        </select>
                        <div class="invalid-feedback">
                            Please fill in the Class
                        </div>
                    </div>
                </div>
                <div class="form-group row  align-items-center">
                    <label class="col-md-4 text-md-right text-left">
                        Jurusan
                    </label>
                    <div class="col-md-8 col-lg-6">
                        <select required name="majors" class="form-control">
                            <option selected disabled>== Jurusan ==</option>
                            <option value="TKJ">Teknik Komputer Jaringan</option>
                            <option value="DPIB">DPIB</option>
                            <option value="GEO">Geomatika</option>
                            <option value="KGSP">KGSP</option>
                            <option value="KA">Kimia Analisis</option>
                            <option value="PF">Produksi Film</option>
                        </select>
                        <div class="invalid-feedback">
                            Please fill in the Majors
                        </div>
                    </div>
                </div>
                <div class="form-group row  align-items-center">
                    <label class="col-md-4 text-md-right text-left">
                        Entry Year
                    </label>
                    <div class="col-md-8 col-lg-6">
                        <input type="date" class="form-control" name="entry_year" required=""
                            placeholder="Entry Year Member">
                        <div class="invalid-feedback">
                            Please fill in the Year
                        </div>
                    </div>
                </div>`)
        }else{
            $('#smkn5').html(' ')
        }
    })

    $('#upgrade').on('submit', function(e) {
        e.preventDefault();
        let data = new FormData(this);

        $.ajax({
            url:'/api/v1/member/upgrade',
            data:data,
            contentType:false,
            processData:false,
            type:'POST',
            headers:{
                'X-CSRF-TOKEN':csrftoken
            },
            success:res=>{
                SweetAlert(res)
                $('#UpgradeDone').html(`<h1>Mohon tunggu! permintaan anda sedang di proses</h1><i class="fas text-warning fa-hourglass mt-4" style="font-size:62px"></i>`)
                $('#UpgradeMember').html(' ')
            },
            error:err=>{
                SweetAlert({status:err.responseJSON.status, message:err.responseJSON.message})
            }
        })
    })

})
