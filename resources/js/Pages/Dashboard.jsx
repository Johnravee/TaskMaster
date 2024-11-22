import React, { useState } from 'react';
import 'bootstrap-icons/font/bootstrap-icons.css';
import logo from '../assets/images/logo.png';
import Calendar from './Calendar';
import History from './History';
import Header from '../Components/Header';
import 


const Dashboard = ({ user_data }) => {

  const [showCalendar, setShowCalendar] = useState(false)
  const [showHistory, setShowHistory] = useState(false)


  const handleShowCalendar = () =>{
    setShowCalendar(true)
    setShowHistory(false)
  }

  const handleShowHistory = () =>{
    setShowCalendar(false)
    setShowHistory(true)
  }

  


  return (
    <div className='dashboard'>

        <Header />
      <nav className="navigations">
        <button className="btn-navigation" onClick={handleShowCalendar}>Calendar</button>
        <button className="btn-navigation" onClick={handleShowHistory}> History</button>
        <button className="btn-navigation"></button>
      </nav>


      <div className="page-frame">
          {showCalendar && <Calendar />}
          {showHistory && <History />}
      </div>
    </div>

  
  );
};

export default Dashboard;
