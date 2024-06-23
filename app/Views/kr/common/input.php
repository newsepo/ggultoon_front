<style>
  div.search_input {
    display: flex;
    justify-content: flex-start;
    align-items: center;
    box-sizing: border-box;
    border: 1px solid var(--info);
    border-radius: 8px;
    background-color: var(--theme-white);
    padding: 14px 1rem;
    gap: 4px;
  }

  div.search_input input[type="text"] {
    display: block;
    width: 100%;
    text-align: left;
    border-style: none;
    background-color: var(--theme-white);
    color: var(--text-primary);
    outline: none;
  }

  div.search_input input[type="text"]::placeholder {
    color: var(--text-primary);
    text-transform: capitalize;
  }
</style>

<div class="search_input">
  <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
    <circle cx="11.7812" cy="11.7812" r="6.09375" stroke="#999999" stroke-width="2" />
    <path d="M20.3125 20.3125L16.25 16.25" stroke="#999999" stroke-width="2" stroke-linecap="round" />
  </svg>
  <input type="text" id="search" class="Text-md" />
</div>