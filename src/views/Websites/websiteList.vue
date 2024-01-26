<template>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>
                    Websites List
                    <!-- <RouterLink to="/website/create" class="btn btn-primary float-end"> Add website </RouterLink> -->
                </h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>URL</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody v-if="this.websites.length > 0">
                        <tr v-for="(website, index) in this.websites" :key="index">
                            <td>{{ website.id }}</td>
                            <td>{{ website.name }}</td>
                            <td>{{ website.url }}</td>
                            <td>
                                <button class="btn btn-danger" @click="subscribeWithPrompt(website.id)"> Subscribe </button>
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr>
                            <td colspan="7">Loading...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>


<script>
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
    name: 'websites',
    data() {
        return {
            websites: [],
            users: [],
        };
    },
    mounted() {
        this.getWebsites();
    },
    methods: {
        getWebsites() {
            axios.get('http://127.0.0.1:8000/api/websites')
                .then(res => {
                    if (res && res.data && res.data.websites) {
                        this.websites = res.data.websites;
                        this.websiteIds = res.data.websites.map(website => website.id); // Store website IDs
                    } else {
                        console.error('Invalid response structure:', res);
                    }
                })
                .catch(error => {
                    console.error('Error fetching websites:', error);
                });
        },

        subscribeWithPrompt(website_id) {
            Swal.fire({
                title: "Are you sure?",
                text: "Do You want to subscribe to this website?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Subscribe it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    const email = this.$route.params.email;
                    const subscriptionData = {
                        email: email,
                        website_id: website_id,
                    };
                    axios.post('http://127.0.0.1:8000/api/subscribers', subscriptionData)
                    .then((response) => {
                        console.log('User subscribed successfully:', response.data);
                            Swal.fire({
                                title: "Subscribed!",
                                text: "You have successfully subscribed to the website.",
                                icon: "success"
                            });
                    })
                    .catch((error) => {
                        console.error('Error in subscription data:', error);
                        Swal.fire({
                            title: "Can't subscribe",
                            text: "You already subscribe this website",
                            icon: "error"
                        });
                    });
                }
            });
        }, 
    },
};
</script>
