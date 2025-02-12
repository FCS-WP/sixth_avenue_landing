// import { DisplayLabel } from './components/DisplayLabel';

let Main = {
  init: async function () {

    // initialize demo javascript component - async/await invokes some 
    //  level of babel transformation 
    const displayLabel = new DisplayLabel();
    await displayLabel.init();

  }
};


console.log($('.more-link'));
// Main.init();

function getTimeParts(selectedValue) {
  let timeSelect = parseInt(selectedValue.replace(/.*?(\d+)[^\d]*$/, '$1'), 10);
  return {
      addHour: Math.floor(timeSelect / 60),
      addMinutes: timeSelect % 60
  };
}

function calculateEndTime() {
  let time = $('select[name="starttime1"]').val();
  if (!time) {
      console.error("Missing Start Time");
      return;
  }

  let parts = time.split(":");
  let endHours = parseInt(parts[0], 10);
  let endMinutes = parseInt(parts[1], 10);
  let addHour = 0;
  let addMinutes = 0;

  let timeSlots = $('select[name="timeslot1"]').data("timeParts");
  if (!timeSlots) {
      addHour = 0;
      addMinutes = 25;
  } else {
      addHour = timeSlots.addHour;
      addMinutes = timeSlots.addMinutes;
  }

  let totalHours = endHours + addHour;
  let totalMinutes = endMinutes + addMinutes;

  if (totalMinutes >= 60) {
      totalHours += Math.floor(totalMinutes / 60);
      totalMinutes = totalMinutes % 60;
  }

  let finalTime = totalHours.toString().padStart(2, "0") + ":" + totalMinutes.toString().padStart(2, "0");
  $('#value_endtime').text(finalTime);
}

$('select[name="timeslot1"]').on("change", function() {
  let selectedValue = $(this).val();
  let timeParts = getTimeParts(selectedValue);
  $(this).data("timeParts", timeParts);
  calculateEndTime(); 
});

$('#zippy_time_slots').on("click", function() {
  calculateEndTime();
});
