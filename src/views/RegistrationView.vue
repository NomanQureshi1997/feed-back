<template>
  <div style="height: 480px; width: 486px">
    <h1>Register</h1>
    <v-form @submit.prevent="submitForm">
      <v-text-field
        v-model="name"
        label="Name"
        required
        :rules="nameRules"
      ></v-text-field>
      <v-text-field
        v-model="email"
        label="E-mail"
        required
        :rules="emailRules"
      ></v-text-field>
      <v-text-field
        v-model="password"
        label="Password"
        required
        :rules="passwordRules"
        type="password"
      ></v-text-field>
      <v-btn type="submit" color="primary" :disabled="!isFormValid"
        >Register</v-btn
      >
    </v-form>
    <v-alert v-if="text.length > 0" type="info" title="Alert"  variant="tonal">{{ text[0] }}</v-alert>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      name: "",
      email: "",
      password: "",
      text: [],
    };
  },
  computed: {
    nameRules() {
      return [(value) => !!value || "Name is required"];
    },
    emailRules() {
      return [
        (value) => !!value || "E-mail is required",
        (value) => /^\S+@\S+\.\S+$/.test(value) || "E-mail must be valid",
      ];
    },
    passwordRules() {
      return [
        (value) => !!value || "Password is required",
        (value) =>
          (value && value.length >= 8) ||
          "Password must be at least 8 characters",
      ];
    },
    isFormValid() {
      return (
        this.nameRules.every((rule) => rule(this.name) === true) &&
        this.emailRules.every((rule) => rule(this.email) === true) &&
        this.passwordRules.every((rule) => rule(this.password) === true)
      );
    },
  },
  methods: {
    async submitForm() {
      if (!this.isFormValid) {
        console.log("Form validation failed. Please check errors.");
        return;
      }

      try {
        const response = await axios.post(
          "http://127.0.0.1:8000/api/register",
          {
            name: this.name,
            email: this.email,
            password: this.password,
          }
        );

        // Assuming the API returns a token
        const token = response.data.access_token;

        // Save the token to local storage
        localStorage.setItem("token", token);
        this.$router.push({name: feedbacks});
      } catch (error) {
        if (
          error.response &&
          error.response.data &&
          error.response.data.error
        ) {
          const errors = error.response.data.error;

          if(typeof errors.email != undefined)
          {
            this.text = errors.email
            return
          }

          if(typeof errors.password != undefined)
          {
            this.text = errors.password
            return
          }
          if(typeof errors.name != undefined)
          {
            this.text = errors.name
            return
          }
        } else {
          // Handle the case when the structure is unexpected
          console.error("Unexpected error structure", error);
        }
      }
    },
  },
};
</script>
