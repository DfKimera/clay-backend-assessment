import API from "./API";

export default {

	async login(email, password) {
		return await API.post('auth', {email: email, password: password});
	},

	async identify(token) {
		let data = await API.get('me', token);

		if(!data) return null;
		if(data.status !== 'ok') return null;
		if(!data.user) return null;

		return data.user;
	},

}
