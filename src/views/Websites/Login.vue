<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-4 mx-auto mt-5" >
                <div class="card">
                    <div class="card-body">       
                        <h2 align="center"> Login</h2>
                        <form @submit.prevent="loginUser">
                            <div class="form-group" align="left">
                                <label>Email</label>
                                <input type="email" v-model="user.email" class="form-control"  placeholder="Email">
                            </div>
                            <div class="form-group" align="left">
                                <label>Password</label>
                                <input type="password" v-model="user.password" class="form-control"  placeholder="Password">
                            </div>
                            <!-- <router-link :to="{ name: 'WebsiteIndex', params: { email: user.email } }"> -->
                        <button type="submit" class="btn btn-primary" @click="">Login</button>
                        <!-- </router-link> -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
   
<script>
import axios from 'axios';
import Swal from 'sweetalert2';


export default {
  data() {
    return {
      user: {
        email: '',
        password: '',
      },
      errorMessage: '', // Define errorMessage here
    
    };
  },
  methods: {
  loginUser() {
    axios
      .post('http://127.0.0.1:8000/api/login', this.user)
      .then((response) => {
        Swal.fire({
          icon: 'success',
          title: 'Login Successful',
          text: 'You have successfully logged in!',
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'OK'
        }).then(() => {
          
          this.$router.push({
            name: 'WebsiteIndex',
            params: { email: this.user.email }
          });
        });
      })
      .catch((error) => {
        
        this.errorMessage = 'Email and/or password error';
        
        Swal.fire({
          icon: 'error',
          title: 'Login Failed',
          text: 'Invalid email and/or password. Please try again.',
          confirmButtonColor: '#d33',
          confirmButtonText: 'OK'
        });
        console.error(error);
      });
  }
}

};
</script>
   