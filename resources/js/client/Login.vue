<template>
	<form class="card" @submit.prevent="onLogin()">
		<loading-feedback :is-loading="isLoading"></loading-feedback>

		<div class="card-header"><strong>Access your locks</strong></div>
		<div class="card-body">
			<div class="form-group">
				<label for="fld-email">E-mail:</label>
				<input id="fld-email" v-model="email" type="email" class="form-control" required />
			</div>

			<div class="form-group">
				<label for="fld-password">Password:</label>
				<input id="fld-password" v-model="password" type="password" class="form-control" required />
			</div>
		</div>
		<div class="card-footer">
			<button class="btn btn-success btn-block">Login <i class="fa fa-sign-in"></i></button>
		</div>
	</form>
</template>
<script>

	import Auth from "../services/Auth";

	export default {

		data: () => { return {
			isLoading: false,

			email: null,
			password: null,
		}},

		methods: {

			onLogin() {
				this.isLoading = true;

				Auth.login(this.email, this.password)
					.then((data) => {
						this.isLoading = false;
						console.log("Logged in: ", data);
						this.$emit('login', data.token);
					})
					.catch((err) => {
						this.isLoading = false;
						alert('Failed to authenticate: ' + err);
					})
			},

		}

	}

</script>