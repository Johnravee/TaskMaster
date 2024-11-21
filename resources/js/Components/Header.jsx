import React from 'react'
import 'bootstrap-icons/font/bootstrap-icons.css'
import logo from '../assets/images/logo.png'
import '../css/Header.css'

const Header = () => {
  return (
    <div>
      <header className="header">
        <img className="logo" src={logo} alt="Logo"/>
        <h1 className="title">Task Master</h1>
      </header>
    </div>
  )
}

export default Header
