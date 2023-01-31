import bearer from '@websanova/vue-auth/drivers/auth/bearer'
import axios from '@websanova/vue-auth/drivers/http/axios.1.x'
import router from '@websanova/vue-auth/drivers/router/vue-router.2.x'

// Auth base configuration some of this options
// can be override in method calls
const config = {
  auth: bearer,
  // auth: {
  //   request: function (req, token) {
  //     this.options.http._setHeaders.call(this, req, { Authorization: 'Bearer ' + token });
  //   },
  //   response: function (res) {
  //     var headers = this.options.http._getHeaders.call(this, res),
  //         token = headers.Authorization || headers.authorization;

  //     if (token) {
  //       return token;
  //     }
  //   } 
  // },
  http: axios,
  router: router,
  // tokenDefaultName: 'token',
  // tokenStore: ['localStorage'],
  // localStorage.setItem ('name', 'Bepatient'),
  rolesVar: 'role',
  registerData: {url: 'auth/register', method: 'POST', redirect: '/login'},
  loginData: {url: 'auth/login', method: 'POST', redirect: '', fetchUser: true},
  logoutData: {url: 'auth/logout', method: 'POST', redirect: '/', makeRequest: true},
  fetchData: {url: 'auth/user', method: 'GET', enabled: true},
  refreshData: {url: 'auth/refresh', method: 'GET', enabled: true, interval: 30}
}

export default config