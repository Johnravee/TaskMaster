import React, { useState } from 'react';
import axios from 'axios';

const EventForm = () => {
  const [formData, setFormData] = useState({
    title: '',
    start: '',
    end: '',
    all_day: false,
  });

  const [loading, setLoading] = useState(false); // To manage loading state
  const [error, setError] = useState(null); // To manage error state
  const [success, setSuccess] = useState(false); // To manage success state

  // Handle input changes
  const handleChange = (e) => {
    const { name, value, type, checked } = e.target;
    setFormData((prevData) => ({
      ...prevData,
      [name]: type === 'checkbox' ? checked : value
    }));
  };

  // Handle form submission
  const handleSubmit = async (e) => {
    e.preventDefault();

    // Get the CSRF token from the meta tag
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    // Prepare data for submission
    const eventData = { ...formData };

    // Set loading state before making the request
    setLoading(true);
    setError(null);
    setSuccess(false);

    try {
      // Send data to backend using Axios
      const response = await axios.post('/create-task', eventData, {
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-Token': csrfToken || '', // Include CSRF token if present
        }
      });

      // Handle success
      if (response.status === 200) {
        setSuccess(true);
        setFormData({
          title: '',
          start: '',
          end: '',
          all_day: false
        });
      }
    } catch (err) {
      // Handle error
      setError(err.response ? err.response.data.message : 'Something went wrong');
    } finally {
      setLoading(false); // Reset loading state
    }
  };

  return (
    <div>
      <form onSubmit={handleSubmit}>
        <div>
          <label htmlFor="title">Title:</label>
          <input
            type="text"
            id="title"
            name="title"
            value={formData.title}
            onChange={handleChange}
            required
          />
        </div>

        <div>
          <label htmlFor="start">Start Date/Time:</label>
          <input
            type="datetime-local"
            id="start"
            name="start"
            value={formData.start}
            onChange={handleChange}
            required
          />
        </div>

        <div>
          <label htmlFor="end">End Date/Time:</label>
          <input
            type="datetime-local"
            id="end"
            name="end"
            value={formData.end}
            onChange={handleChange}
            required
          />
        </div>

        <div>
          <label htmlFor="all_day">All Day Event:</label>
          <input
            type="checkbox"
            id="all_day"
            name="all_day"
            checked={formData.all_day}
            onChange={handleChange}
          />
        </div>

       

        <div>
          <button type="submit" disabled={loading}>
            {loading ? 'Submitting...' : 'Submit'}
          </button>
        </div>
      </form>

      {success && (
        <div className="success-message">
          Event created successfully!
        </div>
      )}

      {error && (
        <div className="error-message">
          Error: {error}
        </div>
      )}
    </div>
  );
};

export default EventForm;
