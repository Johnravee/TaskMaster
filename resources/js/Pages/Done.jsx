import React, { useEffect, useState } from 'react'
import { filteredData } from '../utils/searchTable'
import DataTable from 'react-data-table-component'
import '../css/Done.css'
import 'bootstrap-icons/font/bootstrap-icons.css'
import { DeleteModal } from '../Components/Modals'
const Done = () => {

    const [deleteId, setDeleteId] = useState('')
    const [searchQuery, setSearchQuery] = useState('')
    const [datas, setDatas] = useState([])
    const [filtered, setFiltered] = useState([]);
    const [deleteShowModal, setDeleteShowModal] = useState(false)


    const closeModal = () =>{
    setDeleteShowModal(false)
  }

    const fetchDataSchedules = async () =>{
        try {
            const response = await axios.get('/schedule/done')

            if(response.status === 200){
                setDatas(response.data)
                
            }
        } catch (error) {
            console.error('Fetching done data error:', error);
            
        }
    }

   useEffect(() => {
       const result = filteredData(datas, searchQuery);
        setFiltered(result);
    }, [datas, searchQuery]);


    useEffect(()=>{
        fetchDataSchedules()
    },[])


    const handleDelete = (id) => {
    setDeleteId(id)
    setDeleteShowModal(true)
    console.log(deleteId);
    
  }

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
            onClick={() => handleDelete(row.id)} 
            className='done-delete-btn'
          >
           <i className="bi bi-trash"></i>
          </button>
        </div>
      ),
    },
  ]

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
    <div className='done-container'>
      <h2 className='done-title'>Done List</h2>
      <DeleteModal show={deleteShowModal} id={deleteId} onClose={closeModal} fetchData={fetchDataSchedules}/>
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

export default Done
