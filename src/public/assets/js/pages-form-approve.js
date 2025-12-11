/**
 *  Form Wizard
 */

'use strict';


function toggleInfo() {
  const femaleSelected = document.querySelector('input[name="msCauseCheck"][value="1"]').checked;
  document.getElementById('LSR').style.display = femaleSelected ? 'none' : 'block';
  console.log(femaleSelected);
}
 
//upload file
$('#add-file-approve').on('click', function () {
  const row = `
    <div class="file-row mb-2 d-flex gap-2 align-items-center">
      <input type="file" name="files[]" class="form-control w-75" required>
      <button type="button" class="btn btn-danger btn-remove">ลบ</button>
    </div>`;
  $('#file-container').append(row);
});

// ลบแถว input
$('#file-container').on('click', '.btn-remove', function () {
  $(this).closest('.file-row').remove();
});
   

 $('.btn-submit-approve').on('click', function (event) {
    // event.preventDefault();
    let formApprove = $('#multiStepsFormApprove')[0];
    let formData = new FormData(formApprove);

    console.log(formData);


    $.ajax({
      url: '/approve/save',
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      },
      success: function (response) {
// console.log(response);

        if (response) {
          Swal.fire({
            title: response.message,
            icon: response.class,
            customClass: {
              confirmButton: 'btn btn-primary waves-effect waves-light',
            },
            buttonsStyling: false,
          }).then(result => {
            if (result.isConfirmed) {
              window.location.href = '/main';
            }
          });
        }
      },
      error: function (xhr) {
            console.error('status:', xhr.status);
            console.error('error :', error);
            console.error('responseText:', xhr.responseText);
            alert('เกิดข้อผิดพลาดขณะบันทึกข้อมูล');
      },
    });
  });
;
