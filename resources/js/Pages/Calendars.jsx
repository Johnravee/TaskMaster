import React, { useEffect, useState } from 'react'
import { Calendar } from '@fullcalendar/core'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import listPlugin from '@fullcalendar/list'
import interactionPlugin from '@fullcalendar/interaction'
import '../css/Calendars.css'
import { ScheduleModal, ErrorModal } from '../Components/Modals'
import { formatDate } from '../utils/formatDate'

const Calendars = () => {
  const [showModal, setShowModal] = useState(false)
  const [clickDate, setClickDate] = useState('')
  const [errModal, setErrModal] = useState(false)
  const [errMsg, setErrMsg] = useState('')

  const closeModal = () => {
    setShowModal(false)
    setErrModal(false)
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
        timeZone: 'local',
        initialView: 'dayGridMonth',
        showNonCurrentDates: true,
        eventDisplay: 'list-item',
        editable: false,
        selectable: true,
        dayMaxEvents: true,
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,timeGridWeek,listWeek'
        },
        events: async (fetchInfo, successCallback, failureCallback) => {
          try {
            const response = await fetch('/api/user/schedules')
            const schedules = await response.json()

            const events = schedules.map(schedule => ({
              id: schedule.id,
              title: schedule.title,
              start: schedule.start,
              end: schedule.end,
            }))

            // console.log('Events passed to calendar:', events) // Debugging log
            successCallback(events)
          } catch (error) {
            // console.error('Error fetching events:', error)
            failureCallback(error)
          }
        },

        eventColor: '#378006', 
        dateClick: function(info) {
          if(info.dateStr < new Date().toISOString().split('T')[0]){
             setErrModal(true)
             setErrMsg("The date you selected is in the past.")
             return
          }

          setClickDate(info.dateStr)
          setShowModal(true)
        },

        eventContent: function(info) {
          const { event } = info
          const formattedEndDate = event.end ? ` - <span style="color:#ef4444">Ends: ${formatDate(event.end)}</span>` : '' 
          return {
            html: `${event.title}${formattedEndDate}`
          }
        }
      })

      calendar.render()
    }
  }, [])

  return (
    <div className='calendars'>
      <ErrorModal show={errModal}  onClose={closeModal} message={errMsg}/>
      <ScheduleModal show={showModal} start={clickDate} onClose={closeModal} />
      <div className="calendar-container">
        <div id="calendar"></div>
      </div>
    </div>
  )
}

export default Calendars
