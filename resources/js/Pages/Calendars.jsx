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

  const closeModal = () =>{
    setShowModal(false)
  }


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
            setClickDate(info.dateStr)
            setShowModal(true)
          }

      
      })



      calendar.render()
    }

  

  }, [])


 

  return (
    <div className='calendars'>
      <ScheduleModal show={showModal} date={clickDate} onClose={closeModal} />
      <div className="calendar-container">
        <div id="calendar"></div>
      </div>
    </div>
  )
}

export default Calendars
