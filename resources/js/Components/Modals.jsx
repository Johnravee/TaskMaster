import React, { useEffect, useState } from "react"
import "../css/Modals.css"
import Loader from "./Loader"
import { SetCsrf } from "../utils/axiosCsrfToken"
import axios from "axios"

export const ErrorModal = (props) => {
  const { show, message, onClose } = props

  useEffect(() => {
    const modal = document.querySelector(".err-modal")
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
  )
}



export const SuccessModal = (props) => {
  const { show, message, onClose } = props

  useEffect(() => {
    const modal = document.querySelector(".success-modal")
    if (show) {
      modal.style.display = "flex"
    } else {
      modal.style.display = "none"
    }
  }, [show])

  const handleRedirect = () => {
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
  )
}


// create new schedule modal
export const ScheduleModal = (props) => {
  const { show, start, onClose, existingSchedule, isUpdate, fetchData } = props

 

  
  const [scheduleID, setScheduleID] = useState(existingSchedule?.id || '')
  const [userID, setUserID] = useState(existingSchedule?.user_id || '')
  const [startDate, setStartDate] = useState(existingSchedule?.start || start || '')
  const [title, setTitle] = useState(existingSchedule?.title || '')
  const [description, setDescription] = useState(existingSchedule?.description || '')
  const [end, setEnd] = useState(existingSchedule?.end || '')
  const [category, setCategory] = useState(existingSchedule?.category || '')
  const [loading, setLoading] = useState(false)
  const [error, setError] = useState('')

  useEffect(() => {
    if (existingSchedule) {
      setScheduleID(existingSchedule.id || '')
      setUserID(existingSchedule.user_id || '')
      setStartDate(existingSchedule.start || '');
      setTitle(existingSchedule.title || '');
      setDescription(existingSchedule.description || '');
      setEnd(existingSchedule.end || '');
      setCategory(existingSchedule.category || '');
    }
  }, [existingSchedule]);


  useEffect(() => {
    if (start) {
      setStartDate(start || '')
    }
  }, [start]);





  

  SetCsrf()

  const handleSubmit = async () => {
    const modal = document.querySelector(".schedule-modal-container");
    try {

      if (end <= start || end <= startDate) {
        setError('End date must be after start date')
        return
      }

      if(title === '' || description === '' || category === '') {
        setError('Incomplete form field, Please fill all fields')
        return
      }

      setLoading(true);
      modal.style.display = "none";

      const apiUrl = isUpdate ? '/user/schedule/update' : '/api/schedule';
      const method = isUpdate ? 'PUT' : 'POST';

      const dataToSend = isUpdate
        ? { scheduleID, userID, title, description, start: startDate, end, category }
        : { title, description, start: startDate, end, category };

      const response = await axios({
        method: method,
        url: apiUrl,
        data: dataToSend
      });


      if (response.status === (isUpdate ? 200 : 201)) {
        setLoading(false);
        onClose();
        setTitle('')
        setCategory('')
        setDescription('')
        setEnd('')
        setError('')
        isUpdate && fetchData()
      }
    } catch (error) {
      console.error(`Error in schedule ${isUpdate ? 'update' : 'creation'}:`, error.response ? error.response.data : error.message);
    }
  };

  if(!show) return null  

  return (
    <div className="schedule-modal-container">
      {loading && <Loader />}
      <div className="schedule-modal-box">
        <div className="schedule-modal-header">
          <h2>{isUpdate ? 'Update Schedule' : 'Create Schedule'}</h2>
          <button className="close-btn" onClick={onClose}><i className="bi bi-x-square-fill"></i></button>
        </div>
        <div>
          <h3>{error && <p style={{ color: 'red', textAlign: 'center' }}>{error}</p>}</h3>
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
            />
          </div>

          <div>
            <label htmlFor="start">Start Date</label>
            <input
              type="date"
              name="start"
              id="start"
              value={startDate}
              onChange={(e) => setStartDate(e.target.value)}
              readOnly={!!start}
              required
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
          <select
            name="category"
            id="category"
            value={category}
            onChange={(e) => setCategory(e.target.value)}
            required
          >
            <option value="">Select a category</option>
            <option value="Priority">Priority</option>
            <option value="Normal">Normal</option>
          </select>
          </div>

          <div className="schedule-submit-button">
            <button onClick={handleSubmit}>{isUpdate ? 'Update' : 'Submit'}</button>
          </div>
        </div>
      </div>
    </div>
  )
}

// delete modal
export const DeleteModal = (props) => {
  const { show, id, onClose, fetchData } = props;

  useEffect(() => {
    const modal = document.querySelector(".del-modal");
    if (show) {
      modal.style.display = "flex";
    } else {
      modal.style.display = "none";
    }
  }, [show]);


  const handleDelete = async () => {
    try {
      const response = await axios.delete(`/schedule/${id}`)

      if (response && response.status === 202) {
        fetchData()
        onClose()
      }
    } catch (error) {
      console.error(`Delete Schedule failed : ${error}`)
    }
  }



  return (
    <div className="del-modal">
      <div className="del-modal-content">
        <div className="del-modal-title">
          <i className="bi bi-trash"></i>
        </div>
        <div className="del-modal-body">
          <p>Are you sure you want to Delete?</p>
        </div>
        <div className="del-modal-close">
          <button type="button" className="del-close" onClick={onClose} >
            Close
          </button>
          <button type="button" className="del-submit" onClick={handleDelete}>Delete</button>
        </div>
      </div>
    </div>
  );
};



