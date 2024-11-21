import React, {useState} from 'react'
import Header from '../Components/Header'
import { ErrorModal } from '../Components/Modals'
import Loader from '../Components/Loader'
import '../css/Login.css'
import banner from '../assets/images/banner.png'
import { PlainBlackButton, GithubButton, GoogleButton } from '../Components/Buttons'



const Login = () => {


  const [email, setEmail] = useState('')
  const [password, setPassword] = useState('')
  const [loading, setLoading] = useState(false)
  const [showModal, setShowModal] = useState(false)
  const [modalErroMessage, setModalErrorMessage] = useState('')


  const handleNavigation = () =>{
    window.location.href = '/form/register'
  }


   const closeModal = () => {
     setShowModal(false);
    }

  return (
    <div className='login'>
        {loading && <Loader />}

      <ErrorModal show={showModal} message={modalErroMessage} onClose={closeModal} />
      

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

            <div className="btn-container" >
              <PlainBlackButton  text={'Log In'} />
            </div>

            <div className="seperator">
              <span>or sign in with</span>
            </div>

            <div className="social-btn">
              <GoogleButton text={"Continue with Google"} />
            </div>

            <div className="social-btn">
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
