<template>
  <div class="v-row">
    <div class="v-col-9">
      <CreateFeedbackVue @refetch="fetchFeedbacks" />
      <v-table>
        <thead>
          <tr>
            <th class="text-left">Title</th>
            <th class="text-left">Category</th>
            <th class="text-left">Description</th>
            <th class="text-left">User</th>
            <th class="text-left">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(feedback, index) in feedbacks.data" :key="index">
            <td>{{ feedback.title }}</td>
            <td>{{ feedback.category }}</td>
            <td>{{ feedback.description }}</td>
            <td>{{ feedback.user.name }}</td>
            <td>
              <v-btn
                dense
                @click="viewComment(feedback)"
                :style="
                  feedbackId == feedback.id ? 'color: red' : 'color: blue'
                "
                >{{
                  feedbackId == feedback.id ? "Viewing comment" : "View comment"
                }}</v-btn
              >
            </td>
          </tr>
        </tbody>
      </v-table>

      <v-pagination
        v-if="feedbacks.last_page > 1"
        v-model="feedbacks.current_page"
        :length="feedbacks.last_page"
        :total-visible="7"
      ></v-pagination>
    </div>
    <div class="v-col-3">
      <Comments :id="feedbackId" />
    </div>
  </div>
</template>

<script>
import axios from "axios";
import CreateFeedbackVue from "@/components/CreateFeedback.vue";
import Comments from "@/components/Comments.vue";

export default {
  data() {
    return {
      feedbacks: {
        data: [],
        current_page: 1,
        last_page: 1,
        per_page: 10,
        total: 0,
      },
      feedbackId: 1,
    };
  },
  components: {
    CreateFeedbackVue,
    Comments,
  },
  watch :{
    "feedbacks.current_page"() {
        this.fetchFeedbacks()
    }
  },
  mounted() {
    this.fetchFeedbacks();
  },
  methods: {
    viewComment(feedback) {
      this.feedbackId = feedback.id;
    },
    async fetchFeedbacks() {
      try {
        const token = localStorage.getItem("token");
        const headers = {
          Authorization: `Bearer ${token}`,
        };

        const response = await axios.get(
          "http://127.0.0.1:8000/api/feedbacks",
          {
            headers,
            params: { page: this.feedbacks.current_page },
          }
        );

        // Extract pagination details from the response and update data
        this.feedbacks = response.data.feedbacks;
        if (this.feedbacks.data.length > 0) {
          this.feedbackId = this.feedbacks.data[0].id;
        }
      } catch (error) {
        console.error("Error fetching feedbacks:", error);
      }
    },
    changePage(page) {
      console.log(page, "page");
      this.feedbacks.current_page = page;
      this.fetchFeedbacks();
    },
  },
};
</script>
