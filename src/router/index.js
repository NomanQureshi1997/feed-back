import { createRouter, createWebHistory } from "vue-router";
import LoginView from "../views/LoginView.vue";
import RegistrationView from "../views/RegistrationView.vue";
import FeedbacksView from "../views/FeedbacksView.vue";

// Define a route guard function
// const authGuard = (to, from, next) => {
//   const token = localStorage.getItem("token");

//   if (token) {
//     // Token is present, allow access to the route
//     next(true);
//   } else {
//     // Token is not present, redirect to the login page
//     next("/login");
//   }
// };

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/login",
      name: "login",
      component: LoginView,
      // beforeEnter: (to, from) => {
      //   const token = localStorage.getItem("token");

      //   if (token) {
      //     next({ name: "feedbacks" });
      //   } else {
      //     return false;
      //   }
      // },
    },
    {
      path: "/register",
      name: "register",
      component: RegistrationView,
      // beforeEnter: (to, from) => {
      //   const token = localStorage.getItem("token");

      //   if (token) {
      //     next({ name: "feedbacks" });
      //   } else {
      //     return false;
      //   }
      // },
    },
    {
      path: "/feedbacks",
      name: "feedbacks",
      component: FeedbacksView,
      // beforeEnter: authGuard, // Apply the route guard to the feedbacks route
    },
  ],
});

export default router;
