import React from 'react';
import '../css/Buttons.css'
import 'bootstrap-icons/font/bootstrap-icons.css'

const Buttons = ({ type, text }) => {
  return (
    <div>
      {type === 'black-logo' ? (
        <button className="btn-logo-black">
          <i className="bi bi-github"></i>
          {text}
        </button>
      ) : type === 'plain-black' ? (
        <button className="btn-plain-black">{text}</button>
      ) : type === 'plain-white' ? (
        <button className="btn-plain-white">{text}</button>
      ) : null}
    </div>
  );
};

export default Buttons;
