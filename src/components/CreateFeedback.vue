<template>
    <div >
      <v-form @submit.prevent="submitFeedbackForm" class="d-flex justify-space-around">
        <v-text-field v-model="title" label="Title" required></v-text-field>
  
        <v-select
          v-model="category"
          :items="categoryOptions"
          label="Category"
          required
        ></v-select>
  
        <v-text-field v-model="description" label="Description" required></v-text-field>
  
        <v-btn type="submit" color="primary">Submit Feedback</v-btn>
      </v-form>
  
      <v-table>
        <!-- ... (unchanged table structure) ... -->
      </v-table>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        title: '',
        category: null,
        categoryOptions: ['name', 'date', 'content'],
        description: '',
        feedbacks: [],
      };
    },
    mounted() {
    },
    methods: {
      async submitFeedbackForm() {
        try {
          const token = localStorage.getItem('token');
          const headers = {
            Authorization: `Bearer ${token}`,
          };
  
          const response = await axios.post('http://127.0.0.1:8000/api/feedback', {
            title: this.title,
            category: this.category,
            description: this.description,
          }, { headers });
  
          console.log('Feedback submitted successfully:', response.data);
  
          // After submitting, fetch the updated feedbacks
          this.$emit('refetch')
        } catch (error) {
          console.error('Error submitting feedback:', error.response ? error.response.data : error.message);
        }
      },
    },
  };
  </script>
  