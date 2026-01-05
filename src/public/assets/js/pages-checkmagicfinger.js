    /**
     *  Form Wizard
     */

    'use strict';
  function toggleCause(element) {
    const eventSection = document.getElementById('msEventSection');
    // ถ้าเลือก Unsafe Action (ID 2) ให้แสดง LSR (ขยับกว้างขึ้น)
    if (element.value == "2") {
        eventSection.style.display = 'block';
    } else {
        // ถ้าเลือก Unsafe Condition (ID 1) ให้ซ่อน LSR (ขยับแคบลง)
        eventSection.style.display = 'none';
    }
}
 

function toggleOtherInput(element) {
    const otherInput = document.getElementById('otherEventInput');
    // ตรวจสอบ ID ของ "อื่นๆ" จากฐานข้อมูลของคุณ  
    if (element.value == "7") {
        otherInput.style.display = 'block';
        document.getElementById('event_note').focus();
    } else {
        otherInput.style.display = 'none';
        document.getElementById('event_note').value = ''; // ล้างค่าเมื่อไม่ได้เลือกอื่นๆ
    }
}


//  $('.btnSHEApprove').on('click', function (event) { 
//     let formApprove = $('#multiStepsFormSHEApprove')[0];
//     let formData = new FormData(formApprove); 

//     $.ajax({
//       url: '/sheapprove/update',
//       type: 'POST',
//       data: formData,
//       processData: false,
//       contentType: false,
//       headers: {
//         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
//       },
//       success: function (response) {
//         if (response) {
//           Swal.fire({
//             title: response.message,
//             icon: response.success,
//             customClass: {
//               confirmButton: 'btn btn-primary waves-effect waves-light',
//             },
//             buttonsStyling: false,
//           }).then(result => {
//             if (result.isConfirmed) {
//               window.location.href = '/main';
//             }
//           });
//         }
//       },
//       error: function (xhr) {
//         console.error('เกิดข้อผิดพลาด:', xhr.responseText);
//         alert('เกิดข้อผิดพลาดขณะบันทึกข้อมูล');
//       },
//     });
//   });
// ;
