<template>
  <v-card class="mx-auto"  style="height: 90vh">
    <v-virtual-scroll :items="items" height="200">
      <template v-slot:default="{ item }">
        {{ item.comment }} | By {{ item.user.name }}
      </template>
    </v-virtual-scroll>

    <!-- Add input field and submit button for comments -->
    <v-form @submit.prevent="submitComment">
      <v-text-field v-model="newComment" label="Add Comment" required></v-text-field>
      <v-btn type="submit" color="primary">Submit Comment</v-btn>
    </v-form>
  </v-card>
</template>

<script>
import axios from "axios";

export default {
  data: () => ({
    items: [],
    newComment: "",
  }),
  props: {
    id: {
      type: String,
      default: "",
    },
  },
  watch: {
    id() {
      this.fetchComments()
    }
  },

  methods: {
    async fetchComments() {
      try {
        const token = localStorage.getItem("token");
        const headers = {
          Authorization: `Bearer ${token}`,
        };

        const response = await axios.get(
          "http://127.0.0.1:8000/api/feedbacks/" + this.id + "/comments",
          {
            headers,
          }
        );

        this.items = response.data.comments;
      } catch (error) {
        console.error("Error fetching comments:", error);
      }
    },
    async submitComment() {
      try {
        const token = localStorage.getItem("token");
        const headers = {
          Authorization: `Bearer ${token}`,
        };

        const response = await axios.post(
          "http://127.0.0.1:8000/api/feedbacks/" + this.id + "/comments",
          { comment: this.newComment },
          {
            headers,
          }
        );

        this.newComment = ""
        this.fetchComments()
      } catch (error) {
        console.error("Error submitting comment:", error);
      }
    },
  },
};
</script>
