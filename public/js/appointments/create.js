let $doctor, $date, $hours, iRadio; // Extend scopes
const noHoursAlert = `<div class="alert alert-danger" role="alert">
                        <strong>¡Lo sentimos!</strong> No se encontraron horas disponibles para el médico en el día seleccionado
                      </div>`;
$(function () {
    $doctor = $('#doctor');
    $date = $('#date');
    $hours = $('#hours');
    const $specialty = $('#specialty');
    $specialty.change(()=>{
       const specialtyId = $specialty.val();
       const url = `../specialties/${specialtyId}/doctors`;
       $.getJSON(url, onDoctorsLoaded, $doctor.html(''));
    });
    $doctor.change(loadHours);
    $date.change(loadHours);
});

function onDoctorsLoaded(doctors) {
  let htmlOptions = "";
  doctors.forEach( doctor => {
    htmlOptions +=`<option value="${doctor.id}">${doctor.name}</option>`;
  });
  $doctor.html(htmlOptions);
  loadHours();  // side-effect
}

function loadHours() {
  const selectedDate = $date.val();
  const doctorId     = $doctor.val();
  const url = `../schedule/hours?date=${selectedDate}&doctor_id=${doctorId}`;
  $.getJSON(url, displayHours);
}

function displayHours(data) {
  if (!data.morning && !data.afternoon ) {
      // console.log('No se encontraron horas disponibles para el médico en el día seleccionado');
      $hours.html(noHoursAlert);
      return;
  }
  iRadio = 0;
  let htmlHours = '<div class="text-center"><div class="row">';
  if (data.morning.length) {
      htmlHours += '<div class="col"><div class="mb-3">Horario AM</div>';
      const morning_intervals = data.morning;
      morning_intervals.forEach( interval => {
        htmlHours += getRadioIntervalHtml(interval);
      })
      htmlHours += '</div>';
  }
  if (data.afternoon.length) {
      htmlHours += '<div class="col"><div class="mb-3">Horario PM</div>';
      const afternoon_intervals = data.afternoon;
      afternoon_intervals.forEach( interval => {
        htmlHours += getRadioIntervalHtml(interval);
      })
      htmlHours += '</div>';
  }
  htmlHours += '</div></div>';

  $hours.html(htmlHours);
}

function getRadioIntervalHtml(interval) {
  const text = `${interval.start} - ${interval.end}`;
  return `<div class="custom-control custom-radio mb-3">
            <input type="radio" class="custom-control-input"
               id="interval${iRadio}" name="schedule_time" value="${interval.start}" required>
            <label class="custom-control-label" for="interval${iRadio++}">${text}</label>
          </div>`;
}
