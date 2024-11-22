import React, { useState } from 'react'
import Calendars from './Calendars'
import History from './History'
import '../css/Dashboard.css' 
import 'bootstrap-icons/font/bootstrap-icons.css'
import axios from 'axios'

const Dashboard = ({ user_data }) => {
  const [isSidebarOpen, setSidebarOpen] = useState(false)
  const [showCalendar, setShowCalendar] = useState(false)
  const [showHistory, setShowHistory] = useState(false)


   

  const toggleSidebar = () => {
    setSidebarOpen(!isSidebarOpen)
  }

  const handleShowCalendar = () => {
    setShowCalendar(true)
    setShowHistory(false)
    setSidebarOpen(!isSidebarOpen)
  }

  const handleShowHistory = () => {
    setShowCalendar(false)
    setShowHistory(true)
  }

  const handleLogout = async () =>{
    try {

        console.log('clicked!')
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
     
        // Set CSRF token in Axios headers
        axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken

       const response = await axios.get('/logout', {withCredentials: true})

       if(response.status === 200){
        window.location.href = '/login'
       }

    } catch (error) {
      console.error(`Error logging out: ${error.response.data}`)
      // set modal error 
    }
  }

  return (
    <div className="dashboard">
      <div className="dashboard-container">
        {/* Sidebar */}
        <div className={`sidebar ${isSidebarOpen ? 'open' : ''}`}>
          <div className="logo_details">
            <i className="bi bi-audio" />
            <div className="logo_name">Task Master</div>
            <i className="bi bi-list" id="btn" onClick={toggleSidebar} />
          </div>
          <ul className="nav-list">
            <li>
              <a  >
                <i className="bi bi-house-door" />
                <span className="link_name">Dashboard</span>
              </a>
            </li>
            <li>
              <a onClick={handleShowCalendar}>
                <i className="bi bi-calendar-plus-fill" />
                <span className="link_name">Calendar</span>
              </a>
            </li>
            <li>
              <a href="#">
                <i className="bi bi-star-half" id ="star" />
                <span className="link_name">Important</span>
              </a>
            </li>
            <li>
              <a onClick={handleShowHistory}>
                <i className="bi bi-clock-history" />
                <span className="link_name">History</span>
              </a>
            </li>
            <li className="profile">
              <div className="profile_details">
                <div className="profile_content">
                  <div className="name">{user_data.name}</div>
                  <div className="designation">User</div>
                </div>
              </div>
              <i className="bi bi-box-arrow-right" id="log_out" onClick={handleLogout} />
            </li>
          </ul>
        </div>

        <section className="home-section">
            <div className="text">Dashboard</div>

            {showCalendar && <Calendars />}
            {showHistory && <History />}
          </section>

      </div>
    </div>
  )
}

export default Dashboard
