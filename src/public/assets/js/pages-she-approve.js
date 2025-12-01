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
$('#add-file-she-approve').on('click', function () {
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
   

 $('.btnSHEApprove').on('click', function (event) { 
    let formApprove = $('#multiStepsFormSHEApprove')[0];
    let formData = new FormData(formApprove); 

    $.ajax({
      url: '/sheapprove/update',
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      },
      success: function (response) {
        if (response) {
          Swal.fire({
            title: response.message,
            icon: response.success,
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
        console.error('เกิดข้อผิดพลาด:', xhr.responseText);
        alert('เกิดข้อผิดพลาดขณะบันทึกข้อมูล');
      },
    });
  });
;
