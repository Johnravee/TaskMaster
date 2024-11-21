import React, { useEffect } from "react";
import "../css/Modals.css";

export const ErrorModal = (props) => {
  const { show, message, onClose } = props;

  useEffect(() => {
    const modal = document.querySelector(".err-modal");
    if (show) {
      modal.style.display = "flex"; 
    } else {
      modal.style.display = "none"; 
    }
  }, [show]); 



  return (
    <div className="err-modal">
      <div className="err-modal-content">
        <div className="err-modal-title">
          <i className="bi bi-bug-fill"></i>
        </div>
        <div className="err-modal-body">
          <p>{message}</p>
        </div>
        <div className="err-modal-close">
          <button className="err-btn" onClick={onClose}>
            Close
          </button>
        </div>
      </div>
    </div>
  );
};



export const SuccessModal = (props) => {
  const { show, message, onClose } = props;

  useEffect(() => {
    const modal = document.querySelector(".success-modal");
    if (show) {
      modal.style.display = "flex"; 
    } else {
      modal.style.display = "none"; 
    }
  }, [show]); 

  const handleRedirect = () =>{
    window.location.href = "/login"
  }



  return (
    <div className="success-modal">
      <div className="success-modal-content">
        <div className="success-modal-title">
          <i className="bi bi-check-all"></i>
        </div>
        <div className="success-modal-body">
          <p>{message}</p>
        </div>
        <div className="success-modal-button">
          <button id="redirect-login" onClick={handleRedirect}>
            Login
          </button>
          <button id="close-success-btn" onClick={onClose}>
            Close
          </button>
        </div>
      </div>
    </div>
  );
};
