import React, { useState } from 'react';

function SearchBar({ onSearch }) {
  const [query, setQuery] = useState('');

  // Mettre à jour la valeur de la recherche
  const handleChange = (event) => {
    const value = event.target.value;
    setQuery(value);
  };

  // Déclencher la recherche lorsque le formulaire est soumis
  const handleSubmit = (event) => {
    event.preventDefault();
    onSearch(query);
  };

  return (
    <form className='Search' onSubmit={handleSubmit}>
      <input
        className='searchTexte'
        type="text"
        placeholder="Rechercher..."
        value={query}
        onChange={handleChange}
      />
      <button className='Button' type="submit">Rechercher</button>
    </form>
  );
}

export default SearchBar;