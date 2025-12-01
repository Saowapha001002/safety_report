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
$('#add-file').on('click', function () {
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

(function () {
  // Numbered Wizard
  // --------------------------------------------------------------------
  const wizardNumbered = document.querySelector('.wizard-numbered'),
    wizardNumberedBtnNextList = [].slice.call(wizardNumbered.querySelectorAll('.btn-next')),
    wizardNumberedBtnPrevList = [].slice.call(wizardNumbered.querySelectorAll('.btn-prev')),
    wizardNumberedBtnSubmit = wizardNumbered.querySelector('.btn-submit');

  if (typeof wizardNumbered !== undefined && wizardNumbered !== null) {
    const numberedStepper = new Stepper(wizardNumbered, {
      linear: false
    });
    if (wizardNumberedBtnNextList) {
      wizardNumberedBtnNextList.forEach(wizardNumberedBtnNext => {
        wizardNumberedBtnNext.addEventListener('click', event => {
          numberedStepper.next();
        });
      });
    }
    if (wizardNumberedBtnPrevList) {
      wizardNumberedBtnPrevList.forEach(wizardNumberedBtnPrev => {
        wizardNumberedBtnPrev.addEventListener('click', event => {
          numberedStepper.previous();
        });
      });
    }
    if (wizardNumberedBtnSubmit) {
      wizardNumberedBtnSubmit.addEventListener('click', event => {
        // event.preventDefault ();
        // alert ('Submitted..!!');
        let form = $ ('#multiStepsFormMagic')[0];
        console.log (form);
        let formData = new FormData (form);

        $.ajax ({
          url: '/from/save',
          type: 'POST',
          data: formData,
          processData: false, // อย่าประมวลผล FormData
          contentType: false, // ให้ browser จัดการ header เอง
          headers: {
            'X-CSRF-TOKEN': $ ('meta[name="csrf-token"]').attr ('content'),
          },
          success: function (response) { 
             console.log (response);
              if (response) {
                Swal.fire ({
                    title: response.message,
                    icon: response.success,
                    customClass: {
                      confirmButton: 'btn btn-primary waves-effect waves-light',
                    },
                    buttonsStyling: false,
                  }).then (result => {
                    if (result.isConfirmed) {
                      window.location.href = '/main';
                    }
                  });
            }
          }, error: function (xhr) {
            console.error ('เกิดข้อผิดพลาด:', xhr.responseText);
            alert ('เกิดข้อผิดพลาดขณะบันทึกข้อมูล');
          },
        });
      });
    }
  }

  
})();
