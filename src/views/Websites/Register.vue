<template>
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div
      class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
              <div class="card-body">
                <p class="text-center">Create an Account</p>
                <form @submit.prevent="submitForm">
                  <div class="mb-3">
                    <label for="exampleInputUsername" class="form-label">Name : </label>
                    <input type="text" class="form-control" v-model="user.name" id="exampleInputUsername"
                      placeholder="Enter your username">
                  </div>
                  <div class="mb-3">
                    <label for="exampleInputEmail" class="form-label">Email :</label>
                    <input type="email" class="form-control" v-model="user.email" id="exampleInputEmail"
                      placeholder="Enter your email">
                  </div>
                  <div class="mb-4">
                    <label for="exampleInputPassword" class="form-label">Password :</label>
                    <input type="password" class="form-control" v-model="user.password" id="exampleInputPassword"
                      placeholder="Enter your password">
                  </div>
                  <button type="submit"
                    class="btn btn-primary d-block mx-auto w-70 py-2 fs-4 mb-4 rounded-2 ">Register</button>
                  <div class="d-flex align-items-center justify-content-center">
                    <p>Already have an account?</p>
                    <router-link to="/login" class="text-primary fw-bold ms-2">Sign In</router-link>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

import axios from 'axios'
import Swal from 'sweetalert2'


export default {
  name: 'user',
  data() {
    return {
      result: {},
      user: {
        name: '',
        email: '',
        password: ''
      }
    }
  },
  created() {

  },
  methods: {
    submitForm() {
      axios
        .post('http://127.0.0.1:8000/api/register', this.user)
        .then((response) => {
          console.log('user registration successfully:', response.data);
          
          Swal.fire({
            icon: 'success',
            title: 'Registration Successful',
            text: 'You have successfully registered!',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
          }).then(() => {
            
            this.$router.push('/login');
          });
        })
        .catch((error) => {
          console.error('Error sending user data:', error);
          
          Swal.fire({
            icon: 'error',
            title: 'Registration Failed',
            text: 'An error occurred while registering. Please try again later.',
            confirmButtonColor: '#d33',
            confirmButtonText: 'OK'
          });
        });
    }
  }
}
</script>