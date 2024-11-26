import React, { useEffect, useState } from 'react'
import DataTable from 'react-data-table-component'
import '../css/History.css'
import 'bootstrap-icons/font/bootstrap-icons.css'
import axios from 'axios'

const History = () => {
  const [searchQuery, setSearchQuery] = useState('')

  // Initialize datas as an array of objects
  const [datas, setDatas] = useState([])


  useEffect(() => {
    (async function()  {
      try {
        const response = await axios.get('/api/user/schedules');
        setDatas(response.data)
      } catch (error) {
        console.log(error);  
      }
    })()
}, []);


  const COLUMNS = [
    { name: 'Title', selector: row => row.title, sortable: true },
    { name: 'Description', selector: row => row.description, sortable: true },
    { name: 'Start Date', selector: row => row.start, sortable: true },
    { name: 'Due Date', selector: row => row.end, sortable: true },
    { name: 'Category', selector: row => row.category, sortable: true },
    { name: 'Status', selector: row => row.status, sortable: true },
    // Actions Column
    {
      name: 'Actions',
      cell: (row) => (
        <div>
          <button
            onClick={() => handleEdit(row.id)} 
            className='edit-btn'
          >
            <i className="bi bi-pencil-square"></i>
          </button>
          <button
            onClick={() => handleDelete(row.id)} 
            className='delete-btn'
          >
           <i className="bi bi-trash"></i>
          </button>
        </div>
      ),
    },
  ]

  const filteredData = datas.filter(row =>
    Object.values(row).some(value =>
      value.toString().toLowerCase().includes(searchQuery.toLowerCase())
    )
  )


  const handleEdit = (id) => {
    console.log('Editing task with ID:', id)
  
  }


  const handleDelete = (id) => {
    console.log('Deleting task with ID:', id)
    
  }

  const customStyles = {
    header: {
      style: {
        backgroundColor: '#191919',
        color: '#fffafa',
        fontWeight: 'bold',
        textAlign: 'center',
      },
    },
    headRow: {
      style: {
        backgroundColor: '#191919',
        color: '#fffafa',
      },
    },
    headCells: {
      style: {
        padding: '10px',
        fontSize: '14px',
        textAlign: 'center',
        fontWeight: 'bold',
      },
    },
    cells: {
      style: {
        padding: '15px',
        textAlign: 'center',
        fontSize: '15px',
      },
    },
  }

  const ExpandedRowComponent = ({ data }) => (
    <div className='expanded-row'>
      <p><strong>Start Date:</strong> {data.start}</p>
      <p><strong>Due Date:</strong> {data.end}</p>
      <p><strong>Status:</strong> {data.status}</p>
      <p><strong>Category:</strong> {data.category}</p>
      <p><strong>Description:</strong> {data.description}</p>
    </div>
  )

  return (
    <div className='history-container'>
      <h2 className='history-title'>Task History</h2>
      <div className='search-container'>
        <input
          type="text"
          placeholder="Search Tasks..."
          value={searchQuery}
          onChange={(e) => setSearchQuery(e.target.value)}
          className='search-input'
        />
      </div>

      <DataTable
        columns={COLUMNS}
        data={filteredData}
        pagination
        customStyles={customStyles}
        fixedHeader
        theme="default"
        highlightOnHover
        responsive
        dense
        expandableRows
        expandableRowsComponent={ExpandedRowComponent} 
      />
    </div>
  )
}

export default History
