import React, {useState, useEffect} from 'react'
import Header from '../Components/Header'
import { ErrorModal } from '../Components/Modals'
import Loader from '../Components/Loader'
import '../css/Login.css'
import banner from '../assets/images/banner.png'
import { PlainBlackButton, GithubButton, GoogleButton } from '../Components/Buttons'
import axios from 'axios'
import { SetCsrf } from '../utils/axiosCsrfToken'



const Login = ({errorkupal}) => {


  const [email, setEmail] = useState('')
  const [password, setPassword] = useState('')
  const [loading, setLoading] = useState(false)
  const [errorMessage, setErrorMessage] = useState('')


  const handleNavigation = () =>{
    window.location.href = '/form/register'
  }
  
    SetCsrf()

    const handleFormLogin = async () =>{
      try {

        setErrorMessage('')

        // Basic validation
        if (!email || !password) {
          setErrorMessage('All fields are required.')
          return
        }

        // Email validation
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
        if (!emailPattern.test(email)) {
          setErrorMessage('Please enter a valid email address.')
          return
        }

        // show loader
        setLoading(true)

        const response = await axios.post('/form/login', {email, password})
        setEmail('')
        setPassword('')


       if (response.data.redirectUrl && response.status === 200) {
            window.location.href = response.data.redirectUrl  
        } else {
            setErrorMessage('Login failed, please try again.')
        }

      
      } catch (error) {
        // console.error(`Error response : ${error.response.data.error}`) //Uncomment for debugging
        setLoading(false)
        setErrorMessage(error.response.data.details || error.response.data.message || error.response.data.error)
        setEmail('')
        setPassword('')
      }
    }


    const handleGoogleLogin = async () =>{
      try {

        setErrorMessage('')
        // redirect lang sa google form
        window.location.href = '/api/auth/google/redirect';

        
      }
      catch(error){
          // console.error("Error from google login", error) Uncomment for debugging 
          setErrorMessage('Google login failed, please try again.')
      }
    }


    const handleGithubLogin = async () =>{
      try {
        setErrorMessage('')

        // redirect lang sa github form
        window.location.href = 'api/auth/github/redirect';


      } catch (error) {
        console.error("Error from github login", error.response.data.error) //Uncomment for debugging 
        setErrorMessage(errorkupal)
      }

    }



  return (
    <div className='login'>
        {loading && <Loader />}

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
            <h2 id="sign-in-txt">Sign In</h2>

            {errorMessage && <p className="error-message">{errorMessage}</p>}

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

            <div className="btn-container" onClick={handleFormLogin}>
              <PlainBlackButton  text={'Log In'} />
            </div>

            <div className="seperator">
              <span>or sign in with</span>
            </div>

            <div className="social-btn" onClick={handleGoogleLogin}>
              <GoogleButton text={"Continue with Google"} />
            </div>

            <div className="social-btn" onClick={handleGithubLogin}>
              <GithubButton text={"Continue with Github"} />
            </div>

            <p className="signin" onClick={handleNavigation}>
              Create new account 
            </p>
          </div>
        </div>
      </div>
    </div>
  )
}

export default Login
