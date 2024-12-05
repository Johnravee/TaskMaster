import React, { useState, useEffect } from 'react'
import DataTable from 'react-data-table-component'
import '../css/Tasklist.css'
import 'bootstrap-icons/font/bootstrap-icons.css'
import { ScheduleModal, DeleteModal } from '../Components/Modals'
import axios from 'axios'
import { filteredData } from '../utils/searchTable'

const Tasklist = () => {
   const [searchQuery, setSearchQuery] = useState('')
   const [datas, setDatas] = useState([])
   const [filtered, setFiltered] = useState([])
   const [clickedRow, setClickedRow] = useState({})
   const [editShowModal, setEditShowModal] = useState(false)
   const [isEditRowCLicked, setIsEditRowCLicked] = useState(false)  
   const [deleteID, setDeleteID] = useState('')
   const [deleteShowModal, setDeleteShowModal] = useState(false)


  const closeModal = () =>{
    setEditShowModal(false)
    setDeleteShowModal(false)
   
    
  }
  

  const fetchDataSchedules = async () => {
    try {
        const response = await axios.get('/api/user/schedules')
        setDatas(response.data)
        
        
        
      } catch (error) {
        console.log(error)  
      }
  }

  // Fetch data ho
    useEffect(()=>{
        fetchDataSchedules()
    },[])




    

  const COLUMNS = [
    { name: 'Title', selector: row => row.title, sortable: true },
    { name: 'Description', selector: row => row.description, sortable: true },
    { name: 'Start Date', selector: row => row.start, sortable: true },
    { name: 'Due Date', selector: row => row.end, sortable: true },
    { name: 'Category', selector: row => row.category, sortable: true },
    { name: 'Status', selector: row => row.status, sortable: true },
    {
      name: 'Actions',
      cell: (row) => (
        <div>

          <button
            onClick={() => handleDone(row.id)} 
            className='tasklist-done-btn'
          >
            <i className="bi bi-check"></i>
          </button>

          <button
            onClick={() => handleEdit(row)} 
            className='tasklist-edit-btn'
          >
            <i className="bi bi-pencil-square"></i>
          </button>
          <button
            onClick={() => handleDelete(row.id)} 
            className='tasklist-delete-btn'
          >
           <i className="bi bi-trash"></i>
          </button>
        </div>
      ),
    },
  ]

  useEffect(()=>{
    const result = filteredData(datas, searchQuery)
    setFiltered(result)
  },[datas, searchQuery])


  const handleEdit = (row) => {
    setClickedRow(row)
    setEditShowModal(true)
    setIsEditRowCLicked(true)
  }


  const handleDelete = (id) => {
    setDeleteID(id)
    setDeleteShowModal(true)
  }

  const handleDone = async (id) => {
    try {
      const response = await axios.patch('/user/schedule/update', {id})

      if (response.status === 200) {
        setDatas([])
        fetchDataSchedules()
      }

    } catch (error) {
      console.error('Error updating task to done', error)
    }
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
      <h2 className='history-title'>Task List</h2>
      <ScheduleModal show={editShowModal} onClose={closeModal} existingSchedule={clickedRow} isUpdate={isEditRowCLicked} fetchData={fetchDataSchedules} />
      <DeleteModal show={deleteShowModal} id={deleteID} onClose={closeModal} fetchData={fetchDataSchedules}/>
      <div className='search-container'>
        <input
          type="text"
          placeholder="Search Tasks..."
          value={searchQuery}
          onChange={(e) => setSearchQuery(e.target.value)}
          className='search-input'
        />
      </div>

      <div className="data-table-container">
        <DataTable
          columns={COLUMNS}
          data={filtered}
          customStyles={customStyles}
          expandableRowsComponent={ExpandedRowComponent}
          pagination
          theme="default"
          highlightOnHover
          responsive
          dense
          expandableRows
          fixedHeaderScrollHeight='600px'
          fixedHeader
        />
      </div>
    </div>
  )
}

export default Tasklist
