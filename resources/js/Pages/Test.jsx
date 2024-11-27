import React, { useEffect } from 'react'
import { Calendar } from '@fullcalendar/core'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import listPlugin from '@fullcalendar/list'
import interactionPlugin from '@fullcalendar/interaction';
const Test = () => {

  useEffect(()=>{
     var calendarEl = document.getElementById('calendar');

  var calendar = new Calendar(calendarEl, {
    plugins: [dayGridPlugin, timeGridPlugin, listPlugin, interactionPlugin],
    timeZone: 'UTC',
    initialView: 'dayGridMonth',
    events: 'https://fullcalendar.io/api/demo-feeds/events.json',
    editable: true,
    selectable: true
  });

  calendar.render();
  },[])

  return (
    <div>
        <div id='calendar'></div>
    </div>
  )
}

export default Test
