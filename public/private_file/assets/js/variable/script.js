const csrftoken = $('meta[name="csrf-token"]').data('token')
const value_checkbox = []

$(document).ready(function() {
    ClassicEditor
    .create( document.querySelector( '.use-ckeditor' ), {
    } )
    .then( editor => {
        editor.model.document.on( 'change:data', () => {
            $('form input[data-editor="ckeditor"]').val(editor.getData()) ;
            deskripsi = editor.getData();
        } );
    } )
    .catch( error => {
        console.log( error );
    } );

    $('.image-input-preview').change(function(){
        let id = $(this).data('id')
        let reader = new FileReader();

        reader.onload = (e) => {

          $(`#${id}`).attr('src', e.target.result);
        }

        reader.readAsDataURL(this.files[0]);

    });


})
