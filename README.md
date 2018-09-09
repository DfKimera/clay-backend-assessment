# Clay Back-end Assessment

Submission by **Aryel Tupinambá**


## Project scope

- Admin panel to manage locks & accessors
- Registered accessors can login to the panel
- API w/ accessor-bound JWT to get list of locks & manage their status
- Status changes are queued, call CLP API
- Audit trail at every event
	- Request generates an event
	- If queued, queued job updates event with result
