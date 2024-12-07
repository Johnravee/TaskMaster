import React, { useState } from 'react';
import Header from '../Components/Header';
import logo from '../assets/images/blacklogo.png';
import '../css/reset.css';
import axios from 'axios';
function Reset({ token }) {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [passwordConfirmation, setPasswordConfirmation] = useState('');
  const [passwordError, setPasswordError] = useState('');

  const handleSubmit = async (e) => {
  e.preventDefault();

  // Check if the passwords match
  if (password !== passwordConfirmation) {
    setPasswordError('Passwords do not match');
    return;
  }

  if(password.length < 8){
    setPasswordError("Password should have at least 8 characters");
    return
  }

  try {
    let response = await axios.post('/reset-password', {
      token,
      email,
      password,
      password_confirmation: passwordConfirmation,  
    });

   
    if(response.status === 200){
        window.location.href = response.data.redirectURL
    }
    
  } catch (error) {
    console.error('Error reset password', error.response?.data || error);
  }
};


  const handlePasswordChange = (e) => {
    setPassword(e.target.value);
    // Reset error message on password change
    setPasswordError('');
  };

  const handleConfirmPasswordChange = (e) => {
    setPasswordConfirmation(e.target.value);

    

    // Validate if passwords match
    if (e.target.value !== password) {
      setPasswordError('Passwords do not match');
    } else {
      setPasswordError('');
    }
  };

  return (
    <div>
      <Header />
      <div className="reset-container">
        <form onSubmit={handleSubmit} className="reset-form">
          <div className="reset-logo-container">
            <img src={logo} alt="Logo" className="reset-logo" />
          </div>

          <div className="reset-input-group">
            <label htmlFor="reset-email" className="reset-label">Email</label>
            <input
              type="email"
              id="reset-email"
              value={email}
              onChange={(e) => setEmail(e.target.value)}
              className="reset-input"
              required
            />
          </div>

          <div className="reset-input-group">
            <label htmlFor="reset-password" className="reset-label">New Password</label>
            <input
              type="password"
              id="reset-password"
              value={password}
              onChange={handlePasswordChange}
              className="reset-input"
              required
            />
          </div>

          <div className="reset-input-group">
            <label htmlFor="reset-passwordConfirmation" className="reset-label">Confirm Password</label>
            <input
              type="password"
              id="reset-passwordConfirmation"
              value={passwordConfirmation}
              onChange={handleConfirmPasswordChange}
              className={`reset-input ${passwordError ? 'reset-input-error' : ''}`}
              required
            />
            {passwordError && <p className="reset-error-message" style={{ color: 'red' }}>{passwordError}</p>}

          </div>

          <button type="submit" className="reset-button">Reset Password</button>
        </form>
      </div>
    </div>
  );
}

export default Reset;
