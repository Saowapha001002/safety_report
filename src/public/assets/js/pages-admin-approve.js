/**
 *  Form Wizard
 */

'use strict'; 

 function toggleOtherInput(radio) {
        const selectedId = parseInt(radio.value);
        const otherInput = document.getElementById('otherEventInput');

        if (selectedId === 7 ) {
            otherInput.style.display = 'block';
        } else {
            otherInput.style.display = 'none';
            document.getElementById('other_event_text').value = '';
        }
    }

    // หากเลือก อื่นๆ (Other) ในเหตุการณ์ ***
    document.addEventListener('DOMContentLoaded', function () {
        const selected = document.querySelector('input[name="msEvent"]:checked');
        if (selected) {
            toggleOtherInput(selected);
        }
    });

      // หากเลือก Unsafe Action การกระทำที่ไม่ปลอดภัย (Life Saveing Rules) ***  
      function toggleCause(radio) {
        const selectedValue = parseInt(radio.value);
        const eventSection = document.getElementById('eventSection');
       
        // แสดงหรือซ่อนส่วนของเหตุการณ์ตามค่าที่เลือก
        if (selectedValue === 2) {
           console.log(selectedValue);
            eventSection.style.display = 'block';
        } else {
            eventSection.style.display = 'none';
        }
    }

    // กรณีรีเฟรชหน้าและมีค่าที่เลือกอยู่แล้ว
    document.addEventListener('DOMContentLoaded', function () {
        const selected = document.querySelector('input[name="msCauseCheck"]:checked');
        if (selected) {
            toggleCause(selected);
        }
    });
 
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
