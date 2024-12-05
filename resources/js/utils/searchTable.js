


export const filteredData = (datas, searchQuery) => {
 const filtered = datas.filter(row =>
    Object.values(row).some(value =>
      value.toString().toLowerCase().includes(searchQuery.toLowerCase())
    )
  );

  return filtered;
};
