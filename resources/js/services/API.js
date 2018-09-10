import axios from "axios";

export default {

	headers(token) {
		if(!token) return {};
		return {headers: {Authorization: `Bearer ${token}`}};
	},

	async get(path, token = null) {
		console.log("API.GET", path, token);

		let response = await axios.get('/api/' + path, this.headers(token));

		if(!response.data) {
			return {status: 'failed', reason: 'request_failed'};
		}

		return response.data;
	},

	async post(path, data, token = null) {
		console.log("API.POST", path, data, token);

		let response = await axios.post('/api/' + path, data, this.headers(token));

		if(!response.data) {
			return {status: 'failed', reason: 'request_failed'};
		}

		return response.data;
	},

	async put(path, data, token = null) {
		console.log("API.PUT", path, data, token);

		let response = await axios.put('/api/' + path, data, this.headers(token));

		if(!response.data) {
			return {status: 'failed', reason: 'request_failed'};
		}

		return response.data;
	}

}