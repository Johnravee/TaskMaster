import React, { useState } from 'react'
import Header from '../Components/Header'
import logo from '../assets/images/blacklogo.png'
import '../css/forgot.css'
import emailGif from '../assets/images/email.gif'
import axios from 'axios'

const Forgot = () => {

  const [email, setEmail] = useState('')
  const [showGif, setShowGif] = useState(false)
  const handleSubmit = async () =>{
    try {
      setShowGif(true)
      let response = await axios.post('/forgot/password', {email})
      
    } catch (error) {
      console.error('Error password reset', error)
    }
  }

  return (
    <div className='Forgot'>
      <Header />
        <div className="forgot-container">
          

            {
              showGif 
                      ?
                        <div className="send-reset-success">
                                <img src={emailGif} alt="sent email" />
                        </div>
                      :
                        <div className="forgot-form">
                          <div className="forgot-logo-content">
                            <img src={logo} alt="logo" />
                          </div>

                          <div className="forgot-email-input">
                              <label htmlFor="email">Email</label>
                              <input type="email" name="email" id="forgot-email-input" required onChange={(e)=> setEmail(e.target.value)}/>
                          </div>

                          <button onClick={handleSubmit} type='button' id='forgot-button'>Send Reset Link</button>
                        </div>
                      
                        
            }
        </div>
    </div>
  )
}

export default Forgot
