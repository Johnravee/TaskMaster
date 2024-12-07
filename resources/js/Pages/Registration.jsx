import '../css/Registration.css'
import banner from '../assets/images/banner.png'
import Header from '../Components/Header'
import { PlainBlackButton } from '../Components/Buttons'
import Loader from '../Components/Loader'
import axios from 'axios'
import React, { useState, useEffect } from 'react'
import { ErrorModal, SuccessModal } from '../Components/Modals' 

const Registration = () => {
  const [name, setName] = useState('')
  const [email, setEmail] = useState('')
  const [password, setPassword] = useState('')
  const [confirmPassword, setConfirmPassword] = useState('')
  const [errorMessage, setErrorMessage] = useState('')
  const [loading, setLoading] = useState(false)
  const [showModal, setShowModal] = useState(false)
  const [modalErroMessage, setModalErrorMessage] = useState('')
  const [modalSuccessMessage, setModalSuccessMessage] = useState('')

  useEffect(() => {
    document.title = "Registration | Task Master"; 
  }, []); 



  const closeModal = () => {
     setShowModal(false);
    }

  // Redirect user
  const handleNavigation = () => {
    window.location.href = '/login'
  }

  const handleSignUp = async () => {
    // Reset error message
    setErrorMessage('')

    // Basic validation
    if (!name || !email || !password || !confirmPassword) {
      setErrorMessage('All fields are required.')
      return
    }

    // Email validation
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
    if (!emailPattern.test(email)) {
      setErrorMessage('Please enter a valid email address.')
      return
    }

    // Password validation
    if (password.length < 8) {
      setErrorMessage('Password must be at least 8 characters long.')
      return
    }

    // Confirm password validation
    if (password !== confirmPassword) {
      setErrorMessage('Passwords do not match.')
      return
    }

    // Show loader
    setLoading(true)

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    
    // Set CSRF token in Axios headers
    axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken
    
    try {
      const response = await axios.post('/api/users', { name, email, password })
    //   console.log('Response:', response.data) uncomment for debugging
     
      setLoading(false)
      setEmail('')
      setName('')
      setPassword('')
      setConfirmPassword('')
      setModalSuccessMessage(response.data.message)
      setShowModal(true)
      
    } catch (error) {
    //   console.error('Error:', error.response ? error.response.data : error.message) uncomment for debugging
        setEmail('')
        setName('')
        setPassword('')
        setConfirmPassword('')
        setLoading(false)
        setModalErrorMessage(error.response.data.error || error.response.data.message),
        setShowModal(true) 

    }
  }

  return (
    <div className='registration'>
      {loading && <Loader />}

      <ErrorModal show={showModal} message={modalErroMessage} onClose={closeModal} />
      
      <SuccessModal show={showModal} message={modalSuccessMessage} onClose={closeModal} />

      <Header />

      <div className="content-wrapper">
        <div className="container1">
          <div className="wrapper1">
            <h2 id="banner-text">Your personal productivity companion.</h2>
            <img id="banner" src={banner} alt="banner" />
          </div>
        </div>

        <div className="container2">
          <div className="form">
            <h2 id="sign-up-txt">Sign Up</h2>

            {errorMessage && <p className="error-message">{errorMessage}</p>}

            <div className="input-group">
              <p className="labels">Username</p>
              <input
                className="inputs"
                type="text"
                value={name}
                onChange={(e) => setName(e.target.value)}
              />
            </div>

            <div className="input-group">
              <p className="labels">Email</p>
              <input
                className="inputs"
                type="email"
                value={email}
                onChange={(e) => setEmail(e.target.value)}
              />
            </div>

            <div className="input-group">
              <p className="labels">Password</p>
              <input
                className="inputs"
                type="password"
                value={password}
                onChange={(e) => setPassword(e.target.value)}
              />
            </div>

            <div className="input-group">
              <p className="labels">Confirm Password</p>
              <input
                className="inputs"
                type="password"
                value={confirmPassword}
                onChange={(e) => setConfirmPassword(e.target.value)}
              />
            </div>

            <div className="btn-container" onClick={handleSignUp}>
              <PlainBlackButton text={'Sign Up'} />
            </div>

            <p className="signin">
              Already have an account?
              <span className="signinlink" onClick={handleNavigation}>
                Sign In
              </span>
            </p>
          </div>
        </div>
      </div>
    </div>
  )
}

export default Registration
