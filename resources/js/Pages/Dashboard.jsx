import React, { useState, useEffect } from 'react'
import Calendars from './Calendars'
import History from './History'
import '../css/Dashboard.css' 
import 'bootstrap-icons/font/bootstrap-icons.css'
import Tasklist from './Tasklist'
import axios from 'axios'
import { SetCsrf } from '../utils/axiosCsrfToken'
import { ScheduleModal } from '../Components/Modals'
import Done from './Done'

const Dashboard = ({ user_data }) => {
  const [isSidebarOpen, setSidebarOpen] = useState(false)
  const [showCalendar, setShowCalendar] = useState(false)
  const [showHistory, setShowHistory] = useState(false)
  const [showDone, setShowDone] = useState(false)
  const [showList, setShowList] = useState(true)
  const [showModal, setShowModal] = useState(false); 


  useEffect(() => {
    document.title = "Dashboard | Task Master"; 
  }, []); 

  const closeModal = () => {
    setShowModal(false);
   
  };

  const toggleSidebar = () => {
    setSidebarOpen(!isSidebarOpen)
  }

  const handleShowDashboard = () =>{
    setShowCalendar(false)  
    setShowHistory(false)
    setShowList(true)
    setShowDone(false)
  }

  const handleShowCalendar = () => {
    setShowCalendar(true)
    setShowHistory(false)
    setShowList(false)
    setShowDone(false)
  }

  const handleShowHistory = () => {
    setShowCalendar(false)
    setShowHistory(true)
    setShowList(false)
    setShowDone(false)
  }

  const handleShowDone = () => {
    setShowCalendar(false)
    setShowHistory(false)
    setShowList(false)
    setShowDone(true)
  }

  const handleAddSchedule = () =>{
    setShowModal(true);
  }

  const handleLogout = async () =>{
    try {
      SetCsrf()
      const response = await axios.get('/logout', { withCredentials: true })
      if (response.status === 200) {
        window.location.href = '/login'
      }
    } catch (error) {
      console.error(`Error logging out: ${error.response.data}`)
    }
  }

  return (
    <div className="dashboard">
      <ScheduleModal show={showModal} onClose={closeModal}  start={null}/>
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
              <a onClick={handleShowDashboard}>
                <i className="bi bi-house-door" />
                <span className="link_name">Dashboard</span>
              </a>
            </li>
            <li>
              <a onClick={handleAddSchedule}>
                <i className="bi bi-plus-square" />
                <span className="link_name">New Task</span>
              </a>
            </li>
            <li>
              <a onClick={handleShowCalendar}>
                <i className="bi bi-calendar-plus-fill" id="calendar-icon" />
                <span className="link_name">Calendar</span>
              </a>
            </li>
            <li>
              <a onClick={handleShowDone}>
                <i className="bi bi-list-check" id="star-icon" />
                <span className="link_name">Done</span>
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
                  <div className="designation">{user_data.isAdmin ? 'Admin' : 'User'}</div>
                </div>
              </div>
              <i className="bi bi-box-arrow-right" id="log_out" onClick={handleLogout} />
            </li>
          </ul>
        </div>

        <section className="home-section">
          {showList && <Tasklist />}
          {showCalendar && <Calendars />}
          {showHistory && <History />}
          {showDone && <Done />}
        </section>
      </div>
    </div>
  )
}

export default Dashboard
