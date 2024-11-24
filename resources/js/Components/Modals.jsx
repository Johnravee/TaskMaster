import React, { useEffect, useState } from "react"
import "../css/Modals.css"
import Loader from "./Loader"
import { SetCsrf } from "../utils/axiosCsrfToken"

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
  )
}


// create new schedule modal
export const ScheduleModal = (props) => {
  const { show, start, onClose, existingSchedule, isUpdate } = props  


  const [startDate, setStartDate] = useState(existingSchedule?.start || start)
  const [title, setTitle] = useState(existingSchedule?.title || '')
  const [description, setDescription] = useState(existingSchedule?.description || '')
  const [end, setEnd] = useState(existingSchedule?.end || '')
  const [category, setCategory] = useState(existingSchedule?.category || '')
  const [loading, setLoading] = useState(false)


   useEffect(() => {
    if (existingSchedule?.start) {
      setStartDate(existingSchedule.start)
    } else if (start) {
      setStartDate(start)
    }
  }, [existingSchedule, start])

  

  useEffect(() => {
    const modal = document.querySelector(".schedule-modal-container")
    if (show) {
      modal.style.display = "flex"
    } else {
      modal.style.display = "none"
    }
  }, [show])

  SetCsrf()

  const handleSubmit = async () => {
    const modal = document.querySelector(".schedule-modal-container")
    try {
      setLoading(true)
      modal.style.display = "none"
      
      const apiUrl = isUpdate ? `/api/schedule/${existingSchedule.id}` : '/api/schedule'
      const method = isUpdate ? 'PUT' : 'POST'

      const response = await axios({
        method: method,
        url: apiUrl,
        data: { title, description, start, end, category }
      })

      if (response.status === (isUpdate ? 200 : 201)) {
        setLoading(false)
        onClose()
      }

    } catch (error) {
      console.error(`Error in schedule ${isUpdate ? 'update' : 'creation'}: ${error.response.data}`)
    }
  }

  return (
    <div className="schedule-modal-container">
      {loading && <Loader />}
      <div className="schedule-modal-box">
        <button className="close-btn" onClick={onClose}>&times</button>
        <h2>{isUpdate ? 'Update Schedule' : 'Create Schedule'}</h2>
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
              value={startDate}
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
            <button onClick={handleSubmit}>{isUpdate ? 'Update' : 'Submit'}</button>
          </div>
        </div>
      </div>
    </div>
  )
}



