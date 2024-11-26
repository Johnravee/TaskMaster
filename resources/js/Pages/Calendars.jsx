import React, { useEffect, useState } from 'react'
import { Calendar } from '@fullcalendar/core'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import listPlugin from '@fullcalendar/list'
import interactionPlugin from '@fullcalendar/interaction';
import '../css/Calendars.css'
import { ScheduleModal } from '../Components/Modals'


const Calendars = () => {

   const [showModal, setShowModal] = useState(false)
   const [clickDate, setClickDate] = useState('')
   const [schedule, setSchedule] = useState([])

  const closeModal = () =>{
    setShowModal(false)
  }


  useEffect(() => {
  const calendarEl = document.getElementById('calendar');

  if (calendarEl) {
    const calendar = new Calendar(calendarEl, {
      plugins: [dayGridPlugin, timeGridPlugin, listPlugin, interactionPlugin],
      height: 600,
      handleWindowResize: true,
      stickyHeaderDates: true,
      expandRows: true,
      timeZone: 'local',  
      initialView: 'dayGridMonth',
      showNonCurrentDates: false,
      eventDisplay : 'list-item',
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,listWeek'
      },
      events: async (fetchInfo, successCallback, failureCallback) => {
        try {
          const response = await fetch('/api/user/schedules');
          const schedules = await response.json();
          
          const events = schedules.map(schedule => ({
            id: schedule.id,
            title: schedule.title,
            start: schedule.start,
            end: schedule.end,
          }));

          console.log('Events passed to calendar:', events); // Debugging log
          successCallback(events);
        } catch (error) {
          console.error('Error fetching events:', error);
          failureCallback(error);
        }
      },

      eventColor: '#378006',
      dateClick: function(info) {
        setClickDate(info.dateStr);
        setShowModal(true);
      }
    });

    calendar.render();
  }
}, []);


 

  return (
    <div className='calendars'>
      <ScheduleModal show={showModal} start={clickDate} onClose={closeModal}  />
      <div className="calendar-container">
        <div id="calendar"></div>
      </div>
    </div>
  )
}

export default Calendars
