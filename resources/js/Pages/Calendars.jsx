import React, { useEffect } from 'react'
import { Calendar } from '@fullcalendar/core'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import listPlugin from '@fullcalendar/list'
import interactionPlugin from '@fullcalendar/interaction';
import '../css/Calendars.css'


const Calendars = () => {
  useEffect(() => {
    const calendarEl = document.getElementById('calendar')
    
    if (calendarEl) {
      const calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin, timeGridPlugin, listPlugin, interactionPlugin],
        height: 600,
        handleWindowResize: true,
        stickyHeaderDates: true,
        expandRows: true,

        
        initialView: 'dayGridMonth',
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,timeGridWeek,listWeek'
        },

         dateClick: function(info) {
            alert('Clicked on: ' + info.dateStr);
            
          }

      
      })



      calendar.render()
    }

  

  }, [])

  return (
    <div className='calendars'>
      <div className="calendar-container">
        <div id="calendar"></div>
      </div>
    </div>
  )
}

export default Calendars
