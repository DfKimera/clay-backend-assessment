import API from "./API";

export default {

	async list(token) {
		let response = await API.get('locks', token);

		if(!response || !response.locks) return [];

		return response.locks;
	},

	async find(id, token) {
		let response = await API.get('locks/' + id, token);

		if(!response || !response.lock) return null;

		return response;
	},

	async lock(id, token) {
		return await API.put('locks/' + id, {access_type: 'lock'}, token);
	},

	async unlock(id, token) {
		return await API.put('locks/' + id, {access_type: 'unlock'}, token);
	}

}