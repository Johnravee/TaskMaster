import React from 'react'
import '../css/Buttons.css'
import githublogo from '../assets/images/githublogo.png'
import googlelogo from '../assets/images/googlelogo.png'

export const PlainBlackButton = ({ text }) => {
  return (
    <div>
      <button className="btn-plain-black">{text}</button>
    </div>
  )
}


export const PlainWhiteButton = ({text}) => {
  return (
    <div>
      <button className="btn-plain-white">{text}</button>
    </div>
  )
}


export const GithubButton = ({text}) => {
  return (
    <div>
      <button className="btn-logo-black">
          <img src={githublogo} alt="logo" />
          {text}
        </button>
    </div>
  )
}



export const GoogleButton = ({text}) => {
  return (
    <div>
      <button className="btn-logo-white">
          <img src={googlelogo} alt="logo" />
          {text}
        </button>
    </div>
  )
}

