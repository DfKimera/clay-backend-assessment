<template>
	<div>
		<login v-if="!user" @login="onLogin"></login>
		<locks-list v-if="user && !currentLock" :token="token" @logout="onLogout" @view="viewLock"></locks-list>
		<lock-activity v-if="currentLock" :token="token" :lock="currentLock" @close="onBackButton"></lock-activity>
	</div>
</template>
<script>

	import Auth from "../services/Auth";
	import LocksList from "./LocksList";

	export default {
		components: {LocksList},
		data: () => { return {
			user: null,
			token: null,
			currentLock: null,
		}},

		mounted: function() {

		},

		methods: {

			async onLogin(token) {
				console.log("Logged with token: ", token);
				this.token = token;
				this.user = await Auth.identify(token);
			},

			onLogout() {
				this.user = null;
				this.token = null;
			},

			onBackButton() {
				this.currentLock = null;
			},

			viewLock(lock) {
				this.currentLock = lock;
			}

		}

	}

</script>