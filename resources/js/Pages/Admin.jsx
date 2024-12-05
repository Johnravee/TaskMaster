import React, { useEffect, useState } from 'react'
import Header from '../Components/Header'
import '../css/Admin.css'
import axios from 'axios'

const Admin = () => {

  const [usersCount, setUsersCount] = useState(0)
  const [missedCount, setMissedCount] = useState(0)
  const [pendingCount, setPendingCount] = useState(0)
  

  const fetchCounters = async ()=>{
    try {
      const response = await axios('/admin/counts');

      if(response.status === 200) {
        setUsersCount(response.data[0])
        setMissedCount(response.data[1])
        setPendingCount(response.data[2])    
      }

    } catch (error) {
      console.error('Error fetching counts: ', error);
      
    }
  }

  useEffect(()=>{
    fetchCounters()
  },[])
  

  return (
    <div className='admin'>

        <div className="header-skew">
          
           <Header />

            <div className="skew-bg">
              <div className="top-skew"></div>  
            </div>    

        </div>

        <div className="admin-content">

          <div className="card-container">

              <div className="user-numbers-card">
                <div className="card-title">
                    NUMBER OF USERS
                </div>
                <div className="card-numbers">
                  <h1>{usersCount}</h1>
                </div>
            </div>


            <div className="missed-task-card">
                <div className="card-title">
                  MISSED TASK
                </div>
                <div className="card-numbers">
                  <h1>{missedCount}</h1>
                </div>
            </div>


            <div className="pending-task-card">
                <div className="card-title">
                    PENDING TASK
                </div>
                <div className="card-numbers">
                  <h1>{pendingCount}</h1>
                </div>
            </div>


          </div>

        </div>

        <div className="footer-skew">
            <div className="footer-skew-bg">
              <div className="bottom-skew"></div>  
            </div>    
        </div>

    </div>
  )
}

export default Admin
