import React, { useEffect, useState } from "react";
import "../css/Modals.css";
import Loader from "./Loader";

export const ErrorModal = (props) => {
  const { show, message, onClose } = props;

  useEffect(() => {
    const modal = document.querySelector(".err-modal");
    if (show) {
      modal.style.display = "flex"
    } else {
      modal.style.display = "none"
    }
  }, [show])



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
      modal.style.display = "flex"
    } else {
      modal.style.display = "none"
    }
  }, [show])

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


// create new schedule modal
export const ScheduleModal = (props) => {
  const { show, start, onClose } = props;

  const [title, setTitle] = useState('');
  const [description, setDescription] = useState('');
  const [end, setEnd] = useState('');
  const [category, setCategory] = useState('');
  const [loading, setLoading] = useState(false)


  useEffect(() => {
    const modal = document.querySelector(".schedule-modal-container");
    if (show) {
      modal.style.display = "flex"
    } else {
      modal.style.display = "none"
    }
  }, [show])


  const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    
    // Set CSRF token in Axios headers
    axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken

  // Handle form submission
  const handleSubmit = async () => {

    const modal = document.querySelector(".schedule-modal-container");

    try {

      setLoading(true)
      modal.style.display = "none"

      const response = await axios.post('/api/schedule', {title, description, start, end, category});

      if(response.status === 201){
         modal.style.display = "none"
         setLoading(false)
      }

    } catch (error) {
      console.error(`Error in schedule creation : ${error.response.data}`)
    }

  };

  return (
    <div className="schedule-modal-container">
      {loading && <Loader />}
      <div className="schedule-modal-box">
        <button className="close-btn" onClick={onClose}>&times;</button> 
        <h2>Create Schedule</h2>
        <div>
          <div>
            <label htmlFor="title">Title</label>
            <input
              type="text"
              name="title"
              id="title"
              value={title}
              onChange={(e) => setTitle(e.target.value)}
              required
            />
          </div>

          <div>
            <label htmlFor="description">Description</label>
            <input
              type="text"
              name="description"
              id="description"
              value={description}
              onChange={(e) => setDescription(e.target.value)}
              required
            />
          </div>

          <div>
            <label htmlFor="start">Start Date</label>
            <input
              type="date"
              name="start"
              id="start"
              value={start}
              required
              readOnly
            />
          </div>

          <div>
            <label htmlFor="end">End Date</label>
            <input
              type="date"
              name="end"
              id="end"
              value={end}
              onChange={(e) => setEnd(e.target.value)}
              required
            />
          </div>

          <div>
            <label htmlFor="category">Category</label>
            <input
              type="text"
              name="category"
              id="category"
              value={category}
              onChange={(e) => setCategory(e.target.value)}
              required
            />
          </div>

          <div className="schedule-submit-button">
            <button onClick={handleSubmit}>Submit</button>
          </div>
        </div>
      </div>
    </div>
  );
};


