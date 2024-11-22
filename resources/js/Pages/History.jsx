import React from 'react'
import DataTable from 'react-data-table-component'


const History = () => {



  const COLUMNS = [
    {
      name: 'ID',
      sortable : true
    },

    {
      name: 'Title',
      sortable : true
    },

    {
      name: 'Description',
      sortable : true
    },

    {
      name: 'Start Date',
      sortable : true
    },

    {
      name: 'Due Date',
      sortable : true
    },

    {
      name: 'Category',
      sortable : true
    },
    
    {
      name: 'Status',
      sortable : true
    },

  ]

  return (
    <div>
      <DataTable 
      columns={COLUMNS}
      
      
      />
    </div>
  )
}

export default History
