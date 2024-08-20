<template>
    <div class="pagination">
      <button
        :disabled="!pagination.prev_page_url"
        @click="$emit('paginate', pagination.prev_page_url)">
        Previous
      </button>
      <span>Page {{ pagination.current_page }} of {{ pagination.last_page }}</span>
      <button
        :disabled="!pagination.next_page_url"
        @click="$emit('paginate', pagination.next_page_url)">
        Next
      </button>
    </div>
  </template>

  <script>
  export default {
    props: {
      pagination: {
        type: Object,
        required: true
      }
    }
  }
  </script>

  <style scoped>
  .pagination {
    display: flex;
    justify-content: space-between;
    margin-top: 1rem;
  }
  button {
    padding: 0.5rem 1rem;
    background-color: #3490dc;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }
  button:disabled {
    background-color: #ccc;
    cursor: not-allowed;
  }
  </style>
